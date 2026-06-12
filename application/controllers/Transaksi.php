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
        $data['title'] = 'Transaksi Laundry';
        $keyword = $this->input->get('keyword');
        
        // 1. Ambil data user yang sedang login
            $user_id = $this->session->userdata('user_id');
            $user_data = $this->db->where('id', $user_id)->get('users')->row();
        
        // 2. Ambil pelanggan_id-nya (Jika NULL, berarti Admin yang bisa lihat semua)
            $pelanggan_id = isset($user_data->pelanggan_id) ? $user_data->pelanggan_id : null;
            
            $data['keyword'] = $keyword;
            
        // 3. Kirim keyword dan pelanggan_id ke model
            $data['transaksi'] = $this->Transaksi_model->get_all($keyword, $pelanggan_id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit($id) {
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