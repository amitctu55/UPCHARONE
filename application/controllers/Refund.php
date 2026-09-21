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
        $uid = $this->session->userdata('USERID') ?:
               $this->session->userdata('userid') ?:
               $this->session->userdata('WEB_UID') ?:
               $this->session->userdata('user_id');
        if ($uid) return $uid;

        $email = $this->session->userdata('useremail') ?: $this->session->userdata('email');
        if ($email) {
            $u = $this->db->get_where('userlogin', array('EMAIL' => $email))->row();
            if ($u) return $u->USERID;
        }

        $mob = $this->session->userdata('mobile') ?: $this->session->userdata('usermobile');
        if ($mob) {
            $u = $this->db->get_where('userlogin', array('MOBILE' => $mob))->row();
            if ($u) return $u->USERID;
        }

        return null;
    }

    /**
     * POST: Initiate a Refund or Cancellation for an Order / Appointment / Lab Booking
     */
    public function initiate() {
        $userId = $this->_get_user_id();
        if (!$userId) {
            echo json_encode(array('status' => 'error', 'message' => 'User not authenticated. Please log in.'));
            return;
        }

        $order_ref = trim($this->input->post('order_ref'));
        $reason    = trim($this->input->post('reason')) ?: 'Patient requested cancellation';
        $refund_to = strtoupper(trim($this->input->post('refund_to') ?: 'WALLET')); // WALLET (instant) or GATEWAY (5-7 days)

        if (empty($order_ref)) {
            echo json_encode(array('status' => 'error', 'message' => 'Order reference is required.'));
            return;
        }

        // 1. Check razorpay_orders first
        $order = $this->Payment_model->get_order_by_ref($order_ref);

        if ($order) {
            if ($order['user_id'] != $userId && !$this->session->userdata('adminuserid')) {
                echo json_encode(array('status' => 'error', 'message' => 'Unauthorized order access.'));
                return;
            }

            if ($order['status'] === 'REFUNDED') {
                echo json_encode(array('status' => 'error', 'message' => 'This order has already been refunded.'));
                return;
            }

            if ($order['status'] !== 'PAID') {
                // If unpaid in gateway, but it's an appointment, cancel the appointment cleanly
                if ($order['purpose'] === 'APPOINTMENT' && $order['reference_id']) {
                    $this->db->where('appointment_id', $order['reference_id'])->update('appointment', array(
                        'appointment_status' => '2',
                        'status'             => '2',
                        'cancel_date'        => date('Y-m-d H:i:s'),
                        'cancel_by'          => 'U',
                        'cancel_reason'      => $reason
                    ));
                    echo json_encode(array('status' => 'success', 'message' => 'Appointment #' . $order['reference_id'] . ' has been cancelled successfully.'));
                    return;
                }
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

            $refund_amount = round(($original_amount * ($refund_percent / 100)), 2);

            $res = null;
            if ($refund_amount > 0) {
                $res = $this->Refund_model->create_refund(
                    $order['internal_order_ref'],
                    $userId,
                    $refund_amount,
                    $refund_to,
                    $reason . ' (' . $refund_percent . '% refund policy applied)',
                    'PATIENT'
                );
            }

            // Update order status to REFUNDED
            $this->Payment_model->update_order_status($order['internal_order_ref'], 'REFUNDED');

            // If appointment, update status to cancelled
            if ($order['purpose'] === 'APPOINTMENT' && $order['reference_id']) {
                $this->db->where('appointment_id', $order['reference_id'])->update('appointment', array(
                    'appointment_status' => '2', // Cancelled
                    'status'             => '2',
                    'payment_status'     => ($refund_amount > 0) ? 'REFUNDED' : $order['status'],
                    'cancel_date'        => date('Y-m-d H:i:s'),
                    'cancel_by'          => 'U',
                    'cancel_reason'      => $reason
                ));
            }

            // If lab test, update status to cancelled
            if ($order['purpose'] === 'LAB_TEST' && $order['reference_id']) {
                $this->db->where('booking_id', $order['reference_id'])->update('path_book', array(
                    'status'         => 'CANCELLED',
                    'order_stage'    => 'CANCELLED',
                    'payment_status' => ($refund_amount > 0) ? 'REFUNDED' : 'PAID',
                    'cancel_date'    => date('Y-m-d H:i:s')
                ));
            }

            $success_msg = ($res && !empty($res['message'])) 
                ? $res['message'] 
                : ('Order cancelled successfully' . ($refund_amount > 0 ? '. Refund of ₹' . number_format($refund_amount, 2) . ' processed.' : '.'));

            echo json_encode(array(
                'status'         => 'success',
                'refund_ref'     => $res ? ($res['refund_ref'] ?? '') : '',
                'refund_amount'  => $refund_amount,
                'refund_percent' => $refund_percent,
                'message'        => $success_msg
            ));
            return;
        }

        // 2. Fallback: Lookup in appointment table directly
        $appt_id = null;
        if (stripos($order_ref, 'APPT-') === 0 || stripos($order_ref, 'APPT_') === 0 || is_numeric($order_ref)) {
            $appt_id = preg_replace('/[^0-9]/', '', $order_ref);
        }

        if ($appt_id) {
            $app = $this->db->get_where('appointment', array('appointment_id' => $appt_id))->row_array();
            if ($app) {
                if ($app['user_id'] != $userId && !$this->session->userdata('adminuserid')) {
                    echo json_encode(array('status' => 'error', 'message' => 'Unauthorized appointment access.'));
                    return;
                }

                if ($app['status'] == '2' || $app['appointment_status'] == '2' || strtoupper($app['payment_status']) === 'REFUNDED') {
                    echo json_encode(array('status' => 'error', 'message' => 'Appointment #' . $appt_id . ' is already cancelled.'));
                    return;
                }

                $pay_status = strtoupper($app['payment_status'] ?: 'UNPAID');
                $is_paid    = ($pay_status === 'PAID' || $pay_status === 'DONE');
                $amount     = floatval(!empty($app['amount']) ? $app['amount'] : (!empty($app['fee']) ? $app['fee'] : 0));

                if ($is_paid && $amount > 0) {
                    $app_datetime = $app['appointment_date'] . ' ' . (!empty($app['appointment_time']) ? $app['appointment_time'] : '10:00:00');
                    $refund_percent = $this->Refund_model->calculate_refund_percentage($app_datetime);
                    $refund_amount  = round(($amount * ($refund_percent / 100)), 2);

                    $res = null;
                    if ($refund_amount > 0) {
                        $res = $this->Refund_model->create_refund(
                            'APPT-' . $appt_id,
                            $userId,
                            $refund_amount,
                            'WALLET', // Direct/cash/UPI appointments refunded to Upchar Wallet
                            $reason . ' (' . $refund_percent . '% refund policy applied)',
                            'PATIENT'
                        );
                    }

                    $this->db->where('appointment_id', $appt_id)->update('appointment', array(
                        'appointment_status' => '2',
                        'status'             => '2',
                        'payment_status'     => ($refund_amount > 0) ? 'REFUNDED' : $app['payment_status'],
                        'cancel_date'        => date('Y-m-d H:i:s'),
                        'cancel_by'          => 'U',
                        'cancel_reason'      => $reason
                    ));

                    $msg = 'Appointment #' . $appt_id . ' has been cancelled successfully.';
                    if ($res && !empty($res['message'])) {
                        $msg .= ' ' . $res['message'];
                    } else if ($refund_amount <= 0) {
                        $msg .= ' Cancellation time window has expired; no refund credited as per policy.';
                    }

                    echo json_encode(array(
                        'status'         => 'success',
                        'refund_ref'     => $res ? ($res['refund_ref'] ?? '') : '',
                        'refund_amount'  => $refund_amount,
                        'refund_percent' => $refund_percent,
                        'message'        => $msg
                    ));
                    return;
                } else {
                    // Unpaid appointment cancellation
                    $this->db->where('appointment_id', $appt_id)->update('appointment', array(
                        'appointment_status' => '2',
                        'status'             => '2',
                        'cancel_date'        => date('Y-m-d H:i:s'),
                        'cancel_by'          => 'U',
                        'cancel_reason'      => $reason
                    ));

                    echo json_encode(array(
                        'status'  => 'success',
                        'message' => 'Appointment #' . $appt_id . ' has been cancelled successfully.'
                    ));
                    return;
                }
            }
        }

        // 3. Fallback: Lookup in path_book table
        $booking_id = null;
        if (stripos($order_ref, 'LAB-') === 0 || stripos($order_ref, 'BOOK-') === 0) {
            $booking_id = preg_replace('/[^0-9]/', '', $order_ref);
        }

        if ($booking_id) {
            $lb = $this->db->get_where('path_book', array('booking_id' => $booking_id))->row_array();
            if ($lb) {
                if ($lb['user_id'] != $userId && !$this->session->userdata('adminuserid')) {
                    echo json_encode(array('status' => 'error', 'message' => 'Unauthorized lab booking access.'));
                    return;
                }

                if ($lb['status'] === 'CANCELLED' || $lb['order_stage'] === 'CANCELLED') {
                    echo json_encode(array('status' => 'error', 'message' => 'Lab order #' . $booking_id . ' is already cancelled.'));
                    return;
                }

                $is_paid = ($lb['payment_status'] == '1' || strtoupper($lb['payment_status']) === 'PAID');
                $amount  = floatval(!empty($lb['total_amount']) ? $lb['total_amount'] : 0);

                if ($is_paid && $amount > 0) {
                    $res = $this->Refund_model->create_refund(
                        'LAB-' . $booking_id,
                        $userId,
                        $amount,
                        'WALLET',
                        $reason,
                        'PATIENT'
                    );

                    $this->db->where('booking_id', $booking_id)->update('path_book', array(
                        'status'         => 'CANCELLED',
                        'order_stage'    => 'CANCELLED',
                        'payment_status' => 'REFUNDED',
                        'cancel_date'    => date('Y-m-d H:i:s')
                    ));

                    echo json_encode(array(
                        'status'         => 'success',
                        'refund_ref'     => $res ? ($res['refund_ref'] ?? '') : '',
                        'refund_amount'  => $amount,
                        'refund_percent' => 100,
                        'message'        => 'Lab order #' . $booking_id . ' cancelled successfully. ' . ($res['message'] ?? '')
                    ));
                    return;
                } else {
                    $this->db->where('booking_id', $booking_id)->update('path_book', array(
                        'status'      => 'CANCELLED',
                        'order_stage' => 'CANCELLED',
                        'cancel_date' => date('Y-m-d H:i:s')
                    ));

                    echo json_encode(array(
                        'status'  => 'success',
                        'message' => 'Lab order #' . $booking_id . ' has been cancelled successfully.'
                    ));
                    return;
                }
            }
        }

        echo json_encode(array('status' => 'error', 'message' => 'Order or appointment not found.'));
        return;
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
