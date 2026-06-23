<?php
class Laporan_model extends CI_Model {

    public function get_mutasi_masuk($dari, $sampai) {
        $this->db->select('mutasi_sabun_masuk.*, sabun.nama_sabun, satuan_sabun.nama_satuan, users.nama_lengkap');
        $this->db->from('mutasi_sabun_masuk');
        $this->db->join('sabun', 'sabun.id = mutasi_sabun_masuk.sabun_id', 'left');
        $this->db->join('satuan_sabun', 'satuan_sabun.id = sabun.satuan_id', 'left');
        $this->db->join('users', 'users.id = mutasi_sabun_masuk.user_id', 'left');
        $this->db->where('mutasi_sabun_masuk.tanggal >=', $dari);
        $this->db->where('mutasi_sabun_masuk.tanggal <=', $sampai);
        $this->db->order_by('mutasi_sabun_masuk.tanggal', 'DESC');
        return $this->db->get()->result();
    }

    public function get_pemakaian_shift($dari, $sampai) {
        $this->db->select('pemakaian_sabun.*, sabun.nama_sabun, satuan_sabun.nama_satuan, users.nama_lengkap');
        $this->db->from('pemakaian_sabun');
        $this->db->join('sabun', 'sabun.id = pemakaian_sabun.sabun_id', 'left');
        $this->db->join('satuan_sabun', 'satuan_sabun.id = sabun.satuan_id', 'left');
        $this->db->join('users', 'users.id = pemakaian_sabun.user_id', 'left');
        $this->db->where('pemakaian_sabun.tanggal >=', $dari);
        $this->db->where('pemakaian_sabun.tanggal <=', $sampai);
        $this->db->order_by('pemakaian_sabun.tanggal', 'DESC');
        return $this->db->get()->result();
    }

    public function get_stok_sabun() {
        $this->db->select('sabun.*, satuan_sabun.nama_satuan');
        $this->db->from('sabun');
        $this->db->join('satuan_sabun', 'satuan_sabun.id = sabun.satuan_id', 'left');
        return $this->db->get()->result();
    }

    public function get_laporan_transaksi($dari, $sampai) {
        $this->db->select('transaksi_header.*, pelanggan.nama as nama_pelanggan, users.nama_lengkap');
        $this->db->from('transaksi_header');
        $this->db->join('pelanggan', 'pelanggan.id = transaksi_header.pelanggan_id', 'left');
        $this->db->join('users', 'users.id = transaksi_header.user_id', 'left');
        $this->db->where('transaksi_header.tanggal >=', $dari);
        $this->db->where('transaksi_header.tanggal <=', $sampai);
        $this->db->order_by('transaksi_header.tanggal', 'DESC');
        return $this->db->get()->result();
    }

    // Insert mutasi masuk
    public function insert_mutasi_masuk() {
        $data = [
            'sabun_id' => $this->input->post('sabun_id'),
            'jumlah' => $this->input->post('jumlah'),
            'tanggal' => $this->input->post('tanggal'),
            'keterangan' => $this->input->post('keterangan'),
            'user_id' => $this->session->userdata('user_id')
        ];
        $this->db->insert('mutasi_sabun_masuk', $data);

        // Update stok sabun
        $sabun = $this->db->where('id', $data['sabun_id'])->get('sabun')->row();
        $stok_baru = $sabun->stok_akhir + $data['jumlah'];
        $this->db->where('id', $data['sabun_id'])->update('sabun', ['stok_akhir' => $stok_baru]);
    }

    // Insert pemakaian sabun
    public function insert_pemakaian() {
        $data = [
            'sabun_id' => $this->input->post('sabun_id'),
            'jumlah' => $this->input->post('jumlah'),
            'tanggal' => $this->input->post('tanggal'),
            'shift' => $this->input->post('shift'),
            'keterangan' => $this->input->post('keterangan'),
            'user_id' => $this->session->userdata('user_id')
        ];
        $this->db->insert('pemakaian_sabun', $data);

        // Kurangi stok
        $sabun = $this->db->where('id', $data['sabun_id'])->get('sabun')->row();
        $stok_baru = $sabun->stok_akhir - $data['jumlah'];
        $this->db->where('id', $data['sabun_id'])->update('sabun', ['stok_akhir' => $stok_baru]);
    }

        /**
     * Mengambil riwayat mutasi & pemakaian untuk 1 chemical dalam rentang tanggal
     */
    public function get_transaksi_stok($sabun_id, $dari, $sampai) {
        // 1. Ambil Mutasi Masuk
        $mutasi = $this->db->select("tanggal, jumlah as masuk, 0 as keluar, 'Mutasi Masuk' as keterangan")
                           ->from('mutasi_sabun_masuk')
                           ->where('sabun_id', $sabun_id)
                           ->where('tanggal >=', $dari)
                           ->where('tanggal <=', $sampai)
                           ->get()->result();

        // 2. Ambil Pemakaian
        $pakai = $this->db->select("tanggal, 0 as masuk, jumlah as keluar, CONCAT('Pemakaian Shift ', shift) as keterangan")
                          ->from('pemakaian_sabun')
                          ->where('sabun_id', $sabun_id)
                          ->where('tanggal >=', $dari)
                          ->where('tanggal <=', $sampai)
                          ->get()->result();

        // 3. Gabungkan dan urutkan berdasarkan tanggal
        $all_transaksi = array_merge($mutasi, $pakai);
        usort($all_transaksi, function($a, $b) {
            return strtotime($a->tanggal) - strtotime($b->tanggal);
        });

        return $all_transaksi;
    }

    /**
     * Menghitung Saldo Awal (Stok sebelum tanggal 'dari')
     */
    public function hitung_saldo_awal($sabun_id, $dari) {
        $sabun = $this->db->where('id', $sabun_id)->get('sabun')->row();
        $stok_awal_db = $sabun ? (float)$sabun->stok_awal : 0;

        // Total mutasi masuk sebelum periode
        $masuk_sebelum = $this->db->select('COALESCE(SUM(jumlah),0) as total')
                                  ->where('sabun_id', $sabun_id)
                                  ->where('tanggal <', $dari)
                                  ->get('mutasi_sabun_masuk')->row()->total;

        // Total pemakaian sebelum periode
        $pakai_sebelum = $this->db->select('COALESCE(SUM(jumlah),0) as total')
                                  ->where('sabun_id', $sabun_id)
                                  ->where('tanggal <', $dari)
                                  ->get('pemakaian_sabun')->row()->total;

        return $stok_awal_db + (float)$masuk_sebelum - (float)$pakai_sebelum;
    }
}