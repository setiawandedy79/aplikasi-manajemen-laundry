<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) redirect('auth');
        $this->load->model('Pelanggan_model');
    }

    public function index() {
        $data['title'] = 'Master Pelanggan';
        $data['pelanggan'] = $this->Pelanggan_model->get_all();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('pelanggan/index', $data);
        $this->load->view('templates/footer');
    }

    public function add() {
        $data['title'] = 'Tambah Pelanggan';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('pelanggan/form');
        $this->load->view('templates/footer');
    }

    public function save() {
        $this->Pelanggan_model->insert();
        $this->session->set_flashdata('success', 'Data berhasil disimpan');
        redirect('pelanggan');
    }

    public function edit($id) {
        $data['title'] = 'Edit Pelanggan';
        $data['row'] = $this->Pelanggan_model->get_by_id($id);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('pelanggan/form', $data);
        $this->load->view('templates/footer');
    }

    public function update($id) {
        $this->Pelanggan_model->update($id);
        $this->session->set_flashdata('success', 'Data berhasil diupdate');
        redirect('pelanggan');
    }

    public function delete($id) {
        $this->Pelanggan_model->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus');
        redirect('pelanggan');
    }
}