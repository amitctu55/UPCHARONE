<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->ensure_schema();
    }

    /**
     * Auto-ensure helper tables / columns exist if needed
     */
    private function ensure_schema() {
        try {
            if ($this->db && $this->db->table_exists('patient_dependents') === FALSE) {
                $this->db->query("CREATE TABLE IF NOT EXISTS `patient_dependents` (
                  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                  `primary_user_id` int(11) unsigned NOT NULL,
                  `name` varchar(100) NOT NULL,
                  `relationship` varchar(50) NOT NULL DEFAULT 'FAMILY',
                  `gender` varchar(10) DEFAULT NULL,
                  `dob` date DEFAULT NULL,
                  `blood_group` varchar(10) DEFAULT NULL,
                  `medical_history` text DEFAULT NULL,
                  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
                  PRIMARY KEY (`id`),
                  KEY `idx_dep_user` (`primary_user_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
            }
        } catch (Throwable $e) {}
    }

    /**
     * Get paginated patient directory with total bookings & wallet balance
     */
    public function get_patients($limit = 10, $offset = 0, $filters = array()) {
        $this->db->select("
            SQL_CALC_FOUND_ROWS u.USERID, u.FNAME, u.LNAME, u.EMAIL, u.MOBILE, 
            u.GENDER, u.DOB, u.BGROUP, u.HEIGHT, u.WEIGHT, u.STATUS, u.REG_DATE,
            CONCAT('UPC-PAT-', LPAD(u.USERID, 5, '0')) as medical_id,
            COALESCE(w.points_balance, 0) as wallet_points,
            (SELECT COUNT(*) FROM appointment a WHERE a.user_id = u.USERID) as total_appointments
        ", FALSE);
        $this->db->from('userlogin u');
        $this->db->join('user_wallet w', 'w.user_id = u.USERID', 'left');

        // Keyword search (Name, Email, ID)
        if (!empty($filters['keyword'])) {
            $kw = trim($filters['keyword']);
            $this->db->group_start();
            $this->db->like('u.FNAME', $kw);
            $this->db->or_like('u.LNAME', $kw);
            $this->db->or_like('u.EMAIL', $kw);
            if (is_numeric($kw)) {
                $this->db->or_where('u.USERID', (int)$kw);
            }
            $this->db->group_end();
        }

        // Mobile Filter
        if (!empty($filters['mobile'])) {
            $this->db->like('u.MOBILE', trim($filters['mobile']));
        }

        // Status Filter
        if (isset($filters['status']) && $filters['status'] !== '') {
            $this->db->where('u.STATUS', $filters['status']);
        }

        // Blood Group Filter
        if (!empty($filters['blood_group'])) {
            $this->db->where('u.BGROUP', $filters['blood_group']);
        }

        $this->db->order_by('u.USERID', 'DESC');
        $this->db->limit($limit, $offset);

        $query = $this->db->get();
        return ($query && is_object($query)) ? $query->result_array() : array();
    }

    /**
     * Get complete patient profile & dependents
     */
    public function get_patient_profile($patient_id) {
        $patient_id = (int)$patient_id;
        $this->db->select("
            u.*, 
            CONCAT('UPC-PAT-', LPAD(u.USERID, 5, '0')) as medical_id,
            COALESCE(w.points_balance, 0) as wallet_points,
            COALESCE(w.lifetime_earned, 0) as lifetime_earned,
            COALESCE(w.lifetime_spent, 0) as lifetime_spent
        ");
        $this->db->from('userlogin u');
        $this->db->join('user_wallet w', 'w.user_id = u.USERID', 'left');
        $this->db->where('u.USERID', $patient_id);
        $res = $this->db->get();
        $patient = ($res && is_object($res)) ? $res->row_array() : null;

        if ($patient) {
            if ($this->db->table_exists('patient_dependents')) {
                $dep_q = $this->db->get_where('patient_dependents', array('primary_user_id' => $patient_id));
                $patient['dependents'] = ($dep_q && is_object($dep_q)) ? $dep_q->result_array() : array();
            } else {
                $patient['dependents'] = array();
            }
        }

        return $patient;
    }

    /**
     * Get patient appointment history
     */
    public function get_patient_appointments($patient_id) {
        $patient_id = (int)$patient_id;
        if (!$this->db->table_exists('appointment')) {
            return array();
        }

        $this->db->select("
            a.appointment_id, a.appointment_date, a.appointment_time, a.from_timing, a.to_timing,
            a.fee, a.amount, a.payment_status, a.status as booking_status, a.ref_no, a.book_date,
            p.fname as dr_fname, p.lname as dr_lname, p.mobile as dr_mobile,
            COALESCE(ms.name, 'General Practitioner') as dr_speciality,
            COALESCE(h.name, c.name, 'Healthcare Facility') as facility_name,
            COALESCE(h.city, c.city, p.city) as facility_city
        ");
        $this->db->from('appointment a');
        $this->db->join('profile_dr p', '(p.id = a.doctor_id OR p.user_id = a.doctor_id)', 'left');
        $this->db->join('master_specialization ms', 'ms.id = p.specialization', 'left');
        $this->db->join('hospital h', '(h.uid = a.institute_id OR h.id = a.institute_id)', 'left');
        $this->db->join('clinic c', 'c.id = a.institute_id', 'left');
        $this->db->where('a.user_id', $patient_id);
        $this->db->order_by('a.appointment_date', 'DESC');
        $this->db->order_by('a.from_timing', 'DESC');

        $query = $this->db->get();
        return ($query && is_object($query)) ? $query->result_array() : array();
    }

    /**
     * Get medical records & prescriptions
     */
    public function get_patient_medical_history($patient_id) {
        $patient_id = (int)$patient_id;
        if (!$this->db->table_exists('prescriptions')) {
            return array();
        }

        $this->db->select("
            pr.*, p.fname as dr_fname, p.lname as dr_lname,
            COALESCE(ms.name, 'Physician') as dr_speciality,
            COALESCE(h.name, 'Upchar Healthcare Facility') as hospital_name
        ");
        $this->db->from('prescriptions pr');
        $this->db->join('profile_dr p', 'p.id = pr.doctor_id', 'left');
        $this->db->join('master_specialization ms', 'ms.id = p.specialization', 'left');
        $this->db->join('hospital h', 'h.id = pr.hospital_id', 'left');
        $this->db->where('pr.patient_id', $patient_id);
        $this->db->order_by('pr.created_at', 'DESC');

        $query = $this->db->get();
        return ($query && is_object($query)) ? $query->result_array() : array();
    }

    /**
     * Get billing & financial transaction logs
     */
    public function get_patient_payments($patient_id) {
        $patient_id = (int)$patient_id;
        $payments = array();

        if ($this->db->table_exists('financial_transactions')) {
            $txns = $this->db->select("
                txn_id, txn_code, category, gross_amount, payment_status,
                facility_name, created_at, encounter_id
            ")
            ->from('financial_transactions')
            ->where('patient_id', $patient_id)
            ->order_by('created_at', 'DESC')
            ->get();

            if ($txns && is_object($txns) && $txns->num_rows() > 0) {
                return $txns->result_array();
            }
        }

        // Fallback to appointment billing log
        if ($this->db->table_exists('appointment')) {
            $appt_bill = $this->db->select("
                appointment_id as txn_id, 
                COALESCE(ref_no, CONCAT('TXN-APT-', appointment_id)) as txn_code, 
                'Doctor Consultation Booking' as category,
                COALESCE(amount, fee, 0) as gross_amount, 
                COALESCE(payment_status, 'PAID') as payment_status, 
                payment_mode, 
                COALESCE(book_date, pay_date, NOW()) as created_at
            ")
            ->from('appointment')
            ->where('user_id', $patient_id)
            ->order_by('appointment_id', 'DESC')
            ->get();

            if ($appt_bill && is_object($appt_bill)) {
                return $appt_bill->result_array();
            }
        }

        return $payments;
    }

    /**
     * Get reward points balance and audit trail
     */
    public function get_patient_rewards($patient_id) {
        $patient_id = (int)$patient_id;
        $wallet = array('points_balance' => 0, 'lifetime_earned' => 0, 'lifetime_spent' => 0);
        $transactions = array();

        if ($this->db->table_exists('user_wallet')) {
            $w = $this->db->get_where('user_wallet', array('user_id' => $patient_id))->row_array();
            if (!empty($w)) {
                $wallet = $w;
            }
        }

        if ($this->db->table_exists('wallet_transactions')) {
            $tx = $this->db->order_by('transaction_id', 'DESC')
                ->get_where('wallet_transactions', array('user_id' => $patient_id))
                ->result_array();
            if (!empty($tx)) {
                $transactions = $tx;
            }
        }

        return array(
            'wallet' => $wallet,
            'transactions' => $transactions
        );
    }

    /**
     * Toggle Patient Status (Active / Blocked)
     */
    public function toggle_status($patient_id) {
        $patient_id = (int)$patient_id;
        $u = $this->db->get_where('userlogin', array('USERID' => $patient_id))->row();
        if ($u) {
            $new_status = ($u->STATUS == '1') ? '2' : '1';
            $this->db->where('USERID', $patient_id)->update('userlogin', array('STATUS' => $new_status));
            return $new_status;
        }
        return false;
    }

    /**
     * Reset Patient Password
     */
    public function reset_password($patient_id, $new_password) {
        $patient_id = (int)$patient_id;
        $pwd = md5($new_password);
        return $this->db->where('USERID', $patient_id)->update('userlogin', array('PASSWORD' => $pwd));
    }
}
