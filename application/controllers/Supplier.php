<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends MY_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) redirect('auth');
        $this->load->model('Supplier_model');
    }

    public function index() {
        $data['title'] = 'Master Supplier';
        $data['supplier'] = $this->Supplier_model->get_all();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('supplier/index', $data);
        $this->load->view('templates/footer');
    }

    public function add() {
        $data['title'] = 'Tambah Supplier';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('supplier/form');
        $this->load->view('templates/footer');
    }

    public function save() {
        $this->Supplier_model->insert();
        $this->session->set_flashdata('success', 'Data berhasil disimpan');
        redirect('supplier');
    }

    public function edit($id) {
        $data['title'] = 'Edit Supplier';
        $data['row'] = $this->Supplier_model->get_by_id($id);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('supplier/form', $data);
        $this->load->view('templates/footer');
    }

    public function update($id) {
        $this->Supplier_model->update($id);
        $this->session->set_flashdata('success', 'Data berhasil diupdate');
        redirect('supplier');
    }

    public function delete($id) {
        $this->Supplier_model->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus');
        redirect('supplier');
    }
}