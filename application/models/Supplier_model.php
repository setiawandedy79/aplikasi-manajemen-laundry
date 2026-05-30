<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_model extends CI_Model {
    public function get_all() {
        return $this->db->order_by('id', 'DESC')->get('supplier')->result();
    }

    public function get_by_id($id) {
        return $this->db->where('id', $id)->get('supplier')->row();
    }

    public function insert() {
        $data = [
            'nama_supplier' => $this->input->post('nama_supplier'),
            'kontak'        => $this->input->post('kontak'),
            'alamat'        => $this->input->post('alamat'),
            'telepon'       => $this->input->post('telepon')
        ];
        $this->db->insert('supplier', $data);
    }

    public function update($id) {
        $data = [
            'nama_supplier' => $this->input->post('nama_supplier'),
            'kontak'        => $this->input->post('kontak'),
            'alamat'        => $this->input->post('alamat'),
            'telepon'       => $this->input->post('telepon')
        ];
        $this->db->where('id', $id)->update('supplier', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id)->delete('supplier');
    }
}