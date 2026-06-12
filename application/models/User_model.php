<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function get_all() {
        $this->db->select('users.*, pelanggan.nama as nama_pelanggan');
        $this->db->from('users');
        $this->db->join('pelanggan', 'pelanggan.id = users.pelanggan_id', 'left');
        $this->db->order_by('users.id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_by_id($id) {
        $this->db->select('users.*, pelanggan.nama as nama_pelanggan');
        $this->db->from('users');
        $this->db->join('pelanggan', 'pelanggan.id = users.pelanggan_id', 'left');
        $this->db->where('users.id', $id);
        return $this->db->get()->row();
    }

    // ✅ METHOD INI WAJIB ADA UNTUK PROSES LOGIN
    public function get_by_username($username) {
        $this->db->select('users.*, pelanggan.nama as nama_pelanggan');
        $this->db->from('users');
        $this->db->join('pelanggan', 'pelanggan.id = users.pelanggan_id', 'left');
        $this->db->where('users.username', $username);
        return $this->db->get()->row();
    }

    public function insert() {
        // Tangkap data pelanggan_id dengan aman
        $pelanggan_id = $this->input->post('pelanggan_id');
        if (empty($pelanggan_id)) {
            $pelanggan_id = NULL;
        }

        $data = [
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'username'     => $this->input->post('username'),
            'password'     => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role'         => $this->input->post('role'),
            'pelanggan_id' => $pelanggan_id
        ];
        
        $this->db->insert('users', $data);
    }

    public function update($id) {
        // Tangkap data pelanggan_id dengan aman
        $pelanggan_id = $this->input->post('pelanggan_id');
        if (empty($pelanggan_id)) {
            $pelanggan_id = NULL;
        }

        $password = $this->input->post('password');
        
        $data = [
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'username'     => $this->input->post('username'),
            'role'         => $this->input->post('role'),
            'pelanggan_id' => $pelanggan_id
        ];
        
        // Update password hanya jika diisi
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        
        $this->db->where('id', $id)->update('users', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id)->delete('users');
    }
}