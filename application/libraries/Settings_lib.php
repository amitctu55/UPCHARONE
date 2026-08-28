<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * System Settings Library (Main Application)
 */
class Settings_lib {

    protected $CI;
    protected static $memory_cache = null;
    protected $cache_file;
    protected $encryption_key;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->database();
        $this->encryption_key = config_item('encryption_key') ?: 'Upchar_System_Secret_Key_2026';
        $this->cache_file = APPPATH . 'cache/system_settings_cache.json';
    }

    public function get($key, $default = null) {
        $all = $this->get_all();
        if (isset($all[$key])) {
            return $all[$key]['value'];
        }
        return $default;
    }

    public function get_category($category) {
        $all = $this->get_all();
        $filtered = [];
        foreach ($all as $key => $item) {
            if ($item['category'] === $category) {
                $filtered[$key] = $item;
            }
        }
        return $filtered;
    }

    public function get_all($force_refresh = false) {
        if (!$force_refresh && self::$memory_cache !== null) {
            return self::$memory_cache;
        }

        if (!$force_refresh && file_exists($this->cache_file) && (time() - filemtime($this->cache_file) < 3600)) {
            $cached = @json_decode(file_get_contents($this->cache_file), true);
            if (is_array($cached) && !empty($cached)) {
                self::$memory_cache = $cached;
                return self::$memory_cache;
            }
        }

        $rows = $this->CI->db->get('system_settings')->result_array();
        $settings = [];

        foreach ($rows as $row) {
            $val = $row['setting_value'];
            if ($row['is_encrypted'] == 1 && !empty($val)) {
                $val = $this->decrypt_value($val);
            }

            $settings[$row['setting_key']] = [
                'id' => $row['id'],
                'category' => $row['category'],
                'key' => $row['setting_key'],
                'value' => $val,
                'is_encrypted' => (bool)$row['is_encrypted'],
                'field_type' => $row['field_type'],
                'description' => $row['description']
            ];
        }

        self::$memory_cache = $settings;
        @file_put_contents($this->cache_file, json_encode($settings, JSON_UNESCAPED_UNICODE));

        return $settings;
    }

    public function decrypt_value($encrypted_str) {
        if (empty($encrypted_str) || strpos($encrypted_str, 'ENC:') !== 0) {
            return $encrypted_str;
        }

        $raw = base64_decode(substr($encrypted_str, 4));
        $cipher = "AES-256-CBC";
        $key = hash('sha256', $this->encryption_key, true);
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = substr($raw, 0, $ivlen);
        $hmac = substr($raw, $ivlen, 32);
        $ciphertext_raw = substr($raw, $ivlen + 32);

        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, true);
        if (hash_equals($hmac, $calcmac)) {
            return openssl_decrypt($ciphertext_raw, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        }

        return '';
    }
}
