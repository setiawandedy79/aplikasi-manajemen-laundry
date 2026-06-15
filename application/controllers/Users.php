<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

    public function __construct() {
        parent::__construct();
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
        $data['pelanggan_list'] = $this->db->order_by('nama', 'ASC')->get('pelanggan')->result();
        $data['row'] = null;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('users/form', $data);
        $this->load->view('templates/footer');
    }

    public function edit($id) {
        $data['title'] = 'Edit User';
        $data['row'] = $this->User_model->get_by_id($id);
        $data['pelanggan_list'] = $this->db->order_by('nama', 'ASC')->get('pelanggan')->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('users/form', $data);
        $this->load->view('templates/footer');
    }

    public function save() {
        $id = $this->input->post('id');
        if ($id) {
            $this->User_model->update($id);
        } else {
            $this->User_model->insert();
        }
        redirect('users');
    }

    public function delete($id) {
        $this->User_model->delete($id);
        redirect('users');
    }
}