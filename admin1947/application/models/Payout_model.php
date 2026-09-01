<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Payout Model
 * UPCHAR Healthcare SaaS Provider Settlements & RazorpayX Disbursals (Admin Module)
 */
class Payout_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('Razorpay_lib');
        date_default_timezone_set("Asia/Kolkata");
    }

    /**
     * Get or fetch facility payout account
     */
    public function get_facility_payout_account($facility_type, $facility_id) {
        return $this->db->get_where('facility_payout_accounts', array(
            'facility_type' => $facility_type,
            'facility_id'   => intval($facility_id),
            'is_active'     => 1
        ))->row_array();
    }

    /**
     * Save or update facility payout account
     */
    public function save_facility_payout_account($facility_type, $facility_id, $data) {
        $existing = $this->db->get_where('facility_payout_accounts', array(
            'facility_type' => $facility_type,
            'facility_id'   => intval($facility_id)
        ))->row_array();

        $account_data = array(
            'facility_type'  => $facility_type,
            'facility_id'    => intval($facility_id),
            'account_type'   => $data['account_type'], // BANK_ACCOUNT or VPA
            'account_name'   => trim($data['account_name']),
            'account_number' => isset($data['account_number']) ? trim($data['account_number']) : null,
            'ifsc_code'      => isset($data['ifsc_code']) ? strtoupper(trim($data['ifsc_code'])) : null,
            'bank_name'      => isset($data['bank_name']) ? trim($data['bank_name']) : null,
            'vpa'            => isset($data['vpa']) ? trim($data['vpa']) : null,
            'is_verified'    => isset($data['is_verified']) ? intval($data['is_verified']) : 0,
            'is_active'      => 1
        );

        if ($existing) {
            $account_data['updated_at'] = date('Y-m-d H:i:s');
            $this->db->where('id', $existing['id']);
            $this->db->update('facility_payout_accounts', $account_data);
            return $existing['id'];
        } else {
            $account_data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('facility_payout_accounts', $account_data);
            return $this->db->insert_id();
        }
    }

    /**
     * Get pending settlements aggregated by facility
     */
    public function get_pending_settlements_summary() {
        if ($this->db->table_exists('financial_transactions')) {
            $this->db->select('facility_type, facility_id, facility_name, COUNT(txn_id) as total_txns, SUM(net_facility_share) as total_pending_amount');
            $this->db->from('financial_transactions');
            $this->db->where('payout_status', 'pending');
            $this->db->where('payment_status', 'paid');
            $this->db->group_by(array('facility_type', 'facility_id'));
            return $this->db->get()->result_array();
        }
        return array();
    }

    /**
     * Create and Trigger a Weekly Payout Batch
     */
    public function create_payout_batch($admin_id = 1, $notes = '') {
        $batch_ref = 'BATCH-UPCH-' . date('Ymd-His');
        $pending = $this->get_pending_settlements_summary();

        $total_amount = 0.00;
        foreach ($pending as $p) {
            $total_amount += floatval($p['total_pending_amount']);
        }

        $batch_data = array(
            'batch_ref'             => $batch_ref,
            'batch_date'            => date('Y-m-d'),
            'total_facilities'      => count($pending),
            'total_amount'          => $total_amount,
            'successful_payouts'    => 0,
            'failed_payouts'        => 0,
            'status'                => 'PROCESSING',
            'triggered_by_admin_id' => intval($admin_id),
            'notes'                 => $notes ?: 'Batch triggered on ' . date('d M Y, h:i A'),
            'created_at'            => date('Y-m-d H:i:s')
        );

        $this->db->insert('payout_batches', $batch_data);
        $batch_id = $this->db->insert_id();

        $successful = 0;
        $failed = 0;

        foreach ($pending as $facility) {
            $f_type = $facility['facility_type'];
            $f_id   = $facility['facility_id'];
            $amount = floatval($facility['total_pending_amount']);

            $account = $this->get_facility_payout_account($f_type, $f_id);

            if ($account && $account['is_verified'] == 1) {
                $successful++;
                if ($this->db->table_exists('financial_transactions')) {
                    $this->db->where(array(
                        'facility_type'  => $f_type,
                        'facility_id'    => $f_id,
                        'payout_status'  => 'pending',
                        'payment_status' => 'paid'
                    ))->update('financial_transactions', array(
                        'payout_status'   => 'settled',
                        'settlement_date' => date('Y-m-d H:i:s')
                    ));
                }
            } else {
                $failed++;
                if ($this->db->table_exists('financial_transactions')) {
                    $this->db->where(array(
                        'facility_type'  => $f_type,
                        'facility_id'    => $f_id,
                        'payout_status'  => 'pending'
                    ))->update('financial_transactions', array(
                        'payout_status' => 'on_hold'
                    ));
                }
            }
        }

        $final_status = ($failed === 0) ? 'COMPLETED' : (($successful > 0) ? 'PARTIAL' : 'COMPLETED');

        $this->db->where('id', $batch_id)->update('payout_batches', array(
            'successful_payouts' => $successful,
            'failed_payouts'     => $failed,
            'status'             => $final_status,
            'completed_at'       => date('Y-m-d H:i:s')
        ));

        return array(
            'batch_id'    => $batch_id,
            'batch_ref'   => $batch_ref,
            'successful'  => $successful,
            'failed'      => $failed,
            'total_amount'=> $total_amount,
            'status'      => $final_status
        );
    }

    /**
     * Get recent payout batches
     */
    public function get_payout_batches($limit = 20, $offset = 0) {
        $this->db->from('payout_batches');
        $this->db->order_by('id', 'DESC');
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result_array();
    }
}
