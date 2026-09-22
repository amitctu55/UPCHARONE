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

    /**
     * Resolve authenticated user data (ID, Mobile, Email)
     */
    private function _get_current_user() {
        $uid = $this->session->userdata('USERID') ?:
               $this->session->userdata('userid') ?:
               $this->session->userdata('WEB_UID') ?:
               $this->session->userdata('user_id');

        $userRow = null;
        if ($uid) {
            $userRow = $this->db->get_where('userlogin', array('USERID' => $uid))->row_array();
        }

        if (!$userRow) {
            $email = $this->session->userdata('useremail') ?: $this->session->userdata('email');
            if ($email) {
                $userRow = $this->db->get_where('userlogin', array('EMAIL' => $email))->row_array();
            }
        }

        if (!$userRow) {
            $mob = $this->session->userdata('mobile') ?: $this->session->userdata('usermobile') ?: $this->session->userdata('username');
            if ($mob) {
                $userRow = $this->db->group_start()
                                    ->where('MOBILE', $mob)
                                    ->or_where('EMAIL', $mob)
                                    ->group_end()
                                    ->get('userlogin')->row_array();
            }
        }

        if ($userRow) {
            return array(
                'id'     => intval($userRow['USERID']),
                'name'   => trim($userRow['FNAME'] . ' ' . $userRow['LNAME']) ?: $userRow['FNAME'],
                'mobile' => $userRow['MOBILE'],
                'email'  => $userRow['EMAIL']
            );
        }

        if ($this->session->userdata('adminuserid')) {
            return array(
                'id'     => intval($this->session->userdata('adminuserid')),
                'name'   => 'Administrator',
                'mobile' => '',
                'email'  => ''
            );
        }

        return null;
    }

    /**
     * Check if a record belongs to the active user (by user_id, mobile, or email)
     */
    private function _is_authorized($recordUserId, $recordMobile, $recordEmail, $currentUser) {
        if ($this->session->userdata('adminuserid')) {
            return true;
        }

        if (empty($currentUser) || empty($currentUser['id'])) {
            return false;
        }

        // Direct user ID match
        if (!empty($recordUserId) && intval($recordUserId) === intval($currentUser['id'])) {
            return true;
        }

        // Mobile match (exact or last 10 digits)
        if (!empty($recordMobile) && !empty($currentUser['mobile'])) {
            $cleanRecMob  = preg_replace('/[^0-9]/', '', $recordMobile);
            $cleanUserMob = preg_replace('/[^0-9]/', '', $currentUser['mobile']);
            if (strlen($cleanRecMob) > 10)  $cleanRecMob  = substr($cleanRecMob, -10);
            if (strlen($cleanUserMob) > 10) $cleanUserMob = substr($cleanUserMob, -10);

            if (!empty($cleanRecMob) && $cleanRecMob === $cleanUserMob) {
                return true;
            }
        }

        // Email match
        if (!empty($recordEmail) && !empty($currentUser['email'])) {
            if (strtolower(trim($recordEmail)) === strtolower(trim($currentUser['email']))) {
                return true;
            }
        }

        return false;
    }

    /**
     * POST: Initiate a Refund or Cancellation for an Order / Appointment / Lab Booking
     */
    public function initiate() {
        header('Content-Type: application/json; charset=utf-8');

        $currentUser = $this->_get_current_user();
        if (!$currentUser) {
            echo json_encode(array('status' => 'error', 'message' => 'User not authenticated. Please log in to cancel bookings.'));
            return;
        }

        $userId    = $currentUser['id'];
        $order_ref = trim($this->input->post('order_ref'));
        $reason    = trim($this->input->post('reason')) ?: 'Patient requested cancellation';
        $refund_to = strtoupper(trim($this->input->post('refund_to') ?: 'WALLET')); // WALLET (instant) or GATEWAY

        if (empty($order_ref)) {
            echo json_encode(array('status' => 'error', 'message' => 'Order or appointment reference is required.'));
            return;
        }

        // ----------------------------------------------------
        // 1. If order_ref represents an APPOINTMENT (e.g. APPT-628 or 628)
        // ----------------------------------------------------
        $appt_id = null;
        if (stripos($order_ref, 'APPT-') === 0 || stripos($order_ref, 'APPT_') === 0 || (is_numeric($order_ref) && strlen($order_ref) <= 8)) {
            $appt_id = intval(preg_replace('/[^0-9]/', '', $order_ref));
        }

        if ($appt_id) {
            $app = $this->db->get_where('appointment', array('appointment_id' => $appt_id))->row_array();
            if ($app) {
                // Verify authorization across ID, mobile and email
                if (!$this->_is_authorized($app['user_id'], $app['appointment_mobile'], $app['appointment_email'], $currentUser)) {
                    echo json_encode(array('status' => 'error', 'message' => 'Unauthorized access. This appointment does not match your patient profile.'));
                    return;
                }

                // Check if already cancelled
                if ($app['status'] == '2' || $app['appointment_status'] == '2' || strtoupper($app['payment_status']) === 'REFUNDED') {
                    echo json_encode(array('status' => 'error', 'message' => 'Appointment #' . $appt_id . ' is already cancelled.'));
                    return;
                }

                // Check for linked gateway payment order
                $order = $this->db->where('purpose', 'APPOINTMENT')
                                  ->where('reference_id', $appt_id)
                                  ->order_by('id', 'DESC')
                                  ->get('razorpay_orders')
                                  ->row_array();

                $pay_status = strtoupper($app['payment_status'] ?: 'UNPAID');
                $is_paid    = ($pay_status === 'PAID' || $pay_status === 'DONE' || ($order && $order['status'] === 'PAID'));
                $amount     = floatval(!empty($app['amount']) ? $app['amount'] : (!empty($app['fee']) ? $app['fee'] : ($order ? $order['amount'] : 0)));

                if ($is_paid && $amount > 0) {
                    $app_datetime   = $app['appointment_date'] . ' ' . (!empty($app['from_timing']) ? $app['from_timing'] : (!empty($app['appointment_time']) ? $app['appointment_time'] : '10:00:00'));
                    $refund_percent = $this->Refund_model->calculate_refund_percentage($app_datetime);
                    
                    // If refunding to Upchar Wallet, ensure guaranteed 100% refund for patient satisfaction
                    if ($refund_to === 'WALLET') {
                        $refund_percent = ($refund_percent > 0) ? $refund_percent : 100;
                    }

                    $refund_amount  = round(($amount * ($refund_percent / 100)), 2);

                    $res = null;
                    if ($refund_amount > 0) {
                        $res = $this->Refund_model->create_refund(
                            'APPT-' . $appt_id,
                            $userId,
                            $refund_amount,
                            $refund_to,
                            $reason . ' (' . $refund_percent . '% refund policy applied)',
                            'PATIENT'
                        );
                    }

                    // Update appointment status to cancelled and payment status to REFUNDED
                    $this->db->where('appointment_id', $appt_id)->update('appointment', array(
                        'appointment_status' => '2',
                        'status'             => '2',
                        'payment_status'     => ($refund_amount > 0) ? 'REFUNDED' : $app['payment_status'],
                        'cancel_date'        => date('Y-m-d H:i:s'),
                        'cancel_by'          => 'U',
                        'cancel_reason'      => $reason
                    ));

                    // If linked razorpay order exists, update its status as well
                    if ($order) {
                        $this->Payment_model->update_order_status($order['internal_order_ref'], 'REFUNDED');
                    }

                    $msg = 'Appointment #' . $appt_id . ' has been cancelled successfully.';
                    if ($res && !empty($res['message'])) {
                        $msg .= ' ' . $res['message'];
                    } else if ($refund_amount > 0) {
                        $msg .= ' ₹' . number_format($refund_amount, 2) . ' credited to your Upchar Wallet.';
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
                    // Unpaid / Payment Pending appointment cancellation
                    $this->db->where('appointment_id', $appt_id)->update('appointment', array(
                        'appointment_status' => '2',
                        'status'             => '2',
                        'cancel_date'        => date('Y-m-d H:i:s'),
                        'cancel_by'          => 'U',
                        'cancel_reason'      => $reason
                    ));

                    if ($order) {
                        $this->Payment_model->update_order_status($order['internal_order_ref'], 'FAILED', null, array(
                            'error_reason' => 'Cancelled by patient before payment'
                        ));
                    }

                    echo json_encode(array(
                        'status'  => 'success',
                        'message' => 'Appointment #' . $appt_id . ' has been cancelled successfully.'
                    ));
                    return;
                }
            }
        }

        // ----------------------------------------------------
        // 2. If order_ref represents a LAB BOOKING (e.g. LAB-24 or BOOK-24)
        // ----------------------------------------------------
        $booking_id = null;
        if (stripos($order_ref, 'LAB-') === 0 || stripos($order_ref, 'BOOK-') === 0) {
            $booking_id = intval(preg_replace('/[^0-9]/', '', $order_ref));
        }

        if ($booking_id) {
            $lb = $this->db->get_where('path_book', array('booking_id' => $booking_id))->row_array();
            if ($lb) {
                if (!$this->_is_authorized($lb['user_id'], $lb['patient_mobile'], $lb['patient_email'], $currentUser)) {
                    echo json_encode(array('status' => 'error', 'message' => 'Unauthorized access. This diagnostic booking does not match your patient profile.'));
                    return;
                }

                if ($lb['status'] === 'CANCELLED' || $lb['order_stage'] === 'CANCELLED' || $lb['status'] === '2') {
                    echo json_encode(array('status' => 'error', 'message' => 'Diagnostic order #' . $booking_id . ' is already cancelled.'));
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
                        'status'         => '2',
                        'order_stage'    => 'CANCELLED',
                        'payment_status' => 'REFUNDED',
                        'cancel_date'    => date('Y-m-d H:i:s'),
                        'cancel_by'      => 'U',
                        'cancel_reason'      => $reason
                    ));

                    // Check linked razorpay_order
                    $order = $this->db->where('purpose', 'LAB_TEST')
                                      ->where('reference_id', $booking_id)
                                      ->order_by('id', 'DESC')
                                      ->get('razorpay_orders')
                                      ->row_array();
                    if ($order) {
                        $this->Payment_model->update_order_status($order['internal_order_ref'], 'REFUNDED');
                    }

                    echo json_encode(array(
                        'status'         => 'success',
                        'refund_ref'     => $res ? ($res['refund_ref'] ?? '') : '',
                        'refund_amount'  => $amount,
                        'refund_percent' => 100,
                        'message'        => 'Diagnostic order #' . $booking_id . ' cancelled successfully. ₹' . number_format($amount, 2) . ' refunded to your Upchar Wallet.'
                    ));
                    return;
                } else {
                    $this->db->where('booking_id', $booking_id)->update('path_book', array(
                        'status'        => '2',
                        'order_stage'   => 'CANCELLED',
                        'cancel_date'   => date('Y-m-d H:i:s'),
                        'cancel_by'     => 'U',
                        'cancel_reason' => $reason
                    ));

                    echo json_encode(array(
                        'status'  => 'success',
                        'message' => 'Diagnostic order #' . $booking_id . ' has been cancelled successfully.'
                    ));
                    return;
                }
            }
        }

        // ----------------------------------------------------
        // 3. Fallback: Search razorpay_orders by internal_order_ref
        // ----------------------------------------------------
        $order = $this->Payment_model->get_order_by_ref($order_ref);
        if ($order) {
            $isOrderAuthorized = ($order['user_id'] == $userId || $this->session->userdata('adminuserid'));

            // Check linked record if order user_id doesn't match directly
            if (!$isOrderAuthorized) {
                if ($order['purpose'] === 'APPOINTMENT' && $order['reference_id']) {
                    $linkedApp = $this->db->get_where('appointment', array('appointment_id' => $order['reference_id']))->row_array();
                    if ($linkedApp && $this->_is_authorized($linkedApp['user_id'], $linkedApp['appointment_mobile'], $linkedApp['appointment_email'], $currentUser)) {
                        $isOrderAuthorized = true;
                    }
                } elseif ($order['purpose'] === 'LAB_TEST' && $order['reference_id']) {
                    $linkedLb = $this->db->get_where('path_book', array('booking_id' => $order['reference_id']))->row_array();
                    if ($linkedLb && $this->_is_authorized($linkedLb['user_id'], $linkedLb['patient_mobile'], $linkedLb['patient_email'], $currentUser)) {
                        $isOrderAuthorized = true;
                    }
                }
            }

            if (!$isOrderAuthorized) {
                echo json_encode(array('status' => 'error', 'message' => 'Unauthorized order access.'));
                return;
            }

            if ($order['status'] === 'REFUNDED') {
                echo json_encode(array('status' => 'error', 'message' => 'This order has already been refunded.'));
                return;
            }

            if ($order['status'] !== 'PAID') {
                // If unpaid, cancel the linked appointment cleanly
                if ($order['purpose'] === 'APPOINTMENT' && $order['reference_id']) {
                    $this->db->where('appointment_id', $order['reference_id'])->update('appointment', array(
                        'appointment_status' => '2',
                        'status'             => '2',
                        'cancel_date'        => date('Y-m-d H:i:s'),
                        'cancel_by'          => 'U',
                        'cancel_reason'      => $reason
                    ));
                    $this->Payment_model->update_order_status($order['internal_order_ref'], 'FAILED');
                    echo json_encode(array('status' => 'success', 'message' => 'Appointment #' . $order['reference_id'] . ' has been cancelled successfully.'));
                    return;
                }
                echo json_encode(array('status' => 'error', 'message' => 'Only paid orders can be refunded.'));
                return;
            }

            $original_amount = floatval($order['amount']);
            $refund_percent  = 100;

            if ($order['purpose'] === 'APPOINTMENT' && $order['reference_id']) {
                $app = $this->db->get_where('appointment', array('appointment_id' => $order['reference_id']))->row_array();
                if ($app && !empty($app['appointment_date'])) {
                    $app_datetime = $app['appointment_date'] . ' ' . (!empty($app['from_timing']) ? $app['from_timing'] : '10:00:00');
                    $refund_percent = $this->Refund_model->calculate_refund_percentage($app_datetime);
                    if ($refund_to === 'WALLET') $refund_percent = ($refund_percent > 0) ? $refund_percent : 100;
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

            $this->Payment_model->update_order_status($order['internal_order_ref'], 'REFUNDED');

            if ($order['purpose'] === 'APPOINTMENT' && $order['reference_id']) {
                $this->db->where('appointment_id', $order['reference_id'])->update('appointment', array(
                    'appointment_status' => '2',
                    'status'             => '2',
                    'payment_status'     => ($refund_amount > 0) ? 'REFUNDED' : $order['status'],
                    'cancel_date'        => date('Y-m-d H:i:s'),
                    'cancel_by'          => 'U',
                    'cancel_reason'      => $reason
                ));
            }

            if ($order['purpose'] === 'LAB_TEST' && $order['reference_id']) {
                $this->db->where('booking_id', $order['reference_id'])->update('path_book', array(
                    'status'         => '2',
                    'order_stage'    => 'CANCELLED',
                    'payment_status' => ($refund_amount > 0) ? 'REFUNDED' : 'PAID',
                    'cancel_date'    => date('Y-m-d H:i:s'),
                    'cancel_by'      => 'U',
                    'cancel_reason'  => $reason
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

        echo json_encode(array('status' => 'error', 'message' => 'Booking reference #' . htmlspecialchars($order_ref) . ' not found.'));
    }

    /**
     * GET: Check Refund Status
     */
    public function status($refund_id = 0) {
        header('Content-Type: application/json; charset=utf-8');
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
