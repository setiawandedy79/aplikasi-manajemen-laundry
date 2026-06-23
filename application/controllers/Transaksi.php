<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        $this->load->model('Transaksi_model');
        $this->load->model('Pakaian_model');
        $this->load->model('Pelanggan_model');
    }

    public function index() {
        $data['title'] = 'Data Transaksi';
        $keyword = $this->input->get('keyword');
        if ($keyword === NULL) $keyword = '';
        $data['keyword'] = $keyword;
        
        // Ambil data user untuk filter unit
        $user_id = $this->session->userdata('user_id');
        $user_data = $this->db->where('id', $user_id)->get('users')->row();
        $pelanggan_id = isset($user_data->pelanggan_id) ? $user_data->pelanggan_id : null;
        
        // --- KONFIGURASI PAGINATION ---
        $this->load->library('pagination');
        $config['base_url'] = base_url('transaksi/index');
        $config['total_rows'] = $this->Transaksi_model->count_all_transaksi($keyword, $pelanggan_id);
        $config['per_page'] = 50; // ✅ TAMPILKAN 50 DATA PER HALAMAN
        $config['uri_segment'] = 3;
        
        // Styling Pagination agar rapi (Bootstrap)
        $config['full_tag_open'] = '<ul class="pagination justify-content-center mt-3">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');
        // --------------------------------

        $this->pagination->initialize($config);
        
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        // ✅ TAMBAHKAN BARIS INI DI KETIGA CONTROLLER
        $data['no'] = $page + 1;
        // ✅ FIX: Mencegah error ctype_digit() null di PHP 8.1
        // Memaksa segment ke-3 bernilai '0' jika kosong, agar tidak error di create_links()
        if ($this->uri->segment(3) === NULL) {
            $this->uri->segments[3] = '0';
        }
        $data['links'] = $this->pagination->create_links();
        
        // Kirim limit dan offset ke model
        $data['transaksi'] = $this->Transaksi_model->get_all($keyword, $pelanggan_id, $config['per_page'], $page);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit($id) {
        // Cek hak akses edit
            if (!can_edit('transaksi')) {
                $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses untuk mengedit data');
                redirect('transaksi');
            }
        $data['title'] = 'Edit Transaksi';
        $data['header'] = $this->Transaksi_model->get_header_by_id($id);
        if (!$data['header']) {
            $this->session->set_flashdata('error', 'Data transaksi tidak ditemukan');
            redirect('transaksi');
        }
        
        $data['pakaian'] = $this->Pakaian_model->get_all();
        $data['pelanggan'] = $this->Pelanggan_model->get_all();
        $data['detail'] = $this->Transaksi_model->get_detail_by_transaksi($id);
        $data['no_transaksi'] = $data['header']->no_transaksi;
        $data['is_edit'] = true;
        $data['transaksi_id'] = $id;
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/form', $data); // Reuse form yang sama
        $this->load->view('templates/footer');
    }

public function update($id) {
    // 1. LOAD MODEL LOG (Jika belum di-load di __construct)
        $this->load->model('Activity_log_model');

    // 2. AMBIL DATA LAMA SEBELUM DIUPDATE
        $old_data = $this->Transaksi_model->get_header_by_id($id);

    // 3. PROSES UPDATE KE DATABASE
        $this->Transaksi_model->update($id);

    // 4. AMBIL DATA BARU DARI INPUT POST
        $new_data = $this->input->post();

    // 5. CATAT KE LOG
        $this->Activity_log_model->add_log('transaksi', 'UPDATE', $id, $old_data, $new_data);

        $this->session->set_flashdata('success', 'Data berhasil diupdate');
        redirect('transaksi');
        // if ($this->Transaksi_model->update($id)) {
        //     $this->session->set_flashdata('success', 'Transaksi berhasil diupdate');
        //     redirect('transaksi/detail/' . $id);
        // } else {
        //     $this->session->set_flashdata('error', 'Gagal mengupdate transaksi');
        //     redirect('transaksi/edit/' . $id);
        // }
    }

    public function add() {
        // Cek hak akses add
            if (!can_add('transaksi')) {
                $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses untuk menambah data');
                redirect('transaksi');
            }
        $data['title'] = 'Tambah Transaksi';
        $data['pakaian'] = $this->Pakaian_model->get_all();
        $data['pelanggan'] = $this->Pelanggan_model->get_all();
        $data['no_transaksi'] = $this->Transaksi_model->generate_no();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/form', $data);
        $this->load->view('templates/footer');
    }

    public function save() {
        // Simpan data ke database
        $insert_id = $this->Transaksi_model->insert();
        
        // Jika berhasil simpan, redirect langsung ke halaman Detail
        if ($insert_id) {
            $this->session->set_flashdata('success', 'Transaksi berhasil disimpan');
            redirect('transaksi/detail/' . $insert_id);
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan transaksi');
            redirect('transaksi/add');
        }
    }

    public function detail($id) {
        $data['title'] = 'Detail Transaksi';
        $data['header'] = $this->Transaksi_model->get_header_by_id($id);
        $data['detail'] = $this->Transaksi_model->get_detail_by_transaksi($id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/detail', $data);
        $this->load->view('templates/footer');
    }

    public function delete($id) {
        // Cek hak akses delete
            if (!can_delete('transaksi')) {
                $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses untuk menghapus data');
                redirect('transaksi');
            }
        $this->load->model('Activity_log_model');

    // 1. AMBIL DATA LAMA SEBELUM DIHAPUS
        $old_data = $this->Transaksi_model->get_header_by_id($id);

    // 2. PROSES HAPUS
        $this->Transaksi_model->delete($id);

    // 3. CATAT KE LOG (new_data kosong karena dihapus)
        $this->Activity_log_model->add_log('transaksi', 'DELETE', $id, $old_data, null);

        $this->session->set_flashdata('success', 'Data berhasil dihapus');
        redirect('transaksi');
        // $this->Transaksi_model->delete($id);
        // $this->session->set_flashdata('success', 'Transaksi berhasil dihapus');
        // redirect('transaksi');
    }

    public function print($id) {
        $data['header'] = $this->Transaksi_model->get_header_by_id($id);

        // Filter langsung di query (hanya ambil yang dicentang)
        $this->db->where('ceklis', 1);
        $data['detail'] = $this->Transaksi_model->get_detail_by_transaksi($id);

        $this->load->view('transaksi/print', $data);
    }

} // <-- KURUNG KURAWAL PENUTUP CLASS INI PENTING