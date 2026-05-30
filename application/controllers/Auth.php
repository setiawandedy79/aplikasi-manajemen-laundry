<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function index() {
        $this->load->view('auth/login');
    }
// public function login() {
//     $username = $this->input->post('username');
//     $password = $this->input->post('password');

//     $this->load->model('User_model');
//     $user = $this->User_model->get_by_username($username);

//     // DEBUG: Hapus setelah berhasil
//     log_message('error', 'User found: ' . ($user ? 'YES' : 'NO'));
//     if ($user) {
//         log_message('error', 'Password verify: ' . (password_verify($password, $user->password) ? 'TRUE' : 'FALSE'));
//         log_message('error', 'Stored hash: ' . $user->password);
//     }

//     if ($user && password_verify($password, $user->password)) {
//         // ... (kode sukses login)
//     } else {
//         $this->session->set_flashdata('error', 'Username atau Password salah!');
//         redirect('auth');
//     }
// }
    public function login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $this->load->model('User_model');
        $user = $this->User_model->get_by_username($username);

        if ($user && password_verify($password, $user->password)) {
            $this->session->set_userdata([
                'user_id' => $user->id,
                'username' => $user->username,
                'nama_lengkap' => $user->nama_lengkap,
                'role' => $user->role,
                'logged_in' => TRUE
            ]);
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Username atau Password salah!');
            redirect('auth');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }
}