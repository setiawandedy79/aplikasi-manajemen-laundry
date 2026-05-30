<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('is_allowed')) {
    function is_allowed($controller) {
        $CI =& get_instance();
        $CI->config->load('access');
        $access = $CI->config->item('access');
        $role   = $CI->session->userdata('role');

        if (isset($access[$controller]) && in_array($role, $access[$controller])) {
            return TRUE;
        }
        return FALSE;
    }
}