<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller { // Pastikan extend MY_Controller untuk proteksi akses

    public function __construct() {
        parent::__construct();
        // Pastikan hanya admin yang bisa akses controller ini (opsional, bisa juga via config/access.php)
        if ($this->session->userdata('role') !== 'admin') {
            redirect('dashboard');
        }
        $this->load->model('User_model');
    }

    public function index() {
        $data['title'] = 'Master User';
        $data['users'] = $this->User_model->get_all();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('users/index', $data);
        $this->load->view('templates/footer');
    }

    public function add() {
        $data['title'] = 'Tambah User';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('users/form', $data);
        $this->load->view('templates/footer');
    }

    public function save() {
        // Validasi Form
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembali ke form dengan error
            $this->session->set_flashdata('error', validation_errors());
            redirect('users/add');
        } else {
            if ($this->User_model->insert()) {
                $this->session->set_flashdata('success', 'User berhasil ditambahkan');
            } else {
                $this->session->set_flashdata('error', 'Gagal! Username mungkin sudah digunakan');
            }
            redirect('users');
        }
    }

    public function edit($id) {
        $data['title'] = 'Edit User';
        $data['row'] = $this->User_model->get_by_id($id);
        if (!$data['row']) redirect('users');
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('users/form', $data);
        $this->load->view('templates/footer');
    }

    public function update($id) {
        $this->form_validation->set_rules('username', 'Username', "required|min_length[4]|is_unique[users.username.id.{$id}]");
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('users/edit/'.$id);
        } else {
            if ($this->User_model->update($id)) {
                $this->session->set_flashdata('success', 'User berhasil diupdate');
            } else {
                $this->session->set_flashdata('error', 'Gagal! Username mungkin sudah digunakan');
            }
            redirect('users');
        }
    }

    public function delete($id) {
        if ($this->User_model->delete($id)) {
            $this->session->set_flashdata('success', 'User berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus user (tidak bisa hapus diri sendiri)');
        }
        redirect('users');
    }
}