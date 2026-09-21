<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pathology extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->helper(array('url', 'html', 'form', 'security', 'settings'));
        $this->load->database();
    }

    /**
     * Main Pathology Labs & Test Catalog View - Unified to mytest
     */
    public function index() {
        $qs = $this->input->server('QUERY_STRING');
        redirect('mytest' . ($qs ? '?' . $qs : ''));
    }


    /**
     * AJAX Booking Endpoint for Pathology Test / Home Collection
     */
    public function quick_book() {
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
            return;
        }

        $test_id        = intval($this->input->post('test_id'));
        $lab_id         = intval($this->input->post('lab_id'));
        $patient_name   = trim($this->input->post('patient_name', TRUE));
        $patient_mobile = trim($this->input->post('patient_mobile', TRUE));
        $patient_email  = trim($this->input->post('patient_email', TRUE));
        $booking_date   = trim($this->input->post('booking_date', TRUE)) ?: date('Y-m-d');
        $time_slot      = trim($this->input->post('time_slot', TRUE)) ?: 'Morning (07:00 AM - 11:00 AM)';
        $visit_type     = trim($this->input->post('visit_type', TRUE)) ?: 'HOME_COLLECTION'; // 'HOME_COLLECTION' or 'VISIT_LAB'
        $patient_address= trim($this->input->post('patient_address', TRUE));

        if (empty($patient_name) || empty($patient_mobile)) {
            echo json_encode(['status' => 'error', 'message' => 'Please provide your full name and mobile number.']);
            return;
        }

        // Fetch Test Details
        $test = $this->db->where('test_id', $test_id)->get('pathtest')->row();
        $test_name = $test ? $test->test_name : 'Diagnostic Blood Checkup';
        $test_amount = $test ? floatval($test->amount) : 350.00;
        $short_name = $test ? $test->short_name : 'CBC';

        if (!$lab_id && $test) {
            $lab_id = $test->path_id;
        }

        $lab = $this->db->where('id', $lab_id)->get('pathlab')->row();
        $lab_name = $lab ? $lab->name : 'Upchar Central Diagnostic Lab';

        // Insert into path_book
        $book_data = [
            'patient_name'   => $patient_name,
            'patient_mobile' => $patient_mobile,
            'patient_email'  => $patient_email,
            'pathlab_id'     => strval($lab_id),
            'total_amount'   => $test_amount,
            'payment_mode'   => 'COD',
            'payment_status' => '0', // 0 = Pending / Pay on Collection
            'book_date'      => date('Y-m-d H:i:s', strtotime($booking_date . ' ' . date('H:i:s'))),
            'status'         => '1'  // 1 = Active / Confirmed
        ];

        $this->db->insert('path_book', $book_data);
        $booking_id = $this->db->insert_id();

        // Insert into path_book_test
        if ($booking_id) {
            $test_item = [
                'booking_id' => $booking_id,
                'pathlab_id' => strval($lab_id),
                'test_id'    => strval($test_id),
                'test_name'  => $test_name,
                'short_name' => $short_name,
                'amount'     => intval($test_amount),
                'status'     => '1'
            ];
            $this->db->insert('path_book_test', $test_item);

            // Optional SMS/Email Dispatch
            if (!empty($patient_email)) {
                $this->load->library('azad_lib');
                $email_subj = "Lab Test Booking Confirmed [#UPC-LAB-{$booking_id}] - Upchar Healthcare";
                $email_body = "Dear {$patient_name},<br><br>"
                            . "Your diagnostic test booking has been successfully scheduled.<br><br>"
                            . "<b>Booking Reference:</b> #UPC-LAB-{$booking_id}<br>"
                            . "<b>Test Name:</b> {$test_name}<br>"
                            . "<b>Diagnostic Center:</b> {$lab_name}<br>"
                            . "<b>Scheduled Date:</b> {$booking_date} ({$time_slot})<br>"
                            . "<b>Collection Type:</b> " . ($visit_type === 'HOME_COLLECTION' ? 'Doorstep Home Sample Collection' : 'Visit Lab') . "<br>"
                            . "<b>Payable Amount:</b> ₹" . number_format($test_amount, 2) . " (Pay on Sample Collection / Cash/UPI)<br><br>"
                            . "Our phlebotomist / support executive will contact you prior to sample collection.<br><br>"
                            . "Warm regards,<br><b>Upchar Healthcare Diagnostics</b>";

                @$this->azad_lib->sendMail($patient_email, $email_subj, $email_body);
            }

            echo json_encode([
                'status'        => 'success',
                'booking_id'    => $booking_id,
                'reference_no'  => "UPC-LAB-" . str_pad($booking_id, 5, '0', STR_PAD_LEFT),
                'test_name'     => $test_name,
                'lab_name'      => $lab_name,
                'amount'        => $test_amount,
                'booking_date'  => $booking_date,
                'time_slot'     => $time_slot,
                'visit_type'    => ($visit_type === 'HOME_COLLECTION' ? 'Home Sample Collection' : 'Visit Diagnostic Center'),
                'message'       => "Booking successfully confirmed! Reference ID: #UPC-LAB-" . str_pad($booking_id, 5, '0', STR_PAD_LEFT)
            ]);
            return;
        }

        echo json_encode(['status' => 'error', 'message' => 'Failed to save booking. Please try again or call support.']);
    }
}
