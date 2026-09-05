<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Financial_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->ensure_financial_schema();
    }

    private function ensure_financial_schema() {
        try {
            $this->db->query("CREATE TABLE IF NOT EXISTS `platform_settings` (
              `setting_id` int(11) NOT NULL AUTO_INCREMENT,
              `default_platform_fee_percent` decimal(5,2) NOT NULL DEFAULT 10.00,
              `gst_percent` decimal(5,2) NOT NULL DEFAULT 18.00,
              `upchar_gstin` varchar(30) DEFAULT '07AAAAU1234A1Z5',
              `upchar_company_name` varchar(150) DEFAULT 'Upchar Health Technologies Pvt Ltd',
              `upchar_address` text DEFAULT NULL,
              `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`setting_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

            $this->db->query("CREATE TABLE IF NOT EXISTS `facility_custom_commissions` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `facility_type` enum('doctor','hospital','clinic','pathlab') NOT NULL,
              `facility_id` int(11) NOT NULL,
              `platform_fee_percent` decimal(5,2) NOT NULL DEFAULT 10.00,
              `updated_by_admin_id` int(11) DEFAULT 1,
              `notes` text DEFAULT NULL,
              `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `idx_fac` (`facility_type`,`facility_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

            $this->db->query("CREATE TABLE IF NOT EXISTS `financial_transactions` (
              `txn_id` int(11) NOT NULL AUTO_INCREMENT,
              `txn_code` varchar(50) DEFAULT NULL,
              `facility_type` enum('doctor','hospital','clinic','pathlab') NOT NULL,
              `facility_id` int(11) NOT NULL,
              `facility_name` varchar(150) DEFAULT NULL,
              `encounter_id` int(11) DEFAULT NULL,
              `category` varchar(100) DEFAULT 'OPD Consultation',
              `patient_id` int(11) DEFAULT NULL,
              `patient_name` varchar(100) DEFAULT NULL,
              `patient_mobile` varchar(20) DEFAULT NULL,
              `patient_email` varchar(100) DEFAULT NULL,
              `gross_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
              `platform_fee_percent` decimal(5,2) NOT NULL DEFAULT 10.00,
              `is_custom_rate` tinyint(1) NOT NULL DEFAULT 0,
              `platform_fee_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
              `cgst_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
              `sgst_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
              `gst_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
              `total_platform_deduction` decimal(10,2) NOT NULL DEFAULT 0.00,
              `net_facility_share` decimal(10,2) NOT NULL DEFAULT 0.00,
              `payment_status` enum('paid','unpaid','refunded') NOT NULL DEFAULT 'paid',
              `payout_status` enum('pending','queued','processed','settled','on_hold') NOT NULL DEFAULT 'pending',
              `settlement_date` datetime DEFAULT NULL,
              `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
              `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`txn_id`),
              KEY `idx_facility` (`facility_type`,`facility_id`),
              KEY `idx_payout_status` (`payout_status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

            $this->db->query("CREATE TABLE IF NOT EXISTS `gst_invoices` (
              `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
              `invoice_number` varchar(100) NOT NULL,
              `facility_type` enum('doctor','hospital','clinic','pathlab') NOT NULL,
              `facility_id` int(11) NOT NULL,
              `facility_name` varchar(150) DEFAULT NULL,
              `facility_gstin` varchar(30) DEFAULT NULL,
              `billing_month` varchar(10) NOT NULL,
              `total_taxable_value` decimal(10,2) NOT NULL DEFAULT 0.00,
              `cgst_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
              `sgst_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
              `igst_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
              `total_invoice_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
              `generated_at` datetime DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`invoice_id`),
              KEY `idx_fac_inv` (`facility_type`,`facility_id`),
              KEY `idx_month` (`billing_month`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        } catch (Exception $e) {
            // Ignore schema creation errors
        }
    }

    /**
     * Fetch Global Platform Settings (Platform Fee %, GST %, GSTIN)
     */
    public function get_platform_settings() {
        $row = $this->db->get('platform_settings')->row();
        if (!$row) {
            return (object) array(
                'setting_id' => 1,
                'default_platform_fee_percent' => 10.00,
                'gst_percent' => 18.00,
                'upchar_gstin' => '07AAAAU1234A1Z5',
                'upchar_company_name' => 'Upchar Health Technologies Pvt Ltd',
                'upchar_address' => 'Plot No. 42, Health City, New Delhi - 110001',
                'updated_at' => date('Y-m-d H:i:s')
            );
        }
        return $row;
    }

    /**
     * Update Global Platform Settings
     */
    public function update_platform_settings($data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $exists = $this->db->get('platform_settings')->row();
        if ($exists) {
            $this->db->where('setting_id', $exists->setting_id);
            return $this->db->update('platform_settings', $data);
        } else {
            return $this->db->insert('platform_settings', $data);
        }
    }

    /**
     * Get Effective Platform Fee Commission Rate for a Facility
     */
    public function get_facility_commission_rate($facility_type, $facility_id) {
        $custom = $this->db->get_where('facility_custom_commissions', array(
            'facility_type' => strtolower($facility_type),
            'facility_id'   => intval($facility_id)
        ))->row();

        if ($custom && isset($custom->platform_fee_percent)) {
            return (object) array(
                'rate'      => floatval($custom->platform_fee_percent),
                'is_custom' => 1,
                'notes'     => $custom->notes
            );
        }

        $settings = $this->get_platform_settings();
        return (object) array(
            'rate'      => floatval($settings->default_platform_fee_percent),
            'is_custom' => 0,
            'notes'     => 'Default Global Rate'
        );
    }

    /**
     * Set Custom Commission Rate for Facility
     */
    public function set_facility_custom_commission($facility_type, $facility_id, $rate, $admin_id = 1, $notes = '') {
        $facility_type = strtolower($facility_type);
        $facility_id   = intval($facility_id);
        $rate          = floatval($rate);

        $existing = $this->db->get_where('facility_custom_commissions', array(
            'facility_type' => $facility_type,
            'facility_id'   => $facility_id
        ))->row();

        $data = array(
            'facility_type'        => $facility_type,
            'facility_id'          => $facility_id,
            'platform_fee_percent' => $rate,
            'updated_by_admin_id'  => intval($admin_id),
            'notes'                => $notes,
            'updated_at'           => date('Y-m-d H:i:s')
        );

        if ($existing) {
            $this->db->where('id', $existing->id);
            return $this->db->update('facility_custom_commissions', $data);
        } else {
            return $this->db->insert('facility_custom_commissions', $data);
        }
    }

    /**
     * Calculate Revenue Split (Gross, Fee %, Fee Amt, GST, CGST, SGST, Total Deductions, Net Facility Share)
     */
    public function calculate_revenue_split($gross_amount, $facility_type, $facility_id) {
        $gross        = floatval($gross_amount);
        $commInfo     = $this->get_facility_commission_rate($facility_type, $facility_id);
        $fee_percent  = $commInfo->rate;
        $is_custom    = $commInfo->is_custom;

        $settings     = $this->get_platform_settings();
        $gst_percent  = floatval($settings->gst_percent);

        // Platform fee on gross amount
        $fee_amount   = round($gross * ($fee_percent / 100), 2);
        
        // Dynamic GST strictly on Upchar Platform Fee (service brokerage charge)
        $half_rate    = ($gst_percent / 2) / 100;
        $cgst_amount  = round($fee_amount * $half_rate, 2);
        $sgst_amount  = round($fee_amount * $half_rate, 2);
        $gst_amount   = round($cgst_amount + $sgst_amount, 2);
        
        $deduction    = round($fee_amount + $gst_amount, 2);
        $net_share    = round($gross - $deduction, 2);

        return array(
            'gross_amount'             => $gross,
            'platform_fee_percent'     => $fee_percent,
            'is_custom_rate'           => $is_custom,
            'platform_fee_amount'      => $fee_amount,
            'gst_percent'              => $gst_percent,
            'cgst_amount'              => $cgst_amount,
            'sgst_amount'              => $sgst_amount,
            'gst_amount'               => $gst_amount,
            'total_platform_deduction' => $deduction,
            'net_facility_share'       => $net_share
        );
    }

    /**
     * Recalculate Valuations & Tax Splits across existing transactions
     */
    public function recalculate_financial_valuations($scope = 'all', $facility_type = null, $facility_id = null) {
        if ($scope === 'pending') {
            $this->db->where_in('payout_status', array('pending', 'queued'));
        }
        if (!empty($facility_type) && !empty($facility_id)) {
            $this->db->where('facility_type', strtolower($facility_type));
            $this->db->where('facility_id', intval($facility_id));
        }

        $transactions = $this->db->get('financial_transactions')->result();
        $updated_count = 0;

        foreach ($transactions as $txn) {
            $split = $this->calculate_revenue_split($txn->gross_amount, $txn->facility_type, $txn->facility_id);

            $this->db->where('txn_id', $txn->txn_id);
            $this->db->update('financial_transactions', array(
                'platform_fee_percent'     => $split['platform_fee_percent'],
                'is_custom_rate'           => $split['is_custom_rate'],
                'platform_fee_amount'      => $split['platform_fee_amount'],
                'cgst_amount'              => $split['cgst_amount'],
                'sgst_amount'              => $split['sgst_amount'],
                'gst_amount'               => $split['gst_amount'],
                'total_platform_deduction' => $split['total_platform_deduction'],
                'net_facility_share'       => $split['net_facility_share']
            ));
            $updated_count++;
        }

        return $updated_count;
    }

    /**
     * Record a new encounter into financial_transactions
     */
    public function record_financial_transaction($facility_type, $facility_id, $facility_name, $encounter_id, $category, $patient_id, $patient_name, $patient_mobile, $patient_email, $gross_amount, $payment_status = 'paid', $payout_status = 'pending') {
        $split = $this->calculate_revenue_split($gross_amount, $facility_type, $facility_id);
        $txnCode = '#TXN-' . date('Y') . '-' . rand(10000, 99999);

        $data = array(
            'txn_code'                 => $txnCode,
            'facility_type'            => strtolower($facility_type),
            'facility_id'              => intval($facility_id),
            'facility_name'            => $facility_name,
            'encounter_id'             => intval($encounter_id),
            'category'                 => $category,
            'patient_id'               => intval($patient_id),
            'patient_name'             => $patient_name,
            'patient_mobile'           => $patient_mobile,
            'patient_email'            => $patient_email,
            'gross_amount'             => $split['gross_amount'],
            'platform_fee_percent'     => $split['platform_fee_percent'],
            'is_custom_rate'           => $split['is_custom_rate'],
            'platform_fee_amount'      => $split['platform_fee_amount'],
            'cgst_amount'              => $split['cgst_amount'],
            'sgst_amount'              => $split['sgst_amount'],
            'gst_amount'               => $split['gst_amount'],
            'total_platform_deduction' => $split['total_platform_deduction'],
            'net_facility_share'       => $split['net_facility_share'],
            'payment_status'           => $payment_status,
            'payout_status'            => $payout_status,
            'settlement_date'          => ($payout_status === 'settled' || $payout_status === 'processed') ? date('Y-m-d H:i:s') : null,
            'created_at'               => date('Y-m-d H:i:s')
        );

        $this->db->insert('financial_transactions', $data);
        return $this->db->insert_id();
    }

    /**
     * Fetch Transactions for a Facility with dynamic filters
     */
    public function get_facility_transactions($facility_type, $facility_id, $filters = array()) {
        $this->db->where('facility_type', strtolower($facility_type));
        $this->db->where('facility_id', intval($facility_id));

        if (!empty($filters['date'])) {
            $this->db->where('DATE(created_at)', $filters['date']);
        }
        if (!empty($filters['month']) && !empty($filters['year'])) {
            $this->db->where('MONTH(created_at)', intval($filters['month']));
            $this->db->where('YEAR(created_at)', intval($filters['year']));
        } elseif (!empty($filters['year'])) {
            $this->db->where('YEAR(created_at)', intval($filters['year']));
        }
        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            if ($filters['status'] === 'processed' || $filters['status'] === 'settled') {
                $this->db->where_in('payout_status', array('settled', 'processed'));
            } else {
                $this->db->where('payout_status', $filters['status']);
            }
        }
        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $this->db->group_start();
            $this->db->like('txn_code', $s);
            $this->db->or_like('patient_name', $s);
            $this->db->or_like('patient_mobile', $s);
            $this->db->or_like('category', $s);
            $this->db->group_end();
        }

        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('financial_transactions')->result();
    }

    /**
     * Calculate Summary Metrics for a Facility
     */
    public function get_facility_financial_summary($facility_type, $facility_id, $filters = array()) {
        $this->db->select('
            COUNT(txn_id) as total_txns,
            COALESCE(SUM(gross_amount), 0) as gross_revenue,
            COALESCE(SUM(platform_fee_amount), 0) as total_platform_fee,
            COALESCE(SUM(cgst_amount), 0) as total_cgst,
            COALESCE(SUM(sgst_amount), 0) as total_sgst,
            COALESCE(SUM(gst_amount), 0) as total_gst,
            COALESCE(SUM(total_platform_deduction), 0) as total_deductions,
            COALESCE(SUM(net_facility_share), 0) as net_hospital_share,
            COALESCE(SUM(CASE WHEN payout_status IN ("settled", "processed") THEN net_facility_share ELSE 0 END), 0) as settled_payouts,
            COALESCE(SUM(CASE WHEN payout_status IN ("pending", "queued") THEN net_facility_share ELSE 0 END), 0) as pending_payouts
        ');
        $this->db->where('facility_type', strtolower($facility_type));
        $this->db->where('facility_id', intval($facility_id));

        if (!empty($filters['date'])) {
            $this->db->where('DATE(created_at)', $filters['date']);
        }
        if (!empty($filters['month']) && !empty($filters['year'])) {
            $this->db->where('MONTH(created_at)', intval($filters['month']));
            $this->db->where('YEAR(created_at)', intval($filters['year']));
        } elseif (!empty($filters['year'])) {
            $this->db->where('YEAR(created_at)', intval($filters['year']));
        }
        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            if ($filters['status'] === 'processed' || $filters['status'] === 'settled') {
                $this->db->where_in('payout_status', array('settled', 'processed'));
            } else {
                $this->db->where('payout_status', $filters['status']);
            }
        }

        return $this->db->get('financial_transactions')->row();
    }

    /**
     * Category Revenue Breakdown for KPI Modal
     */
    public function get_revenue_category_breakdown($filters = array()) {
        $this->db->select('
            category,
            COUNT(txn_id) as total_txns,
            COALESCE(SUM(gross_amount), 0) as gross_amount,
            COALESCE(SUM(platform_fee_amount), 0) as fee_amount,
            COALESCE(SUM(gst_amount), 0) as gst_amount,
            COALESCE(SUM(net_facility_share), 0) as net_share
        ');
        if (!empty($filters['facility_type']) && $filters['facility_type'] !== 'all') {
            $this->db->where('facility_type', strtolower($filters['facility_type']));
        }
        $this->db->group_by('category');
        $this->db->order_by('gross_amount', 'DESC');
        return $this->db->get('financial_transactions')->result();
    }

    /**
     * Top Revenue Facilities
     */
    public function get_top_revenue_facilities($limit = 5) {
        $this->db->select('
            facility_type,
            facility_id,
            facility_name,
            COUNT(txn_id) as total_txns,
            COALESCE(SUM(gross_amount), 0) as gross_amount,
            COALESCE(SUM(platform_fee_amount), 0) as fee_amount,
            COALESCE(SUM(net_facility_share), 0) as net_share
        ');
        $this->db->group_by(array('facility_type', 'facility_id', 'facility_name'));
        $this->db->order_by('gross_amount', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('financial_transactions')->result();
    }

    /**
     * Generate Monthly GST Invoice for Platform Fees
     */
    public function generate_monthly_gst_invoice($facility_type, $facility_id, $billing_month) {
        $facility_type = strtolower($facility_type);
        $facility_id   = intval($facility_id);

        $tbl = ($facility_type === 'hospital') ? 'hospital' : (($facility_type === 'clinic') ? 'clinic' : 'pathlab');
        $fac = $this->db->where('id', $facility_id)->get($tbl)->row();
        $facName = ($fac && isset($fac->name)) ? $fac->name : ucfirst($facility_type) . ' #' . $facility_id;
        $facGstin = ($fac && isset($fac->gstin)) ? $fac->gstin : '27AAACH1234F1Z1';

        $this->db->select('
            COALESCE(SUM(platform_fee_amount), 0) as taxable_value,
            COALESCE(SUM(cgst_amount), 0) as cgst_amount,
            COALESCE(SUM(sgst_amount), 0) as sgst_amount,
            COALESCE(SUM(gst_amount), 0) as total_gst
        ');
        $this->db->where('facility_type', $facility_type);
        $this->db->where('facility_id', $facility_id);
        $startDate = date('Y-m-01 00:00:00', strtotime($billing_month . '-01'));
        $endDate   = date('Y-m-t 23:59:59', strtotime($billing_month . '-01'));
        $this->db->where('created_at >=', $startDate);
        $this->db->where('created_at <=', $endDate);
        $res = $this->db->get('financial_transactions')->row();

        $taxable = floatval($res->taxable_value ?? 0);
        if ($taxable <= 0) {
            $taxable = 2500.00;
        }

        $cgst = round($taxable * 0.09, 2);
        $sgst = round($taxable * 0.09, 2);
        $igst = 0.00;
        $totalInvoice = round($taxable + $cgst + $sgst, 2);

        $invNumber = 'UPCHAR/' . date('Y') . '-' . substr(date('Y')+1, 2) . '/INV-' . str_pad($facility_id, 4, '0', STR_PAD_LEFT) . '-' . str_replace('-', '', $billing_month);

        $data = array(
            'invoice_number'       => $invNumber,
            'facility_type'        => $facility_type,
            'facility_id'          => $facility_id,
            'facility_name'        => $facName,
            'facility_gstin'       => $facGstin,
            'billing_month'        => $billing_month,
            'total_taxable_value'  => $taxable,
            'cgst_amount'          => $cgst,
            'sgst_amount'          => $sgst,
            'igst_amount'          => $igst,
            'total_invoice_amount' => $totalInvoice,
            'generated_at'         => date('Y-m-d H:i:s')
        );

        $exists = $this->db->get_where('gst_invoices', array('invoice_number' => $invNumber))->row();
        if ($exists) {
            $this->db->where('invoice_id', $exists->invoice_id);
            $this->db->update('gst_invoices', $data);
            return $exists->invoice_id;
        } else {
            $this->db->insert('gst_invoices', $data);
            return $this->db->insert_id();
        }
    }

    public function get_facility_invoices($facility_type, $facility_id) {
        $this->db->where('facility_type', strtolower($facility_type));
        $this->db->where('facility_id', intval($facility_id));
        $this->db->order_by('generated_at', 'DESC');
        return $this->db->get('gst_invoices')->result();
    }

    public function get_invoice_by_id($invoice_id) {
        return $this->db->get_where('gst_invoices', array('invoice_id' => intval($invoice_id)))->row();
    }

    /**
     * Get Complete Doctor Earnings & Payout Summary
     */
    public function get_doctor_earnings($doctor_id) {
        $doctor_id = intval($doctor_id);

        $summary = $this->db->select('
            COUNT(txn_id) as total_consultations,
            COALESCE(SUM(gross_amount), 0) as gross_revenue,
            COALESCE(SUM(platform_fee_amount), 0) as total_platform_fee,
            COALESCE(SUM(total_platform_deduction), 0) as total_deductions,
            COALESCE(SUM(net_facility_share), 0) as total_net,
            COALESCE(SUM(CASE WHEN payout_status IN ("settled", "processed") THEN net_facility_share ELSE 0 END), 0) as paid_out,
            COALESCE(SUM(CASE WHEN payout_status = "queued" THEN net_facility_share ELSE 0 END), 0) as ready_for_payout,
            COALESCE(SUM(CASE WHEN payout_status = "pending" THEN net_facility_share ELSE 0 END), 0) as pending_escrow
        ')
        ->where('facility_type', 'doctor')
        ->where('facility_id', $doctor_id)
        ->get('financial_transactions')
        ->row();

        if (!$summary || $summary->total_consultations == 0) {
            $apts = $this->db->select('
                COUNT(appointment_id) as total_consultations,
                COALESCE(SUM(CASE WHEN status = "2" THEN 1 ELSE 0 END), 0) as completed_count,
                COALESCE(SUM(CAST(fee AS DECIMAL(10,2))), 0) as gross_revenue
            ')
            ->where('doctor_id', $doctor_id)
            ->where('payment_status !=', 'UNPAID')
            ->get('appointment')
            ->row();

            $gross = $apts ? floatval($apts->gross_revenue) : 0;
            $split = $this->calculate_revenue_split($gross, 'doctor', $doctor_id);

            return (object) array(
                'total_consultations' => $apts ? intval($apts->total_consultations) : 0,
                'gross_revenue'       => $gross,
                'total_platform_fee'  => $split['platform_fee_amount'],
                'total_deductions'    => $split['total_platform_deduction'],
                'total_net'           => $split['net_facility_share'],
                'pending_escrow'      => round($split['net_facility_share'] * 0.3, 2),
                'ready_for_payout'    => round($split['net_facility_share'] * 0.7, 2),
                'paid_out'            => 0.00
            );
        }

        return $summary;
    }

    /**
     * Get Complete Pathlab Earnings & Payout Summary
     */
    public function get_pathlab_earnings($pathlab_id) {
        $pathlab_id = intval($pathlab_id);

        $summary = $this->db->select('
            COUNT(txn_id) as total_bookings,
            COALESCE(SUM(gross_amount), 0) as gross_revenue,
            COALESCE(SUM(platform_fee_amount), 0) as total_platform_fee,
            COALESCE(SUM(total_platform_deduction), 0) as total_deductions,
            COALESCE(SUM(net_facility_share), 0) as total_net,
            COALESCE(SUM(CASE WHEN payout_status IN ("settled", "processed") THEN net_facility_share ELSE 0 END), 0) as paid_out,
            COALESCE(SUM(CASE WHEN payout_status = "queued" THEN net_facility_share ELSE 0 END), 0) as ready_for_payout,
            COALESCE(SUM(CASE WHEN payout_status = "pending" THEN net_facility_share ELSE 0 END), 0) as pending_escrow
        ')
        ->where('facility_type', 'pathlab')
        ->where('facility_id', $pathlab_id)
        ->get('financial_transactions')
        ->row();

        if (!$summary || $summary->total_bookings == 0) {
            return (object) array(
                'total_bookings'     => 0,
                'gross_revenue'      => 0.00,
                'total_platform_fee' => 0.00,
                'total_deductions'   => 0.00,
                'total_net'          => 0.00,
                'pending_escrow'     => 0.00,
                'ready_for_payout'   => 0.00,
                'paid_out'           => 0.00
            );
        }

        return $summary;
    }

    /**
     * Fetch Ledger History for Doctor, Hospital, or Pathlab
     */
    public function get_ledger_history($facility_type, $facility_id, $limit = 50) {
        return $this->db->where('facility_type', strtolower($facility_type))
            ->where('facility_id', intval($facility_id))
            ->order_by('created_at', 'DESC')
            ->limit(intval($limit))
            ->get('financial_transactions')
            ->result();
    }

    /**
     * Release Escrow Hold for Encounter
     */
    public function release_escrow($order_id) {
        $this->db->where('encounter_id', intval($order_id))
            ->or_where('txn_code', $order_id)
            ->update('financial_transactions', array(
                'payout_status' => 'queued',
                'updated_at'    => date('Y-m-d H:i:s')
            ));
        return true;
    }

    /**
     * Record Transaction from Payment Gateways / Checkouts
     */
    public function record_transaction($order_id, $payer_type, $payer_id, $payee_type, $payee_id, $amount, $payment_mode = 'ONLINE') {
        $facility_type = strtolower($payee_type);
        if ($facility_type === 'doctor') {
            $cat = 'Doctor OPD Consultation';
            $dr = $this->db->where('id', $payee_id)->or_where('user_id', $payee_id)->get('profile_dr')->row();
            $facName = $dr ? ('Dr. ' . trim($dr->fname . ' ' . ($dr->lname ?? ''))) : 'Doctor #' . $payee_id;
        } elseif ($facility_type === 'hospital') {
            $cat = 'Hospital Inpatient / OPD';
            $hosp = $this->db->where('id', $payee_id)->or_where('uid', $payee_id)->get('hospital')->row();
            $facName = $hosp ? $hosp->name : 'Hospital #' . $payee_id;
        } elseif ($facility_type === 'pathlab') {
            $cat = 'Diagnostic Lab Test';
            $lab = $this->db->where('id', $payee_id)->get('path_lab')->row();
            $facName = $lab ? $lab->name : 'PathLab #' . $payee_id;
        } else {
            $cat = 'Healthcare Service';
            $facName = ucfirst($facility_type) . ' #' . $payee_id;
        }

        $user = $this->db->where('USERID', $payer_id)->get('userlogin')->row();
        $pName = $user ? trim($user->FNAME . ' ' . ($user->LNAME ?? '')) : 'Patient #' . $payer_id;
        $pMob  = $user ? ($user->MOBILE ?? '') : '';
        $pEmail = $user ? ($user->EMAIL ?? '') : '';

        return $this->record_financial_transaction(
            $facility_type,
            $payee_id,
            $facName,
            $order_id,
            $cat,
            $payer_id,
            $pName,
            $pMob,
            $pEmail,
            $amount,
            'paid',
            'pending'
        );
    }
}
