<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sabun extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) redirect('auth');
        $this->load->model(['Sabun_model', 'Satuan_model', 'Supplier_model']); // ✅ Tambah Supplier_model
        // $this->load->model('Sabun_model');
        // $this->load->model('Satuan_model');
    }

    public function index() {
        $data['title'] = 'Master Sabun';
        $data['sabun'] = $this->Sabun_model->get_all();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('sabun/index', $data);
        $this->load->view('templates/footer');
    }

    public function add() {
        $data['title'] = 'Tambah Sabun';
        $data['satuan'] = $this->Satuan_model->get_all();
        $data['supplier'] = $this->Supplier_model->get_all(); // ✅ Kirim data supplier
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('sabun/form', $data);
        $this->load->view('templates/footer');
    }

    public function save() {
        $this->Sabun_model->insert();
        $this->session->set_flashdata('success', 'Data berhasil disimpan');
        redirect('sabun');
    }

    public function edit($id) {
        $data['title'] = 'Edit Sabun';
        $data['row'] = $this->Sabun_model->get_by_id($id);
        $data['satuan'] = $this->Satuan_model->get_all();
        $data['supplier'] = $this->Supplier_model->get_all();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('sabun/form', $data);
        $this->load->view('templates/footer');
    }

    public function update($id) {
        $this->Sabun_model->update($id);
        $this->session->set_flashdata('success', 'Data berhasil diupdate');
        redirect('sabun');
    }

    public function delete($id) {
        $this->Sabun_model->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus');
        redirect('sabun');
    }
}