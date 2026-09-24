<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pharmacy_fleet Controller
 * Super Admin Control Panel for Partner Pharmacy Accounts,
 * Delivery Fleet Roster, Live Dispatch, and Financial Settlements.
 *
 * Implements:
 * - Self-healing schema provisioning (_ensure_tables) for zero-downtime production deployment
 * - Server-side tab rendering (?tab=pharmacy|fleet|dispatch|settlements)
 * - Safe defensive database querying (verifies table and column existence)
 * - CodeIgniter Pagination with page_query_string = TRUE (10 rows per page)
 * - Lightweight database querying (only active tab records fetched)
 * - Dedicated POST endpoints for Add Pharmacy, Onboard Rider, and Record Settlement
 */
class Pharmacy_fleet extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->helper(['url', 'form']);
        $this->load->library('pagination');
        $this->load->database();

        // 1. Self-healing schema synchronization: ensure tables and columns exist
        $this->_ensure_tables();

        // 2. Admin session & guard token bridge
        if (!$this->session->userdata('userid') && !$this->session->userdata('username')) {
            $cookieToken = $this->input->cookie('upchar_admin_guard', TRUE);
            if ($cookieToken) {
                $decoded = json_decode(base64_decode($cookieToken), TRUE);
                if (is_array($decoded) && !empty($decoded['adminuserid']) && !empty($decoded['sig'])) {
                    $expectedSig = hash_hmac('sha256', $decoded['adminuserid'] . '|' . $decoded['username'] . '|' . $decoded['role'], 'UpcharMasterAdminSecret2026');
                    if (hash_equals($expectedSig, $decoded['sig'])) {
                        $this->session->set_userdata([
                            'adminuserid'      => $decoded['adminuserid'],
                            'userid'           => $decoded['adminuserid'],
                            'username'         => $decoded['username'],
                            'code'             => '1',
                            'active_auth_role' => 'admin',
                            'logged_in'        => TRUE
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Self-healing Database Schema Synchronizer
     * Automatically provisions missing tables and columns on production / staging environments
     */
    private function _ensure_tables() {
        try {
            if (!$this->db) {
                return;
            }

            // 1. pharmacy_stores table
            $this->db->query("CREATE TABLE IF NOT EXISTS `pharmacy_stores` (
                `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `hospital_id` INT(11) UNSIGNED NULL,
                `associated_doctor_id` INT(11) UNSIGNED NULL,
                `store_name` VARCHAR(255) NOT NULL,
                `drug_license_no` VARCHAR(100) NULL,
                `gstin` VARCHAR(50) NULL,
                `phone` VARCHAR(20) NULL,
                `email` VARCHAR(100) NULL,
                `address` TEXT NULL,
                `city` VARCHAR(100) DEFAULT 'Varanasi',
                `pincode` VARCHAR(10) NULL,
                `latitude` DECIMAL(10, 8) DEFAULT 25.31760000,
                `longitude` DECIMAL(11, 8) DEFAULT 82.97390000,
                `commission_rate` DECIMAL(5, 2) DEFAULT 8.00,
                `delivery_radius_km` DECIMAL(4, 1) DEFAULT 5.0,
                `operating_hours` VARCHAR(100) DEFAULT '09:00 AM - 10:00 PM',
                `max_queue_limit` INT DEFAULT 25,
                `is_emergency_closed` TINYINT(1) DEFAULT 0,
                `is_verified` TINYINT(1) DEFAULT 1,
                `pharmacist_name` VARCHAR(100) NULL,
                `store_photo` VARCHAR(255) NULL,
                `drug_license_file` VARCHAR(255) NULL,
                `gst_certificate` VARCHAR(255) NULL,
                `is_active` TINYINT(1) DEFAULT 1,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX `idx_ps_city` (`city`),
                INDEX `idx_ps_active` (`is_active`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            // Ensure additive columns in pharmacy_stores if table existed previously with older schema
            if ($this->db->table_exists('pharmacy_stores')) {
                if (!$this->db->field_exists('delivery_radius_km', 'pharmacy_stores')) {
                    @$this->db->query("ALTER TABLE `pharmacy_stores` ADD COLUMN `delivery_radius_km` DECIMAL(4, 1) DEFAULT 5.0");
                }
                if (!$this->db->field_exists('operating_hours', 'pharmacy_stores')) {
                    @$this->db->query("ALTER TABLE `pharmacy_stores` ADD COLUMN `operating_hours` VARCHAR(100) DEFAULT '09:00 AM - 10:00 PM'");
                }
                if (!$this->db->field_exists('max_queue_limit', 'pharmacy_stores')) {
                    @$this->db->query("ALTER TABLE `pharmacy_stores` ADD COLUMN `max_queue_limit` INT DEFAULT 25");
                }
                if (!$this->db->field_exists('is_emergency_closed', 'pharmacy_stores')) {
                    @$this->db->query("ALTER TABLE `pharmacy_stores` ADD COLUMN `is_emergency_closed` TINYINT(1) DEFAULT 0");
                }
                if (!$this->db->field_exists('is_verified', 'pharmacy_stores')) {
                    @$this->db->query("ALTER TABLE `pharmacy_stores` ADD COLUMN `is_verified` TINYINT(1) DEFAULT 1");
                }
                if (!$this->db->field_exists('commission_rate', 'pharmacy_stores')) {
                    @$this->db->query("ALTER TABLE `pharmacy_stores` ADD COLUMN `commission_rate` DECIMAL(5, 2) DEFAULT 8.00");
                }
                if (!$this->db->field_exists('drug_license_no', 'pharmacy_stores')) {
                    @$this->db->query("ALTER TABLE `pharmacy_stores` ADD COLUMN `drug_license_no` VARCHAR(100) NULL");
                }
                if (!$this->db->field_exists('gstin', 'pharmacy_stores')) {
                    @$this->db->query("ALTER TABLE `pharmacy_stores` ADD COLUMN `gstin` VARCHAR(50) NULL");
                }
                if (!$this->db->field_exists('phone', 'pharmacy_stores')) {
                    @$this->db->query("ALTER TABLE `pharmacy_stores` ADD COLUMN `phone` VARCHAR(20) NULL");
                }
                if (!$this->db->field_exists('email', 'pharmacy_stores')) {
                    @$this->db->query("ALTER TABLE `pharmacy_stores` ADD COLUMN `email` VARCHAR(100) NULL");
                }
                if (!$this->db->field_exists('address', 'pharmacy_stores')) {
                    @$this->db->query("ALTER TABLE `pharmacy_stores` ADD COLUMN `address` TEXT NULL");
                }
                if (!$this->db->field_exists('city', 'pharmacy_stores')) {
                    @$this->db->query("ALTER TABLE `pharmacy_stores` ADD COLUMN `city` VARCHAR(100) DEFAULT 'Varanasi'");
                }
                if (!$this->db->field_exists('hospital_id', 'pharmacy_stores')) {
                    @$this->db->query("ALTER TABLE `pharmacy_stores` ADD COLUMN `hospital_id` INT(11) UNSIGNED NULL");
                }
                if (!$this->db->field_exists('associated_doctor_id', 'pharmacy_stores')) {
                    @$this->db->query("ALTER TABLE `pharmacy_stores` ADD COLUMN `associated_doctor_id` INT(11) UNSIGNED NULL");
                }
            }

            // 2. delivery_riders table
            $this->db->query("CREATE TABLE IF NOT EXISTS `delivery_riders` (
                `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(100) NULL,
                `rider_name` VARCHAR(100) NULL,
                `phone` VARCHAR(20) NOT NULL,
                `email` VARCHAR(100) NULL,
                `driving_license_no` VARCHAR(50) NULL,
                `vehicle_type` VARCHAR(50) DEFAULT 'Bike',
                `vehicle_number` VARCHAR(50) NOT NULL,
                `current_lat` DECIMAL(10, 8) DEFAULT 25.31760000,
                `current_lng` DECIMAL(11, 8) DEFAULT 82.97390000,
                `current_latitude` DECIMAL(10, 8) DEFAULT 25.31760000,
                `current_longitude` DECIMAL(11, 8) DEFAULT 82.97390000,
                `status` ENUM('AVAILABLE', 'BUSY', 'OFFLINE') DEFAULT 'AVAILABLE',
                `is_verified` TINYINT(1) DEFAULT 1,
                `is_active` TINYINT(1) DEFAULT 1,
                `total_completed_orders` INT DEFAULT 0,
                `wallet_balance` DECIMAL(10, 2) DEFAULT 0.00,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX `idx_dr_status` (`status`, `is_active`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            // Ensure additive columns in delivery_riders if table existed previously with older schema
            if ($this->db->table_exists('delivery_riders')) {
                if (!$this->db->field_exists('name', 'delivery_riders')) {
                    @$this->db->query("ALTER TABLE `delivery_riders` ADD COLUMN `name` VARCHAR(100) NULL AFTER `id`");
                }
                if (!$this->db->field_exists('rider_name', 'delivery_riders')) {
                    @$this->db->query("ALTER TABLE `delivery_riders` ADD COLUMN `rider_name` VARCHAR(100) NULL AFTER `name`");
                }
                if (!$this->db->field_exists('email', 'delivery_riders')) {
                    @$this->db->query("ALTER TABLE `delivery_riders` ADD COLUMN `email` VARCHAR(100) NULL");
                }
                if (!$this->db->field_exists('driving_license_no', 'delivery_riders')) {
                    @$this->db->query("ALTER TABLE `delivery_riders` ADD COLUMN `driving_license_no` VARCHAR(50) NULL");
                }
                if (!$this->db->field_exists('vehicle_type', 'delivery_riders')) {
                    @$this->db->query("ALTER TABLE `delivery_riders` ADD COLUMN `vehicle_type` VARCHAR(50) DEFAULT 'Bike'");
                }
                if (!$this->db->field_exists('current_latitude', 'delivery_riders')) {
                    @$this->db->query("ALTER TABLE `delivery_riders` ADD COLUMN `current_latitude` DECIMAL(10, 8) DEFAULT 25.31760000");
                }
                if (!$this->db->field_exists('current_longitude', 'delivery_riders')) {
                    @$this->db->query("ALTER TABLE `delivery_riders` ADD COLUMN `current_longitude` DECIMAL(11, 8) DEFAULT 82.97390000");
                }
                if (!$this->db->field_exists('current_lat', 'delivery_riders')) {
                    @$this->db->query("ALTER TABLE `delivery_riders` ADD COLUMN `current_lat` DECIMAL(10, 8) DEFAULT 25.31760000");
                }
                if (!$this->db->field_exists('current_lng', 'delivery_riders')) {
                    @$this->db->query("ALTER TABLE `delivery_riders` ADD COLUMN `current_lng` DECIMAL(11, 8) DEFAULT 82.97390000");
                }
                if (!$this->db->field_exists('is_verified', 'delivery_riders')) {
                    @$this->db->query("ALTER TABLE `delivery_riders` ADD COLUMN `is_verified` TINYINT(1) DEFAULT 1");
                }
                if (!$this->db->field_exists('total_completed_orders', 'delivery_riders')) {
                    @$this->db->query("ALTER TABLE `delivery_riders` ADD COLUMN `total_completed_orders` INT DEFAULT 0");
                }
                if (!$this->db->field_exists('wallet_balance', 'delivery_riders')) {
                    @$this->db->query("ALTER TABLE `delivery_riders` ADD COLUMN `wallet_balance` DECIMAL(10, 2) DEFAULT 0.00");
                }
                // Sync name / rider_name
                @$this->db->query("UPDATE `delivery_riders` SET `name` = `rider_name` WHERE (`name` IS NULL OR `name` = '') AND `rider_name` IS NOT NULL AND `rider_name` != ''");
                @$this->db->query("UPDATE `delivery_riders` SET `rider_name` = `name` WHERE (`rider_name` IS NULL OR `rider_name` = '') AND `name` IS NOT NULL AND `name` != ''");
            }

            // 3. medicine_orders table
            $this->db->query("CREATE TABLE IF NOT EXISTS `medicine_orders` (
                `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `order_code` VARCHAR(50) NOT NULL,
                `user_id` INT(11) UNSIGNED NULL DEFAULT 0,
                `pharmacy_id` INT(11) UNSIGNED NULL DEFAULT 0,
                `prescription_id` INT(11) UNSIGNED NULL DEFAULT 0,
                `rider_id` INT(11) UNSIGNED NULL DEFAULT 0,
                `item_total` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
                `delivery_fee` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
                `total_amount` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
                `order_status` ENUM('PLACED', 'PENDING_RX', 'CONFIRMED', 'PACKED', 'ASSIGNED', 'IN_TRANSIT', 'DELIVERED', 'CANCELLED') DEFAULT 'PLACED',
                `payment_mode` ENUM('COD', 'ONLINE', 'WALLET') DEFAULT 'COD',
                `payment_status` ENUM('PENDING', 'PAID', 'REFUNDED') DEFAULT 'PENDING',
                `delivery_otp` VARCHAR(10) DEFAULT '1234',
                `customer_name` VARCHAR(100) NULL,
                `customer_phone` VARCHAR(20) NULL,
                `rider_assigned_at` DATETIME NULL,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX `idx_mo_order_code` (`order_code`),
                INDEX `idx_mo_status` (`order_status`),
                INDEX `idx_mo_rider` (`rider_id`),
                INDEX `idx_mo_pharmacy` (`pharmacy_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            // 4. pharmacy_settlements table
            $this->db->query("CREATE TABLE IF NOT EXISTS `pharmacy_settlements` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `pharmacy_id` INT NOT NULL,
                `settlement_period_start` DATE NOT NULL,
                `settlement_period_end` DATE NOT NULL,
                `gross_sales` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
                `upchar_commission` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
                `net_payout` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
                `utr_number` VARCHAR(100) DEFAULT NULL,
                `settlement_status` ENUM('PENDING', 'PROCESSED', 'FAILED') DEFAULT 'PENDING',
                `processed_at` DATETIME NULL,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                INDEX `idx_ps_pharmacy` (`pharmacy_id`),
                INDEX `idx_ps_status` (`settlement_status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            // 5. order_delivery_assignments table
            $this->db->query("CREATE TABLE IF NOT EXISTS `order_delivery_assignments` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `order_id` INT NOT NULL,
                `rider_id` INT NOT NULL,
                `assigned_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                `picked_up_at` DATETIME NULL,
                `delivered_at` DATETIME NULL,
                `delivery_status` ENUM('ASSIGNED', 'PICKED_UP', 'DELIVERED', 'FAILED', 'REASSIGNED') DEFAULT 'ASSIGNED',
                `rider_payout_amount` DECIMAL(8, 2) DEFAULT 35.00,
                `cod_collected_amount` DECIMAL(10, 2) DEFAULT 0.00,
                INDEX `idx_oda_order` (`order_id`),
                INDEX `idx_oda_rider` (`rider_id`),
                INDEX `idx_oda_status` (`delivery_status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            // Seed initial records if pharmacy_stores has 0 records
            if ($this->db->table_exists('pharmacy_stores') && $this->db->count_all('pharmacy_stores') == 0) {
                $this->db->insert_batch('pharmacy_stores', [
                    [
                        'store_name'         => 'Apex Care Medicos & Chemist',
                        'drug_license_no'    => 'DL-UP-VNS-20B-10842',
                        'gstin'              => '09AAACA1122D1Z4',
                        'phone'              => '9838112233',
                        'email'              => 'apex.medicos@upchar.info',
                        'address'            => 'Ground Floor, Near Apex Hospital, Sigra',
                        'city'               => 'Varanasi',
                        'pincode'            => '221002',
                        'latitude'           => 25.31760000,
                        'longitude'          => 82.97390000,
                        'commission_rate'    => 10.00,
                        'delivery_radius_km' => 6.0,
                        'operating_hours'    => '08:00 AM - 11:00 PM',
                        'is_active'          => 1,
                        'created_at'         => date('Y-m-d H:i:s')
                    ],
                    [
                        'store_name'         => 'Sanjivani 24x7 Chemist & Druggists',
                        'drug_license_no'    => 'DL-UP-VNS-21-44589',
                        'gstin'              => '09BBACB2233E2Z5',
                        'phone'              => '9450223344',
                        'email'              => 'sanjivani.vns@upchar.info',
                        'address'            => 'Plot 42, Maldahiya Crossing',
                        'city'               => 'Varanasi',
                        'pincode'            => '221001',
                        'latitude'           => 25.32620000,
                        'longitude'          => 82.98600000,
                        'commission_rate'    => 8.00,
                        'delivery_radius_km' => 8.0,
                        'operating_hours'    => '24 Hours Open',
                        'is_active'          => 1,
                        'created_at'         => date('Y-m-d H:i:s')
                    ]
                ]);
            }

            // Seed initial records if delivery_riders has 0 records
            if ($this->db->table_exists('delivery_riders') && $this->db->count_all('delivery_riders') == 0) {
                $this->db->insert_batch('delivery_riders', [
                    [
                        'name'               => 'Rahul Sharma',
                        'rider_name'         => 'Rahul Sharma',
                        'phone'              => '9876543210',
                        'email'              => 'rahul.rider@upchar.info',
                        'driving_license_no' => 'UP652018000412',
                        'vehicle_type'       => 'Bike',
                        'vehicle_number'     => 'UP 65 BT 1024',
                        'current_lat'        => 25.31800000,
                        'current_lng'        => 82.97400000,
                        'current_latitude'   => 25.31800000,
                        'current_longitude'  => 82.97400000,
                        'status'             => 'AVAILABLE',
                        'is_verified'        => 1,
                        'is_active'          => 1,
                        'created_at'         => date('Y-m-d H:i:s')
                    ],
                    [
                        'name'               => 'Amit Verma',
                        'rider_name'         => 'Amit Verma',
                        'phone'              => '9876543211',
                        'email'              => 'amit.rider@upchar.info',
                        'driving_license_no' => 'UP652019000889',
                        'vehicle_type'       => 'Scooter',
                        'vehicle_number'     => 'UP 65 CK 5588',
                        'current_lat'        => 25.32600000,
                        'current_lng'        => 82.98500000,
                        'current_latitude'   => 25.32600000,
                        'current_longitude'  => 82.98500000,
                        'status'             => 'AVAILABLE',
                        'is_verified'        => 1,
                        'is_active'          => 1,
                        'created_at'         => date('Y-m-d H:i:s')
                    ]
                ]);
            }
        } catch (\Throwable $e) {
            log_message('error', 'Pharmacy_fleet _ensure_tables error: ' . $e->getMessage());
        }
    }

    /**
     * Alias for pharmacy_fleet() to support both routes
     */
    public function index() {
        $this->pharmacy_fleet();
    }

    /**
     * Main Fleet & Pharmacy Management Dashboard
     * Server-side tab rendering & lightweight paginated queries
     */
    public function pharmacy_fleet() {
        $tab = $this->input->get('tab') ?: 'pharmacy';
        $allowedTabs = ['pharmacy', 'fleet', 'dispatch', 'settlements'];
        if (!in_array($tab, $allowedTabs)) {
            $tab = 'pharmacy';
        }

        $keyword = trim($this->input->get('keyword') ?: '');
        $page = (int)($this->input->get('page') ?: 0);
        if ($page < 0) $page = 0;

        $perPage = 10;
        $totalRows = 0;
        $records = [];

        try {
            // 1. Server-side Tab Querying: Fetch ONLY active tab data
            switch ($tab) {
                case 'fleet':
                    if ($this->db->table_exists('delivery_riders')) {
                        // Total Count for Pagination
                        $this->db->from('delivery_riders dr');
                        if (!empty($keyword)) {
                            $this->db->group_start();
                            if ($this->db->field_exists('name', 'delivery_riders')) {
                                $this->db->like('dr.name', $keyword);
                            }
                            if ($this->db->field_exists('rider_name', 'delivery_riders')) {
                                $this->db->or_like('dr.rider_name', $keyword);
                            }
                            $this->db->or_like('dr.phone', $keyword);
                            $this->db->or_like('dr.vehicle_number', $keyword);
                            $this->db->group_end();
                        }
                        $totalRows = (int)$this->db->count_all_results();

                        // Paginated Query
                        if ($this->db->table_exists('medicine_orders')) {
                            $this->db->select('dr.*, 
                                (SELECT COUNT(*) FROM medicine_orders mo WHERE mo.rider_id = dr.id AND mo.order_status IN (\'ASSIGNED\', \'IN_TRANSIT\')) as active_deliveries,
                                (SELECT mo.order_code FROM medicine_orders mo WHERE mo.rider_id = dr.id AND mo.order_status IN (\'ASSIGNED\', \'IN_TRANSIT\') LIMIT 1) as active_order_code,
                                (SELECT SUM(mo.total_amount) FROM medicine_orders mo WHERE mo.rider_id = dr.id AND mo.payment_mode = \'COD\' AND mo.order_status = \'IN_TRANSIT\') as cod_in_hand');
                        } else {
                            $this->db->select('dr.*, 0 as active_deliveries, NULL as active_order_code, 0.00 as cod_in_hand');
                        }
                        $this->db->from('delivery_riders dr');
                        if (!empty($keyword)) {
                            $this->db->group_start();
                            if ($this->db->field_exists('name', 'delivery_riders')) {
                                $this->db->like('dr.name', $keyword);
                            }
                            if ($this->db->field_exists('rider_name', 'delivery_riders')) {
                                $this->db->or_like('dr.rider_name', $keyword);
                            }
                            $this->db->or_like('dr.phone', $keyword);
                            $this->db->or_like('dr.vehicle_number', $keyword);
                            $this->db->group_end();
                        }
                        $this->db->order_by('dr.id', 'ASC');
                        $this->db->limit($perPage, $page);
                        $records = (array)$this->db->get()->result_array();
                    }
                    break;

                case 'dispatch':
                    if ($this->db->table_exists('medicine_orders')) {
                        // Total Count for Pagination
                        $this->db->from('medicine_orders mo');
                        if ($this->db->table_exists('pharmacy_stores')) {
                            $this->db->join('pharmacy_stores ps', 'ps.id = mo.pharmacy_id', 'left');
                        }
                        if (!empty($keyword)) {
                            $this->db->group_start();
                            $this->db->like('mo.order_code', $keyword);
                            $this->db->or_like('mo.customer_name', $keyword);
                            $this->db->or_like('mo.customer_phone', $keyword);
                            if ($this->db->table_exists('pharmacy_stores')) {
                                $this->db->or_like('ps.store_name', $keyword);
                            }
                            $this->db->group_end();
                        }
                        $totalRows = (int)$this->db->count_all_results();

                        // Paginated Query
                        $selectCols = 'mo.*';
                        if ($this->db->table_exists('pharmacy_stores')) {
                            $selectCols .= ', ps.store_name';
                        }
                        if ($this->db->table_exists('delivery_riders')) {
                            $selectCols .= ', dr.name as rider_name, dr.phone as rider_phone';
                        }
                        $this->db->select($selectCols);
                        $this->db->from('medicine_orders mo');
                        if ($this->db->table_exists('pharmacy_stores')) {
                            $this->db->join('pharmacy_stores ps', 'ps.id = mo.pharmacy_id', 'left');
                        }
                        if ($this->db->table_exists('delivery_riders')) {
                            $this->db->join('delivery_riders dr', 'dr.id = mo.rider_id', 'left');
                        }
                        if (!empty($keyword)) {
                            $this->db->group_start();
                            $this->db->like('mo.order_code', $keyword);
                            $this->db->or_like('mo.customer_name', $keyword);
                            $this->db->or_like('mo.customer_phone', $keyword);
                            if ($this->db->table_exists('pharmacy_stores')) {
                                $this->db->or_like('ps.store_name', $keyword);
                            }
                            $this->db->group_end();
                        }
                        $this->db->order_by('mo.id', 'DESC');
                        $this->db->limit($perPage, $page);
                        $records = (array)$this->db->get()->result_array();
                    }
                    break;

                case 'settlements':
                    if ($this->db->table_exists('pharmacy_settlements')) {
                        $statusFilter = strtoupper($this->input->get('status') ?: 'ALL');
                        $dateFrom = $this->input->get('date_from');
                        $dateTo   = $this->input->get('date_to');

                        // Base filter builder
                        $applyFilters = function() use ($keyword, $statusFilter, $dateFrom, $dateTo) {
                            if ($statusFilter !== 'ALL') {
                                $this->db->where('pset.settlement_status', $statusFilter);
                            }
                            if (!empty($dateFrom) && !empty($dateTo)) {
                                $this->db->where('pset.settlement_period_start >=', $dateFrom);
                                $this->db->where('pset.settlement_period_end <=', $dateTo);
                            }
                            if (!empty($keyword)) {
                                $this->db->group_start();
                                if ($this->db->table_exists('pharmacy_stores')) {
                                    $this->db->like('ps.store_name', $keyword);
                                }
                                $this->db->or_like('pset.utr_number', $keyword);
                                $this->db->or_like('pset.bank_account_no', $keyword);
                                $this->db->group_end();
                            }
                        };

                        // Total Count for Pagination
                        $this->db->from('pharmacy_settlements pset');
                        if ($this->db->table_exists('pharmacy_stores')) {
                            $this->db->join('pharmacy_stores ps', 'ps.id = pset.pharmacy_id', 'left');
                        }
                        $applyFilters();
                        $totalRows = (int)$this->db->count_all_results();

                        // Paginated Query
                        $selectCols = 'pset.*';
                        if ($this->db->table_exists('pharmacy_stores')) {
                            $selectCols .= ', ps.store_name, ps.gstin, ps.phone as store_phone, ps.drug_license_no, ps.city as store_city';
                        }
                        if ($this->db->table_exists('hospital')) {
                            $selectCols .= ', h.name as hospital_name';
                        }
                        $this->db->select($selectCols);
                        $this->db->from('pharmacy_settlements pset');
                        if ($this->db->table_exists('pharmacy_stores')) {
                            $this->db->join('pharmacy_stores ps', 'ps.id = pset.pharmacy_id', 'left');
                            if ($this->db->table_exists('hospital')) {
                                $this->db->join('hospital h', 'h.id = ps.hospital_id', 'left');
                            }
                        }
                        $applyFilters();
                        $this->db->order_by('pset.id', 'DESC');
                        $this->db->limit($perPage, $page);
                        $records = (array)$this->db->get()->result_array();

                        // Compute Summary KPIs for Reconciliation Control Bar
                        $this->db->select('COALESCE(SUM(gross_sales), 0) as total_gmv, COALESCE(SUM(upchar_commission), 0) as total_comm, COALESCE(SUM(cod_remittance), 0) as total_cod');
                        $sumRow = $this->db->get('pharmacy_settlements')->row_array();
                        $data['settle_total_gmv'] = (float)($sumRow['total_gmv'] ?? 0);
                        $data['settle_platform_revenue'] = (float)($sumRow['total_comm'] ?? 0);
                        $data['settle_outstanding_cod'] = (float)($sumRow['total_cod'] ?? 0);

                        $this->db->select('COALESCE(SUM(net_payout), 0) as net_due');
                        $this->db->where_in('settlement_status', ['DUE', 'PROCESSING', 'PENDING']);
                        $dueRow = $this->db->get('pharmacy_settlements')->row_array();
                        $data['settle_net_payout_due'] = (float)($dueRow['net_due'] ?? 0);
                        $data['status_filter'] = $statusFilter;
                        $data['date_from'] = $dateFrom;
                        $data['date_to'] = $dateTo;
                    }
                    break;

                case 'pharmacy':
                default:
                    if ($this->db->table_exists('pharmacy_stores')) {
                        // Total Count for Pagination
                        $this->db->from('pharmacy_stores ps');
                        if (!empty($keyword)) {
                            $this->db->group_start();
                            $this->db->like('ps.store_name', $keyword);
                            $this->db->or_like('ps.phone', $keyword);
                            if ($this->db->field_exists('drug_license_no', 'pharmacy_stores')) {
                                $this->db->or_like('ps.drug_license_no', $keyword);
                            }
                            if ($this->db->field_exists('gstin', 'pharmacy_stores')) {
                                $this->db->or_like('ps.gstin', $keyword);
                            }
                            $this->db->group_end();
                        }
                        $totalRows = (int)$this->db->count_all_results();

                        // Paginated Query
                        $selectCols = "ps.*";
                        if ($this->db->table_exists('hospital')) {
                            $selectCols .= ", h.name as hospital_name";
                        }
                        if ($this->db->table_exists('profile_dr')) {
                            $selectCols .= ", CONCAT('Dr. ', d.fname, ' ', d.lname) as doctor_name";
                        }
                        $this->db->select($selectCols);
                        $this->db->from('pharmacy_stores ps');
                        if ($this->db->table_exists('hospital')) {
                            $this->db->join('hospital h', 'h.id = ps.hospital_id', 'left');
                        }
                        if ($this->db->table_exists('profile_dr')) {
                            $this->db->join('profile_dr d', 'd.id = ps.associated_doctor_id', 'left');
                        }
                        if (!empty($keyword)) {
                            $this->db->group_start();
                            $this->db->like('ps.store_name', $keyword);
                            $this->db->or_like('ps.phone', $keyword);
                            if ($this->db->field_exists('drug_license_no', 'pharmacy_stores')) {
                                $this->db->or_like('ps.drug_license_no', $keyword);
                            }
                            if ($this->db->field_exists('gstin', 'pharmacy_stores')) {
                                $this->db->or_like('ps.gstin', $keyword);
                            }
                            $this->db->group_end();
                        }
                        $this->db->order_by('ps.id', 'DESC');
                        $this->db->limit($perPage, $page);
                        $records = (array)$this->db->get()->result_array();
                    }
                    break;
            }
        } catch (\Throwable $e) {
            log_message('error', 'Pharmacy_fleet querying exception: ' . $e->getMessage());
            $records = [];
            $totalRows = 0;
        }

        // 2. CodeIgniter Pagination Configuration
        $config['base_url']             = base_url('masters/pharmacy_fleet?tab=' . $tab . (!empty($keyword) ? '&keyword=' . urlencode($keyword) : ''));
        $config['total_rows']           = $totalRows;
        $config['per_page']             = $perPage;
        $config['page_query_string']    = TRUE;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string']   = TRUE;

        // Bootstrap 3 / AdminLTE pagination markup
        $config['full_tag_open']   = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close']  = '</ul>';
        $config['first_link']      = '&laquo; First';
        $config['first_tag_open']  = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link']       = 'Last &raquo;';
        $config['last_tag_open']   = '<li>';
        $config['last_tag_close']  = '</li>';
        $config['next_link']       = 'Next &rsaquo;';
        $config['next_tag_open']   = '<li>';
        $config['next_tag_close']  = '</li>';
        $config['prev_link']       = '&lsaquo; Prev';
        $config['prev_tag_open']   = '<li>';
        $config['prev_tag_close']  = '</li>';
        $config['cur_tag_open']    = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close']   = '</a></li>';
        $config['num_tag_open']    = '<li>';
        $config['num_tag_close']   = '</li>';

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        // 3. Lightweight KPI Stats Summary (Defensive counts)
        $data['total_stores']        = $this->db->table_exists('pharmacy_stores') ? (int)$this->db->count_all('pharmacy_stores') : 0;
        $data['total_riders']        = $this->db->table_exists('delivery_riders') ? (int)$this->db->count_all('delivery_riders') : 0;
        $data['active_riders_count'] = $this->db->table_exists('delivery_riders') ? 
            (int)$this->db->where('status !=', 'OFFLINE')->where('is_active', 1)->count_all_results('delivery_riders') : 0;
        $data['active_orders_count'] = $this->db->table_exists('medicine_orders') ? 
            (int)$this->db->where_in('order_status', ['PACKED', 'ASSIGNED', 'IN_TRANSIT'])->count_all_results('medicine_orders') : 0;
        $data['total_settlements']   = $this->db->table_exists('pharmacy_settlements') ? 
            (int)$this->db->count_all('pharmacy_settlements') : 0;

        // 4. Modal Dropdowns (loaded defensively)
        $data['all_doctors']   = $this->db->table_exists('profile_dr') ? 
            (array)$this->db->select('id, fname, lname')->order_by('fname', 'ASC')->get_where('profile_dr', ['approved' => '1', 'verified' => '1'])->result_array() : [];
        $data['all_hospitals'] = $this->db->table_exists('hospital') ? 
            (array)$this->db->select('id, name, city')->order_by('name', 'ASC')->get_where('hospital', ['status' => '1'])->result_array() : [];
        $data['all_stores']    = $this->db->table_exists('pharmacy_stores') ? 
            (array)$this->db->select('id, store_name, commission_rate')->order_by('store_name', 'ASC')->get('pharmacy_stores')->result_array() : [];
        $data['all_riders']    = $this->db->table_exists('delivery_riders') ? 
            (array)$this->db->select('id, name, rider_name, vehicle_number, status')->where('is_active', 1)->get('delivery_riders')->result_array() : [];
        $data['active_orders'] = $this->db->table_exists('medicine_orders') ? 
            (array)$this->db->select('id, order_code, order_status, total_amount')
                ->where_in('order_status', ['PACKED', 'ASSIGNED', 'IN_TRANSIT'])
                ->order_by('id', 'DESC')->limit(30)->get('medicine_orders')->result_array() : [];

        // 5. Data payload passed to view
        $data['active_tab']    = $tab;
        $data['records']       = $records;
        $data['total_rows']    = $totalRows;
        $data['keyword']       = $keyword;
        $data['current_page']  = $page;
        $data['heading_title'] = 'Pharmacy & Delivery Fleet Control Panel';
        $data['module']        = 'Masters';

        // 6. Complete standard layout load
        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('masters/pharmacy_fleet_view', $data);
        $this->load->view('inc/sidebar');
        $this->load->view('inc/headersetting');
        $this->load->view('inc/footerlink');
        $this->load->view('inc/table_footer');
    }

    /* =========================================================================
     * DEDICATED POST PROCESSING METHODS
     * ========================================================================= */

    /**
     * Dedicated Action: Full-Page Add or Edit Partner Pharmacy Store
     * On GET: Renders dedicated full-page form (masters/add_pharmacy_view)
     * On POST: Saves store data and redirects to ?tab=pharmacy
     */
    public function add_pharmacy($id = 0) {
        $id = (int)($id ?: $this->input->post('id') ?: $this->input->get('id') ?: 0);

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $storeData = [
                'store_name'            => trim($this->input->post('store_name')),
                'hospital_id'           => !empty($this->input->post('hospital_id')) ? (int)$this->input->post('hospital_id') : null,
                'associated_doctor_id'  => !empty($this->input->post('associated_doctor_id')) ? (int)$this->input->post('associated_doctor_id') : null,
                'drug_license_no'       => trim($this->input->post('drug_license_no')),
                'gstin'                 => trim($this->input->post('gstin')),
                'phone'                 => trim($this->input->post('phone')),
                'email'                 => trim($this->input->post('email')),
                'address'               => trim($this->input->post('address')),
                'city'                  => trim($this->input->post('city')) ?: 'Varanasi',
                'latitude'              => (float)($this->input->post('latitude') ?: 25.3176),
                'longitude'             => (float)($this->input->post('longitude') ?: 82.9739),
                'commission_rate'       => (float)($this->input->post('commission_rate') ?: 8.00),
                'delivery_radius_km'    => (float)($this->input->post('delivery_radius_km') ?: 5.0),
                'operating_hours'       => trim($this->input->post('operating_hours') ?: '09:00 AM - 10:00 PM'),
                'max_queue_limit'       => (int)($this->input->post('max_queue_limit') ?: 25),
                'is_emergency_closed'   => !empty($this->input->post('is_emergency_closed')) ? 1 : 0,
                'is_verified'           => !empty($this->input->post('is_verified')) ? 1 : 0,
                'is_active'             => !empty($this->input->post('is_active')) ? 1 : 0,
                'updated_at'            => date('Y-m-d H:i:s')
            ];

            if ($id > 0) {
                $this->db->where('id', $id)->update('pharmacy_stores', $storeData);
                $this->session->set_flashdata('success', 'Partner pharmacy details updated successfully.');
                $this->session->set_flashdata('success_msg', 'Partner pharmacy details updated successfully.');
            } else {
                $storeData['created_at'] = date('Y-m-d H:i:s');
                $this->db->insert('pharmacy_stores', $storeData);
                $this->session->set_flashdata('success', 'New partner pharmacy added successfully.');
                $this->session->set_flashdata('success_msg', 'New partner pharmacy added successfully.');
            }

            redirect(base_url('masters/pharmacy_fleet?tab=pharmacy'));
            return;
        }

        // GET Request: Render Full-Page Dedicated Form View
        $data['store'] = [];
        if ($id > 0 && $this->db->table_exists('pharmacy_stores')) {
            $data['store'] = (array)$this->db->get_where('pharmacy_stores', ['id' => $id])->row_array();
        }

        $data['all_doctors']   = $this->db->table_exists('profile_dr') ? 
            (array)$this->db->select('id, fname, lname')->order_by('fname', 'ASC')->get_where('profile_dr', ['approved' => '1', 'verified' => '1'])->result_array() : [];
        $data['all_hospitals'] = $this->db->table_exists('hospital') ? 
            (array)$this->db->select('id, name, city')->order_by('name', 'ASC')->get_where('hospital', ['status' => '1'])->result_array() : [];
        $data['heading_title'] = $id > 0 ? 'Edit Partner Pharmacy' : 'Add New Partner Pharmacy';
        $data['module']        = 'Masters';

        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('masters/add_pharmacy_view', $data);
        $this->load->view('inc/sidebar');
        $this->load->view('inc/headersetting');
        $this->load->view('inc/footerlink');
        $this->load->view('inc/table_footer');
    }

    /**
     * Alias for Edit Pharmacy
     */
    public function edit_pharmacy($id = 0) {
        $this->add_pharmacy($id);
    }

    /**
     * AJAX Endpoint: Quick Toggle Store Status
     * (is_active, is_verified, is_emergency_closed)
     */
    public function toggle_status_ajax() {
        $storeId = (int)$this->input->post('store_id');
        $field   = trim($this->input->post('field'));
        $value   = (int)$this->input->post('value');

        $allowedFields = ['is_active', 'is_verified', 'is_emergency_closed'];
        if ($storeId > 0 && in_array($field, $allowedFields) && $this->db->table_exists('pharmacy_stores')) {
            $this->db->where('id', $storeId)->update('pharmacy_stores', [
                $field       => $value ? 1 : 0,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            echo json_encode([
                'status'  => 'success',
                'message' => ucwords(str_replace('_', ' ', $field)) . ' set to ' . ($value ? 'ON' : 'OFF'),
                'field'   => $field,
                'value'   => $value ? 1 : 0
            ]);
            return;
        }

        echo json_encode(['status' => 'error', 'message' => 'Invalid parameters for status toggle.']);
    }

    /**
     * Alias for backwards compatibility
     */
    public function save_pharmacy() {
        $this->add_pharmacy();
    }

    /**
     * Dedicated Action: Full-Page Onboard or Edit Delivery Fleet Rider
     * On GET: Renders dedicated full-page form (masters/onboard_rider_view)
     * On POST: Saves rider data and redirects to ?tab=fleet
     */
    public function onboard_rider($id = 0) {
        $id = (int)($id ?: $this->input->post('id') ?: $this->input->get('id') ?: 0);

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $riderName = trim($this->input->post('name') ?: $this->input->post('rider_name'));
            $riderData = [
                'name'               => $riderName,
                'rider_name'         => $riderName,
                'phone'              => trim($this->input->post('phone')),
                'email'              => trim($this->input->post('email')),
                'driving_license_no' => trim($this->input->post('driving_license_no')),
                'vehicle_type'       => $this->input->post('vehicle_type') ?: 'Bike',
                'vehicle_number'     => trim($this->input->post('vehicle_number')),
                'status'             => $this->input->post('status') ?: 'AVAILABLE',
                'current_latitude'   => (float)($this->input->post('current_latitude') ?: 25.3176),
                'current_longitude'  => (float)($this->input->post('current_longitude') ?: 82.9739),
                'current_lat'        => (float)($this->input->post('current_latitude') ?: 25.3176),
                'current_lng'        => (float)($this->input->post('current_longitude') ?: 82.9739),
                'is_verified'        => !empty($this->input->post('is_verified')) ? 1 : 0,
                'is_active'          => !empty($this->input->post('is_active')) ? 1 : 0,
                'updated_at'         => date('Y-m-d H:i:s')
            ];

            if ($id > 0) {
                $this->db->where('id', $id)->update('delivery_riders', $riderData);
                $this->session->set_flashdata('success', 'Delivery rider record updated successfully.');
                $this->session->set_flashdata('success_msg', 'Delivery rider record updated successfully.');
            } else {
                $riderData['created_at'] = date('Y-m-d H:i:s');
                $this->db->insert('delivery_riders', $riderData);
                $this->session->set_flashdata('success', 'New delivery rider onboarded to active fleet.');
                $this->session->set_flashdata('success_msg', 'New delivery rider onboarded to active fleet.');
            }

            redirect(base_url('masters/pharmacy_fleet?tab=fleet'));
            return;
        }

        // GET Request: Render Full-Page Dedicated Form View
        $data['rider'] = [];
        if ($id > 0 && $this->db->table_exists('delivery_riders')) {
            $data['rider'] = (array)$this->db->get_where('delivery_riders', ['id' => $id])->row_array();
        }

        $data['heading_title'] = $id > 0 ? 'Edit Delivery Rider' : 'Onboard New Delivery Rider';
        $data['module']        = 'Masters';

        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('masters/onboard_rider_view', $data);
        $this->load->view('inc/sidebar');
        $this->load->view('inc/headersetting');
        $this->load->view('inc/footerlink');
        $this->load->view('inc/table_footer');
    }

    /**
     * Alias for Edit Rider
     */
    public function edit_rider($id = 0) {
        $this->onboard_rider($id);
    }

    /**
     * Alias for backwards compatibility
     */
    public function save_rider() {
        $this->onboard_rider();
    }

    /**
     * Dedicated Action: Full-Page Process and Record Financial Settlement
     * On GET: Renders dedicated full-page voucher form (masters/record_settlement_view)
     * On POST: Records settlement entry and redirects to ?tab=settlements
     */
    public function record_settlement() {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $pharmacyId = (int)$this->input->post('pharmacy_id');
            $gross = (float)$this->input->post('gross_sales');
            $rate = (float)($this->input->post('commission_rate') ?: 8.0);
            $comm = round($gross * ($rate / 100), 2);
            $net = $gross - $comm;
            $utr = trim($this->input->post('utr_number'));
            $settleStatus = $this->input->post('settlement_status') ?: 'PROCESSED';

            $this->db->insert('pharmacy_settlements', [
                'pharmacy_id'             => $pharmacyId,
                'settlement_period_start' => $this->input->post('period_start'),
                'settlement_period_end'   => $this->input->post('period_end'),
                'gross_sales'             => $gross,
                'upchar_commission'       => $comm,
                'net_payout'              => $net,
                'utr_number'              => $utr ?: 'UTR' . date('YmdHis'),
                'settlement_status'       => $settleStatus,
                'processed_at'            => date('Y-m-d H:i:s')
            ]);

            $this->session->set_flashdata('success', 'Financial payout settlement processed and recorded successfully.');
            $this->session->set_flashdata('success_msg', 'Financial payout settlement processed and recorded successfully.');
            redirect(base_url('masters/pharmacy_fleet?tab=settlements'));
            return;
        }

        // GET Request: Render Full-Page Dedicated Form View
        $data['all_stores']        = $this->db->table_exists('pharmacy_stores') ? 
            (array)$this->db->select('id, store_name, commission_rate')->order_by('store_name', 'ASC')->get('pharmacy_stores')->result_array() : [];
        $data['selected_store_id'] = (int)$this->input->get('store_id');
        $data['heading_title']     = 'Process Pharmacy Settlement';
        $data['module']            = 'Masters';

        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('masters/record_settlement_view', $data);
        $this->load->view('inc/sidebar');
        $this->load->view('inc/headersetting');
        $this->load->view('inc/footerlink');
        $this->load->view('inc/table_footer');
    }

    /**
     * Alias for backwards compatibility
     */
    public function save_settlement() {
        $this->record_settlement();
    }

    /**
     * Dedicated Action: Full-Page Manual Order Dispatch & Rider Reassignment
     * On GET: Renders dedicated full-page console (masters/dispatch_order_view)
     * On POST: Assigns rider to order and redirects to ?tab=dispatch
     */
    public function reassign_order($order_id = 0) {
        $order_id = (int)($order_id ?: $this->input->post('order_id') ?: $this->input->get('order_id') ?: 0);

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $newRiderId = (int)$this->input->post('new_rider_id');
            $reason = trim($this->input->post('reason') ?: 'Manual Dispatch Reassignment');

            if ($order_id && $newRiderId && $this->db->table_exists('medicine_orders') && $this->db->table_exists('delivery_riders')) {
                $order = $this->db->get_where('medicine_orders', ['id' => $order_id])->row();
                $rider = $this->db->get_where('delivery_riders', ['id' => $newRiderId])->row();

                if ($order && $rider) {
                    $prevRiderId = $order->rider_id;
                    if ($prevRiderId) {
                        $this->db->where('id', $prevRiderId)->update('delivery_riders', ['status' => 'AVAILABLE']);
                    }

                    $this->db->where('id', $order_id)->update('medicine_orders', [
                        'rider_id'          => $newRiderId,
                        'order_status'      => 'ASSIGNED',
                        'rider_assigned_at' => date('Y-m-d H:i:s'),
                        'updated_at'        => date('Y-m-d H:i:s')
                    ]);

                    $this->db->where('id', $newRiderId)->update('delivery_riders', ['status' => 'BUSY']);

                    if ($this->db->table_exists('order_delivery_assignments')) {
                        $this->db->insert('order_delivery_assignments', [
                            'order_id'            => $order_id,
                            'rider_id'            => $newRiderId,
                            'assigned_at'         => date('Y-m-d H:i:s'),
                            'delivery_status'     => 'REASSIGNED',
                            'rider_payout_amount' => 35.00
                        ]);
                    }

                    $riderDisplayName = $rider->name ?: $rider->rider_name ?: 'Rider #' . $rider->id;
                    $this->session->set_flashdata('success', "Order #{$order->order_code} successfully dispatched/reassigned to {$riderDisplayName}.");
                    $this->session->set_flashdata('success_msg', "Order #{$order->order_code} successfully dispatched/reassigned to {$riderDisplayName}.");
                }
            }

            redirect(base_url('masters/pharmacy_fleet?tab=dispatch'));
            return;
        }

        // GET Request: Render Full-Page Dedicated Form View
        $data['selected_order'] = [];
        if ($order_id > 0 && $this->db->table_exists('medicine_orders')) {
            $q = $this->db->select('mo.*' . ($this->db->table_exists('pharmacy_stores') ? ', ps.store_name' : ''))
                ->from('medicine_orders mo');
            if ($this->db->table_exists('pharmacy_stores')) {
                $q->join('pharmacy_stores ps', 'ps.id = mo.pharmacy_id', 'left');
            }
            $data['selected_order'] = (array)$q->where('mo.id', $order_id)->get()->row_array();
        }

        $data['all_riders']    = $this->db->table_exists('delivery_riders') ? 
            (array)$this->db->select('id, name, rider_name, vehicle_number, status')->where('is_active', 1)->get('delivery_riders')->result_array() : [];
        $data['active_orders'] = $this->db->table_exists('medicine_orders') ? 
            (array)$this->db->select('mo.id, mo.order_code, mo.customer_name, mo.order_status, mo.total_amount')
                ->where_in('order_status', ['PACKED', 'ASSIGNED', 'IN_TRANSIT', 'PLACED', 'CONFIRMED'])
                ->order_by('id', 'DESC')->limit(50)->get('medicine_orders mo')->result_array() : [];
        $data['heading_title'] = 'Manual Order Dispatch & Reassignment';
        $data['module']        = 'Masters';

        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('masters/dispatch_order_view', $data);
        $this->load->view('inc/sidebar');
        $this->load->view('inc/headersetting');
        $this->load->view('inc/footerlink');
        $this->load->view('inc/table_footer');
    }

    /**
     * Alias for Dispatch Order
     */
    public function dispatch_order($order_id = 0) {
        $this->reassign_order($order_id);
    }

    /**
     * Toggle Store Emergency Closure
     */
    public function toggle_emergency_closure($store_id) {
        if ($this->db->table_exists('pharmacy_stores')) {
            $store = $this->db->get_where('pharmacy_stores', ['id' => (int)$store_id])->row();
            if ($store) {
                $newStatus = !empty($store->is_emergency_closed) ? 0 : 1;
                $this->db->where('id', $store->id)->update('pharmacy_stores', [
                    'is_emergency_closed' => $newStatus,
                    'updated_at'          => date('Y-m-d H:i:s')
                ]);
                $msg = $newStatus ? 'Store marked EMERGENCY CLOSED (Orders temporarily halted).' : 'Store restored to ACTIVE live status.';
                $this->session->set_flashdata('success', $msg);
                $this->session->set_flashdata('success_msg', $msg);
            }
        }
        redirect(base_url('masters/pharmacy_fleet?tab=pharmacy'));
    }

    /**
     * Mark Paid & Enter UTR (AJAX Endpoint)
     * POST /admin1947/masters/pharmacy_fleet/mark_paid_ajax
     */
    public function mark_paid_ajax() {
        $settlementId = (int)$this->input->post('settlement_id');
        $utrNumber = strtoupper(trim($this->input->post('utr_number')));
        $notes = trim($this->input->post('settlement_notes') ?: 'Settlement batch cleared via Corporate NEFT/RTGS');

        if (!$settlementId || empty($utrNumber)) {
            return $this->_json_response(['status' => 'error', 'message' => 'Valid Settlement ID and Bank UTR Reference required.'], 400);
        }

        $this->db->trans_start();
        $this->db->where('id', $settlementId)->update('pharmacy_settlements', [
            'utr_number'        => $utrNumber,
            'settlement_status' => 'PAID',
            'settlement_notes'  => $notes,
            'processed_at'      => date('Y-m-d H:i:s')
        ]);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return $this->_json_response(['status' => 'error', 'message' => 'Database error recording settlement transaction.'], 500);
        }

        return $this->_json_response([
            'status'     => 'success',
            'message'    => "Settlement #{$settlementId} successfully marked PAID with UTR: {$utrNumber}.",
            'utr_number' => $utrNumber
        ]);
    }

    /**
     * Export Bank NEFT/RTGS Batch CSV (Corporate Banking Format for HDFC/ICICI/SBI)
     * GET /admin1947/masters/pharmacy_fleet/export_settlement_csv
     */
    public function export_settlement_csv() {
        $this->db->select('s.*, ps.store_name, ps.phone as store_phone');
        $this->db->from('pharmacy_settlements s');
        if ($this->db->table_exists('pharmacy_stores')) {
            $this->db->join('pharmacy_stores ps', 'ps.id = s.pharmacy_id', 'left');
        }
        $this->db->order_by('s.id', 'DESC');
        $settlements = (array)$this->db->get()->result_array();

        $filename = 'UPCHAR_Bank_Batch_NEFT_' . date('Ymd_His') . '.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $out = fopen('php://output', 'w');
        // Corporate banking bulk payout format
        fputcsv($out, [
            'Transaction Reference',
            'Beneficiary Store Name',
            'Beneficiary Account Number',
            'IFSC Code',
            'Bank Name',
            'Payout Amount (INR)',
            'Payment Mode',
            'Settlement Cycle',
            'Status',
            'Remarks'
        ]);

        foreach ($settlements as $s) {
            $storeName = $s['store_name'] ?? 'Chemist Store #' . $s['pharmacy_id'];
            $accNo = $s['bank_account_no'] ?? '50200048123940';
            $ifsc = $s['bank_ifsc'] ?? 'HDFC0001254';
            $bank = $s['bank_name'] ?? 'HDFC Bank';
            $net = (float)($s['net_payout'] ?? 0);
            $cycle = ($s['settlement_period_start'] ?? '') . ' to ' . ($s['settlement_period_end'] ?? '');

            fputcsv($out, [
                $s['utr_number'] ?: ('BATCH-' . $s['id'] . '-' . date('Ymd')),
                $storeName,
                "'" . $accNo,
                $ifsc,
                $bank,
                number_format($net, 2, '.', ''),
                'NEFT',
                $cycle,
                $s['settlement_status'] ?? 'DUE',
                $s['settlement_notes'] ?? 'UPCHAR Weekly Chemist Payout'
            ]);
        }
        fclose($out);
        exit;
    }

    /**
     * View Order Breakdown Drawer (AJAX Endpoint)
     * GET /admin1947/masters/pharmacy_fleet/order_breakdown_ajax/{settlement_id}
     */
    public function order_breakdown_ajax($settlementId = 0) {
        $settlementId = (int)$settlementId;
        $settlement = $this->db->get_where('pharmacy_settlements', ['id' => $settlementId])->row_array();
        if (!$settlement) {
            return $this->_json_response(['status' => 'error', 'message' => 'Settlement record not found.'], 404);
        }

        $store = $this->db->get_where('pharmacy_stores', ['id' => $settlement['pharmacy_id']])->row_array();
        $settlement['store_name'] = $store['store_name'] ?? 'Partner Chemist';

        $orders = $this->db->select('id, order_code, customer_name, total_amount, payment_mode, payment_status, order_status, created_at')
            ->from('medicine_orders')
            ->where('pharmacy_id', $settlement['pharmacy_id'])
            ->order_by('id', 'DESC')
            ->limit(15)
            ->get()->result_array();

        return $this->_json_response([
            'status'     => 'success',
            'settlement' => $settlement,
            'orders'     => $orders
        ]);
    }
}
