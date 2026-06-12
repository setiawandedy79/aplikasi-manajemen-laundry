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
         // 1. Ambil data user yang sedang login
                $user_id = $this->session->userdata('user_id');
                $user_data = $this->db->where('id', $user_id)->get('users')->row();
    
        // 2. Tentukan pelanggan_id
                $pelanggan_id = isset($user_data->pelanggan_id) ? $user_data->pelanggan_id : null;

        // 3. Load model yang diperlukan
                $this->load->model('Transaksi_model');

        // ✅ TAMBAHKAN BARIS INI UNTUK MENGHILANGKAN ERROR
        // 4. Hitung Total Transaksi (difilter sesuai unit jika bukan admin)
                $data['total_transaksi'] = $this->Transaksi_model->count_all($pelanggan_id);

        // 5. ✅ HITUNG TOTAL PELANGGAN / UNIT
            // Jika user adalah petugas unit, totalnya adalah 1. Jika admin, hitung semua unit.
                if (!empty($pelanggan_id)) {
                    $data['total_pelanggan'] = 1; 
                } else {
                    $data['total_pelanggan'] = $this->db->count_all('pelanggan');
                }

        // 6. ✅ HITUNG TOTAL SABUN / CHEMICAL
                $data['total_sabun'] = $this->db->count_all('sabun');
        
            // (Kode lain untuk transaksi_terbaru, dll tetap di sini...)
        // 7. Ambil data transaksi terbaru (difilter sesuai unit)
                $data['transaksi_terbaru'] = $this->Transaksi_model->get_latest(5, $pelanggan_id);
                
        // $data['total_transaksi'] = $this->Transaksi_model->count_all();
        // $data['total_pelanggan'] = $this->Pelanggan_model->count_all();
        // $data['total_sabun'] = $this->Sabun_model->count_all();
        // $data['transaksi_terbaru'] = $this->Transaksi_model->get_latest(5, $pelanggan_id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }
}