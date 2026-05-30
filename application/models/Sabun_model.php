<?php
class Sabun_model extends CI_Model {

    public function get_all() {
        $this->db->select('sabun.*, satuan_sabun.nama_satuan, supplier.nama_supplier');
        $this->db->from('sabun');
        $this->db->join('satuan_sabun', 'satuan_sabun.id = sabun.satuan_id', 'left');
        $this->db->join('supplier', 'supplier.id = sabun.supplier_id', 'left');
        $this->db->order_by('sabun.id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_by_id($id) {
        $this->db->select('sabun.*, satuan_sabun.nama_satuan, supplier.nama_supplier');
        $this->db->from('sabun');
        $this->db->join('satuan_sabun', 'satuan_sabun.id = sabun.satuan_id', 'left');
        $this->db->join('supplier', 'supplier.id = sabun.supplier_id', 'left');
        $this->db->where('sabun.id', $id);
        return $this->db->get()->row();
    }

    public function insert() {
        $data = [
            'supplier_id' => $this->input->post('supplier_id') ?: NULL,
            'nama_sabun' => $this->input->post('nama_sabun'),
            'satuan_id' => $this->input->post('satuan_id'),
            'stok_awal' => $this->input->post('stok_awal'),
            'stok_akhir' => $this->input->post('stok_awal')
        ];
        $this->db->insert('sabun', $data);
    }

    public function update($id) {
        $data = [
            'supplier_id' => $this->input->post('supplier_id') ?: NULL,
            'nama_sabun' => $this->input->post('nama_sabun'),
            'satuan_id' => $this->input->post('satuan_id'),
            'stok_awal' => $this->input->post('stok_awal'),
            'stok_akhir' => $this->input->post('stok_akhir')
        ];
        $this->db->where('id', $id)->update('sabun', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id)->delete('sabun');
    }

    public function count_all() {
        return $this->db->count_all('sabun');
    }

    public function update_stok($id, $stok_akhir) {
        $this->db->where('id', $id)->update('sabun', ['stok_akhir' => $stok_akhir]);
    }
}