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
     * Main Pathology Labs & Test Catalog View
     */
    public function index() {
        // Capture Search & Filter Inputs
        $selected_city     = $this->input->get('city', TRUE);
        $selected_lab      = $this->input->get('lab_id', TRUE);
        $selected_category = $this->input->get('category', TRUE);
        $keyword           = trim($this->input->get('keyword', TRUE));
        $active_tab        = $this->input->get('tab', TRUE) ?: 'labs'; // 'labs', 'tests', 'packages'

        // 1. Fetch Master Dropdowns & Filters
        $data['cities'] = $this->db->select('c.id, c.name, COUNT(p.id) as lab_count')
                                   ->from('master_city c')
                                   ->join('pathlab p', 'p.city = c.id AND p.status = "1"', 'left')
                                   ->where('c.status', '1')
                                   ->group_by('c.id')
                                   ->order_by('c.name', 'ASC')
                                   ->get()
                                   ->result();

        $data['categories'] = $this->db->select('pc.category_id, pc.category_name, COUNT(pt.test_id) as test_count')
                                       ->from('path_category pc')
                                       ->join('pathtest pt', 'pt.category_id = pc.category_id AND pt.status = "1"', 'left')
                                       ->where('pc.status', '1')
                                       ->group_by('pc.category_id')
                                       ->order_by('pc.category_name', 'ASC')
                                       ->get()
                                       ->result();

        $data['labs_dropdown'] = $this->db->order_by('name', 'ASC')
                                          ->where('status', '1')
                                          ->get('pathlab')
                                          ->result();

        // 2. Fetch Pathology Labs with Nested Tests & Stats
        $this->db->select('p.*, c.name as city_name');
        $this->db->from('pathlab p');
        $this->db->join('master_city c', 'c.id = p.city', 'left');
        $this->db->where('p.status', '1');

        if (!empty($selected_city)) {
            $this->db->where('p.city', intval($selected_city));
        }

        if (!empty($selected_lab)) {
            $this->db->where('p.id', intval($selected_lab));
        }

        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('p.name', $keyword);
            $this->db->or_like('p.address', $keyword);
            $this->db->or_like('p.location', $keyword);
            $this->db->or_like('p.tag', $keyword);
            $this->db->group_end();
        }

        $this->db->order_by('p.id', 'ASC');
        $pathologies = $this->db->get()->result();

        // Attach top tests and starting prices to each lab
        foreach ($pathologies as $lab) {
            $lab->tests = $this->db->select('pt.*, pc.category_name')
                                   ->from('pathtest pt')
                                   ->join('path_category pc', 'pc.category_id = pt.category_id', 'left')
                                   ->where('pt.path_id', $lab->id)
                                   ->where('pt.status', '1')
                                   ->order_by('pt.amount', 'ASC')
                                   ->get()
                                   ->result();

            // Calculate starting price
            $min_price = 0;
            if (!empty($lab->tests)) {
                $prices = array_column($lab->tests, 'amount');
                $min_price = min(array_map('floatval', $prices));
            }
            $lab->starting_price = $min_price > 0 ? $min_price : 199;
            $lab->total_test_count = count($lab->tests);
        }

        // 3. Fetch All Individual Diagnostic Tests (for Test Catalog Tab)
        $this->db->select('pt.*, pc.category_name, pl.name as lab_name, pl.city as lab_city_id, c.name as city_name, pl.location as lab_location');
        $this->db->from('pathtest pt');
        $this->db->join('path_category pc', 'pc.category_id = pt.category_id', 'left');
        $this->db->join('pathlab pl', 'pl.id = pt.path_id', 'left');
        $this->db->join('master_city c', 'c.id = pl.city', 'left');
        $this->db->where('pt.status', '1');

        if (!empty($selected_city)) {
            $this->db->where('pl.city', intval($selected_city));
        }
        if (!empty($selected_category)) {
            $this->db->where('pt.category_id', intval($selected_category));
        }
        if (!empty($selected_lab)) {
            $this->db->where('pt.path_id', intval($selected_lab));
        }
        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('pt.test_name', $keyword);
            $this->db->or_like('pt.short_name', $keyword);
            $this->db->or_like('pt.code', $keyword);
            $this->db->or_like('pt.sub_category', $keyword);
            $this->db->or_like('pc.category_name', $keyword);
            $this->db->or_like('pl.name', $keyword);
            $this->db->group_end();
        }

        $this->db->order_by('pt.category_id', 'ASC');
        $this->db->order_by('pt.amount', 'ASC');
        $all_tests = $this->db->get()->result();

        // 4. Fetch Health Packages (Category ID 10 or test_name like 'package' or 'profile')
        $packages = array_filter($all_tests, function($t) {
            return ($t->category_id == 10 || stripos($t->test_name, 'Package') !== false || stripos($t->test_name, 'Profile') !== false || stripos($t->test_name, 'Shield') !== false);
        });

        // Pass Data to View
        $data['pathologies']         = $pathologies;
        $data['all_tests']           = $all_tests;
        $data['packages']            = array_values($packages);
        $data['selected_city']       = $selected_city;
        $data['selected_lab']        = $selected_lab;
        $data['selected_category']   = $selected_category;
        $data['keyword']             = $keyword;
        $data['active_tab']          = $active_tab;
        $data['total_labs_count']    = count($pathologies);
        $data['total_tests_count']   = count($all_tests);
        $data['total_packages_count']= count($packages);

        $this->load->view('pathology_list', $data);
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
