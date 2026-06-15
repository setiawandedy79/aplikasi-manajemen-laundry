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

    public function get_by_username($username) {
        $this->db->select('users.*, pelanggan.nama as nama_pelanggan');
        $this->db->from('users');
        $this->db->join('pelanggan', 'pelanggan.id = users.pelanggan_id', 'left');
        $this->db->where('users.username', $username);
        return $this->db->get()->row();
    }

    public function insert() {
        $pelanggan_id = $this->input->post('pelanggan_id');
        if (empty($pelanggan_id)) {
            $pelanggan_id = NULL;
        }

        // Ambil permissions dari POST
        $permissions = $this->build_permissions();

        $data = [
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'username'     => $this->input->post('username'),
            'password'     => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role'         => $this->input->post('role'),
            'pelanggan_id' => $pelanggan_id,
            'permissions'  => $permissions
        ];
        
        $this->db->insert('users', $data);
    }

    public function update($id) {
        $pelanggan_id = $this->input->post('pelanggan_id');
        if (empty($pelanggan_id)) {
            $pelanggan_id = NULL;
        }

        $password = $this->input->post('password');
        
        // Ambil permissions dari POST
        $permissions = $this->build_permissions();

        $data = [
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'username'     => $this->input->post('username'),
            'role'         => $this->input->post('role'),
            'pelanggan_id' => $pelanggan_id,
            'permissions'  => $permissions
        ];

        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->db->where('id', $id)->update('users', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id)->delete('users');
    }

    /**
     * Build permissions JSON dari POST data
     */
    private function build_permissions() {
        $menus = array('dashboard', 'transaksi', 'penyerahan', 'pakaian', 'pelanggan', 'sabun', 'pemakaian', 'mutasi', 'laporan', 'user');
        $actions = array('view', 'add', 'edit', 'delete');
        
        $permissions = array();
        
        foreach ($menus as $menu) {
            $permissions[$menu] = array();
            foreach ($actions as $action) {
                $field_name = $menu . '_' . $action;
                $permissions[$menu][$action] = $this->input->post($field_name) ? 1 : 0;
            }
        }
        
        return json_encode($permissions);
    }

    /**
     * Get default permissions untuk admin (semua 1)
     */
    public function get_default_admin_permissions() {
        $menus = array('dashboard', 'transaksi', 'penyerahan', 'pakaian', 'pelanggan', 'sabun', 'pemakaian', 'mutasi', 'laporan', 'user');
        $actions = array('view', 'add', 'edit', 'delete');
        
        $permissions = array();
        foreach ($menus as $menu) {
            foreach ($actions as $action) {
                $permissions[$menu][$action] = 1;
            }
        }
        
        return json_encode($permissions);
    }
}