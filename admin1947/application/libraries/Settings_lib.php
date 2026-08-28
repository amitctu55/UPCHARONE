<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * System Settings Library
 * Handles secure storage, AES-256 encryption, caching, and audit logging for system configurations.
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

    /**
     * Get a setting by its key
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null) {
        $all = $this->get_all();
        if (isset($all[$key])) {
            return $all[$key]['value'];
        }
        return $default;
    }

    /**
     * Get all settings belonging to a specific category
     * @param string $category
     * @return array
     */
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

    /**
     * Get all system settings as an associative key => data map with cache
     * @param bool $force_refresh
     * @return array
     */
    public function get_all($force_refresh = false) {
        if (!$force_refresh && self::$memory_cache !== null) {
            return self::$memory_cache;
        }

        // Try reading from file cache if available and not expired (< 3600 seconds)
        if (!$force_refresh && file_exists($this->cache_file) && (time() - filemtime($this->cache_file) < 3600)) {
            $cached = @json_decode(file_get_contents($this->cache_file), true);
            if (is_array($cached) && !empty($cached)) {
                self::$memory_cache = $cached;
                return self::$memory_cache;
            }
        }

        // Fetch from database
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
                'raw_value' => $row['setting_value'],
                'is_encrypted' => (bool)$row['is_encrypted'],
                'field_type' => $row['field_type'],
                'description' => $row['description'],
                'updated_by' => $row['updated_by'],
                'updated_at' => $row['updated_at']
            ];
        }

        self::$memory_cache = $settings;

        // Persist to file cache
        @file_put_contents($this->cache_file, json_encode($settings, JSON_UNESCAPED_UNICODE));

        return $settings;
    }

    /**
     * Save/Update settings for a category
     * @param string $category
     * @param array $submitted_data
     * @param array|null $uploaded_files
     * @param string|null $admin_user
     * @param string|null $ip_address
     * @return array ['status' => bool, 'message' => string, 'changed_count' => int]
     */
    public function save_category($category, $submitted_data, $uploaded_files = [], $admin_user = 'SuperAdmin', $ip_address = null) {
        $existing = $this->get_all(true);
        $changes = [];
        $changed_count = 0;

        // Handle uploaded files
        if (!empty($uploaded_files)) {
            foreach ($uploaded_files as $file_key => $file_path) {
                $submitted_data[$file_key] = $file_path;
            }
        }

        foreach ($submitted_data as $key => $new_val) {
            // Check if key exists in settings
            if (!isset($existing[$key])) {
                continue;
            }

            $item = $existing[$key];
            $is_encrypted = $item['is_encrypted'];
            $old_val = $item['value'];
            $new_val = is_string($new_val) ? trim($new_val) : $new_val;

            // If it's a sensitive/encrypted password field and user submitted placeholder '••••••••' or empty, do not overwrite
            if ($is_encrypted && ($new_val === '••••••••' || $new_val === '********' || $new_val === '')) {
                continue;
            }

            // Check if value changed
            if ((string)$old_val !== (string)$new_val) {
                $db_val = $new_val;
                if ($is_encrypted && !empty($new_val)) {
                    $db_val = $this->encrypt_value($new_val);
                }

                $this->CI->db->where('setting_key', $key);
                $this->CI->db->update('system_settings', [
                    'setting_value' => $db_val,
                    'updated_by' => $admin_user,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                // Track diff for audit log (mask sensitive fields)
                $changes[$key] = [
                    'old' => $is_encrypted ? '********' : $old_val,
                    'new' => $is_encrypted ? '********' : $new_val
                ];
                $changed_count++;
            }
        }

        // Record Audit Log if any changes occurred
        if (!empty($changes)) {
            $admin_id = $this->CI->session->userdata('adminuserid') ?: $this->CI->session->userdata('userid') ?: 1;
            $this->CI->db->insert('system_settings_audit_log', [
                'admin_id' => $admin_id,
                'admin_username' => $admin_user,
                'category' => $category,
                'action' => 'UPDATE',
                'changes' => json_encode($changes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                'ip_address' => $ip_address ?: $this->CI->input->ip_address(),
                'user_agent' => substr($this->CI->input->user_agent(), 0, 250),
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        // Clear caches
        $this->clear_cache();

        return [
            'status' => true,
            'message' => $changed_count > 0 ? "Successfully updated {$changed_count} setting(s)." : "No settings were modified.",
            'changed_count' => $changed_count,
            'changes' => $changes
        ];
    }

    /**
     * Clear memory and file cache
     */
    public function clear_cache() {
        self::$memory_cache = null;
        if (file_exists($this->cache_file)) {
            @unlink($this->cache_file);
        }
    }

    /**
     * Encrypt a string using AES-256-CBC with HMAC-SHA256 integrity
     * @param string $plain_text
     * @return string base64 encoded payload
     */
    public function encrypt_value($plain_text) {
        if ($plain_text === '' || $plain_text === null) {
            return '';
        }

        $cipher = "AES-256-CBC";
        $key = hash('sha256', $this->encryption_key, true);
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);

        $ciphertext_raw = openssl_encrypt($plain_text, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, true);

        return 'ENC:' . base64_encode($iv . $hmac . $ciphertext_raw);
    }

    /**
     * Decrypt a string created by encrypt_value
     * @param string $encrypted_str
     * @return string
     */
    public function decrypt_value($encrypted_str) {
        if (empty($encrypted_str)) {
            return '';
        }

        // If not prefixed with ENC:, it might be unencrypted plaintext
        if (strpos($encrypted_str, 'ENC:') !== 0) {
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

    /**
     * Helper to mask sensitive strings for display in UI
     * @param string $str
     * @return string
     */
    public function mask_value($str) {
        if (empty($str)) {
            return '';
        }
        $len = strlen($str);
        if ($len <= 4) {
            return str_repeat('•', $len);
        }
        return '••••••••' . substr($str, -4);
    }
}
