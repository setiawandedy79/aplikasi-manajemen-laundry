<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mutasi extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) redirect('auth');
        $this->load->model(['Mutasi_model', 'Sabun_model']);
    }

    public function index() {
        $data['title'] = 'Mutasi Masuk Sabun';
        $data['mutasi'] = $this->Mutasi_model->get_all();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('mutasi/index', $data);
        $this->load->view('templates/footer');
    }

    public function add() {
        $data['title'] = 'Tambah Mutasi Masuk';
        $data['sabun'] = $this->Sabun_model->get_all();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('mutasi/form', $data);
        $this->load->view('templates/footer');
    }

    public function save() {
        $this->Mutasi_model->insert();
        $this->session->set_flashdata('success', 'Mutasi masuk berhasil disimpan & stok ditambahkan');
        redirect('mutasi');
    }

    public function edit($id) {
        $data['title'] = 'Edit Mutasi Masuk';
        $data['row'] = $this->Mutasi_model->get_by_id($id);
        $data['sabun'] = $this->Sabun_model->get_all();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('mutasi/form', $data);
        $this->load->view('templates/footer');
    }

    public function update($id) {
       $this->load->model('Activity_log_model');
    // 1. AMBIL DATA LAMA SEBELUM DIHAPUS
        $old_data = $this->Mutasi_model->get_header_by_id($id);

    // 2. PROSES HAPUS
        $this->Mutasi_model->delete($id);

    // 3. CATAT KE LOG (new_data kosong karena dihapus)
        $this->Activity_log_model->add_log('mutasi', 'DELETE', $id, $old_data, null);

        $this->session->set_flashdata('success', 'Data berhasil dihapus');
        redirect('mutasi');
        //$this->load->model('Activity_log_model');
        // $this->Mutasi_model->update($id);
        // $this->session->set_flashdata('success', 'Data berhasil diupdate & stok disesuaikan');
        // redirect('mutasi');
    }

    public function delete($id) {
        // 1. AMBIL DATA LAMA SEBELUM DIHAPUS
            $old_data = $this->Mutasi_model->get_header_by_id($id);

        // 2. PROSES HAPUS
            $this->Mutasi_model->delete($id);

        // 3. CATAT KE LOG (new_data kosong karena dihapus)
            $this->Activity_log_model->add_log('mutasi', 'DELETE', $id, $old_data, null);

            $this->session->set_flashdata('success', 'Data berhasil dihapus');
            redirect('mutasi');
        // $this->Mutasi_model->delete($id);
        // $this->session->set_flashdata('success', 'Data dihapus & stok dikembalikan');
        // redirect('mutasi');
    }
}