<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penyerahan extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') !== 'admin' && $this->session->userdata('role') !== 'kasir') {
            redirect('dashboard');
        }
        $this->load->model('Transaksi_model');
    }

    public function index() {
        $data['title'] = 'Penyerahan Laundry';
        $data['transaksi'] = $this->Transaksi_model->get_list_penyerahan();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('penyerahan/index', $data);
        $this->load->view('templates/footer');
    }

    public function form($id) {
        $data['title'] = 'Form Penyerahan';
        $data['header'] = $this->Transaksi_model->get_header_by_id($id);
        
        if (!$data['header']) {
            $this->session->set_flashdata('error', 'Data transaksi tidak ditemukan');
            redirect('penyerahan');
        }
        
        $data['detail'] = $this->Transaksi_model->get_detail_for_penyerahan($id);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('penyerahan/form', $data);
        $this->load->view('templates/footer');
    }

    public function save() {
        $id = $this->input->post('transaksi_id');
        $nama_pengambil = $this->input->post('nama_pengambil');
        
        $detail_ids        = $this->input->post('detail_id');
        $jumlah_diserahkan = $this->input->post('jumlah_diserahkan');
        $keterangans       = $this->input->post('keterangan');

        $detail_data = [];
        
        if (!empty($detail_ids) && is_array($detail_ids)) {
            foreach ($detail_ids as $key => $did) {
                $detail_data[] = [
                    'detail_id'  => $did,
                    'jumlah'     => isset($jumlah_diserahkan[$key]) ? (int)$jumlah_diserahkan[$key] : 0, // ⚠️ Koma di sini WAJIB ada!
                    'keterangan' => isset($keterangans[$key]) ? $keterangans[$key] : ''
                ];
            }
        }

        $this->Transaksi_model->update_penyerahan($id, $nama_pengambil, $detail_data);
        $this->session->set_flashdata('success', 'Data penyerahan berhasil disimpan');
        redirect('penyerahan');
    }
}