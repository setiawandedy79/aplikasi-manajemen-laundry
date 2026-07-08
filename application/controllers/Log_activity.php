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
        
        // --- KONFIGURASI PAGINATION ---
        $this->load->library('pagination');
        $config['base_url'] = base_url('log_activity/index');
        $config['total_rows'] = $this->db->count_all('activity_log');
        $config['per_page'] = 50; // 50 log per halaman
        $config['uri_segment'] = 3;
        
        // Styling Bootstrap
        $config['full_tag_open'] = '<ul class="pagination justify-content-center mt-3">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');
        
        $this->pagination->initialize($config);
        
        $page = ($this->uri->segment(3)) ? (int) $this->uri->segment(3) : 0;
        $data['no'] = $page + 1; // Nomor urut berlanjut
        
        if ($this->uri->segment(3) === NULL) {
            $this->uri->segments[3] = '0';
        }
        
        $data['links'] = $this->pagination->create_links();
        
        // ✅ JOIN DENGAN TABEL USERS UNTUK AMBIL NAMA LENGKAP
        $this->db->select('
            activity_log.*,
            users.nama_lengkap as user_nama,
            users.username as user_username
        ');
        $this->db->from('activity_log');
        $this->db->join('users', 'users.id = activity_log.user_id', 'left');
        $this->db->order_by('activity_log.id', 'DESC');
        $this->db->limit($config['per_page'], $page);
        $data['logs'] = $this->db->get()->result();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('log_activity/index', $data);
        $this->load->view('templates/footer');
    }

    public function cleanup() {
        if ($this->session->userdata('role') !== 'admin') {
            redirect('dashboard');
        }
        $one_year_ago = date('Y-m-d H:i:s', strtotime('-1 year'));
        $this->db->where('created_at <', $one_year_ago);
        $total_hapus = $this->db->count_all_results('activity_log');
        if ($total_hapus > 0) {
            $this->db->where('created_at <', $one_year_ago);
            $this->db->delete('activity_log');
            $this->session->set_flashdata('success', "Berhasil menghapus $total_hapus data log yang berumur lebih dari 1 tahun.");
        } else {
            $this->session->set_flashdata('info', "Tidak ada data log yang berumur lebih dari 1 tahun untuk dihapus.");
        }
        redirect('log_activity');
    }
}