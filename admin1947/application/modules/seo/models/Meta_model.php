<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Meta_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_ensure_table();
    }

    /**
     * Ensure meta_tags table and all modern SEO columns exist
     */
    public function _ensure_table()
    {
        try {
            if (!$this->db) {
                return;
            }

            // Create table if not exists
            $this->db->query("CREATE TABLE IF NOT EXISTS `meta_tags` (
              `meta_id` INT(11) NOT NULL AUTO_INCREMENT,
              `page_url` VARCHAR(255) NOT NULL,
              `meta_title` VARCHAR(255) NOT NULL,
              `meta_description` TEXT DEFAULT NULL,
              `meta_keyword` VARCHAR(255) DEFAULT NULL,
              `canonical_url` VARCHAR(255) DEFAULT NULL,
              `robots_meta` VARCHAR(50) DEFAULT 'index, follow',
              `og_title` VARCHAR(255) DEFAULT NULL,
              `og_description` TEXT DEFAULT NULL,
              `og_image` VARCHAR(255) DEFAULT NULL,
              `og_type` VARCHAR(50) DEFAULT 'website',
              `twitter_title` VARCHAR(255) DEFAULT NULL,
              `twitter_description` TEXT DEFAULT NULL,
              `twitter_image` VARCHAR(255) DEFAULT NULL,
              `schema_markup` TEXT DEFAULT NULL,
              `status` ENUM('1','0') NOT NULL DEFAULT '1',
              `meta_date_added` DATETIME DEFAULT NULL,
              `updated_at` DATETIME DEFAULT NULL,
              PRIMARY KEY (`meta_id`),
              KEY `idx_meta_url` (`page_url`(191)),
              KEY `idx_meta_status` (`status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

            // Check existing columns and add any missing ones
            $existing_cols = [];
            $cols_query = $this->db->query("SHOW COLUMNS FROM `meta_tags`");
            if ($cols_query) {
                foreach ($cols_query->result_array() as $col) {
                    $existing_cols[] = $col['Field'];
                }
            }

            $columns_to_add = [
                'canonical_url'       => "VARCHAR(255) DEFAULT NULL AFTER `meta_keyword`",
                'robots_meta'         => "VARCHAR(50) DEFAULT 'index, follow' AFTER `canonical_url`",
                'og_title'            => "VARCHAR(255) DEFAULT NULL AFTER `robots_meta`",
                'og_description'      => "TEXT DEFAULT NULL AFTER `og_title`",
                'og_image'            => "VARCHAR(255) DEFAULT NULL AFTER `og_description`",
                'og_type'             => "VARCHAR(50) DEFAULT 'website' AFTER `og_image`",
                'twitter_title'       => "VARCHAR(255) DEFAULT NULL AFTER `og_type`",
                'twitter_description' => "TEXT DEFAULT NULL AFTER `twitter_title`",
                'twitter_image'       => "VARCHAR(255) DEFAULT NULL AFTER `twitter_description`",
                'schema_markup'       => "TEXT DEFAULT NULL AFTER `twitter_image`",
                'updated_at'          => "DATETIME DEFAULT NULL AFTER `meta_date_added`"
            ];

            foreach ($columns_to_add as $col_name => $col_def) {
                if (!in_array($col_name, $existing_cols)) {
                    @$this->db->query("ALTER TABLE `meta_tags` ADD COLUMN `{$col_name}` {$col_def};");
                }
            }

            // Widen meta_title and meta_description if they are small
            @$this->db->query("ALTER TABLE `meta_tags` MODIFY `meta_title` VARCHAR(255) NOT NULL;");
            @$this->db->query("ALTER TABLE `meta_tags` MODIFY `meta_description` TEXT DEFAULT NULL;");
            @$this->db->query("ALTER TABLE `meta_tags` MODIFY `meta_keyword` VARCHAR(255) DEFAULT NULL;");

        } catch (Throwable $e) {
            log_message('error', 'Error in Meta_model::_ensure_table: ' . $e->getMessage());
        }
    }

    /**
     * Get aggregate statistics for the SEO dashboard
     */
    public function get_seo_stats()
    {
        $stats = [
            'total'          => 0,
            'active'         => 0,
            'inactive'       => 0,
            'og_count'       => 0,
            'schema_count'   => 0,
            'noindex_count'  => 0,
            'missing_desc'   => 0
        ];

        try {
            $stats['total'] = (int)$this->db->count_all('meta_tags');
            
            $q1 = $this->db->where('status', '1')->count_all_results('meta_tags');
            $stats['active'] = (int)$q1;
            $stats['inactive'] = $stats['total'] - $stats['active'];

            $this->db->where("og_title IS NOT NULL AND og_title != ''", NULL, FALSE);
            $stats['og_count'] = (int)$this->db->count_all_results('meta_tags');

            $this->db->where("schema_markup IS NOT NULL AND schema_markup != ''", NULL, FALSE);
            $stats['schema_count'] = (int)$this->db->count_all_results('meta_tags');

            $this->db->like('robots_meta', 'noindex');
            $stats['noindex_count'] = (int)$this->db->count_all_results('meta_tags');

            $this->db->where("(meta_description IS NULL OR meta_description = '')", NULL, FALSE);
            $stats['missing_desc'] = (int)$this->db->count_all_results('meta_tags');

        } catch (Throwable $e) {
            log_message('error', 'Error getting SEO stats: ' . $e->getMessage());
        }

        return $stats;
    }

    /**
     * Get list of meta tags with filtering and pagination
     */
    public function get_meta_list($limit = 10, $offset = 0, $filters = [])
    {
        try {
            $this->_apply_filters($filters);
            $this->db->order_by('meta_id', 'DESC');
            $this->db->limit($limit, $offset);
            $query = $this->db->get('meta_tags');
            return $query ? $query->result() : [];
        } catch (Throwable $e) {
            log_message('error', 'Error in get_meta_list: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get total count of meta tags matching filters
     */
    public function get_meta_count($filters = [])
    {
        try {
            $this->_apply_filters($filters);
            return (int)$this->db->count_all_results('meta_tags');
        } catch (Throwable $e) {
            log_message('error', 'Error in get_meta_count: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Helper to apply filter conditions to active DB query
     */
    private function _apply_filters($filters)
    {
        $search = isset($filters['search']) ? trim($filters['search']) : '';
        $status = isset($filters['status']) ? trim($filters['status']) : '';
        $issue  = isset($filters['issue']) ? trim($filters['issue']) : '';

        if ($search !== '') {
            $this->db->group_start();
            $this->db->like('page_url', $search);
            $this->db->or_like('meta_title', $search);
            $this->db->or_like('meta_description', $search);
            $this->db->or_like('meta_keyword', $search);
            $this->db->group_end();
        }

        if ($status !== '' && $status !== 'all') {
            $this->db->where('status', $status);
        }

        if ($issue === 'missing_desc') {
            $this->db->where("(meta_description IS NULL OR meta_description = '')", NULL, FALSE);
        } elseif ($issue === 'missing_og') {
            $this->db->where("(og_title IS NULL OR og_title = '')", NULL, FALSE);
        } elseif ($issue === 'noindex') {
            $this->db->like('robots_meta', 'noindex');
        } elseif ($issue === 'has_schema') {
            $this->db->where("schema_markup IS NOT NULL AND schema_markup != ''", NULL, FALSE);
        }
    }

    /**
     * Get single meta record by ID
     */
    public function get_meta_by_id($meta_id)
    {
        try {
            $this->db->where('meta_id', (int)$meta_id);
            $res = $this->db->get('meta_tags')->row_array();
            return $res ?: null;
        } catch (Throwable $e) {
            log_message('error', 'Error in get_meta_by_id: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Check if a page_url is already configured
     */
    public function check_url_exists($page_url, $exclude_id = 0)
    {
        try {
            $this->db->where('page_url', trim($page_url));
            if ($exclude_id > 0) {
                $this->db->where('meta_id !=', (int)$exclude_id);
            }
            return $this->db->count_all_results('meta_tags') > 0;
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * Insert a new meta record
     */
    public function insert_meta($data)
    {
        try {
            if (!isset($data['meta_date_added'])) {
                $data['meta_date_added'] = date('Y-m-d H:i:s');
            }
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->db->insert('meta_tags', $data);
            return $this->db->insert_id();
        } catch (Throwable $e) {
            log_message('error', 'Error in insert_meta: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update an existing meta record
     */
    public function update_meta($meta_id, $data)
    {
        try {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->db->where('meta_id', (int)$meta_id);
            return $this->db->update('meta_tags', $data);
        } catch (Throwable $e) {
            log_message('error', 'Error in update_meta: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete single meta record
     */
    public function delete_meta($meta_id)
    {
        try {
            $this->db->where('meta_id', (int)$meta_id);
            return $this->db->delete('meta_tags');
        } catch (Throwable $e) {
            log_message('error', 'Error in delete_meta: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Bulk delete records by array of IDs
     */
    public function bulk_delete_meta($meta_ids)
    {
        try {
            if (empty($meta_ids) || !is_array($meta_ids)) {
                return 0;
            }

            // Sanitize IDs
            $clean_ids = array_filter(array_map('intval', $meta_ids));
            if (empty($clean_ids)) {
                return 0;
            }

            $this->db->where_in('meta_id', $clean_ids);
            $this->db->delete('meta_tags');
            return $this->db->affected_rows();
        } catch (Throwable $e) {
            log_message('error', 'Error in bulk_delete_meta: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Bulk update status ('1' or '0')
     */
    public function bulk_update_status($meta_ids, $new_status)
    {
        try {
            if (empty($meta_ids) || !is_array($meta_ids)) {
                return 0;
            }
            $clean_ids = array_filter(array_map('intval', $meta_ids));
            if (empty($clean_ids)) {
                return 0;
            }

            $status = ($new_status === '1' || $new_status === 1) ? '1' : '0';
            $this->db->where_in('meta_id', $clean_ids);
            $this->db->update('meta_tags', [
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            return $this->db->affected_rows();
        } catch (Throwable $e) {
            log_message('error', 'Error in bulk_update_status: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Toggle status for a single record
     */
    public function toggle_status($meta_id)
    {
        try {
            $curr = $this->get_meta_by_id($meta_id);
            if (!$curr) {
                return false;
            }
            $new_status = ($curr['status'] === '1') ? '0' : '1';
            $this->update_meta($meta_id, ['status' => $new_status]);
            return $new_status;
        } catch (Throwable $e) {
            return false;
        }
    }
}
