<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Financial_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Records double-entry escrow transaction in financial_ledger
     */
    public function record_transaction($order_id, $payer_type, $payer_id, $payee_type, $payee_id, $gross_amount, $gateway_id = null) {
        $gross = floatval($gross_amount);
        $platform_fee_percent = ($payee_type === 'DOCTOR') ? 0.10 : (($payee_type === 'PATHLAB') ? 0.15 : 0.05);
        $platform_fee = round($gross * $platform_fee_percent, 2);
        $tax_amount = round($platform_fee * 0.18, 2); // 18% GST on platform service fee
        $net_payout = $gross - $platform_fee;

        $ref = 'TXN_' . date('YmdHis') . '_' . rand(1000, 9999);

        $data = array(
            'transaction_ref'    => $ref,
            'order_id'           => $order_id,
            'payer_type'         => $payer_type,
            'payer_id'           => intval($payer_id),
            'payee_type'         => $payee_type,
            'payee_id'           => intval($payee_id),
            'gross_amount'       => $gross,
            'platform_fee'       => $platform_fee,
            'tax_amount'         => $tax_amount,
            'net_payout'         => $net_payout,
            'currency'           => 'INR',
            'escrow_status'      => 'HELD',
            'payout_status'      => 'UNPROCESSED',
            'gateway_payment_id' => $gateway_id,
            'created_at'         => date('Y-m-d H:i:s')
        );

        $this->db->insert('financial_ledger', $data);
        return $this->db->insert_id();
    }

    /**
     * Mark escrow as released when service is marked completed
     */
    public function release_escrow($order_id) {
        $this->db->where('order_id', $order_id);
        $this->db->update('financial_ledger', array(
            'escrow_status' => 'RELEASED',
            'payout_status' => 'QUEUED'
        ));
        return $this->db->affected_rows();
    }

    /**
     * Fetch Doctor Earnings Summary
     */
    public function get_doctor_earnings($doctor_id) {
        $this->db->select('
            COUNT(id) as total_consultations,
            COALESCE(SUM(gross_amount), 0) as total_gross,
            COALESCE(SUM(platform_fee), 0) as total_commission,
            COALESCE(SUM(net_payout), 0) as total_net,
            COALESCE(SUM(CASE WHEN escrow_status = "HELD" THEN net_payout ELSE 0 END), 0) as pending_escrow,
            COALESCE(SUM(CASE WHEN payout_status = "PROCESSED" THEN net_payout ELSE 0 END), 0) as paid_out,
            COALESCE(SUM(CASE WHEN payout_status = "QUEUED" THEN net_payout ELSE 0 END), 0) as ready_for_payout
        ');
        $this->db->where('payee_type', 'DOCTOR');
        $this->db->where('payee_id', intval($doctor_id));
        return $this->db->get('financial_ledger')->row();
    }

    /**
     * Fetch Lab Diagnostic Earnings Summary
     */
    public function get_pathlab_earnings($pathlab_id) {
        $this->db->select('
            COUNT(id) as total_orders,
            COALESCE(SUM(gross_amount), 0) as total_gross,
            COALESCE(SUM(platform_fee), 0) as total_commission,
            COALESCE(SUM(net_payout), 0) as total_net,
            COALESCE(SUM(CASE WHEN escrow_status = "HELD" THEN net_payout ELSE 0 END), 0) as pending_escrow,
            COALESCE(SUM(CASE WHEN payout_status = "PROCESSED" THEN net_payout ELSE 0 END), 0) as paid_out
        ');
        $this->db->where('payee_type', 'PATHLAB');
        $this->db->where('payee_id', intval($pathlab_id));
        return $this->db->get('financial_ledger')->row();
    }

    /**
     * Fetch Hospital Earnings Summary
     */
    public function get_hospital_earnings($hospital_id) {
        $this->db->select('
            COUNT(id) as total_txns,
            COALESCE(SUM(gross_amount), 0) as total_gross,
            COALESCE(SUM(platform_fee), 0) as total_commission,
            COALESCE(SUM(net_payout), 0) as total_net,
            COALESCE(SUM(CASE WHEN payout_status = "PROCESSED" THEN net_payout ELSE 0 END), 0) as settled_payout
        ');
        $this->db->where('payee_type', 'HOSPITAL');
        $this->db->where('payee_id', intval($hospital_id));
        return $this->db->get('financial_ledger')->row();
    }

    /**
     * Fetch Ledger History for Stakeholder
     */
    public function get_ledger_history($payee_type, $payee_id, $limit = 50) {
        return $this->db->where('payee_type', $payee_type)
                        ->where('payee_id', intval($payee_id))
                        ->order_by('id', 'DESC')
                        ->limit($limit)
                        ->get('financial_ledger')
                        ->result();
    }
}
