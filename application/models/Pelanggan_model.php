<?php
class Pelanggan_model extends CI_Model {

    public function get_all() {
        return $this->db->order_by('id', 'DESC')->get('pelanggan')->result();
    }

    public function get_by_id($id) {
        return $this->db->where('id', $id)->get('pelanggan')->row();
    }

    public function insert() {
        $data = [
            'nama' => $this->input->post('nama'),
            'alamat' => $this->input->post('alamat'),
            'telepon' => $this->input->post('telepon')
        ];
        $this->db->insert('pelanggan', $data);
    }

    public function update($id) {
        $data = [
            'nama' => $this->input->post('nama'),
            'alamat' => $this->input->post('alamat'),
            'telepon' => $this->input->post('telepon')
        ];
        $this->db->where('id', $id)->update('pelanggan', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id)->delete('pelanggan');
    }

    public function count_all() {
        return $this->db->count_all('pelanggan');
    }
}