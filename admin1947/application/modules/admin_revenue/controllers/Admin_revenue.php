<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_revenue extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");

        // Auth check
        if (!$this->session->userdata('adminuserid') && !$this->session->userdata('userid') && !$this->session->userdata('username')) {
            redirect(base_url('login'));
        }

        $this->load->model('Financial_Model');
        $this->load->helper(array('url', 'form', 'query_string_helper', 'dbquery_helper', 'admin_helper'));
    }

    /**
     * Central Super Admin & Acquisition Revenue Portal
     */
    public function index($tab = 'transactions') {
        $active_tab = $this->input->get('tab') ?: $tab;
        $data['active_tab'] = $active_tab;

        // Build filter criteria
        $filters = array(
            'search'         => trim($this->input->get('search') ?: ''),
            'facility_type'  => $this->input->get('facility_type') ?: 'all',
            'facility_id'    => $this->input->get('facility_id') ?: '',
            'payout_status'  => $this->input->get('payout_status') ?: 'all',
            'payment_status' => $this->input->get('payment_status') ?: 'all',
            'date_from'      => $this->input->get('date_from') ?: '',
            'date_to'        => $this->input->get('date_to') ?: '',
            'month'          => $this->input->get('month') ?: '',
            'year'           => $this->input->get('year') ?: ''
        );
        $data['filters'] = $filters;

        $data['settings'] = $this->Financial_Model->get_platform_settings();
        $data['metrics']  = $this->Financial_Model->get_admin_revenue_metrics($filters);
        $data['category_breakdown'] = $this->Financial_Model->get_revenue_category_breakdown($filters);
        $data['top_facilities']     = $this->Financial_Model->get_top_revenue_facilities(6);

        // Pagination settings
        $pagesize = (int) $this->input->get_post('pagesize');
        $limit    = ($pagesize > 0) ? $pagesize : 10;
        $offset   = ($this->input->get_post('per_page') > 0) ? (int)$this->input->get_post('per_page') : 0;
        $base_url = current_url_query_string(array('tab' => 'transactions'), array('per_page'));

        $total_rows = $this->Financial_Model->count_all_platform_transactions($filters);
        $data['total_txns_count'] = $total_rows;
        $data['recent_txns']      = $this->Financial_Model->get_all_platform_transactions($filters, $limit, $offset);
        $data['page_links']       = admin_pagination($base_url, $total_rows, $limit, $offset);
        $data['limit']            = $limit;
        $data['offset']           = $offset;

        // Fetch all registered facilities for custom commission assignment dropdown
        $data['hospitals'] = $this->db->select('id, name, email, mobile, city')->order_by('name', 'ASC')->get('hospital')->result();
        $data['clinics']   = $this->db->select('id, name, email, mobile, city')->order_by('name', 'ASC')->get('clinic')->result();
        $data['pathlabs']  = $this->db->select('id, name, email, mobile, city')->order_by('name', 'ASC')->get('pathlab')->result();

        // Fetch custom commission overrides
        $data['custom_commissions'] = $this->db->order_by('id', 'DESC')->get('facility_custom_commissions')->result();

        // Fetch generated GST invoices
        $data['invoices'] = $this->db->order_by('invoice_id', 'DESC')->limit(100)->get('gst_invoices')->result();

        // Load AdminLTE Layout
        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('revenue_dashboard', $data);
        $this->load->view('inc/sidebar');
        $this->load->view('inc/headersetting');
        $this->load->view('inc/footerlink');
        $this->load->view('inc/table_footer');
    }

    /**
     * Export Filtered Transactions to CSV / Excel
     */
    public function export_transactions() {
        $filters = array(
            'search'         => trim($this->input->get('search') ?: ''),
            'facility_type'  => $this->input->get('facility_type') ?: 'all',
            'facility_id'    => $this->input->get('facility_id') ?: '',
            'payout_status'  => $this->input->get('payout_status') ?: 'all',
            'payment_status' => $this->input->get('payment_status') ?: 'all',
            'date_from'      => $this->input->get('date_from') ?: '',
            'date_to'        => $this->input->get('date_to') ?: '',
            'month'          => $this->input->get('month') ?: '',
            'year'           => $this->input->get('year') ?: ''
        );

        $transactions = $this->Financial_Model->get_all_platform_transactions($filters, 5000, 0);
        $filename = "upchar_transactions_" . date('Ymd_His') . ".csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');

        // CSV Header row
        fputcsv($output, array(
            'Txn Ref', 'Encounter ID', 'Date Time', 'Patient Name', 'Patient ID', 'Patient Mobile', 'Patient Email',
            'Facility Type', 'Facility ID', 'Facility Name', 'Category', 'Gross Amount (INR)',
            'Commission Rate (%)', 'Custom Rate Applied', 'Upchar Platform Fee (INR)',
            'CGST (9%) (INR)', 'SGST (9%) (INR)', 'Total GST (18%) (INR)',
            'Total Platform Deduction (INR)', 'Net Facility Payout (INR)',
            'Payment Status', 'Payout Status', 'Settlement Date'
        ));

        foreach ($transactions as $t) {
            fputcsv($output, array(
                $t->txn_code,
                '#ENC-' . $t->encounter_id,
                date('Y-m-d H:i:s', strtotime($t->created_at)),
                $t->patient_name,
                '#P-' . $t->patient_id,
                $t->patient_mobile,
                $t->patient_email,
                strtoupper($t->facility_type),
                $t->facility_id,
                $t->facility_name ?: ($t->facility_type . ' #' . $t->facility_id),
                $t->category,
                number_format($t->gross_amount, 2, '.', ''),
                number_format($t->platform_fee_percent, 2, '.', '') . '%',
                ($t->is_custom_rate ? 'YES' : 'NO (DEFAULT)'),
                number_format($t->platform_fee_amount, 2, '.', ''),
                number_format($t->cgst_amount, 2, '.', ''),
                number_format($t->sgst_amount, 2, '.', ''),
                number_format($t->gst_amount, 2, '.', ''),
                number_format($t->total_platform_deduction, 2, '.', ''),
                number_format($t->net_facility_share, 2, '.', ''),
                strtoupper($t->payment_status),
                strtoupper($t->payout_status),
                $t->settlement_date ? date('Y-m-d H:i:s', strtotime($t->settlement_date)) : 'N/A'
            ));
        }

        fclose($output);
        exit();
    }

    /**
     * Mark Transaction as Settled / Paid to Facility
     */
    public function settle_payout($txn_id) {
        $txn_id = intval($txn_id);
        $this->Financial_Model->settle_transaction($txn_id);
        $this->session->set_flashdata('flashmsg', "<div class='alert alert-success' style='border-radius: 8px; margin: 15px 0;'><i class='fa fa-check-circle'></i> Transaction #{$txn_id} marked as SETTLED &amp; Transferred to Facility Bank Account!</div>");
        redirect(base_url('admin_revenue?tab=transactions#tab_transactions'));
    }

    /**
     * Queue Transaction for Batch Payout
     */
    public function queue_payout($txn_id) {
        $txn_id = intval($txn_id);
        $this->Financial_Model->queue_payout($txn_id);
        $this->session->set_flashdata('flashmsg', "<div class='alert alert-info' style='border-radius: 8px; margin: 15px 0;'><i class='fa fa-clock-o'></i> Transaction #{$txn_id} QUEUED for next banking payout batch.</div>");
        redirect(base_url('admin_revenue?tab=transactions#tab_transactions'));
    }

    /**
     * AJAX Endpoint for single transaction details modal
     */
    public function transaction_details_ajax($txn_id = 0) {
        $txn_id = intval($txn_id);
        $txn = $this->Financial_Model->get_transaction_by_id($txn_id);
        if (!$txn) {
            echo json_encode(array('status' => 'error', 'message' => 'Transaction not found.'));
            return;
        }

        echo json_encode(array(
            'status' => 'success',
            'data'   => $txn,
            'formatted' => array(
                'gross'      => '₹' . number_format($txn->gross_amount, 2),
                'fee'        => '₹' . number_format($txn->platform_fee_amount, 2),
                'cgst'       => '₹' . number_format($txn->cgst_amount, 2),
                'sgst'       => '₹' . number_format($txn->sgst_amount, 2),
                'gst'        => '₹' . number_format($txn->gst_amount, 2),
                'deduction'  => '₹' . number_format($txn->total_platform_deduction, 2),
                'payout'     => '₹' . number_format($txn->net_facility_share, 2),
                'date'       => date('d M Y, h:i A', strtotime($txn->created_at)),
                'settlement' => $txn->settlement_date ? date('d M Y, h:i A', strtotime($txn->settlement_date)) : 'Pending Settlement'
            )
        ));
    }

    /**
     * Set Custom Commission Rate for Facility (Acquisition Tool)
     */
    public function set_custom_commission() {
        $facility_type = $this->input->post('facility_type');
        $facility_id   = intval($this->input->post('facility_id'));
        $rate          = floatval($this->input->post('platform_fee_percent'));
        $notes                = trim($this->input->post('notes'));
        $admin_id             = intval($this->session->userdata('adminuserid') ?: 1);
        $recalculate_facility = $this->input->post('recalculate_facility');

        if ($facility_id > 0 && $rate >= 0) {
            $this->Financial_Model->set_facility_custom_commission($facility_type, $facility_id, $rate, $admin_id, $notes);
            
            $recalc_msg = '';
            if ($recalculate_facility == '1') {
                $recalc_count = $this->Financial_Model->recalculate_financial_valuations('all', $facility_type, $facility_id);
                $recalc_msg = " and recalculated {$recalc_count} associated transactions";
            }

            $this->session->set_flashdata('flashmsg', "<div class='alert alert-success' style='border-radius: 8px; margin: 15px 0;'><i class='fa fa-check-circle'></i> Custom platform fee of <strong>{$rate}%</strong> assigned to {$facility_type} #{$facility_id}{$recalc_msg}!</div>");
        } else {
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-danger' style='border-radius: 8px; margin: 15px 0;'>Invalid facility or commission percentage.</div>");
        }

        redirect(base_url('admin_revenue?tab=commissions#tab_commissions'));
    }

    /**
     * Update Global Platform Settings & Recalculate Valuations
     */
    public function update_settings() {
        $default_fee       = floatval($this->input->post('default_platform_fee_percent'));
        $gst_percent       = floatval($this->input->post('gst_percent'));
        $upchar_gstin      = trim($this->input->post('upchar_gstin'));
        $auto_recalculate  = $this->input->post('auto_recalculate');

        $this->Financial_Model->update_platform_settings(array(
            'default_platform_fee_percent' => $default_fee,
            'gst_percent'                  => $gst_percent,
            'upchar_gstin'                 => $upchar_gstin
        ));

        $recalc_info = '';
        if ($auto_recalculate === 'all' || $auto_recalculate === 'pending' || $this->input->post('recalculate_all') == '1') {
            $scope = ($auto_recalculate === 'pending') ? 'pending' : 'all';
            $count = $this->Financial_Model->recalculate_financial_valuations($scope);
            $recalc_info = " <br><strong>⚡ Recalculation Complete:</strong> {$count} {$scope} transactions updated with {$gst_percent}% GST (CGST " . ($gst_percent/2) . "% + SGST " . ($gst_percent/2) . "%) and {$default_fee}% standard fee.";
        }

        $this->session->set_flashdata('flashmsg', "<div class='alert alert-success' style='border-radius: 8px; margin: 15px 0;'><i class='fa fa-check-circle'></i> Global Platform &amp; GST Settings updated successfully!{$recalc_info}</div>");
        redirect(base_url('admin_revenue?tab=settings#tab_settings'));
    }

    /**
     * One-Click Recalculate Valuations Endpoint
     */
    public function recalculate_valuations() {
        $scope = $this->input->post('scope') ?: 'all';
        $count = $this->Financial_Model->recalculate_financial_valuations($scope);
        $settings = $this->Financial_Model->get_platform_settings();

        $this->session->set_flashdata('flashmsg', "<div class='alert alert-success' style='border-radius: 8px; margin: 15px 0;'><i class='fa fa-bolt'></i> <strong>Valuations Recalculated!</strong> Successfully recomputed {$count} transactions based on active GST ({$settings->gst_percent}%) and platform fee structure.</div>");
        redirect(base_url('admin_revenue?tab=settings#tab_settings'));
    }

    /**
     * Generate Monthly GST Tax Invoice for Facility
     */
    public function generate_invoice() {
        $facility_type = $this->input->post('facility_type');
        $facility_id   = intval($this->input->post('facility_id'));
        $billing_month = $this->input->post('billing_month') ?: date('Y-m');

        if ($facility_id > 0) {
            $inv_id = $this->Financial_Model->generate_monthly_gst_invoice($facility_type, $facility_id, $billing_month);
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-success' style='border-radius: 8px; margin: 15px 0;'><i class='fa fa-check-circle'></i> GST Tax Invoice generated successfully (Invoice ID #{$inv_id})!</div>");
        }

        redirect(base_url('admin_revenue?tab=invoices#tab_invoices'));
    }

    /**
     * View / Print GST Invoice
     */
    public function invoice_view($invoice_id = 0) {
        $invoice_id = intval($invoice_id);
        $invoice = $this->Financial_Model->get_invoice_by_id($invoice_id);
        if (!$invoice) {
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'>GST Invoice not found!</div>");
            redirect(base_url('admin_revenue?tab=invoices'));
            return;
        }

        $data['invoice']  = $invoice;
        $tbl = ($invoice->facility_type === 'hospital') ? 'hospital' : (($invoice->facility_type === 'clinic') ? 'clinic' : 'pathlab');
        $data['facility'] = $this->db->get_where($tbl, array('id' => $invoice->facility_id))->row();
        $data['settings'] = $this->Financial_Model->get_platform_settings();
        $this->load->view('gst_invoice_view', $data);
    }
}
