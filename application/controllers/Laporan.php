<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) redirect('auth');
        $this->load->model('Laporan_model');
        $this->load->model('Sabun_model');
    }

    public function index() {
        $data['title'] = 'Menu Laporan';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('laporan/index', $data);
        $this->load->view('templates/footer');
    }

    public function mutasi_masuk() {
        $data['title'] = 'Laporan Mutasi Masuk Sabun';
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $data['dari'] = $dari ?: date('Y-m-d');
        $data['sampai'] = $sampai ?: date('Y-m-d');
        $data['data'] = $this->Laporan_model->get_mutasi_masuk($data['dari'], $data['sampai']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('laporan/mutasi_masuk', $data);
        $this->load->view('templates/footer');
    }

    public function pemakaian_shift() {
        $data['title'] = 'Laporan Pemakaian Sabun Per Shift';
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $data['dari'] = $dari ?: date('Y-m-d');
        $data['sampai'] = $sampai ?: date('Y-m-d');
        $data['data'] = $this->Laporan_model->get_pemakaian_shift($data['dari'], $data['sampai']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('laporan/pemakaian_shift', $data);
        $this->load->view('templates/footer');
    }

    public function stok_sabun() {
        $data['title'] = 'Laporan Stok Sabun';
        $data['sabun'] = $this->Laporan_model->get_stok_sabun();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('laporan/stok_sabun', $data);
        $this->load->view('templates/footer');
    }

    public function transaksi() {
        $data['title'] = 'Laporan Transaksi Laundry';
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $data['dari'] = $dari ?: date('Y-m-d');
        $data['sampai'] = $sampai ?: date('Y-m-d');
        $data['data'] = $this->Laporan_model->get_laporan_transaksi($data['dari'], $data['sampai']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('laporan/transaksi', $data);
        $this->load->view('templates/footer');
    }
}