<?php
class Pakaian_model extends CI_Model {

    public function get_all() {
        return $this->db->order_by('id', 'DESC')->get('pakaian')->result();
    }

    public function get_by_id($id) {
        return $this->db->where('id', $id)->get('pakaian')->row();
    }

    public function insert() {
        $data = [
            'nama_pakaian' => $this->input->post('nama_pakaian'),
            'kategori' => $this->input->post('kategori'),
            'berat_kotor'  => (float) $this->input->post('berat_kotor'),
            'berat_bersih' => (float) $this->input->post('berat_bersih')
        ];
        $this->db->insert('pakaian', $data);
    }

    public function update($id) {
        $data = [
            'nama_pakaian' => $this->input->post('nama_pakaian'),
            'kategori' => $this->input->post('kategori'),
            'berat_kotor'  => (float) $this->input->post('berat_kotor'),
            'berat_bersih' => (float) $this->input->post('berat_bersih')
        ];
        $this->db->where('id', $id)->update('pakaian', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id)->delete('pakaian');
    }
}