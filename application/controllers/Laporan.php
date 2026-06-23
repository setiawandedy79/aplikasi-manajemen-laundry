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
        
        // 1. Ambil parameter tanggal dari URL
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        
        // 2. Default ke bulan ini jika kosong
        if (empty($dari) || empty($sampai)) {
            $dari = date('Y-m-01'); // Tanggal 1 bulan ini
            $sampai = date('Y-m-t'); // Tanggal terakhir bulan ini
        }
        
        $data['dari'] = $dari;
        $data['sampai'] = $sampai;
        
        // 3. Ambil data sabun
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

    public function pengambilan_linen() {
        $data['title'] = 'Laporan Pengambilan Linen';
        $data['bulan'] = $this->input->get('bulan') ?: date('m');
        $data['tahun'] = $this->input->get('tahun') ?: date('Y');
        
        // ✅ Ambil parameter ruangan (default: RUANG OK jika kosong)
        $data['ruangan'] = $this->input->get('ruangan') ?: 'RUANG OK'; 

        $nama_bulan_arr = ['01'=>'JANUARI','02'=>'FEBRUARI','03'=>'MARET','04'=>'APRIL','05'=>'MEI','06'=>'JUNI','07'=>'JULI','08'=>'AGUSTUS','09'=>'SEPTEMBER','10'=>'OKTOBER','11'=>'NOVEMBER','12'=>'DESEMBER'];
        $data['nama_bulan'] = $nama_bulan_arr[$data['bulan']];

        // Ambil daftar pelanggan/ruangan untuk dropdown
        $data['daftar_ruangan'] = $this->db->get('pelanggan')->result();

        $all_linens = $this->db->get('pakaian')->result();
        $data['linen_list'] = $all_linens;

        // Query Data
        $this->db->select('td.pakaian_id, DAY(th.tanggal) as hari, SUM(td.jumlah) as total');
        $this->db->from('transaksi_detail td');
        $this->db->join('transaksi_header th', 'th.id = td.transaksi_id');
        
        // ✅ Filter Ruangan Dinamis
        if (!empty($data['ruangan'])) {
            $this->db->join('pelanggan p', 'p.id = th.pelanggan_id');
            $this->db->where('p.nama', $data['ruangan']);
        }

        $this->db->where('td.ceklis', 1);
        $this->db->where('MONTH(th.tanggal)', $data['bulan']);
        $this->db->where('YEAR(th.tanggal)', $data['tahun']);
        $this->db->group_by('td.pakaian_id, DAY(th.tanggal)');
        
        $query = $this->db->get();
        $data_transaksi = [];
        foreach ($query->result() as $row) { $data_transaksi[$row->pakaian_id][$row->hari] = $row->total; }
        $data['data_transaksi'] = $data_transaksi;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('laporan/pengambilan_linen', $data);
        $this->load->view('templates/footer');
    }


    public function print_pengambilan_linen() {
        // 1. Ambil Parameter
        $data['bulan'] = $this->input->get('bulan') ?: date('m');
        $data['tahun'] = $this->input->get('tahun') ?: date('Y');
        $data['ruangan'] = $this->input->get('ruangan') ?: 'RUANG OK';

        // 2. Nama Bulan
        $nama_bulan_arr = ['01'=>'JANUARI','02'=>'FEBRUARI','03'=>'MARET','04'=>'APRIL','05'=>'MEI','06'=>'JUNI','07'=>'JULI','08'=>'AGUSTUS','09'=>'SEPTEMBER','10'=>'OKTOBER','11'=>'NOVEMBER','12'=>'DESEMBER'];
        $data['nama_bulan'] = $nama_bulan_arr[$data['bulan']];

        // 3. Ambil Data Linen
        $data['linen_list'] = $this->db->get('pakaian')->result();

        // 4. Query Transaksi
        $this->db->select('td.pakaian_id, DAY(th.tanggal) as hari, SUM(td.jumlah) as total');
        $this->db->from('transaksi_detail td');
        $this->db->join('transaksi_header th', 'th.id = td.transaksi_id');
        
        if (!empty($data['ruangan'])) {
            $this->db->join('pelanggan p', 'p.id = th.pelanggan_id');
            $this->db->where('p.nama', $data['ruangan']);
    }

        $this->db->where('td.ceklis', 1);
        $this->db->where('MONTH(th.tanggal)', $data['bulan']);
        $this->db->where('YEAR(th.tanggal)', $data['tahun']);
        $this->db->group_by('td.pakaian_id, DAY(th.tanggal)');
        
        $query = $this->db->get();
        $data_transaksi = [];
        foreach ($query->result() as $row) { 
            $data_transaksi[$row->pakaian_id][$row->hari] = $row->total; 
    }
        $data['data_transaksi'] = $data_transaksi;

        // 5. Load View Print (Tanpa header & footer sidebar)
        $this->load->view('laporan/print_pengambilan_linen', $data);
    }

    public function pengembalian_linen() {
        $data['title'] = 'Laporan Pengembalian Linen';
        
        // Ambil parameter filter
        $data['bulan'] = $this->input->get('bulan') ?: date('m');
        $data['tahun'] = $this->input->get('tahun') ?: date('Y');
        $data['ruangan'] = $this->input->get('ruangan') ?: 'RUANG OK';
        
        // Nama bulan
        $nama_bulan_arr = ['01'=>'JANUARI','02'=>'FEBRUARI','03'=>'MARET','04'=>'APRIL','05'=>'MEI','06'=>'JUNI','07'=>'JULI','08'=>'AGUSTUS','09'=>'SEPTEMBER','10'=>'OKTOBER','11'=>'NOVEMBER','12'=>'DESEMBER'];
        $data['nama_bulan'] = $nama_bulan_arr[$data['bulan']];
        
        // Ambil daftar ruangan untuk dropdown
        $data['daftar_ruangan'] = $this->db->get('pelanggan')->result();
        
        // Ambil semua linen dengan berat bersih
        $this->db->select('id, nama_pakaian, berat_bersih');
        $data['linen_list'] = $this->db->get('pakaian')->result();
        
        // Query data pengembalian (jumlah_diserahkan) per hari
        $this->db->select('td.pakaian_id, DAY(th.tanggal) as hari, SUM(td.jumlah_diserahkan) as total');
        $this->db->from('transaksi_detail td');
        $this->db->join('transaksi_header th', 'th.id = td.transaksi_id');
        
        if (!empty($data['ruangan'])) {
            $this->db->join('pelanggan p', 'p.id = th.pelanggan_id');
            $this->db->where('p.nama', $data['ruangan']);
        }
        
        $this->db->where('td.jumlah_diserahkan >', 0); // Hanya yang ada penyerahan
        $this->db->where('MONTH(th.tanggal)', $data['bulan']);
        $this->db->where('YEAR(th.tanggal)', $data['tahun']);
        $this->db->group_by('td.pakaian_id, DAY(th.tanggal)');
        
        $query = $this->db->get();
        
        $data_transaksi = [];
        foreach ($query->result() as $row) {
            $data_transaksi[$row->pakaian_id][$row->hari] = $row->total;
        }
        $data['data_transaksi'] = $data_transaksi;
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('laporan/pengembalian_linen', $data);
        $this->load->view('templates/footer');  
}

    public function print_pengembalian_linen() {
        $data['bulan'] = $this->input->get('bulan') ?: date('m');
        $data['tahun'] = $this->input->get('tahun') ?: date('Y');
        $data['ruangan'] = $this->input->get('ruangan') ?: 'RUANG OK';
        
        $nama_bulan_arr = ['01'=>'JANUARI','02'=>'FEBRUARI','03'=>'MARET','04'=>'APRIL','05'=>'MEI','06'=>'JUNI','07'=>'JULI','08'=>'AGUSTUS','09'=>'SEPTEMBER','10'=>'OKTOBER','11'=>'NOVEMBER','12'=>'DESEMBER'];
        $data['nama_bulan'] = $nama_bulan_arr[$data['bulan']];
        
        $this->db->select('id, nama_pakaian, berat_bersih');
        $data['linen_list'] = $this->db->get('pakaian')->result();
        
        $this->db->select('td.pakaian_id, DAY(th.tanggal) as hari, SUM(td.jumlah_diserahkan) as total');
        $this->db->from('transaksi_detail td');
        $this->db->join('transaksi_header th', 'th.id = td.transaksi_id');
        
        if (!empty($data['ruangan'])) {
            $this->db->join('pelanggan p', 'p.id = th.pelanggan_id');
            $this->db->where('p.nama', $data['ruangan']);
        }
        
        $this->db->where('td.jumlah_diserahkan >', 0);
        $this->db->where('MONTH(th.tanggal)', $data['bulan']);
        $this->db->where('YEAR(th.tanggal)', $data['tahun']);
        $this->db->group_by('td.pakaian_id, DAY(th.tanggal)');
        
        $query = $this->db->get();
        $data_transaksi = [];
        foreach ($query->result() as $row) {
            $data_transaksi[$row->pakaian_id][$row->hari] = $row->total;
        }
        $data['data_transaksi'] = $data_transaksi;
        
        $this->load->view('laporan/print_pengembalian_linen', $data);
    }

    public function rekapitulasi_pencucian() {
        $data['title'] = 'Rekapitulasi Hasil Pencucian Linen Bersih';
        
        // Ambil parameter tahun (default tahun ini)
        $data['tahun'] = $this->input->get('tahun') ?: date('Y');
        
        // Daftar bulan
        $data['bulan_list'] = [
            1=>'JANUARI', 2=>'FEBRUARI', 3=>'MARET', 4=>'APRIL', 
            5=>'MEI', 6=>'JUNI', 7=>'JULI', 8=>'AGUSTUS', 
            9=>'SEPTEMBER', 10=>'OKTOBER', 11=>'NOVEMBER', 12=>'DESEMBER'
        ];
        
        // Ambil semua pelanggan/unit
        $data['unit_list'] = $this->db->order_by('nama', 'ASC')->get('pelanggan')->result();
        
        // Query: Total berat per pelanggan per bulan
        // Rumus: SUM(jumlah_diserahkan × berat_bersih)
        $this->db->select('
            th.pelanggan_id, 
            MONTH(th.tanggal) as bulan, 
            SUM(td.jumlah_diserahkan * p.berat_bersih) as total_berat
        ');
        $this->db->from('transaksi_detail td');
        $this->db->join('transaksi_header th', 'th.id = td.transaksi_id');
        $this->db->join('pakaian p', 'p.id = td.pakaian_id');
        $this->db->where('td.jumlah_diserahkan >', 0);
        $this->db->where('YEAR(th.tanggal)', $data['tahun']);
        $this->db->where('th.status_serah', 'diserahkan'); // Hanya yang sudah diserahkan
        $this->db->group_by('th.pelanggan_id, MONTH(th.tanggal)');
        
        $query = $this->db->get();
        
        // Format: [pelanggan_id][bulan] = total_berat
        $data_berat = [];
        foreach ($query->result() as $row) {
            $data_berat[$row->pelanggan_id][$row->bulan] = (float)$row->total_berat;
        }
        $data['data_berat'] = $data_berat;
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('laporan/rekapitulasi_pencucian', $data);
        $this->load->view('templates/footer');
    }

    public function print_rekapitulasi_pencucian() {
        $data['tahun'] = $this->input->get('tahun') ?: date('Y');
        
        $data['bulan_list'] = [
            1=>'JANUARI', 2=>'FEBRUARI', 3=>'MARET', 4=>'APRIL', 
            5=>'MEI', 6=>'JUNI', 7=>'JULI', 8=>'AGUSTUS', 
            9=>'SEPTEMBER', 10=>'OKTOBER', 11=>'NOVEMBER', 12=>'DESEMBER'
        ];
        
        $data['unit_list'] = $this->db->order_by('nama', 'ASC')->get('pelanggan')->result();
        
        $this->db->select('
            th.pelanggan_id, 
            MONTH(th.tanggal) as bulan, 
            SUM(td.jumlah_diserahkan * p.berat_bersih) as total_berat
        ');
        $this->db->from('transaksi_detail td');
        $this->db->join('transaksi_header th', 'th.id = td.transaksi_id');
        $this->db->join('pakaian p', 'p.id = td.pakaian_id');
        $this->db->where('td.jumlah_diserahkan >', 0);
        $this->db->where('YEAR(th.tanggal)', $data['tahun']);
        $this->db->where('th.status_serah', 'diserahkan');
        $this->db->group_by('th.pelanggan_id, MONTH(th.tanggal)');
        
        $query = $this->db->get();
        $data_berat = [];
        foreach ($query->result() as $row) {
            $data_berat[$row->pelanggan_id][$row->bulan] = (float)$row->total_berat;
        }
        $data['data_berat'] = $data_berat;
        
        $this->load->view('laporan/print_rekapitulasi_pencucian', $data);
    }

    public function penggunaan_chemical() {
        $data['title'] = 'Laporan Penggunaan Chemical';
        
        $data['bulan'] = $this->input->get('bulan') ?: date('m');
        $data['tahun'] = $this->input->get('tahun') ?: date('Y');
        
        $nama_bulan_arr = ['01'=>'JANUARI','02'=>'FEBRUARI','03'=>'MARET','04'=>'APRIL','05'=>'MEI','06'=>'JUNI','07'=>'JULI','08'=>'AGUSTUS','09'=>'SEPTEMBER','10'=>'OKTOBER','11'=>'NOVEMBER','12'=>'DESEMBER'];
        $data['nama_bulan'] = $nama_bulan_arr[$data['bulan']];

        // 1. Ambil daftar chemical/sabun unik dengan JOIN ke tabel sabun & satuan
        $this->db->select('sabun.nama_sabun, satuan_sabun.nama_satuan');
        $this->db->from('pemakaian_sabun');
        $this->db->join('sabun', 'sabun.id = pemakaian_sabun.sabun_id', 'left');
        $this->db->join('satuan_sabun', 'satuan_sabun.id = sabun.satuan_id', 'left');
        $this->db->group_by('sabun.nama_sabun, satuan_sabun.nama_satuan');
        $this->db->order_by('sabun.nama_sabun', 'ASC');
        $data['chemical_list'] = $this->db->get()->result();

        // 2. Ambil data pemakaian per hari
        $this->db->select('sabun.nama_sabun, DAY(pemakaian_sabun.tanggal) as hari, SUM(pemakaian_sabun.jumlah) as total_harian, satuan_sabun.nama_satuan');
        $this->db->from('pemakaian_sabun');
        $this->db->join('sabun', 'sabun.id = pemakaian_sabun.sabun_id', 'left');
        $this->db->join('satuan_sabun', 'satuan_sabun.id = sabun.satuan_id', 'left');
        $this->db->where('MONTH(pemakaian_sabun.tanggal)', $data['bulan']);
        $this->db->where('YEAR(pemakaian_sabun.tanggal)', $data['tahun']);
        $this->db->group_by('sabun.nama_sabun, DAY(pemakaian_sabun.tanggal)');
        $query = $this->db->get();

        $data_transaksi = [];
        $satuan_chemical = [];
        foreach ($query->result() as $row) {
            $data_transaksi[$row->nama_sabun][$row->hari] = $row->total_harian;
            $satuan_chemical[$row->nama_sabun] = $row->nama_satuan;
        }
        
        $data['data_transaksi'] = $data_transaksi;
        $data['satuan_chemical'] = $satuan_chemical;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('laporan/penggunaan_chemical', $data);
        $this->load->view('templates/footer');
    }

    public function print_penggunaan_chemical() {
        $data['bulan'] = $this->input->get('bulan') ?: date('m');
        $data['tahun'] = $this->input->get('tahun') ?: date('Y');
        
        $nama_bulan_arr = ['01'=>'JANUARI','02'=>'FEBRUARI','03'=>'MARET','04'=>'APRIL','05'=>'MEI','06'=>'JUNI','07'=>'JULI','08'=>'AGUSTUS','09'=>'SEPTEMBER','10'=>'OKTOBER','11'=>'NOVEMBER','12'=>'DESEMBER'];
        $data['nama_bulan'] = $nama_bulan_arr[$data['bulan']];

        // Query sama persis dengan di atas untuk view print
        $this->db->select('sabun.nama_sabun, satuan_sabun.nama_satuan');
        $this->db->from('pemakaian_sabun');
        $this->db->join('sabun', 'sabun.id = pemakaian_sabun.sabun_id', 'left');
        $this->db->join('satuan_sabun', 'satuan_sabun.id = sabun.satuan_id', 'left');
        $this->db->group_by('sabun.nama_sabun, satuan_sabun.nama_satuan');
        $this->db->order_by('sabun.nama_sabun', 'ASC');
        $data['chemical_list'] = $this->db->get()->result();

        $this->db->select('sabun.nama_sabun, DAY(pemakaian_sabun.tanggal) as hari, SUM(pemakaian_sabun.jumlah) as total_harian, satuan_sabun.nama_satuan');
        $this->db->from('pemakaian_sabun');
        $this->db->join('sabun', 'sabun.id = pemakaian_sabun.sabun_id', 'left');
        $this->db->join('satuan_sabun', 'satuan_sabun.id = sabun.satuan_id', 'left');
        $this->db->where('MONTH(pemakaian_sabun.tanggal)', $data['bulan']);
        $this->db->where('YEAR(pemakaian_sabun.tanggal)', $data['tahun']);
        $this->db->group_by('sabun.nama_sabun, DAY(pemakaian_sabun.tanggal)');
        $query = $this->db->get();

        $data_transaksi = [];
        $satuan_chemical = [];
        foreach ($query->result() as $row) {
            $data_transaksi[$row->nama_sabun][$row->hari] = $row->total_harian;
            $satuan_chemical[$row->nama_sabun] = $row->nama_satuan;
        }
        
        $data['data_transaksi'] = $data_transaksi;
        $data['satuan_chemical'] = $satuan_chemical;

        $this->load->view('laporan/print_penggunaan_chemical', $data);
    }

    public function rekapitulasi_chemical() {
        $data['title'] = 'Rekapitulasi Penggunaan Chemical';
        
        // Ambil parameter tahun (default tahun ini)
        $data['tahun'] = $this->input->get('tahun') ?: date('Y');
        
        // 1. Ambil daftar chemical/sabun unik dengan JOIN
        $this->db->select('sabun.nama_sabun, satuan_sabun.nama_satuan');
        $this->db->from('pemakaian_sabun');
        $this->db->join('sabun', 'sabun.id = pemakaian_sabun.sabun_id', 'left');
        $this->db->join('satuan_sabun', 'satuan_sabun.id = sabun.satuan_id', 'left');
        $this->db->group_by('sabun.nama_sabun, satuan_sabun.nama_satuan');
        $this->db->order_by('sabun.nama_sabun', 'ASC');
        $data['chemical_list'] = $this->db->get()->result();

        // 2. Ambil data pemakaian per bulan
        $this->db->select('sabun.nama_sabun, MONTH(pemakaian_sabun.tanggal) as bulan, SUM(pemakaian_sabun.jumlah) as total_bulanan, satuan_sabun.nama_satuan');
        $this->db->from('pemakaian_sabun');
        $this->db->join('sabun', 'sabun.id = pemakaian_sabun.sabun_id', 'left');
        $this->db->join('satuan_sabun', 'satuan_sabun.id = sabun.satuan_id', 'left');
        $this->db->where('YEAR(pemakaian_sabun.tanggal)', $data['tahun']);
        $this->db->group_by('sabun.nama_sabun, MONTH(pemakaian_sabun.tanggal)');
        $query = $this->db->get();

        $data_transaksi = [];
        $satuan_chemical = [];
        foreach ($query->result() as $row) {
            $data_transaksi[$row->nama_sabun][$row->bulan] = (float)$row->total_bulanan;
            $satuan_chemical[$row->nama_sabun] = $row->nama_satuan;
        }
        
        $data['data_transaksi'] = $data_transaksi;
        $data['satuan_chemical'] = $satuan_chemical;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('laporan/rekapitulasi_chemical', $data);
        $this->load->view('templates/footer');
    }

    public function print_rekapitulasi_chemical() {
        $data['tahun'] = $this->input->get('tahun') ?: date('Y');
        
        $this->db->select('sabun.nama_sabun, satuan_sabun.nama_satuan');
        $this->db->from('pemakaian_sabun');
        $this->db->join('sabun', 'sabun.id = pemakaian_sabun.sabun_id', 'left');
        $this->db->join('satuan_sabun', 'satuan_sabun.id = sabun.satuan_id', 'left');
        $this->db->group_by('sabun.nama_sabun, satuan_sabun.nama_satuan');
        $this->db->order_by('sabun.nama_sabun', 'ASC');
        $data['chemical_list'] = $this->db->get()->result();

        $this->db->select('sabun.nama_sabun, MONTH(pemakaian_sabun.tanggal) as bulan, SUM(pemakaian_sabun.jumlah) as total_bulanan, satuan_sabun.nama_satuan');
        $this->db->from('pemakaian_sabun');
        $this->db->join('sabun', 'sabun.id = pemakaian_sabun.sabun_id', 'left');
        $this->db->join('satuan_sabun', 'satuan_sabun.id = sabun.satuan_id', 'left');
        $this->db->where('YEAR(pemakaian_sabun.tanggal)', $data['tahun']);
        $this->db->group_by('sabun.nama_sabun, MONTH(pemakaian_sabun.tanggal)');
        $query = $this->db->get();

        $data_transaksi = [];
        $satuan_chemical = [];
        foreach ($query->result() as $row) {
            $data_transaksi[$row->nama_sabun][$row->bulan] = (float)$row->total_bulanan;
            $satuan_chemical[$row->nama_sabun] = $row->nama_satuan;
        }
        
        $data['data_transaksi'] = $data_transaksi;
        $data['satuan_chemical'] = $satuan_chemical;

        $this->load->view('laporan/print_rekapitulasi_chemical', $data);
    }
}