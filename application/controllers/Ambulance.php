<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Ambulance extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model("Ambulance_model");
        $this->load->library("session");
        $this->load->helper(["url", "html", "form"]);
    }

    /**
     * Resolve Current Logged-in Patient User ID
     */
    private function _get_auth_user_id() {
        return $this->session->userdata('USERID')
            ?: $this->session->userdata('userid')
            ?: $this->session->userdata('WEB_UID')
            ?: $this->session->userdata('user_id')
            ?: null;
    }

    /**
     * Resolve Current Logged-in Patient Profile
     */
    private function _get_auth_user_data() {
        $userId = $this->_get_auth_user_id();
        if ($userId) {
            $user = $this->db->get_where('userlogin', ['USERID' => $userId])->row_array();
            if ($user) {
                return $user;
            }
        }
        return [
            'USERID' => 0,
            'NAME'   => $this->session->userdata('username') ?: $this->session->userdata('name') ?: '',
            'FNAME'  => $this->session->userdata('username') ?: '',
            'LNAME'  => '',
            'MOBILE' => $this->session->userdata('mobile') ?: '',
            'EMAIL'  => $this->session->userdata('email') ?: $this->session->userdata('useremail') ?: ''
        ];
    }

    /**
     * Ambulance Fleet & SOS Main Landing
     */
    public function index() {
        $userId = $this->_get_auth_user_id();
        $user   = $this->_get_auth_user_data();

        $data["page_title"]       = "24/7 Rapid Ambulance & Emergency SOS - Upchar";
        $data["service_types"]    = $this->Ambulance_model->get_service_types();
        $data["categories"]       = $this->Ambulance_model->get_categories();
        $data["providers"]        = $this->Ambulance_model->get_provider_count();
        $data["user"]             = $user;
        $data["user_id"]          = $userId;
        $data["hospitals_list"]   = $this->Ambulance_model->get_hospitals_list(20);
        $data["active_booking"]   = $userId ? $this->Ambulance_model->get_active_or_recent_booking($userId) : null;
        $data["patient_name"]     = trim(($user['FNAME'] ?? '') . ' ' . ($user['LNAME'] ?? '')) ?: ($user['NAME'] ?? 'Valued Patient');

        $this->load->view("includes/header", $data);
        $this->load->view("ambulance/index", $data);
        $this->load->view("includes/footer");
    }

    /**
     * Emergency 1-Tap SOS Dispatch Page
     */
    public function sos() {
        $userId = $this->_get_auth_user_id();
        $user   = $this->_get_auth_user_data();

        $data["page_title"]        = "Emergency SOS Ambulance Dispatch - Upchar";
        $data["user"]              = $user;
        $data["user_id"]           = $userId;
        $data["patient_name"]      = trim(($user['FNAME'] ?? '') . ' ' . ($user['LNAME'] ?? '')) ?: ($user['NAME'] ?? '');
        $data["patient_mobile"]    = $user['MOBILE'] ?? '';
        $data["categories"]        = $this->Ambulance_model->get_categories();
        $data["hospitals_list"]    = $this->Ambulance_model->get_hospitals_list(40);
        $data["active_booking"]    = $userId ? $this->Ambulance_model->get_active_or_recent_booking($userId) : null;
        $data["selected_category"] = strtoupper(trim($this->input->get('category', TRUE) ?: 'ALS'));
        $data["param_pickup"]      = trim($this->input->get('pickup', TRUE) ?: '');
        $data["param_drop"]        = trim($this->input->get('drop', TRUE) ?: '');
        $data["param_dist"]        = max(1.0, floatval($this->input->get('dist', TRUE) ?: 8.0));

        $this->load->view("includes/header", $data);
        $this->load->view("ambulance/sos", $data);
        $this->load->view("includes/footer");
    }

    /**
     * Direct Booking Route (Seamlessly connects patient account)
     */
    public function book() {
        $userId = $this->_get_auth_user_id();
        if ($userId) {
            redirect(base_url('myappointments#ambulance'));
        } else {
            redirect(base_url('ambulance/sos'));
        }
    }

    /**
     * Live GPS Tracking & Trip Telemetry
     */
    public function tracking() {
        $ref    = trim($this->input->get('ref', TRUE) ?: $this->input->post('ref', TRUE) ?: '');
        $userId = $this->_get_auth_user_id();

        if (empty($ref)) {
            $ref = $this->session->userdata('last_ambulance_ref') ?: '';
        }

        $booking = null;
        if (!empty($ref)) {
            $booking = $this->Ambulance_model->get_booking_by_code($ref);
        } elseif ($userId) {
            // Check if user has an active booking
            $booking = $this->Ambulance_model->get_active_or_recent_booking($userId);
            if (!$booking) {
                // Get most recent booking
                $userBookings = $this->Ambulance_model->get_user_ambulance_bookings($userId);
                if (!empty($userBookings)) {
                    $booking = $userBookings[0];
                }
            }
        }

        $data["page_title"]    = "Live Ambulance Tracking - Upchar Emergency Response";
        $data["ref"]           = $ref ?: ($booking['booking_code'] ?? '');
        $data["booking"]       = $booking;
        $data["user_id"]       = $userId;
        $data["user"]          = $this->_get_auth_user_data();

        $this->load->view("includes/header", $data);
        $this->load->view("ambulance/tracking", $data);
        $this->load->view("includes/footer");
    }

    /**
     * AJAX Endpoint: Create Real Ambulance Booking
     */
    public function create_booking() {
        $this->output->set_content_type("application/json");

        if (strtolower($this->input->server('REQUEST_METHOD')) !== 'post') {
            echo json_encode(["status" => "error", "message" => "Invalid request method."]);
            return;
        }

        $userId = $this->_get_auth_user_id();
        $user   = $this->_get_auth_user_data();

        $patientName  = trim($this->input->post('patient_name', TRUE) ?: ($user['FNAME'] . ' ' . $user['LNAME']));
        $mobile       = trim($this->input->post('patient_mobile', TRUE) ?: ($user['MOBILE'] ?? ''));
        $pickupAddr   = trim($this->input->post('pickup_address', TRUE) ?: '');
        $pickupLat    = floatval($this->input->post('pickup_lat', TRUE) ?: 25.3176);
        $pickupLng    = floatval($this->input->post('pickup_lng', TRUE) ?: 82.9739);
        $category     = strtoupper(trim($this->input->post('category', TRUE) ?: 'ALS'));
        $hospitalId   = intval($this->input->post('hospital_id', TRUE) ?: 0);
        $dropAddr     = trim($this->input->post('drop_address', TRUE) ?: '');
        $distanceKm   = floatval($this->input->post('distance_km', TRUE) ?: 8.0);
        $notes        = trim($this->input->post('medical_notes', TRUE) ?: '');

        if (empty($pickupAddr)) {
            echo json_encode(["status" => "error", "message" => "Please specify emergency pickup address or allow GPS detection."]);
            return;
        }

        if (empty($mobile) && !empty($user['MOBILE'])) {
            $mobile = $user['MOBILE'];
        }

        $params = [
            'user_id'        => $userId ?: 0,
            'patient_name'   => $patientName ?: 'Emergency Patient',
            'patient_mobile' => $mobile,
            'category'       => $category,
            'pickup_address' => $pickupAddr,
            'pickup_lat'     => $pickupLat,
            'pickup_lng'     => $pickupLng,
            'hospital_id'    => $hospitalId > 0 ? $hospitalId : null,
            'drop_address'   => $dropAddr,
            'distance_km'    => $distanceKm,
            'medical_notes'  => $notes
        ];

        $res = $this->Ambulance_model->create_booking($params);
        if (!empty($res['booking_code'])) {
            $this->session->set_userdata('last_ambulance_ref', $res['booking_code']);
        }
        echo json_encode($res);
    }

    /**
     * AJAX Endpoint: Cancel Booking
     */
    public function cancel_booking() {
        $this->output->set_content_type("application/json");

        if (strtolower($this->input->server('REQUEST_METHOD')) !== 'post') {
            echo json_encode(["status" => "error", "message" => "Invalid request method."]);
            return;
        }

        $bookingRef = trim($this->input->post('booking_code', TRUE) ?: $this->input->post('booking_id', TRUE) ?: '');
        $reason     = trim($this->input->post('reason', TRUE) ?: 'Cancelled by patient');
        $userId     = $this->_get_auth_user_id();

        if (empty($bookingRef)) {
            echo json_encode(["status" => "error", "message" => "Booking reference required."]);
            return;
        }

        $res = $this->Ambulance_model->cancel_booking($bookingRef, $userId, $reason);
        echo json_encode($res);
    }

    /**
     * AJAX Endpoint: Real-time Live Tracking Telemetry
     */
    public function tracking_api($ref = '') {
        $this->output->set_content_type("application/json");
        $code = trim($ref ?: $this->input->get('ref', TRUE) ?: '');
        if (empty($code)) {
            echo json_encode(["status" => "error", "message" => "Booking code required."]);
            return;
        }

        $data = $this->Ambulance_model->get_telemetry($code);
        echo json_encode($data);
    }

    /**
     * AJAX Endpoint: Get User Bookings List
     */
    public function my_bookings() {
        $this->output->set_content_type("application/json");
        $userId = $this->_get_auth_user_id();
        if (!$userId) {
            echo json_encode(["status" => "error", "message" => "User not authenticated."]);
            return;
        }

        $bookings = $this->Ambulance_model->get_user_ambulance_bookings($userId);
        echo json_encode(["status" => "success", "data" => $bookings]);
    }

    /**
     * AJAX Endpoint: Nearby Hospitals List
     */
    public function hospitals() {
        $this->output->set_content_type("application/json");
        $hospitals = $this->Ambulance_model->get_hospitals_list(50);
        echo json_encode(["status" => "success", "data" => $hospitals]);
    }
}
