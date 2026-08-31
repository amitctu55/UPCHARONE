<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Refund Controller
 * UPCHAR Healthcare SaaS Cancellation & Refund Processing
 */
class Refund extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('Refund_model');
        $this->load->model('Payment_model');
        $this->load->model('Wallet_model');
        $this->load->helper(array('url', 'form'));
    }

    private function _get_user_id() {
        return $this->session->userdata('USERID') ?:
               $this->session->userdata('userid') ?:
               $this->session->userdata('WEB_UID') ?:
               $this->session->userdata('user_id');
    }

    /**
     * POST: Initiate a Refund for an Order / Appointment
     */
    public function initiate() {
        $userId = $this->_get_user_id();
        if (!$userId) {
            echo json_encode(array('status' => 'error', 'message' => 'User not authenticated.'));
            return;
        }

        $order_ref = $this->input->post('order_ref');
        $reason    = $this->input->post('reason') ?: 'Patient requested cancellation';
        $refund_to = $this->input->post('refund_to') ?: 'WALLET'; // WALLET (instant) or GATEWAY (5-7 days)

        if (empty($order_ref)) {
            echo json_encode(array('status' => 'error', 'message' => 'Order reference is required.'));
            return;
        }

        $order = $this->Payment_model->get_order_by_ref($order_ref);
        if (!$order) {
            echo json_encode(array('status' => 'error', 'message' => 'Order not found.'));
            return;
        }

        if ($order['user_id'] != $userId && !$this->session->userdata('adminuserid')) {
            echo json_encode(array('status' => 'error', 'message' => 'Unauthorized order access.'));
            return;
        }

        if ($order['status'] !== 'PAID') {
            echo json_encode(array('status' => 'error', 'message' => 'Only paid orders can be refunded.'));
            return;
        }

        // Calculate refund amount based on appointment timing if available
        $original_amount = floatval($order['amount']);
        $refund_percent  = 100;

        if ($order['purpose'] === 'APPOINTMENT' && $order['reference_id']) {
            $app = $this->db->get_where('appointment', array('appointment_id' => $order['reference_id']))->row_array();
            if ($app && !empty($app['appointment_date'])) {
                $app_datetime = $app['appointment_date'] . ' ' . (isset($app['appointment_time']) ? $app['appointment_time'] : '10:00:00');
                $refund_percent = $this->Refund_model->calculate_refund_percentage($app_datetime);
            }
        }

        if ($refund_percent <= 0) {
            echo json_encode(array('status' => 'error', 'message' => 'Cancellation time window has expired. No refund applicable as per policy.'));
            return;
        }

        $refund_amount = round(($original_amount * ($refund_percent / 100)), 2);

        $res = $this->Refund_model->create_refund(
            $order_ref,
            $userId,
            $refund_amount,
            $refund_to,
            $reason . ' (' . $refund_percent . '% refund policy applied)',
            'PATIENT'
        );

        if ($res && $res['success']) {
            // Update order status to REFUNDED
            $this->Payment_model->update_order_status($order_ref, 'REFUNDED');

            // If appointment, update status to cancelled
            if ($order['purpose'] === 'APPOINTMENT' && $order['reference_id']) {
                $this->db->where('appointment_id', $order['reference_id'])->update('appointment', array(
                    'appointment_status' => '2', // Cancelled
                    'payment_status'     => 'REFUNDED'
                ));
            }

            echo json_encode(array(
                'status'         => 'success',
                'refund_ref'     => $res['refund_ref'],
                'refund_amount'  => $refund_amount,
                'refund_percent' => $refund_percent,
                'message'        => $res['message']
            ));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to process refund.'));
        }
    }

    /**
     * GET: Check Refund Status
     */
    public function status($refund_id = 0) {
        $refund = $this->db->get_where('payment_refunds', array('id' => intval($refund_id)))->row_array();
        if (!$refund) {
            $refund = $this->db->get_where('payment_refunds', array('refund_ref' => $refund_id))->row_array();
        }

        if ($refund) {
            echo json_encode(array('status' => 'success', 'data' => $refund));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Refund record not found.'));
        }
    }
}
