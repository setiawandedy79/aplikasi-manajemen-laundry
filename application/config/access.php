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
    'pakaian'      => ['admin', 'operator'],
    'sabun'        => ['admin', 'operator'],
    'satuan_sabun' => ['admin', 'operator'],
    'pelanggan'    => ['admin', 'operator'],
    //'pelanggan'    => ['admin', 'kasir'],
    'users'        => ['admin'],
    'supplier'     => ['admin', 'operator'],
    
    // Operasional
    'transaksi'    => ['admin', 'operator', 'kasir'],
    'pemakaian'    => ['admin', 'operator'],
    'mutasi'       => ['admin', 'operator'],
    'penyerahan'   => ['admin', 'operator', 'kasir'],
    
    // Laporan
    'laporan'      => ['admin', 'kasir', 'operator'],
];