<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok_opname extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) redirect('auth');
        $this->load->model(['Stok_opname_model', 'Sabun_model']);
    }

    public function index() {
        $data['title'] = 'Stok Opname Chemical';
        
        // Ambil filter tanggal dari URL
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        
        // Default: Bulan ini
        $data['dari'] = $dari ?: date('Y-m-01');
        $data['sampai'] = $sampai ?: date('Y-m-t');
        
        // Pagination
        $this->load->library('pagination');
        $config['base_url']    = base_url('stok_opname/index');
        $config['total_rows']  = $this->db->where('tanggal >=', $data['dari'])->where('tanggal <=', $data['sampai'])->count_all_results('stok_opname');
        $config['per_page']    = 50;
        $config['uri_segment'] = 3;
        $config['reuse_query_string'] = TRUE; // Agar filter tanggal tidak hilang saat pindah halaman
        
        $config['full_tag_open']   = '<ul class="pagination justify-content-center mt-3">';
        $config['full_tag_close']  = '</ul>';
        $config['cur_tag_open']    = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close']   = '</a></li>';
        $config['num_tag_open']    = '<li class="page-item">';
        $config['num_tag_close']   = '</li>';
        $config['attributes']      = array('class' => 'page-link');
        
        $this->pagination->initialize($config);
        
        $page = ($this->uri->segment(3)) ? (int) $this->uri->segment(3) : 0;
        $data['no'] = $page + 1; // Nomor urut berlanjut
        
        if ($this->uri->segment(3) === NULL) {
            $this->uri->segments[3] = '0'; // Fix PHP 8.1
        }
        
        $data['links']    = $this->pagination->create_links();
        $data['opname']   = $this->Stok_opname_model->get_all($data['dari'], $data['sampai'], $config['per_page'], $page);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('stok_opname/index', $data);
        $this->load->view('templates/footer');
    } // ✅ Kurung kurawal penutup index()

    // ✅ METHOD BARU UNTUK PRINT
    public function print_opname() {
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        
        $data['dari'] = $dari ?: date('Y-m-01');
        $data['sampai'] = $sampai ?: date('Y-m-t');
        
        // Ambil SEMUA data dalam rentang tanggal (tanpa limit pagination)
        $data['opname'] = $this->Stok_opname_model->get_all($data['dari'], $data['sampai']);
        
        // Load view print langsung (tanpa header/sidebar)
        $this->load->view('stok_opname/print', $data);
    } // ✅ Kurung kurawal penutup print_opname()

    public function add() {
        $data['title'] = 'Input Stok Opname';
        $data['sabun'] = $this->Sabun_model->get_all();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('stok_opname/form', $data);
        $this->load->view('templates/footer');
    }

    public function save() {
        $this->load->model('Activity_log_model');
        
        if ($this->Stok_opname_model->insert()) {
            $new_data = $this->input->post();
            $this->Activity_log_model->add_log('stok_opname', 'INSERT', null, null, $new_data);
            $this->session->set_flashdata('success', 'Stok opname berhasil disimpan & stok sistem disesuaikan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan stok opname');
        }
        redirect('stok_opname');
    }

    public function delete($id) {
        $this->load->model('Activity_log_model');
        $old_data = $this->Stok_opname_model->get_by_id($id);
        
        if ($this->Stok_opname_model->delete($id)) {
            $this->Activity_log_model->add_log('stok_opname', 'DELETE', $id, $old_data, null);
            $this->session->set_flashdata('success', 'Data opname dihapus & stok dikembalikan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data');
        }
        redirect('stok_opname');
    }
}