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

        $this->load->helper('cookie');
        $ssoCookie = $this->input->cookie('upchar_sso_token');
        $masterUser = null;

        // Check SSO token cookie
        if ($ssoCookie) {
            $this->load->model('Auth_model');
            $payload = $this->Auth_model->verify_sso_token($ssoCookie);
            if ($payload && !empty($payload['sub'])) {
                $masterUser = $this->Auth_model->find_master_user($payload['sub']);
                if ($masterUser && !$uid) {
                    $ciUser = null;
                    if (!empty($masterUser['email'])) {
                        $ciUser = $this->db->get_where('userlogin', ['EMAIL' => $masterUser['email']])->row_array();
                    }
                    if (!$ciUser && !empty($masterUser['mobile'])) {
                        $ciUser = $this->db->get_where('userlogin', ['MOBILE' => $masterUser['mobile']])->row_array();
                    }
                    $sessionUid = $ciUser ? $ciUser['USERID'] : $masterUser['id'];
                    $this->session->set_userdata([
                        'USERID'   => $sessionUid,
                        'userid'   => $sessionUid,
                        'WEB_UID'  => $sessionUid,
                        'username' => $masterUser['name'],
                        'name'     => $masterUser['name'],
                        'email'    => $masterUser['email'],
                        'mobile'   => $masterUser['mobile'],
                        'uuid'     => $masterUser['uuid'],
                        'status'   => $masterUser['status'],
                        'logged_in'=> true,
                    ]);
                    $uid = $sessionUid;
                }
            }
        }

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

        // If userRow found, try to locate linked upchar_users record if not already found
        if ($userRow && !$masterUser) {
            $masterUser = $this->db->group_start()
                                   ->where('email', $userRow['EMAIL'])
                                   ->or_where('mobile', $userRow['MOBILE'])
                                   ->group_end()
                                   ->get('upchar_users')->row_array();
        }

        if ($userRow) {
            return array(
                'id'        => intval($userRow['USERID']),
                'master_id' => $masterUser ? intval($masterUser['id']) : null,
                'name'      => trim($userRow['FNAME'] . ' ' . $userRow['LNAME']) ?: $userRow['FNAME'],
                'mobile'    => $userRow['MOBILE'],
                'email'     => $userRow['EMAIL']
            );
        }

        // Check Unified Master Users table (upchar_users)
        if (!$masterUser && $uid) {
            $masterUser = $this->db->get_where('upchar_users', array('id' => $uid))->row_array();
        }

        $sessionEmail = $this->session->userdata('email') ?: $this->session->userdata('useremail');
        if (!$masterUser && $sessionEmail) {
            $masterUser = $this->db->get_where('upchar_users', array('email' => $sessionEmail))->row_array();
        }

        $sessionMobile = $this->session->userdata('mobile') ?: $this->session->userdata('usermobile');
        if (!$masterUser && $sessionMobile) {
            $masterUser = $this->db->get_where('upchar_users', array('mobile' => $sessionMobile))->row_array();
        }

        if ($masterUser) {
            return array(
                'id'        => intval($masterUser['id']),
                'master_id' => intval($masterUser['id']),
                'name'      => $masterUser['name'],
                'mobile'    => $masterUser['mobile'],
                'email'     => $masterUser['email']
            );
        }

        // Fallback directly from session if logged in
        if ($uid) {
            return array(
                'id'        => intval($uid),
                'master_id' => intval($uid),
                'name'      => $this->session->userdata('name') ?: $this->session->userdata('username') ?: 'Valued Patient',
                'mobile'    => $sessionMobile ?: '',
                'email'     => $sessionEmail ?: ''
            );
        }

        if ($this->session->userdata('adminuserid')) {
            return array(
                'id'        => intval($this->session->userdata('adminuserid')),
                'master_id' => null,
                'name'      => 'Administrator',
                'mobile'    => '',
                'email'     => ''
            );
        }

        return null;
    }

    /**
     * Check if a record belongs to the active user (by user_id, master_id, mobile, or email)
     */
    private function _is_authorized($recordUserId, $recordMobile, $recordEmail, $currentUser) {
        if ($this->session->userdata('adminuserid')) {
            return true;
        }

        if (empty($currentUser) || (empty($currentUser['id']) && empty($currentUser['master_id']))) {
            return false;
        }

        $recId = !empty($recordUserId) ? intval($recordUserId) : 0;

        // 1. Direct ID matches
        if ($recId > 0) {
            if (!empty($currentUser['id']) && $recId === intval($currentUser['id'])) {
                return true;
            }
            if (!empty($currentUser['master_id']) && $recId === intval($currentUser['master_id'])) {
                return true;
            }
            $sessId = $this->session->userdata('USERID') ?: $this->session->userdata('userid') ?: $this->session->userdata('user_id');
            if (!empty($sessId) && $recId === intval($sessId)) {
                return true;
            }

            // 2. Cross-reference record user ID via upchar_users table
            $recMaster = $this->db->get_where('upchar_users', array('id' => $recId))->row_array();
            if ($recMaster) {
                if (!empty($currentUser['email']) && !empty($recMaster['email']) && strtolower(trim($currentUser['email'])) === strtolower(trim($recMaster['email']))) {
                    return true;
                }
                if (!empty($currentUser['mobile']) && !empty($recMaster['mobile'])) {
                    $u1 = substr(preg_replace('/[^0-9]/', '', $currentUser['mobile']), -10);
                    $u2 = substr(preg_replace('/[^0-9]/', '', $recMaster['mobile']), -10);
                    if (!empty($u1) && $u1 === $u2) {
                        return true;
                    }
                }
            }

            // 3. Cross-reference record user ID via userlogin table
            $recLegacy = $this->db->get_where('userlogin', array('USERID' => $recId))->row_array();
            if ($recLegacy) {
                if (!empty($currentUser['email']) && !empty($recLegacy['EMAIL']) && strtolower(trim($currentUser['email'])) === strtolower(trim($recLegacy['EMAIL']))) {
                    return true;
                }
                if (!empty($currentUser['mobile']) && !empty($recLegacy['MOBILE'])) {
                    $u1 = substr(preg_replace('/[^0-9]/', '', $currentUser['mobile']), -10);
                    $u2 = substr(preg_replace('/[^0-9]/', '', $recLegacy['MOBILE']), -10);
                    if (!empty($u1) && $u1 === $u2) {
                        return true;
                    }
                }
            }
        }

        // 4. Mobile match (exact or last 10 digits)
        if (!empty($recordMobile) && !empty($currentUser['mobile'])) {
            $cleanRecMob  = preg_replace('/[^0-9]/', '', $recordMobile);
            $cleanUserMob = preg_replace('/[^0-9]/', '', $currentUser['mobile']);
            if (strlen($cleanRecMob) > 10)  $cleanRecMob  = substr($cleanRecMob, -10);
            if (strlen($cleanUserMob) > 10) $cleanUserMob = substr($cleanUserMob, -10);

            if (!empty($cleanRecMob) && $cleanRecMob === $cleanUserMob) {
                return true;
            }
        }

        // 5. Email match
        if (!empty($recordEmail) && !empty($currentUser['email'])) {
            if (strtolower(trim($recordEmail)) === strtolower(trim($currentUser['email']))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Resolve facility cancellation cutoff policy (in hours)
     */
    private function _get_facility_cancellation_hours($institute_id, $institution_type) {
        $institute_id = intval($institute_id);
        if ($institute_id <= 0) {
            return array('hours' => 3, 'policy_text' => 'Cancellations allowed up to 3 hours prior to consultation slot.');
        }

        $table = ($institution_type === 'C') ? 'clinic' : 'hospital';
        if ($this->db->table_exists($table)) {
            $row = $this->db->select('cancellation_hours, cancellation_policy_text')->where('id', $institute_id)->get($table)->row_array();
            if ($row && isset($row['cancellation_hours'])) {
                $hours = max(0, intval($row['cancellation_hours']));
                $text = !empty($row['cancellation_policy_text']) ? $row['cancellation_policy_text'] : "Cancellations allowed up to {$hours} hours prior to consultation slot.";
                return array('hours' => $hours, 'policy_text' => $text);
            }
        }

        // Check fallback hospital table if not already checked
        if ($table !== 'hospital' && $this->db->table_exists('hospital')) {
            $row = $this->db->select('cancellation_hours, cancellation_policy_text')->where('id', $institute_id)->get('hospital')->row_array();
            if ($row && isset($row['cancellation_hours'])) {
                $hours = max(0, intval($row['cancellation_hours']));
                $text = !empty($row['cancellation_policy_text']) ? $row['cancellation_policy_text'] : "Cancellations allowed up to {$hours} hours prior to consultation slot.";
                return array('hours' => $hours, 'policy_text' => $text);
            }
        }

        return array('hours' => 3, 'policy_text' => 'Cancellations allowed up to 3 hours prior to consultation slot.');
    }

    /**
     * GET/POST: Calculate real-time cancellation fee & refund quote before confirming
     */
    public function quote() {
        header('Content-Type: application/json; charset=utf-8');

        $currentUser = $this->_get_current_user();
        if (!$currentUser) {
            echo json_encode(array('status' => 'error', 'message' => 'User not authenticated. Please log in.'));
            return;
        }

        $order_ref = trim($this->input->get_post('order_ref'));
        if (empty($order_ref)) {
            echo json_encode(array('status' => 'error', 'message' => 'Order reference is required.'));
            return;
        }

        $appt_id = null;
        if (stripos($order_ref, 'APPT-') === 0 || stripos($order_ref, 'APPT_') === 0 || (is_numeric($order_ref) && strlen($order_ref) <= 8)) {
            $appt_id = intval(preg_replace('/[^0-9]/', '', $order_ref));
        }

        if ($appt_id) {
            $app = $this->db->get_where('appointment', array('appointment_id' => $appt_id))->row_array();
            if (!$app) {
                echo json_encode(array('status' => 'error', 'message' => 'Appointment #' . $appt_id . ' not found.'));
                return;
            }

            if (!$this->_is_authorized($app['user_id'], $app['appointment_mobile'], $app['appointment_email'], $currentUser)) {
                echo json_encode(array('status' => 'error', 'message' => 'Unauthorized access to appointment #' . $appt_id . '.'));
                return;
            }

            if ($app['status'] == '2' || $app['appointment_status'] == '2' || strtoupper(trim($app['payment_status'] ?? '')) === 'REFUNDED') {
                echo json_encode(array('status' => 'error', 'message' => 'Appointment #' . $appt_id . ' is already cancelled.'));
                return;
            }

            // Check if appointment is completed/done
            $is_done = ($app['status'] == '3' || strtoupper(trim($app['status'] ?? '')) === 'COMPLETED' || strtoupper(trim($app['status'] ?? '')) === 'DONE' || ($app['appointment_status'] ?? '') == '3');
            if ($is_done) {
                echo json_encode(array('status' => 'error', 'message' => 'This consultation has already been completed and cannot be cancelled.'));
                return;
            }

            // Check facility cancellation timing policy
            $facilityPolicy = $this->_get_facility_cancellation_hours($app['institute_id'] ?? 0, $app['institution_type'] ?? '');
            $cancel_cutoff_hours = $facilityPolicy['hours'];

            $app_timing = !empty($app['from_timing']) ? $app['from_timing'] : (!empty($app['appointment_time']) ? $app['appointment_time'] : '10:00:00');
            $parsed_slot_time = strtotime($app_timing);
            $slot_time_str = ($parsed_slot_time !== false) ? date('H:i:s', $parsed_slot_time) : '10:00:00';
            $app_timestamp = strtotime($app['appointment_date'] . ' ' . $slot_time_str);
            $diff_hrs = ($app_timestamp - time()) / 3600.0;

            if ($diff_hrs < $cancel_cutoff_hours) {
                if ($app_timestamp < time()) {
                    $msg = 'Appointment slot has already passed. It can no longer be cancelled.';
                } else {
                    $msg = "Cancellations are not permitted within {$cancel_cutoff_hours} hours of the scheduled consultation slot as per the facility policy.";
                }
                echo json_encode(array('status' => 'error', 'message' => $msg));
                return;
            }

            // Linked order check
            $order = $this->db->where('purpose', 'APPOINTMENT')
                              ->where('reference_id', $appt_id)
                              ->order_by('id', 'DESC')
                              ->get('razorpay_orders')
                              ->row_array();

            $pay_status = strtoupper(trim($app['payment_status'] ?: 'UNPAID'));
            $is_paid    = ($pay_status === 'PAID' || $pay_status === 'DONE' || ($order && $order['status'] === 'PAID'));
            $amount     = floatval(!empty($app['amount']) ? $app['amount'] : (!empty($app['fee']) ? $app['fee'] : ($order ? $order['amount'] : 0)));

            $policy_mode = $this->Wallet_model->get_setting('cancellation_policy_mode', 'TIERED');

            if ($is_paid && $amount > 0) {
                $app_datetime      = $app['appointment_date'] . ' ' . (!empty($app['from_timing']) ? $app['from_timing'] : (!empty($app['appointment_time']) ? $app['appointment_time'] : '10:00:00'));
                $refund_percent    = $this->Refund_model->calculate_refund_percentage($app_datetime);
                $deduction_percent = max(0, 100 - $refund_percent);
                $deduction_amount  = round(($amount * ($deduction_percent / 100)), 2);
                $refund_amount     = round($amount - $deduction_amount, 2);

                $policy_text = '';
                if ($policy_mode === 'FLAT') {
                    $policy_text = 'Flat Admin Cancellation Fee (' . $deduction_percent . '%)';
                } else {
                    $app_time = strtotime($app_datetime);
                    $diff_hrs = ($app_time - time()) / 3600;
                    if ($diff_hrs >= 24) {
                        $policy_text = 'Tier 1 (> 24 hrs prior): ' . $deduction_percent . '% cancellation fee';
                    } else if ($diff_hrs >= 12) {
                        $policy_text = 'Tier 2 (12-24 hrs prior): ' . $deduction_percent . '% cancellation fee';
                    } else {
                        $policy_text = 'Tier 3 (< 12 hrs prior): ' . $deduction_percent . '% cancellation fee';
                    }
                }

                echo json_encode(array(
                    'status'            => 'success',
                    'order_ref'         => 'APPT-' . $appt_id,
                    'is_paid'           => true,
                    'gross_amount'      => $amount,
                    'deduction_percent' => $deduction_percent,
                    'deduction_amount'  => $deduction_amount,
                    'refund_amount'     => $refund_amount,
                    'refund_to'         => 'Upchar Wallet (Instant Credit)',
                    'policy_mode'       => $policy_mode,
                    'policy_text'       => $policy_text,
                    'appt_date'         => date('d M Y', strtotime($app['appointment_date'])),
                    'appt_time'         => (!empty($app['from_timing']) ? $app['from_timing'] : 'Scheduled')
                ));
                return;
            } else {
                echo json_encode(array(
                    'status'            => 'success',
                    'order_ref'         => 'APPT-' . $appt_id,
                    'is_paid'           => false,
                    'gross_amount'      => $amount,
                    'deduction_percent' => 0,
                    'deduction_amount'  => 0,
                    'refund_amount'     => 0,
                    'policy_text'       => 'Appointment is unpaid. No cancellation fee will be charged.',
                    'appt_date'         => date('d M Y', strtotime($app['appointment_date'])),
                    'appt_time'         => (!empty($app['from_timing']) ? $app['from_timing'] : 'Scheduled')
                ));
                return;
            }
        }

        // Lab Booking Quote
        $booking_id = null;
        if (stripos($order_ref, 'LAB-') === 0 || stripos($order_ref, 'BOOK-') === 0) {
            $booking_id = intval(preg_replace('/[^0-9]/', '', $order_ref));
        }

        if ($booking_id) {
            $lb = $this->db->get_where('path_book', array('booking_id' => $booking_id))->row_array();
            if ($lb) {
                if (!$this->_is_authorized($lb['user_id'], $lb['patient_mobile'], $lb['patient_email'], $currentUser)) {
                    echo json_encode(array('status' => 'error', 'message' => 'Unauthorized access to diagnostic order #' . $booking_id));
                    return;
                }

                $is_paid = ($lb['payment_status'] == '1' || strtoupper($lb['payment_status']) === 'PAID');
                $amount  = floatval(!empty($lb['total_amount']) ? $lb['total_amount'] : 0);

                echo json_encode(array(
                    'status'            => 'success',
                    'order_ref'         => 'LAB-' . $booking_id,
                    'is_paid'           => $is_paid,
                    'gross_amount'      => $amount,
                    'deduction_percent' => 0,
                    'deduction_amount'  => 0,
                    'refund_amount'     => $is_paid ? $amount : 0,
                    'refund_to'         => 'Upchar Wallet (Instant Credit)',
                    'policy_text'       => 'Diagnostic Test Cancellation (100% Wallet Refund)'
                ));
                return;
            }
        }

        echo json_encode(array('status' => 'error', 'message' => 'Invalid order reference.'));
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

                // Check if appointment is completed/done
                $is_done = ($app['status'] == '3' || strtoupper(trim($app['status'] ?? '')) === 'COMPLETED' || strtoupper(trim($app['status'] ?? '')) === 'DONE' || ($app['appointment_status'] ?? '') == '3');
                if ($is_done) {
                    echo json_encode(array('status' => 'error', 'message' => 'This consultation has already been completed and cannot be cancelled.'));
                    return;
                }

                // Check facility cancellation timing policy
                $facilityPolicy = $this->_get_facility_cancellation_hours($app['institute_id'] ?? 0, $app['institution_type'] ?? '');
                $cancel_cutoff_hours = $facilityPolicy['hours'];

                $app_timing = !empty($app['from_timing']) ? $app['from_timing'] : (!empty($app['appointment_time']) ? $app['appointment_time'] : '10:00:00');
                $parsed_slot_time = strtotime($app_timing);
                $slot_time_str = ($parsed_slot_time !== false) ? date('H:i:s', $parsed_slot_time) : '10:00:00';
                $app_timestamp = strtotime($app['appointment_date'] . ' ' . $slot_time_str);
                $diff_hrs = ($app_timestamp - time()) / 3600.0;

                if ($diff_hrs < $cancel_cutoff_hours) {
                    if ($app_timestamp < time()) {
                        $msg = 'Appointment slot has already passed. It can no longer be cancelled.';
                    } else {
                        $msg = "Cancellations are not permitted within {$cancel_cutoff_hours} hours of the scheduled consultation slot as per the facility policy.";
                    }
                    echo json_encode(array('status' => 'error', 'message' => $msg));
                    return;
                }

                // Beneficiary user who should receive wallet credit
                $beneficiaryUserId = (!empty($app['user_id']) && intval($app['user_id']) > 0) ? intval($app['user_id']) : $userId;

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
                    $app_datetime      = $app['appointment_date'] . ' ' . (!empty($app['from_timing']) ? $app['from_timing'] : (!empty($app['appointment_time']) ? $app['appointment_time'] : '10:00:00'));
                    $refund_percent    = $this->Refund_model->calculate_refund_percentage($app_datetime);
                    $deduction_percent = max(0, 100 - $refund_percent);
                    $deduction_amount  = round(($amount * ($deduction_percent / 100)), 2);
                    $refund_amount     = round($amount - $deduction_amount, 2);

                    $res = null;
                    if ($refund_amount > 0) {
                        $res = $this->Refund_model->create_refund(
                            'APPT-' . $appt_id,
                            $beneficiaryUserId,
                            $refund_amount,
                            $refund_to,
                            $reason . ' (' . $deduction_percent . '% deduction applied)',
                            'PATIENT',
                            $deduction_amount,
                            $deduction_percent
                        );
                    }

                    // Update appointment status to cancelled and payment status to REFUNDED
                    $this->db->where('appointment_id', $appt_id)->update('appointment', array(
                        'appointment_status' => '2',
                        'status'             => '2',
                        'payment_status'     => ($refund_amount > 0) ? 'REFUNDED' : $app['payment_status'],
                        'cancel_date'        => date('Y-m-d H:i:s'),
                        'cancel_by'          => 'U',
                        'cancel_reason'      => $reason . ($deduction_percent > 0 ? " ({$deduction_percent}% cancellation fee: -₹{$deduction_amount}, ₹{$refund_amount} refunded)" : "")
                    ));

                    // If linked razorpay order exists, update its status as well
                    if ($order) {
                        $this->Payment_model->update_order_status($order['internal_order_ref'], 'REFUNDED');
                    }

                    $msg = 'Appointment #' . $appt_id . ' has been cancelled successfully.';
                    if ($refund_amount > 0) {
                        $msg .= ' ₹' . number_format($refund_amount, 2) . ' refunded to your Upchar Wallet.';
                        if ($deduction_percent > 0) {
                            $msg .= ' (' . $deduction_percent . '% cancellation deduction of ₹' . number_format($deduction_amount, 2) . ' applied as per policy).';
                        }
                    }

                    echo json_encode(array(
                        'status'            => 'success',
                        'refund_ref'        => $res ? ($res['refund_ref'] ?? '') : '',
                        'refund_amount'     => $refund_amount,
                        'refund_percent'    => $refund_percent,
                        'deduction_amount'  => $deduction_amount,
                        'deduction_percent' => $deduction_percent,
                        'message'           => $msg
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

                    // Also mark linked sm_order as CANCELLED if exists
                    $this->db->where('ITEM_ID', $appt_id)
                             ->where('ITEM_TYPE', 'A')
                             ->update('sm_order', array('PAYMENT_STATUS' => 'CANCELLED', 'REMARK' => 'Cancelled by patient'));

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
                if ($app) {
                    $is_done = ($app['status'] == '3' || strtoupper(trim($app['status'] ?? '')) === 'COMPLETED' || strtoupper(trim($app['status'] ?? '')) === 'DONE' || ($app['appointment_status'] ?? '') == '3');
                    if ($is_done) {
                        echo json_encode(array('status' => 'error', 'message' => 'This consultation has already been completed and cannot be cancelled.'));
                        return;
                    }

                    $facilityPolicy = $this->_get_facility_cancellation_hours($app['institute_id'] ?? 0, $app['institution_type'] ?? '');
                    $cancel_cutoff_hours = $facilityPolicy['hours'];

                    $app_timing = !empty($app['from_timing']) ? $app['from_timing'] : (!empty($app['appointment_time']) ? $app['appointment_time'] : '10:00:00');
                    $parsed_slot_time = strtotime($app_timing);
                    $slot_time_str = ($parsed_slot_time !== false) ? date('H:i:s', $parsed_slot_time) : '10:00:00';
                    $app_timestamp = strtotime($app['appointment_date'] . ' ' . $slot_time_str);
                    $diff_hrs = ($app_timestamp - time()) / 3600.0;

                    if ($diff_hrs < $cancel_cutoff_hours) {
                        if ($app_timestamp < time()) {
                            $msg = 'Appointment slot has already passed. It can no longer be cancelled.';
                        } else {
                            $msg = "Cancellations are not permitted within {$cancel_cutoff_hours} hours of the scheduled consultation slot as per the facility policy.";
                        }
                        echo json_encode(array('status' => 'error', 'message' => $msg));
                        return;
                    }

                    $app_datetime = $app['appointment_date'] . ' ' . $slot_time_str;
                    $refund_percent = $this->Refund_model->calculate_refund_percentage($app_datetime);
                }
            }

            $deduction_percent = max(0, 100 - $refund_percent);
            $deduction_amount  = round(($original_amount * ($deduction_percent / 100)), 2);
            $refund_amount     = round($original_amount - $deduction_amount, 2);

            $res = null;
            if ($refund_amount > 0) {
                $res = $this->Refund_model->create_refund(
                    $order['internal_order_ref'],
                    $userId,
                    $refund_amount,
                    $refund_to,
                    $reason . ' (' . $deduction_percent . '% deduction applied)',
                    'PATIENT',
                    $deduction_amount,
                    $deduction_percent
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
                    'cancel_reason'      => $reason . ($deduction_percent > 0 ? " ({$deduction_percent}% deduction applied)" : "")
                ));
            }

            if ($order['purpose'] === 'LAB_TEST' && $order['reference_id']) {
                $this->db->where('booking_id', $order['reference_id'])->update('path_book', array(
                    'status'         => '2',
                    'order_stage'    => 'CANCELLED',
                    'payment_status' => ($refund_amount > 0) ? 'REFUNDED' : 'PAID',
                    'cancel_date'    => date('Y-m-d H:i:s'),
                    'cancel_by'      => 'U',
                    'cancel_reason'  => $reason . ($deduction_percent > 0 ? " ({$deduction_percent}% deduction applied)" : "")
                ));
            }

            $success_msg = ($res && !empty($res['message'])) 
                ? $res['message'] 
                : ('Order cancelled successfully' . ($refund_amount > 0 ? '. Refund of ₹' . number_format($refund_amount, 2) . ' processed to wallet' . ($deduction_percent > 0 ? ' (' . $deduction_percent . '% deduction applied).' : '.') : '.'));

            echo json_encode(array(
                'status'            => 'success',
                'refund_ref'        => $res ? ($res['refund_ref'] ?? '') : '',
                'refund_amount'     => $refund_amount,
                'refund_percent'    => $refund_percent,
                'deduction_amount'  => $deduction_amount,
                'deduction_percent' => $deduction_percent,
                'message'           => $success_msg
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
