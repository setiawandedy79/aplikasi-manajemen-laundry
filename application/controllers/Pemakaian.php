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
        $data['pemakaian'] = $this->Pemakaian_model->get_all();
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

    public function update($id) {
        if ($this->Pemakaian_model->update($id)) {
            $this->session->set_flashdata('success', 'Data berhasil diupdate');
        } else {
            $this->session->set_flashdata('error', 'Gagal! Stok tidak mencukupi untuk koreksi');
        }
        redirect('pemakaian');
    }

    public function delete($id) {
        $this->Pemakaian_model->delete($id);
        $this->session->set_flashdata('success', 'Data dihapus & stok dikembalikan');
        redirect('pemakaian');
    }
}