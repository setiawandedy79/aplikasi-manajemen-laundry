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
}