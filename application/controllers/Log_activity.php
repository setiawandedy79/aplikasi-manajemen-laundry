<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_activity extends MY_Controller {
    public function __construct() {
        parent::__construct();
        // Pastikan hanya admin yang bisa melihat log
        if ($this->session->userdata('role') !== 'admin') {
            redirect('dashboard');
        }
        $this->load->model('Activity_log_model');
    }

    public function index() {
        $data['title'] = 'Log Aktivitas Sistem';
        
        // Ambil 100 log terbaru
        $this->db->order_by('id', 'DESC')->limit(100);
        $data['logs'] = $this->db->get('activity_log')->result();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('log_activity/index', $data);
        $this->load->view('templates/footer');
    }

    public function cleanup() {
    // Keamanan: Hanya admin yang boleh menghapus log
    if ($this->session->userdata('role') !== 'admin') {
        redirect('dashboard');
    }

    // Hitung tanggal 1 tahun yang lalu
    $one_year_ago = date('Y-m-d H:i:s', strtotime('-1 year'));

    // Hitung berapa banyak data yang akan dihapus (untuk notifikasi)
    $this->db->where('created_at <', $one_year_ago);
    $total_hapus = $this->db->count_all_results('activity_log');

    if ($total_hapus > 0) {
        // Lakukan penghapusan
        $this->db->where('created_at <', $one_year_ago);
        $this->db->delete('activity_log');
        
        $this->session->set_flashdata('success', "Berhasil menghapus $total_hapus data log yang berumur lebih dari 1 tahun.");
    } else {
        $this->session->set_flashdata('info', "Tidak ada data log yang berumur lebih dari 1 tahun untuk dihapus.");
    }

    redirect('log_activity');
    }
}