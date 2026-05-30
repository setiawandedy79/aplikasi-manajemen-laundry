<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Cek login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        // Cek Hak Akses berdasarkan nama controller
        $controller = $this->router->class; // selalu lowercase di CI3
        $this->config->load('access');
        $access = $this->config->item('access');
        $role   = $this->session->userdata('role');

        if (isset($access[$controller]) && !in_array($role, $access[$controller])) {
            // Tampilkan halaman error 403
            $this->output->set_status_header(403);
            echo '<div style="text-align:center; padding:50px; font-family:sans-serif;">';
            echo '<h2>🚫 Akses Ditolak</h2>';
            echo '<p>Anda tidak memiliki izin untuk mengakses halaman <strong>' . ucfirst($controller) . '</strong></p>';
            echo '<a href="' . base_url('dashboard') . '" style="display:inline-block; padding:10px 20px; background:#2563eb; color:white; text-decoration:none; border-radius:5px;">Kembali ke Dashboard</a>';
            echo '</div>';
            exit;
        }
    }
}