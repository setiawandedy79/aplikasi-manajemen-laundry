<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        $this->load->model('Transaksi_model');
        $this->load->model('Sabun_model');
        $this->load->model('Pelanggan_model');
    }

    public function index() {
        $data['title'] = 'Dashboard';
        $data['total_transaksi'] = $this->Transaksi_model->count_all();
        $data['total_pelanggan'] = $this->Pelanggan_model->count_all();
        $data['total_sabun'] = $this->Sabun_model->count_all();
        $data['transaksi_terbaru'] = $this->Transaksi_model->get_latest(5);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }
}