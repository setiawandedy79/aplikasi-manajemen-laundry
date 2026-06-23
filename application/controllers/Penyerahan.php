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
        $keyword = $this->input->get('keyword');
        if ($keyword === NULL) $keyword = '';
        $data['keyword'] = $keyword;
        
        $user_id = $this->session->userdata('user_id');
        $user_data = $this->db->where('id', $user_id)->get('users')->row();
        $pelanggan_id = isset($user_data->pelanggan_id) ? $user_data->pelanggan_id : null;
        
        // --- KONFIGURASI PAGINATION ---
        $this->load->library('pagination');
        $config['base_url'] = base_url('penyerahan/index');
        $config['total_rows'] = $this->Transaksi_model->count_list_penyerahan($keyword, $pelanggan_id);
        $config['per_page'] = 50;
        $config['uri_segment'] = 3;
        
        // Styling (Sama seperti di atas)
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
        // --------------------------------

        $this->pagination->initialize($config);
        
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        // ✅ TAMBAHKAN BARIS INI DI KETIGA CONTROLLER
        $data['no'] = $page + 1;
        
        // ✅ FIX: Mencegah error ctype_digit() null di PHP 8.1
        // Memaksa segment ke-3 bernilai '0' jika kosong, agar tidak error di create_links()
        if ($this->uri->segment(3) === NULL) {
            $this->uri->segments[3] = '0';
        }
        $data['links'] = $this->pagination->create_links();
        
        $data['transaksi'] = $this->Transaksi_model->get_list_penyerahan($keyword, $pelanggan_id, $config['per_page'], $page);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('penyerahan/index', $data);
        $this->load->view('templates/footer');
    }

    public function form($id) {
        $data['title'] = 'Form Penyerahan';
        // 1. Ambil keyword dari URL (?keyword=...)
            $keyword = $this->input->get('keyword');
            if ($keyword === NULL) {
                $keyword = '';
            }
            
            // 2. Kirim keyword ke view agar input form tetap terisi
            $data['keyword'] = $keyword;
            
            // 3. Kirim keyword ke model untuk proses filter
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

    public function rincian($id) {
        $data['title'] = 'Rincian Penyerahan Linen';
        $data['header'] = $this->Transaksi_model->get_header_by_id($id);
        
        if (!$data['header']) {
            $this->session->set_flashdata('error', 'Data transaksi tidak ditemukan');
            redirect('penyerahan');
        }
        
        // Ambil detail linen khusus untuk penyerahan
        $data['detail'] = $this->Transaksi_model->get_detail_for_penyerahan($id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('penyerahan/rincian', $data);
        $this->load->view('templates/footer');
    }
    
    public function print_rincian($id) {
        $data['header'] = $this->Transaksi_model->get_header_by_id($id);
        
        if (!$data['header']) {
            redirect('penyerahan');
        }
        
        $data['detail'] = $this->Transaksi_model->get_detail_for_penyerahan($id);
        
        // Load view print tanpa header & footer sidebar
        $this->load->view('penyerahan/print_rincian', $data);
    }
    
}