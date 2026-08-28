<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Global Settings Helper for Upchar System
 */

if (!function_exists('get_system_setting')) {
    /**
     * Retrieve a system setting by key with fallback
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function get_system_setting($key, $default = null) {
        $CI =& get_instance();
        if (!isset($CI->settings_lib)) {
            $CI->load->library('settings_lib');
        }
        return $CI->settings_lib->get($key, $default);
    }
}

if (!function_exists('is_maintenance_mode')) {
    /**
     * Check if system-wide maintenance mode is enabled and current IP is not whitelisted
     * @return bool
     */
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
            return false; // Whitelisted IP can bypass
        }

        return true;
    }
}

if (!function_exists('mask_secret_field')) {
    /**
     * Format a secret string for display in input forms
     * @param string $val
     * @return string
     */
    function mask_secret_field($val) {
        if (empty($val)) return '';
        $CI =& get_instance();
        if (!isset($CI->settings_lib)) {
            $CI->load->library('settings_lib');
        }
        return $CI->settings_lib->mask_value($val);
    }
}
