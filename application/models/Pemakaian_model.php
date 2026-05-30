<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemakaian_model extends CI_Model {

    public function get_all() {
        $this->db->select('pemakaian_sabun.*, sabun.nama_sabun, satuan_sabun.nama_satuan, users.nama_lengkap');
        $this->db->from('pemakaian_sabun');
        $this->db->join('sabun', 'sabun.id = pemakaian_sabun.sabun_id', 'left');
        $this->db->join('satuan_sabun', 'satuan_sabun.id = sabun.satuan_id', 'left');
        $this->db->join('users', 'users.id = pemakaian_sabun.user_id', 'left');
        $this->db->order_by('pemakaian_sabun.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_by_id($id) {
        return $this->db->where('id', $id)->get('pemakaian_sabun')->row();
    }

    public function get_current_stok($sabun_id) {
        $row = $this->db->select('stok_akhir')->where('id', $sabun_id)->get('sabun')->row();
        return $row ? $row->stok_akhir : 0;
    }

    public function insert() {
        $sabun_id = $this->input->post('sabun_id');
        $jumlah   = (float) $this->input->post('jumlah');
        $stok_sekarang = $this->get_current_stok($sabun_id);

        if ($stok_sekarang < $jumlah) {
            return false; // Stok tidak cukup
        }

        $data = [
            'sabun_id'   => $sabun_id,
            'jumlah'     => $jumlah,
            'tanggal'    => $this->input->post('tanggal'),
            'shift'      => $this->input->post('shift'),
            'keterangan' => $this->input->post('keterangan'),
            'user_id'    => $this->session->userdata('user_id')
        ];
        $this->db->insert('pemakaian_sabun', $data);

        // Kurangi stok otomatis
        $this->db->where('id', $sabun_id)->update('sabun', ['stok_akhir' => $stok_sekarang - $jumlah]);
        return true;
    }

    public function update($id) {
        $old = $this->get_by_id($id);
        $sabun_id = $this->input->post('sabun_id');
        $jumlah   = (float) $this->input->post('jumlah');
        $selisih  = $jumlah - $old->jumlah;

        $stok_sekarang = $this->get_current_stok($sabun_id);
        if ($stok_sekarang < $selisih) {
            return false;
        }

        $data = [
            'tanggal'    => $this->input->post('tanggal'),
            'shift'      => $this->input->post('shift'),
            'keterangan' => $this->input->post('keterangan'),
            'jumlah'     => $jumlah,
            'sabun_id'   => $sabun_id
        ];
        $this->db->where('id', $id)->update('pemakaian_sabun', $data);

        // Update stok berdasarkan selisih
        $this->db->where('id', $sabun_id)->update('sabun', ['stok_akhir' => $stok_sekarang - $selisih]);
        return true;
    }

    public function delete($id) {
        $row = $this->get_by_id($id);
        if ($row) {
            // Kembalikan stok ke sabun
            $stok_sekarang = $this->get_current_stok($row->sabun_id);
            $this->db->where('id', $row->sabun_id)->update('sabun', ['stok_akhir' => $stok_sekarang + $row->jumlah]);
            $this->db->where('id', $id)->delete('pemakaian_sabun');
        }
    }
}