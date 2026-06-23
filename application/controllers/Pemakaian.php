<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemakaian extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) redirect('auth');
        $this->load->model(['Pemakaian_model', 'Sabun_model']);
    }

    public function index() {
    $data['title'] = 'Input Pemakaian Sabun';
    
    // --- KONFIGURASI PAGINATION ---
    $this->load->library('pagination');
    $config['base_url'] = base_url('pemakaian/index');
    $config['total_rows'] = $this->Pemakaian_model->count_all();
    $config['per_page'] = 50;
    $config['uri_segment'] = 3;
    
    // Styling Bootstrap (sama seperti sebelumnya)
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
    
    $this->pagination->initialize($config);
    
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

    // ✅ TAMBAHKAN BARIS INI: Hitung nomor urut awal (Offset + 1)
    $data['no'] = $page + 1;
    
    // ✅ FIX: Mencegah error ctype_digit() null di PHP 8.1
    // Memaksa segment ke-3 bernilai '0' jika kosong, agar tidak error di create_links()
    if ($this->uri->segment(3) === NULL) {
        $this->uri->segments[3] = '0';
    }
    
    $data['links'] = $this->pagination->create_links();
    $data['pemakaian'] = $this->Pemakaian_model->get_all($config['per_page'], $page);
    
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('pemakaian/index', $data);
    $this->load->view('templates/footer');
}

    public function add() {
        $data['title'] = 'Tambah Pemakaian';
        $data['sabun'] = $this->Sabun_model->get_all();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('pemakaian/form', $data);
        $this->load->view('templates/footer');
    }

    public function save() {
        if ($this->Pemakaian_model->insert()) {
            $this->session->set_flashdata('success', 'Pemakaian berhasil disimpan & stok diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal! Stok sabun tidak mencukupi');
        }
        redirect('pemakaian');
    }

    public function edit($id) {
        $data['title'] = 'Edit Pemakaian';
        $data['row'] = $this->Pemakaian_model->get_by_id($id);
        $data['sabun'] = $this->Sabun_model->get_all();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('pemakaian/form', $data);
        $this->load->view('templates/footer');
    }

    // ✅ METHOD UPDATE YANG BENAR
    public function update($id) {
        $this->load->model('Activity_log_model');
        
        // 1. AMBIL DATA LAMA SEBELUM DIUPDATE (untuk log)
        $old_data = $this->Pemakaian_model->get_by_id($id); // ✅ Sudah diperbaiki
        
        // 2. PROSES UPDATE KE DATABASE
        if ($this->Pemakaian_model->update($id)) {
            // 3. AMBIL DATA BARU DARI INPUT POST (untuk log)
            $new_data = $this->input->post();
            
            // 4. CATAT KE LOG SEBAGAI "UPDATE"
            $this->Activity_log_model->add_log('pemakaian', 'UPDATE', $id, $old_data, $new_data);
            
            $this->session->set_flashdata('success', 'Data berhasil diupdate & stok disesuaikan');
        } else {
            $this->session->set_flashdata('error', 'Gagal! Stok tidak mencukupi untuk koreksi');
        }
        
        redirect('pemakaian');
    }

    // ✅ METHOD DELETE YANG BENAR
    public function delete($id) {
        $this->load->model('Activity_log_model');
        
        // 1. AMBIL DATA LAMA SEBELUM DIHAPUS
        $old_data = $this->Pemakaian_model->get_by_id($id); // ✅ Sudah diperbaiki
        
        // 2. PROSES HAPUS
        $this->Pemakaian_model->delete($id);
        
        // 3. CATAT KE LOG SEBAGAI "DELETE"
        $this->Activity_log_model->add_log('pemakaian', 'DELETE', $id, $old_data, null);
        
        $this->session->set_flashdata('success', 'Data berhasil dihapus & stok dikembalikan');
        redirect('pemakaian');
    }
}