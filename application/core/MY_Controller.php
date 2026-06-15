<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // 1. Cek Login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        // 2. Ambil data role dan permissions dari session
        $role = $this->session->userdata('role');
        $permissions = $this->session->userdata('permissions');

        // 3. Jika BUKAN admin, lakukan pengecekan hak akses granular
        if ($role !== 'admin') {
            $controller = $this->router->fetch_class(); // Method yang lebih aman dan stabil di CI3 
            $method = $this->router->method;

            // Mapping nama Controller ke nama Menu di database permission
            $menu_map = array(
                'dashboard'    => 'dashboard',
                'transaksi'    => 'transaksi',
                'penyerahan'   => 'penyerahan',
                'pakaian'      => 'pakaian',
                'pelanggan'    => 'pelanggan',
                'sabun'        => 'sabun',
                'pemakaian'    => 'pemakaian',
                'mutasi'       => 'mutasi',
                'laporan'      => 'laporan',
                'users'         => 'users',
                'log_activity' => 'log_activity'
            );

            // Jika controller yang diakses ada di dalam mapping
            if (isset($menu_map[$controller])) {
                $menu = $menu_map[$controller];
                
                // Tentukan aksi (view, add, edit, delete) berdasarkan nama method
                $action = 'view'; // Default aksi adalah View
                
                if (in_array($method, array('add', 'create', 'insert'))) {
                    $action = 'add';
                } elseif (in_array($method, array('edit', 'update'))) {
                    $action = 'edit';
                } elseif (in_array($method, array('delete', 'remove'))) {
                    $action = 'delete';
                } elseif ($method == 'save') {
                    // Khusus method 'save', cek apakah ada ID (edit) atau tidak (add)
                    if ($this->input->post('id')) {
                        $action = 'edit';
                    } else {
                        $action = 'add';
                    }
                }

                // Cek apakah user memiliki izin untuk aksi tersebut
                $has_access = false;
                if (!empty($permissions) && isset($permissions[$menu][$action]) && $permissions[$menu][$action] == 1) {
                    $has_access = true;
                }

                // Jika tidak punya akses, tolak dan redirect
                if (!$has_access) {
                    $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses untuk fitur ini.');
                    redirect('dashboard');
                }
            }
        }
    }
}