<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends MY_Controller {

    public function __construct() {
        parent::__construct();
        
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak! Hanya Admin yang dapat melakukan backup.');
            redirect('dashboard');
        }
    }

    /**
     * Tampilkan halaman backup dengan tombol
     */
    public function index() {
        $data['title'] = 'Backup Database';
        
        // Hitung estimasi ukuran database
        $query = $this->db->query("
            SELECT 
                table_schema AS db_name,
                ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS size_mb,
                COUNT(*) AS total_tabel
            FROM information_schema.tables
            WHERE table_schema = '".$this->db->database."'
            GROUP BY table_schema
        ")->row();
        
        $data['db_info'] = $query;
        
        // List file backup yang pernah dibuat (jika ada di folder)
        $backup_folder = FCPATH . 'assets/backup/';
        $data['backup_files'] = [];
        if (is_dir($backup_folder)) {
            $files = scandir($backup_folder, SCANDIR_SORT_DESCENDING);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..' && (pathinfo($file, PATHINFO_EXTENSION) === 'sql' || pathinfo($file, PATHINFO_EXTENSION) === 'gz')) {
                    $data['backup_files'][] = [
                        'name' => $file,
                        'size' => $this->format_size(filesize($backup_folder . $file)),
                        'date' => date('d/m/Y H:i', filemtime($backup_folder . $file))
                    ];
                }
            }
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('backup/index', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Proses backup dengan kompresi GZIP
     */
    public function proses() {
        $user   = $this->db->username;
        $pass   = $this->db->password;
        $dbname = $this->db->database;

        $filename = 'backup_medikalaundry_' . date('Ymd_His') . '.sql.gz';
        $backup_folder = FCPATH . 'assets/backup/';
        
        if (!is_dir($backup_folder)) {
            mkdir($backup_folder, 0777, true);
        }
        $filepath = $backup_folder . $filename;

        // Path mysqldump (sesuaikan jika pindah hosting)
        $mysqldump_path = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';
        
        // ✅ FLAG OPTIMAL:
        // --quick              = Baca baris per baris (hemat RAM, cepat untuk DB besar)
        // --single-transaction = Konsisten tanpa lock tabel (tidak ganggu user lain)
        // --routines           = Include stored procedure
        // --triggers           = Include trigger
        // | gzip               = Kompres langsung (file 5-10x lebih kecil!)
        
        if (strpos(PHP_OS, 'WIN') !== false) {
            // Windows: pakai kompresi bawaan PHP setelah dump
            $command = "\"$mysqldump_path\" --quick --single-transaction --routines --triggers -u $user -p\"$pass\" $dbname > \"$backup_folder" . str_replace('.gz', '', $filename) . "\"";
            exec($command, $output, $return_var);
            
            // Kompres manual dengan gzip PHP
            $sql_file = $backup_folder . str_replace('.gz', '', $filename);
            if (file_exists($sql_file)) {
                $sql_content = file_get_contents($sql_file);
                $gz_content = gzencode($sql_content, 9); // Level 9 = kompresi maksimal
                file_put_contents($filepath, $gz_content);
                unlink($sql_file); // Hapus file .sql asli
                $return_var = 0;
            }
        } else {
            // Linux: langsung pipe ke gzip
            $command = "mysqldump --quick --single-transaction --routines --triggers -u $user -p\"$pass\" $dbname | gzip > \"$filepath\"";
            exec($command, $output, $return_var);
        }

        if ($return_var === 0 && file_exists($filepath)) {
            $this->session->set_flashdata('success', 'Backup berhasil! File: <strong>'.$filename.'</strong> ('.$this->format_size(filesize($filepath)).')');
        } else {
            $this->session->set_flashdata('error', 'Gagal backup. Cek permission folder assets/backup/ dan path mysqldump.');
        }
        
        redirect('backup');
    }

    /**
     * Download file backup yang sudah ada
     */
    public function download($filename) {
        $filepath = FCPATH . 'assets/backup/' . $filename;
        
        if (file_exists($filepath)) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Length: ' . filesize($filepath));
            readfile($filepath);
            exit;
        } else {
            $this->session->set_flashdata('error', 'File tidak ditemukan');
            redirect('backup');
        }
    }

    /**
     * Hapus file backup lama
     */
    public function hapus($filename) {
        $filepath = FCPATH . 'assets/backup/' . $filename;
        
        if (file_exists($filepath) && unlink($filepath)) {
            $this->session->set_flashdata('success', 'File backup berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus file');
        }
        redirect('backup');
    }

    private function format_size($bytes) {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}