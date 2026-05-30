<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Satuan_sabun extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) redirect('auth');
        $this->load->model('Satuan_model');
    }

    public function index() {
        $data['title'] = 'Master Satuan Sabun';
        $data['satuan'] = $this->Satuan_model->get_all();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('satuan_sabun/index', $data);
        $this->load->view('templates/footer');
    }

    public function add() {
        $data['title'] = 'Tambah Satuan';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('satuan_sabun/form');
        $this->load->view('templates/footer');
    }

    public function save() {
        $this->Satuan_model->insert();
        $this->session->set_flashdata('success', 'Data berhasil disimpan');
        redirect('satuan_sabun');
    }

    public function edit($id) {
        $data['title'] = 'Edit Satuan';
        $data['row'] = $this->Satuan_model->get_by_id($id);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('satuan_sabun/form', $data);
        $this->load->view('templates/footer');
    }

    public function update($id) {
        $this->Satuan_model->update($id);
        $this->session->set_flashdata('success', 'Data berhasil diupdate');
        redirect('satuan_sabun');
    }

    public function delete($id) {
        $this->Satuan_model->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus');
        redirect('satuan_sabun');
    }
}