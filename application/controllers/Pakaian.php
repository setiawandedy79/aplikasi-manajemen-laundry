<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pakaian extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) redirect('auth');
        $this->load->model('Pakaian_model');
    }

    public function index() {
        $data['title'] = 'Master Pakaian';
        $data['pakaian'] = $this->Pakaian_model->get_all();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('pakaian/index', $data);
        $this->load->view('templates/footer');
    }

    public function add() {
        $data['title'] = 'Tambah Pakaian';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('pakaian/form');
        $this->load->view('templates/footer');
    }

    public function save() {
        $this->Pakaian_model->insert();
        $this->session->set_flashdata('success', 'Data berhasil disimpan');
        redirect('pakaian');
    }

    public function edit($id) {
        $data['title'] = 'Edit Pakaian';
        $data['row'] = $this->Pakaian_model->get_by_id($id);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('pakaian/form', $data);
        $this->load->view('templates/footer');
    }

    public function update($id) {
        $this->Pakaian_model->update($id);
        $this->session->set_flashdata('success', 'Data berhasil diupdate');
        redirect('pakaian');
    }

    public function delete($id) {
        $this->Pakaian_model->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus');
        redirect('pakaian');
    }
}