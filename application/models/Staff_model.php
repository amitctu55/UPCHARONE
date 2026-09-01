<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Staff Model
 * Upchar Enterprise RBAC, Authentication & Schema Provisioner
 */
class Staff_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->_ensure_tables();
    }

    /**
     * Auto-create required tables for Enterprise Suite
     */
    private function _ensure_tables() {
        // 1. staff_users Table
        $this->db->query("CREATE TABLE IF NOT EXISTS `staff_users` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `staff_code` VARCHAR(30) UNIQUE NOT NULL,
            `name` VARCHAR(120) NOT NULL,
            `email` VARCHAR(120) UNIQUE NOT NULL,
            `phone` VARCHAR(20) UNIQUE NOT NULL,
            `password_hash` VARCHAR(255) NOT NULL,
            `role` ENUM('super_admin', 'hr', 'bde', 'collector', 'office_staff') NOT NULL DEFAULT 'office_staff',
            `department` VARCHAR(80) DEFAULT 'Operations',
            `designation` VARCHAR(80) DEFAULT 'Staff',
            `base_salary` DECIMAL(10,2) DEFAULT 25000.00,
            `assigned_area` VARCHAR(100) DEFAULT 'Lucknow Central',
            `status` ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // 2. staff_attendance Table
        $this->db->query("CREATE TABLE IF NOT EXISTS `staff_attendance` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `user_id` INT NOT NULL,
            `punch_date` DATE NOT NULL,
            `check_in_time` DATETIME NOT NULL,
            `check_out_time` DATETIME NULL,
            `check_in_lat` DECIMAL(10,8) NOT NULL,
            `check_in_lng` DECIMAL(11,8) NOT NULL,
            `check_out_lat` DECIMAL(10,8) NULL,
            `check_out_lng` DECIMAL(11,8) NULL,
            `check_in_selfie` TEXT NULL,
            `distance_from_office_km` DECIMAL(6,2) DEFAULT 0.00,
            `status` ENUM('present', 'late', 'half_day', 'absent', 'on_leave') DEFAULT 'present',
            `working_hours` DECIMAL(4,2) DEFAULT 0.00,
            `notes` VARCHAR(255) NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            KEY `idx_user_date` (`user_id`, `punch_date`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // 3. staff_leave_requests Table
        $this->db->query("CREATE TABLE IF NOT EXISTS `staff_leave_requests` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `user_id` INT NOT NULL,
            `leave_type` ENUM('sick', 'casual', 'earned', 'emergency') DEFAULT 'casual',
            `start_date` DATE NOT NULL,
            `end_date` DATE NOT NULL,
            `days_count` INT DEFAULT 1,
            `reason` TEXT NOT NULL,
            `status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
            `reviewed_by` INT NULL,
            `reviewer_notes` TEXT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            KEY `idx_user_status` (`user_id`, `status`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // 4. staff_crm_leads Table
        $this->db->query("CREATE TABLE IF NOT EXISTS `staff_crm_leads` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `bde_id` INT NOT NULL,
            `facility_name` VARCHAR(150) NOT NULL,
            `facility_type` ENUM('hospital', 'clinic', 'diagnostic_lab', 'pharmacy') DEFAULT 'clinic',
            `contact_person` VARCHAR(100) NOT NULL,
            `phone` VARCHAR(20) NOT NULL,
            `email` VARCHAR(100) NULL,
            `address` TEXT NULL,
            `city` VARCHAR(80) DEFAULT 'Lucknow',
            `lead_stage` ENUM('new', 'contacted', 'meeting_scheduled', 'proposal_sent', 'signed', 'lost') DEFAULT 'new',
            `est_monthly_revenue` DECIMAL(10,2) DEFAULT 0.00,
            `commission_pct` DECIMAL(5,2) DEFAULT 10.00,
            `next_followup_date` DATE NULL,
            `notes` TEXT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            KEY `idx_bde_stage` (`bde_id`, `lead_stage`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // 5. staff_expense_claims Table
        $this->db->query("CREATE TABLE IF NOT EXISTS `staff_expense_claims` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `user_id` INT NOT NULL,
            `category` ENUM('fuel', 'transport', 'petty_cash', 'client_entertainment', 'supplies') DEFAULT 'fuel',
            `amount` DECIMAL(10,2) NOT NULL,
            `expense_date` DATE NOT NULL,
            `receipt_proof` VARCHAR(255) NULL,
            `description` TEXT NOT NULL,
            `status` ENUM('submitted', 'approved', 'rejected', 'reimbursed') DEFAULT 'submitted',
            `approved_by` INT NULL,
            `reimbursement_date` DATE NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            KEY `idx_user_expense` (`user_id`, `status`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // 6. staff_sample_handoffs Table
        $this->db->query("CREATE TABLE IF NOT EXISTS `staff_sample_handoffs` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `booking_id` INT NOT NULL,
            `collector_id` INT NOT NULL,
            `lab_id` INT DEFAULT 29,
            `received_by_staff_id` INT NULL,
            `barcode` VARCHAR(100) NOT NULL,
            `sample_condition` ENUM('good', 'compromised', 'temperature_alert') DEFAULT 'good',
            `handoff_time` DATETIME NOT NULL,
            `status` ENUM('in_transit', 'verified_received', 'rejected') DEFAULT 'verified_received',
            `notes` TEXT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            KEY `idx_barcode` (`barcode`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // 7. Ensure extra columns exist in path_book for phlebotomist field tracking
        $fields = $this->db->list_fields('path_book');
        if (!in_array('assigned_collector_id', $fields)) {
            $this->db->query("ALTER TABLE `path_book` ADD COLUMN `assigned_collector_id` INT NULL DEFAULT NULL;");
        }
        if (!in_array('vial_barcode', $fields)) {
            $this->db->query("ALTER TABLE `path_book` ADD COLUMN `vial_barcode` VARCHAR(100) NULL DEFAULT NULL;");
        }
        if (!in_array('collection_status', $fields)) {
            $this->db->query("ALTER TABLE `path_book` ADD COLUMN `collection_status` ENUM('assigned', 'en_route', 'arrived', 'sample_collected', 'handed_to_lab', 'report_ready') DEFAULT 'assigned';");
        }
        if (!in_array('collection_lat', $fields)) {
            $this->db->query("ALTER TABLE `path_book` ADD COLUMN `collection_lat` DECIMAL(10,8) NULL DEFAULT NULL;");
        }
        if (!in_array('collection_lng', $fields)) {
            $this->db->query("ALTER TABLE `path_book` ADD COLUMN `collection_lng` DECIMAL(11,8) NULL DEFAULT NULL;");
        }
        if (!in_array('collected_at', $fields)) {
            $this->db->query("ALTER TABLE `path_book` ADD COLUMN `collected_at` DATETIME NULL DEFAULT NULL;");
        }
        if (!in_array('payment_collected_mode', $fields)) {
            $this->db->query("ALTER TABLE `path_book` ADD COLUMN `payment_collected_mode` VARCHAR(30) DEFAULT 'PENDING';");
        }
        if (!in_array('payment_collected_amount', $fields)) {
            $this->db->query("ALTER TABLE `path_book` ADD COLUMN `payment_collected_amount` DECIMAL(10,2) DEFAULT 0.00;");
        }

        // Ensure optional datetime and cancellation fields in path_book allow NULL
        $this->db->query("ALTER TABLE `path_book` MODIFY `pay_date` DATETIME NULL DEFAULT NULL;");
        $this->db->query("ALTER TABLE `path_book` MODIFY `cancel_date` DATETIME NULL DEFAULT NULL;");
        $this->db->query("ALTER TABLE `path_book` MODIFY `cancel_reason` INT(11) NULL DEFAULT NULL;");
        $this->db->query("ALTER TABLE `path_book` MODIFY `cancel_by` VARCHAR(20) NULL DEFAULT NULL;");
        $this->db->query("ALTER TABLE `path_book` MODIFY `txn_id` VARCHAR(100) NULL DEFAULT NULL;");

        // 8. Seed default test accounts for each role if empty
        $count = $this->db->count_all('staff_users');
        if ($count == 0) {
            $default_pass = md5('admin@123');
            $seeds = [
                [
                    'staff_code'    => 'UPC-ADM-001',
                    'name'          => 'Super Admin',
                    'email'         => 'admin@upcharr.com',
                    'phone'         => '9999990001',
                    'password_hash' => $default_pass,
                    'role'          => 'super_admin',
                    'department'    => 'Management',
                    'designation'   => 'Platform Administrator',
                    'base_salary'   => 80000.00,
                    'assigned_area' => 'HQ - Lucknow'
                ],
                [
                    'staff_code'    => 'UPC-HR-001',
                    'name'          => 'Pooja Sharma (HR Lead)',
                    'email'         => 'hr@upcharr.com',
                    'phone'         => '9999990002',
                    'password_hash' => $default_pass,
                    'role'          => 'hr',
                    'department'    => 'Human Resources',
                    'designation'   => 'HR Manager',
                    'base_salary'   => 45000.00,
                    'assigned_area' => 'HQ - Lucknow'
                ],
                [
                    'staff_code'    => 'UPC-BDE-001',
                    'name'          => 'Rahul Verma (BDE)',
                    'email'         => 'bde@upcharr.com',
                    'phone'         => '9999990003',
                    'password_hash' => $default_pass,
                    'role'          => 'bde',
                    'department'    => 'Business Development',
                    'designation'   => 'Sr. BDE Lead',
                    'base_salary'   => 35000.00,
                    'assigned_area' => 'Lucknow City Zone'
                ],
                [
                    'staff_code'    => 'UPC-COL-001',
                    'name'          => 'Amit Kumar (Phlebotomist)',
                    'email'         => 'collector@upcharr.com',
                    'phone'         => '9999990004',
                    'password_hash' => $default_pass,
                    'role'          => 'collector',
                    'department'    => 'Diagnostic Field Logistics',
                    'designation'   => 'Field Sample Collector',
                    'base_salary'   => 22000.00,
                    'assigned_area' => 'Gomti Nagar & Aliganj'
                ],
                [
                    'staff_code'    => 'UPC-OPS-001',
                    'name'          => 'Suresh Patel (Ops)',
                    'email'         => 'ops@upcharr.com',
                    'phone'         => '9999990005',
                    'password_hash' => $default_pass,
                    'role'          => 'office_staff',
                    'department'    => 'Central Operations',
                    'designation'   => 'Operations & Sample Desk Officer',
                    'base_salary'   => 28000.00,
                    'assigned_area' => 'Central Hub'
                ]
            ];
            $this->db->insert_batch('staff_users', $seeds);
        }
    }

    /**
     * Authenticate staff user
     */
    public function login($identity, $password) {
        $identity = trim($identity);
        $passHash = md5($password);

        $this->db->where('status', 'active');
        $this->db->group_start();
        $this->db->where('email', $identity);
        $this->db->or_where('phone', $identity);
        $this->db->or_where('staff_code', $identity);
        $this->db->group_end();
        $user = $this->db->get('staff_users')->row_array();

        if ($user && ($user['password_hash'] === $passHash || $user['password_hash'] === $password)) {
            return $user;
        }
        return false;
    }

    public function get_user_by_id($id) {
        return $this->db->get_where('staff_users', ['id' => $id])->row_array();
    }

    public function get_all_staff($filters = [], $limit = 50, $offset = 0) {
        if (!empty($filters['role'])) {
            $this->db->where('role', $filters['role']);
        }
        if (!empty($filters['status'])) {
            $this->db->where('status', $filters['status']);
        }
        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $this->db->group_start();
            $this->db->like('name', $s);
            $this->db->or_like('phone', $s);
            $this->db->or_like('email', $s);
            $this->db->or_like('staff_code', $s);
            $this->db->group_end();
        }
        $this->db->order_by('id', 'DESC');
        return $this->db->get('staff_users', $limit, $offset)->result_array();
    }

    public function create_staff($data) {
        if (isset($data['password'])) {
            $data['password_hash'] = md5($data['password']);
            unset($data['password']);
        }
        if (empty($data['staff_code'])) {
            $prefix = strtoupper(substr($data['role'] ?: 'STF', 0, 3));
            $data['staff_code'] = 'UPC-' . $prefix . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
        }
        $this->db->insert('staff_users', $data);
        return $this->db->insert_id();
    }

    public function update_staff($id, $data) {
        if (!empty($data['password'])) {
            $data['password_hash'] = md5($data['password']);
            unset($data['password']);
        }
        return $this->db->where('id', $id)->update('staff_users', $data);
    }
}
