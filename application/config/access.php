<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Format: 'nama_controller' => ['role_yang_diizinkan']
 * Nama controller harus huruf kecil semua.
 */
$config['access'] = [
    'dashboard'    => ['admin', 'kasir', 'operator'],
    // ... config lain ...
    'users'        => ['admin'], // Hanya admin yang boleh akses
    // ... config lain ...
    
    // Master Data
    'pakaian'      => ['admin'],
    'sabun'        => ['admin'],
    'satuan_sabun' => ['admin'],
    'pelanggan'    => ['admin', 'kasir'],
    'users'        => ['admin'],
    'supplier'     => ['admin'],
    
    // Operasional
    'transaksi'    => ['admin', 'kasir'],
    'pemakaian'    => ['admin', 'operator'],
    'mutasi'       => ['admin', 'operator'],
    'penyerahan'   => ['admin', 'kasir'],
    
    // Laporan
    'laporan'      => ['admin', 'kasir', 'operator'],
];