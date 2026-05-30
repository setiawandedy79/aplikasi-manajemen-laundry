<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        $this->load->model('Transaksi_model');
        $this->load->model('Pakaian_model');
        $this->load->model('Pelanggan_model');
    }

    public function index() {
        $data['title'] = 'Transaksi Laundry';
        
        // 1. Ambil keyword dari URL (?q=...)
        // Jika kosong, set default jadi string kosong ''
        $keyword = $this->input->get('q');
        if ($keyword === NULL) {
            $keyword = '';
        }

        // 2. Kirim keyword ke model untuk proses filter
        $data['transaksi'] = $this->Transaksi_model->get_all($keyword);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit($id) {
        $data['title'] = 'Edit Transaksi';
        $data['header'] = $this->Transaksi_model->get_header_by_id($id);
        if (!$data['header']) {
            $this->session->set_flashdata('error', 'Data transaksi tidak ditemukan');
            redirect('transaksi');
        }
        
        $data['pakaian'] = $this->Pakaian_model->get_all();
        $data['pelanggan'] = $this->Pelanggan_model->get_all();
        $data['detail'] = $this->Transaksi_model->get_detail_by_transaksi($id);
        $data['no_transaksi'] = $data['header']->no_transaksi;
        $data['is_edit'] = true;
        $data['transaksi_id'] = $id;
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/form', $data); // Reuse form yang sama
        $this->load->view('templates/footer');
    }

public function update($id) {
        if ($this->Transaksi_model->update($id)) {
            $this->session->set_flashdata('success', 'Transaksi berhasil diupdate');
            redirect('transaksi/detail/' . $id);
        } else {
            $this->session->set_flashdata('error', 'Gagal mengupdate transaksi');
            redirect('transaksi/edit/' . $id);
        }
    }

    public function add() {
        $data['title'] = 'Tambah Transaksi';
        $data['pakaian'] = $this->Pakaian_model->get_all();
        $data['pelanggan'] = $this->Pelanggan_model->get_all();
        $data['no_transaksi'] = $this->Transaksi_model->generate_no();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/form', $data);
        $this->load->view('templates/footer');
    }

    public function save() {
        // Simpan data ke database
        $insert_id = $this->Transaksi_model->insert();
        
        // Jika berhasil simpan, redirect langsung ke halaman Detail
        if ($insert_id) {
            $this->session->set_flashdata('success', 'Transaksi berhasil disimpan');
            redirect('transaksi/detail/' . $insert_id);
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan transaksi');
            redirect('transaksi/add');
        }
    }

    public function detail($id) {
        $data['title'] = 'Detail Transaksi';
        $data['header'] = $this->Transaksi_model->get_header_by_id($id);
        $data['detail'] = $this->Transaksi_model->get_detail_by_transaksi($id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/detail', $data);
        $this->load->view('templates/footer');
    }

    public function delete($id) {
        $this->Transaksi_model->delete($id);
        $this->session->set_flashdata('success', 'Transaksi berhasil dihapus');
        redirect('transaksi');
    }

    public function print($id) {
        $data['header'] = $this->Transaksi_model->get_header_by_id($id);

        // Filter langsung di query (hanya ambil yang dicentang)
        $this->db->where('ceklis', 1);
        $data['detail'] = $this->Transaksi_model->get_detail_by_transaksi($id);

        $this->load->view('transaksi/print', $data);
    }

} // <-- KURUNG KURAWAL PENUTUP CLASS INI PENTING