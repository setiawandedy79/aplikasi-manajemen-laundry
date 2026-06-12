<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_log_model extends CI_Model {

    public function add_log($module, $action, $record_id = null, $old_data = null, $new_data = null) {
        // Ambil data user yang sedang login
        $user_id = $this->session->userdata('user_id');
        $nama_user = $this->session->userdata('nama_lengkap') ?: 'System / Unknown';
        $ip_address = $this->input->ip_address();

        // Format data ke JSON agar rapi dan mudah dibaca nanti
        $data = [
            'user_id'    => $user_id,
            'nama_user'  => $nama_user,
            'module'     => $module,
            'action'     => $action,
            'record_id'  => $record_id,
            'old_data'   => $old_data ? json_encode($old_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : null,
            'new_data'   => $new_data ? json_encode($new_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : null,
            'ip_address' => $ip_address
        ];

        $this->db->insert('activity_log', $data);
    }
}