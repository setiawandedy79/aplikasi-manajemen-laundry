<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mutasi_model extends CI_Model {

    public function get_all() {
        $this->db->select('mutasi_sabun_masuk.*, sabun.nama_sabun, satuan_sabun.nama_satuan, users.nama_lengkap');
        $this->db->from('mutasi_sabun_masuk');
        $this->db->join('sabun', 'sabun.id = mutasi_sabun_masuk.sabun_id', 'left');
        $this->db->join('satuan_sabun', 'satuan_sabun.id = sabun.satuan_id', 'left');
        $this->db->join('users', 'users.id = mutasi_sabun_masuk.user_id', 'left');
        $this->db->order_by('mutasi_sabun_masuk.tanggal', 'DESC');
        $this->db->order_by('mutasi_sabun_masuk.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_by_id($id) {
        return $this->db->where('id', $id)->get('mutasi_sabun_masuk')->row();
    }

    public function insert() {
        $sabun_id = $this->input->post('sabun_id');
        $jumlah   = (float) $this->input->post('jumlah');

        $data = [
            'sabun_id'   => $sabun_id,
            'jumlah'     => $jumlah,
            'tanggal'    => $this->input->post('tanggal'),
            'keterangan' => $this->input->post('keterangan'),
            'user_id'    => $this->session->userdata('user_id')
        ];
        $this->db->insert('mutasi_sabun_masuk', $data);

        // ➕ Tambah stok otomatis
        $this->db->set('stok_akhir', 'stok_akhir + ' . $jumlah, FALSE)
                 ->where('id', $sabun_id)
                 ->update('sabun');
        return true;
    }

    public function update($id) {
        $old = $this->get_by_id($id);
        $new_sabun_id = $this->input->post('sabun_id');
        $new_jumlah   = (float) $this->input->post('jumlah');

        // 🔁 Kembalikan stok lama
        $this->db->set('stok_akhir', 'stok_akhir - ' . $old->jumlah, FALSE)
                 ->where('id', $old->sabun_id)
                 ->update('sabun');
                 
        // ➕ Tambah stok baru
        $this->db->set('stok_akhir', 'stok_akhir + ' . $new_jumlah, FALSE)
                 ->where('id', $new_sabun_id)
                 ->update('sabun');
                 
        $data = [
            'sabun_id'   => $new_sabun_id,
            'jumlah'     => $new_jumlah,
            'tanggal'    => $this->input->post('tanggal'),
            'keterangan' => $this->input->post('keterangan')
        ];
        $this->db->where('id', $id)->update('mutasi_sabun_masuk', $data);
        return true;
    }

    public function delete($id) {
        $row = $this->get_by_id($id);
        if ($row) {
            // ➖ Kurangi stok (revert penambahan)
            $this->db->set('stok_akhir', 'stok_akhir - ' . $row->jumlah, FALSE)
                     ->where('id', $row->sabun_id)
                     ->update('sabun');
            $this->db->where('id', $id)->delete('mutasi_sabun_masuk');
        }
    }
}