<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cek apakah user memiliki hak akses tertentu
 * @param string $menu - Nama menu (transaksi, penyerahan, pakaian, dll)
 * @param string $action - Aksi (view, add, edit, delete)
 * @return bool
 */
if (!function_exists('has_permission')) {
    function has_permission($menu, $action) {
        $CI =& get_instance();
        
        // Admin selalu punya semua hak akses
        $role = $CI->session->userdata('role');
        if ($role === 'admin') {
            return true;
        }
        
        // Ambil permissions dari session (sudah di-set saat login)
        $permissions = $CI->session->userdata('permissions');
        
        if (empty($permissions)) {
            return false;
        }
        
        // Decode JSON jika masih string
        if (is_string($permissions)) {
            $permissions = json_decode($permissions, true);
        }
        
        // Cek permission
        if (isset($permissions[$menu][$action]) && $permissions[$menu][$action] == 1) {
            return true;
        }
        
        return false;
    }
}

/**
 * Alias functions untuk kemudahan
 */
if (!function_exists('can_view')) {
    function can_view($menu) {
        return has_permission($menu, 'view');
    }
}

if (!function_exists('can_add')) {
    function can_add($menu) {
        return has_permission($menu, 'add');
    }
}

if (!function_exists('can_edit')) {
    function can_edit($menu) {
        return has_permission($menu, 'edit');
    }
}

if (!function_exists('can_delete')) {
    function can_delete($menu) {
        return has_permission($menu, 'delete');
    }
}