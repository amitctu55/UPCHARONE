<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Global Settings Helper for Upchar System (Frontend App)
 */

if (!function_exists('get_system_setting')) {
    function get_system_setting($key, $default = null) {
        $CI =& get_instance();
        if (!isset($CI->settings_lib)) {
            $CI->load->library('settings_lib');
        }
        return $CI->settings_lib->get($key, $default);
    }
}

if (!function_exists('is_maintenance_mode')) {
    function is_maintenance_mode() {
        $enabled = get_system_setting('maintenance_mode', '0');
        if ($enabled !== '1' && $enabled !== 1 && $enabled !== true && $enabled !== 'true') {
            return false;
        }

        $allowed_ips_str = get_system_setting('maintenance_allowed_ips', '127.0.0.1, ::1');
        $allowed_ips = array_map('trim', explode(',', $allowed_ips_str));

        $CI =& get_instance();
        $current_ip = $CI->input->ip_address();

        if (in_array($current_ip, $allowed_ips)) {
            return false;
        }

        return true;
    }
}
