<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function get_all() {
        return $this->db->order_by('id', 'DESC')->get('users')->result();
    }

    public function get_by_id($id) {
        return $this->db->where('id', $id)->get('users')->row();
    }

    public function get_by_username($username) {
        return $this->db->where('username', $username)->get('users')->row();
    }

    // ✅ Cek username unik (untuk validasi)
    public function is_username_exists($username, $exclude_id = null) {
        $this->db->where('username', $username);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->get('users')->num_rows() > 0;
    }

    public function insert() {
        $username = $this->input->post('username');
        
        // Validasi manual username unik
        if ($this->is_username_exists($username)) {
            return false; // Username sudah ada
        }

        $data = [
            'username'     => $username,
            'password'     => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'role'         => $this->input->post('role'),
            'created_at'   => date('Y-m-d H:i:s')
        ];
        return $this->db->insert('users', $data);
    }

    public function update($id) {
        $username = $this->input->post('username');
        
        // Validasi username unik (kecuali user yang sedang diedit)
        if ($this->is_username_exists($username, $id)) {
            return false;
        }

        $data = [
            'username'     => $username,
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'role'         => $this->input->post('role')
        ];

        // Hanya update password jika diisi
        if ($this->input->post('password')) {
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }

        $this->db->where('id', $id)->update('users', $data);
        return true;
    }

    public function delete($id) {
        // Cegah hapus user sendiri
        if ($id == $this->session->userdata('user_id')) {
            return false;
        }
        $this->db->where('id', $id)->delete('users');
        return true;
    }

    public function count_all() {
        return $this->db->count_all('users');
    }
}