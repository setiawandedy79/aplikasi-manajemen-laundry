<?php
class Satuan_model extends CI_Model {

    public function get_all() {
        return $this->db->order_by('id', 'DESC')->get('satuan_sabun')->result();
    }

    public function get_by_id($id) {
        return $this->db->where('id', $id)->get('satuan_sabun')->row();
    }

    public function insert() {
        $data = ['nama_satuan' => $this->input->post('nama_satuan')];
        $this->db->insert('satuan_sabun', $data);
    }

    public function update($id) {
        $data = ['nama_satuan' => $this->input->post('nama_satuan')];
        $this->db->where('id', $id)->update('satuan_sabun', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id)->delete('satuan_sabun');
    }
}