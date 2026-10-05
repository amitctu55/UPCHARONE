<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get audit logs with pagination and search
     */
    public function get_audit_logs($limit = 50, $offset = 0, $category = null, $search = null) {
        $this->db->select('*');
        $this->db->from('system_settings_audit_log');

        if (!empty($category) && $category !== 'ALL') {
            $this->db->where('category', $category);
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('admin_username', $search);
            $this->db->or_like('category', $search);
            $this->db->or_like('changes', $search);
            $this->db->or_like('ip_address', $search);
            $this->db->group_end();
        }

        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }

    /**
     * Get audit log count
     */
    public function get_audit_logs_count($category = null, $search = null) {
        $this->db->from('system_settings_audit_log');

        if (!empty($category) && $category !== 'ALL') {
            $this->db->where('category', $category);
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('admin_username', $search);
            $this->db->or_like('category', $search);
            $this->db->or_like('changes', $search);
            $this->db->or_like('ip_address', $search);
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }

    /**
     * Get system health and environment metrics
     */
    public function get_system_health() {
        $health = [];

        // PHP Version
        $health['php_version'] = PHP_VERSION;
        $health['php_status'] = version_compare(PHP_VERSION, '7.4.0', '>=') ? 'good' : 'warning';

        // MySQL Version
        $query = $this->db->query("SELECT VERSION() as version");
        $res = $query->row_array();
        $health['mysql_version'] = $res['version'] ?? 'Unknown';

        // Extensions
        $health['curl_installed'] = extension_loaded('curl');
        $health['openssl_installed'] = extension_loaded('openssl');
        $health['gd_installed'] = extension_loaded('gd');
        $health['mbstring_installed'] = extension_loaded('mbstring');
        $health['mysqli_installed'] = extension_loaded('mysqli');

        // Memory Limit
        $health['memory_limit'] = ini_get('memory_limit');
        $health['max_execution_time'] = ini_get('max_execution_time') . 's';
        $health['upload_max_filesize'] = ini_get('upload_max_filesize');
        $health['post_max_size'] = ini_get('post_max_size');

        // Writable Directories
        $upload_path = FCPATH . 'public/uploads/settings';
        $health['upload_dir_writable'] = is_dir($upload_path) && is_writable($upload_path);

        $cache_path = APPPATH . 'cache';
        $health['cache_dir_writable'] = is_dir($cache_path) && is_writable($cache_path);

        // Redis / OpCache
        $health['opcache_enabled'] = function_exists('opcache_get_status') && !empty(@opcache_get_status());
        $health['redis_installed'] = extension_loaded('redis');

        // Disk space
        $health['disk_free_gb'] = function_exists('disk_free_space') ? round(disk_free_space(".") / (1024 * 1024 * 1024), 2) . ' GB' : 'N/A';
        $health['disk_total_gb'] = function_exists('disk_total_space') ? round(disk_total_space(".") / (1024 * 1024 * 1024), 2) . ' GB' : 'N/A';

        // Server Load / Time
        $health['server_time'] = date('Y-m-d H:i:s T');
        $health['server_ip'] = $_SERVER['SERVER_ADDR'] ?? '127.0.0.1';

        // Total settings count
        $health['total_settings'] = $this->db->count_all('system_settings');
        $health['total_audit_logs'] = $this->db->count_all('system_settings_audit_log');

        return $health;
    }

    /**
     * Get email settings specifically as key-value pairs
     */
    public function get_email_settings() {
        $settings = $this->db->where('setting_group', 'email')->get('system_settings')->result_array();
        $res = [];
        foreach ($settings as $s) {
            $res[$s['setting_key']] = $s['setting_value'];
        }
        return $res;
    }

    /**
     * Update email settings
     */
    public function update_email_settings($data) {
        $fields = ['email_provider', 'mail_from_name', 'mail_from_email', 'from_name', 'from_email', 'smtp_host', 'smtp_port', 'smtp_crypto', 'smtp_user', 'smtp_pass', 'sendgrid_api_key'];
        foreach ($fields as $key) {
            if (isset($data[$key])) {
                $val = $data[$key];
                if ($key === 'smtp_pass' && (empty($val) || strpos($val, '••') !== false)) {
                    continue; // Keep existing password if blank or dots
                }
                $db_key = $key;
                if ($key === 'from_name') $db_key = 'mail_from_name';
                if ($key === 'from_email') $db_key = 'mail_from_email';

                $exists = $this->db->where('setting_key', $db_key)->count_all_results('system_settings');
                if ($exists) {
                    $this->db->where('setting_key', $db_key)->update('system_settings', ['setting_value' => $val]);
                } else {
                    $this->db->insert('system_settings', ['setting_group' => 'email', 'setting_key' => $db_key, 'setting_value' => $val]);
                }
            }
        }
        return true;
    }

    /**
     * Generate SQL Dump backup
     */
    public function generate_db_backup() {
        $this->load->dbutil();
        $prefs = array(
            'format'      => 'txt',
            'filename'    => 'upchar_db_backup_' . date('Y-m-d_H-i-s') . '.sql',
            'add_drop'    => TRUE,
            'add_insert'  => TRUE,
            'newline'     => "\n"
        );
        return $this->dbutil->backup($prefs);
    }
}
