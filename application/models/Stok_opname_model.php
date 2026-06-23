<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok_opname_model extends CI_Model {

    public function get_all($dari = null, $sampai = null, $limit = null, $offset = null) {
        $this->db->select('stok_opname.*, sabun.nama_sabun, satuan_sabun.nama_satuan, users.nama_lengkap');
        $this->db->from('stok_opname');
        $this->db->join('sabun', 'sabun.id = stok_opname.sabun_id', 'left');
        $this->db->join('satuan_sabun', 'satuan_sabun.id = sabun.satuan_id', 'left');
        $this->db->join('users', 'users.id = stok_opname.user_id', 'left');
        
        // ✅ Filter Tanggal (Jika ada)
        if ($dari && $sampai) {
            $this->db->where('stok_opname.tanggal >=', $dari);
            $this->db->where('stok_opname.tanggal <=', $sampai);
        }
        
        $this->db->order_by('stok_opname.tanggal', 'DESC');
        $this->db->order_by('stok_opname.created_at', 'DESC');
        
        // Pagination
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result();
    }

    public function count_all() {
        return $this->db->count_all('stok_opname');
    }

    public function get_by_id($id) {
        return $this->db->where('id', $id)->get('stok_opname')->row();
    }

    /**
     * Simpan hasil opname dan update stok di tabel sabun
     */
    public function insert() {
        $sabun_id    = $this->input->post('sabun_id');
        $stok_fisik  = (float) $this->input->post('stok_fisik');
        $tanggal     = $this->input->post('tanggal') ?: date('Y-m-d');
        $keterangan  = $this->input->post('keterangan');

        // 1. Ambil stok sistem saat ini
        $sabun = $this->db->where('id', $sabun_id)->get('sabun')->row();
        if (!$sabun) return false;

        $stok_sistem = (float) $sabun->stok_akhir;
        $selisih     = $stok_fisik - $stok_sistem;

        // 2. Simpan data opname
        $data = [
            'sabun_id'    => $sabun_id,
            'stok_sistem' => $stok_sistem,
            'stok_fisik'  => $stok_fisik,
            'selisih'     => $selisih,
            'tanggal'     => $tanggal,
            'keterangan'  => $keterangan,
            'user_id'     => $this->session->userdata('user_id')
        ];
        $this->db->insert('stok_opname', $data);

        // 3. ✅ UPDATE stok_akhir di tabel sabun = stok fisik (disesuaikan)
        $this->db->where('id', $sabun_id)
                 ->update('sabun', ['stok_akhir' => $stok_fisik]);

        return true;
    }

    /**
     * Hapus opname dan kembalikan stok ke nilai sebelumnya
     */
    public function delete($id) {
        $row = $this->get_by_id($id);
        if ($row) {
            // Kembalikan stok ke stok_sistem (sebelum diopname)
            $this->db->where('id', $row->sabun_id)
                     ->update('sabun', ['stok_akhir' => $row->stok_sistem]);
            
            $this->db->where('id', $id)->delete('stok_opname');
            return true;
        }
        return false;
    }
}