<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mytest extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->helper(array('url', 'html', 'form', 'security', 'settings'));
        $this->load->database();
        $this->load->library('session');
    }

    /**
     * Main Pathology Tests & Diagnostic Labs Catalog
     */
    public function index() {
        $selected_city     = $this->input->get('city', TRUE) ?: $this->input->get('location', TRUE);
        $keyword           = trim($this->input->get('keyword', TRUE) ?: $this->input->get('pathology_name', TRUE));
        $selected_category = $this->input->get('category', TRUE) ?: $this->input->get('spl', TRUE);
        $active_tab        = $this->input->get('tab', TRUE) ?: 'tests'; // Default to tests catalog tab for mytest

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

        // 2. Fetch Pathology Labs with Nested Tests
        $this->db->select('p.*, c.name as city_name');
        $this->db->from('pathlab p');
        $this->db->join('master_city c', 'c.id = p.city', 'left');
        $this->db->where('p.status', '1');

        if (!empty($selected_city)) {
            $this->db->group_start();
            $this->db->where('p.city', intval($selected_city));
            $this->db->or_like('p.address', $selected_city);
            $this->db->or_like('p.location', $selected_city);
            $this->db->group_end();
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

        foreach ($pathologies as $lab) {
            $lab->tests = $this->db->select('pt.*, pc.category_name')
                                   ->from('pathtest pt')
                                   ->join('path_category pc', 'pc.category_id = pt.category_id', 'left')
                                   ->where('pt.path_id', $lab->id)
                                   ->where('pt.status', '1')
                                   ->order_by('pt.amount', 'ASC')
                                   ->get()
                                   ->result();

            $min_price = 0;
            if (!empty($lab->tests)) {
                $prices = array_column($lab->tests, 'amount');
                $min_price = min(array_map('floatval', $prices));
            }
            $lab->starting_price = $min_price > 0 ? $min_price : 199;
            $lab->total_test_count = count($lab->tests);
        }

        // 3. Fetch All Individual Diagnostic Tests
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

        // 4. Fetch Health Packages
        $packages = array_filter($all_tests, function($t) {
            return ($t->category_id == 10 || stripos($t->test_name, 'Package') !== false || stripos($t->test_name, 'Profile') !== false || stripos($t->test_name, 'Shield') !== false);
        });

        // 5. Current Session Cart
        $cart = $this->session->userdata('path_cart') ?: [];

        $data['pathologies']          = $pathologies;
        $data['all_tests']            = $all_tests;
        $data['packages']             = array_values($packages);
        $data['cart']                 = $cart;
        $data['cart_count']           = count($cart);
        $data['selected_city']        = $selected_city;
        $data['selected_category']    = $selected_category;
        $data['keyword']              = $keyword;
        $data['active_tab']           = $active_tab;
        $data['total_labs_count']     = count($pathologies);
        $data['total_tests_count']    = count($all_tests);
        $data['total_packages_count'] = count($packages);

        $this->load->view('mytest', $data);
    }

    /**
     * AJAX: Add Test to Pathology Cart
     */
    public function add_to_cart() {
        $test_id = intval($this->input->post('test_id'));
        if (!$test_id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid Test ID']);
            return;
        }

        // Fetch Test Details
        $this->db->select('pt.*, pc.category_name, pl.name as lab_name, pl.city as lab_city_id, c.name as city_name');
        $this->db->from('pathtest pt');
        $this->db->join('path_category pc', 'pc.category_id = pt.category_id', 'left');
        $this->db->join('pathlab pl', 'pl.id = pt.path_id', 'left');
        $this->db->join('master_city c', 'c.id = pl.city', 'left');
        $this->db->where('pt.test_id', $test_id);
        $test = $this->db->get()->row();

        if (!$test) {
            echo json_encode(['status' => 'error', 'message' => 'Test not found.']);
            return;
        }

        $cart = $this->session->userdata('path_cart') ?: [];
        $amount = floatval($test->amount);
        $mrp    = round($amount * 1.35);

        $cart[$test_id] = [
            'test_id'     => $test->test_id,
            'test_name'   => $test->test_name,
            'short_name'  => $test->short_name ?: $test->test_name,
            'code'        => $test->code ?: ('UPC-' . $test->test_id),
            'lab_id'      => $test->path_id,
            'lab_name'    => $test->lab_name ?: 'Upchar Diagnostic Lab',
            'city_name'   => $test->city_name ?: 'Partner Network',
            'category'    => $test->category_name ?: 'Diagnostic Test',
            'sample_type' => $test->test_type ?: 'Blood',
            'report_time' => $test->report_day ?: 'Same Day',
            'amount'      => $amount,
            'mrp'         => $mrp,
            'quantity'    => 1
        ];

        $this->session->set_userdata('path_cart', $cart);

        $totals = $this->_calculate_cart_totals($cart);

        echo json_encode([
            'status'     => 'success',
            'message'    => "Added '{$test->test_name}' to cart!",
            'cart_count' => count($cart),
            'subtotal'   => $totals['subtotal'],
            'total_mrp'  => $totals['total_mrp'],
            'savings'    => $totals['savings'],
            'cart_items' => array_values($cart)
        ]);
    }

    /**
     * AJAX: Remove Test from Pathology Cart
     */
    public function remove_from_cart() {
        $test_id = intval($this->input->post('test_id'));
        $cart = $this->session->userdata('path_cart') ?: [];

        if (isset($cart[$test_id])) {
            $name = $cart[$test_id]['test_name'];
            unset($cart[$test_id]);
            $this->session->set_userdata('path_cart', $cart);

            $totals = $this->_calculate_cart_totals($cart);
            echo json_encode([
                'status'     => 'success',
                'message'    => "Removed '{$name}' from cart.",
                'cart_count' => count($cart),
                'subtotal'   => $totals['subtotal'],
                'total_mrp'  => $totals['total_mrp'],
                'savings'    => $totals['savings'],
                'cart_items' => array_values($cart)
            ]);
            return;
        }

        echo json_encode(['status' => 'error', 'message' => 'Item not found in cart.']);
    }

    /**
     * AJAX: Clear entire Pathology Cart
     */
    public function clear_cart() {
        $this->session->unset_userdata('path_cart');
        echo json_encode([
            'status'     => 'success',
            'message'    => 'Cart cleared.',
            'cart_count' => 0,
            'subtotal'   => 0,
            'cart_items' => []
        ]);
    }

    /**
     * AJAX: Get Current Cart Items & Totals
     */
    public function get_cart() {
        $cart = $this->session->userdata('path_cart') ?: [];
        $totals = $this->_calculate_cart_totals($cart);

        echo json_encode([
            'status'     => 'success',
            'cart_count' => count($cart),
            'subtotal'   => $totals['subtotal'],
            'total_mrp'  => $totals['total_mrp'],
            'savings'    => $totals['savings'],
            'cart_items' => array_values($cart)
        ]);
    }

    /**
     * Checkout Page: Patient Details, Timing, Collection & Payment Method
     */
    public function checkout() {
        $cart = $this->session->userdata('path_cart') ?: [];
        if (empty($cart)) {
            $this->session->set_flashdata('flashmsg', '<div class="alert alert-warning"><i class="fa fa-info-circle"></i> Your test cart is empty. Please select a pathology test first.</div>');
            redirect('mytest');
            return;
        }

        $totals = $this->_calculate_cart_totals($cart);

        // Pre-fill user profile if logged in
        $user_id = $this->session->userdata('user_id') ?: $this->session->userdata('id');
        $user = null;
        if ($user_id) {
            $user = $this->db->where('id', $user_id)->get('userlogin')->row();
        }

        $data['cart']         = $cart;
        $data['cart_count']   = count($cart);
        $data['subtotal']     = $totals['subtotal'];
        $data['total_mrp']    = $totals['total_mrp'];
        $data['savings']      = $totals['savings'];
        $data['collection_fee'] = 0.00; // Free Home Sample Collection
        $data['final_total']  = $totals['subtotal'];
        $data['user']         = $user;

        $this->load->view('mytest_checkout', $data);
    }

    /**
     * Process Pathology Payment & Complete Booking
     */
    public function process_payment() {
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            redirect('mytest/checkout');
            return;
        }

        $cart = $this->session->userdata('path_cart') ?: [];
        if (empty($cart)) {
            $this->session->set_flashdata('flashmsg', '<div class="alert alert-danger">Your cart is empty.</div>');
            redirect('mytest');
            return;
        }

        $totals = $this->_calculate_cart_totals($cart);

        // Capture Checkout Form Inputs
        $patient_name    = trim($this->input->post('patient_name', TRUE));
        $patient_mobile  = trim($this->input->post('patient_mobile', TRUE));
        $patient_email   = trim($this->input->post('patient_email', TRUE));
        $patient_age     = trim($this->input->post('patient_age', TRUE));
        $patient_gender  = trim($this->input->post('patient_gender', TRUE)) ?: 'M';
        $patient_address = trim($this->input->post('patient_address', TRUE));
        $booking_date    = trim($this->input->post('booking_date', TRUE)) ?: date('Y-m-d', strtotime('+1 day'));
        $time_slot       = trim($this->input->post('time_slot', TRUE)) ?: 'Morning (08:30 AM - 11:30 AM)';
        $visit_type      = trim($this->input->post('visit_type', TRUE)) ?: 'HOME_COLLECTION';
        $payment_mode    = trim($this->input->post('payment_mode', TRUE)) ?: 'COD'; // 'COD', 'ONLINE_UPI', 'ONLINE_CARD', 'CENTER'
        $notes           = trim($this->input->post('notes', TRUE));

        if (empty($patient_name) || empty($patient_mobile)) {
            $this->session->set_flashdata('flashmsg', '<div class="alert alert-danger">Please fill in patient name and mobile number.</div>');
            redirect('mytest/checkout');
            return;
        }

        // Determine primary lab ID
        $first_item = reset($cart);
        $primary_lab_id = isset($first_item['lab_id']) ? $first_item['lab_id'] : 29;

        // Transaction ID and payment status
        $txn_id = null;
        $payment_status = '0'; // 0 = Pending / Pay on sample collection
        if ($payment_mode === 'ONLINE_UPI' || $payment_mode === 'ONLINE_CARD') {
            $txn_id = 'TXN_UPC_' . strtoupper(uniqid());
            $payment_status = '1'; // 1 = Paid online
        }

        // 1. Insert into path_book
        $book_data = [
            'patient_name'    => $patient_name,
            'patient_mobile'  => $patient_mobile,
            'patient_email'   => $patient_email,
            'patient_address' => $patient_address,
            'patient_age'     => $patient_age,
            'patient_gender'  => $patient_gender,
            'pathlab_id'      => strval($primary_lab_id),
            'total_amount'    => $totals['subtotal'],
            'payment_mode'    => $payment_mode,
            'payment_status'  => $payment_status,
            'pay_date'        => ($payment_status === '1') ? date('Y-m-d H:i:s') : null,
            'book_date'       => date('Y-m-d H:i:s', strtotime($booking_date . ' ' . date('H:i:s'))),
            'time_slot'       => $time_slot,
            'visit_type'      => $visit_type,
            'txn_id'          => $txn_id,
            'notes'           => $notes,
            'status'          => '1' // 1 = Active & Confirmed
        ];

        $this->db->insert('path_book', $book_data);
        $booking_id = $this->db->insert_id();

        if ($booking_id) {
            // 2. Insert all items into path_book_test
            foreach ($cart as $item) {
                $test_item = [
                    'booking_id' => $booking_id,
                    'pathlab_id' => strval($item['lab_id']),
                    'test_id'    => strval($item['test_id']),
                    'test_name'  => $item['test_name'],
                    'short_name' => $item['short_name'],
                    'amount'     => intval($item['amount']),
                    'status'     => '1'
                ];
                $this->db->insert('path_book_test', $test_item);
            }

            // 3. Dispatch Email Confirmation
            if (!empty($patient_email)) {
                $this->load->library('azad_lib');
                $ref_no = "UPC-LAB-" . str_pad($booking_id, 5, '0', STR_PAD_LEFT);
                $test_list_html = "<ul>";
                foreach ($cart as $it) {
                    $test_list_html .= "<li><b>{$it['test_name']}</b> - ₹" . number_format($it['amount']) . "</li>";
                }
                $test_list_html .= "</ul>";

                $pay_display = ($payment_status === '1') ? "<span style='color:#16a34a; font-weight:bold;'>PAID ONLINE ({$payment_mode}) - Txn: {$txn_id}</span>" : "<span style='color:#0284c7; font-weight:bold;'>PAY ON COLLECTION (Cash / UPI at Home)</span>";

                $email_subj = "Order Confirmed [#{$ref_no}] - Upchar Diagnostic Tests";
                $email_body = "Dear {$patient_name},<br><br>"
                            . "Thank you for booking your diagnostic tests with Upchar Healthcare.<br><br>"
                            . "<b>Order Reference:</b> #{$ref_no}<br>"
                            . "<b>Scheduled Date:</b> {$booking_date} ({$time_slot})<br>"
                            . "<b>Collection Type:</b> " . ($visit_type === 'HOME_COLLECTION' ? 'Doorstep Home Sample Collection (Free)' : 'Visit Center') . "<br>"
                            . "<b>Collection Address:</b> {$patient_address}<br>"
                            . "<b>Payment Status:</b> {$pay_display}<br>"
                            . "<b>Total Amount:</b> ₹" . number_format($totals['subtotal'], 2) . "<br><br>"
                            . "<b>Selected Tests:</b><br>{$test_list_html}<br>"
                            . "Our certified phlebotomist will arrive during your chosen time slot. Please observe any fasting instructions.<br><br>"
                            . "Warm regards,<br><b>Upchar Diagnostics Team</b>";

                @$this->azad_lib->sendMail($patient_email, $email_subj, $email_body);
            }

            // 4. Clear Cart and redirect to Order Success
            $this->session->unset_userdata('path_cart');
            redirect('mytest/order_success/' . $booking_id);
            return;
        }

        $this->session->set_flashdata('flashmsg', '<div class="alert alert-danger">An error occurred while creating your booking. Please try again.</div>');
        redirect('mytest/checkout');
    }

    /**
     * Order Confirmation & Receipt View
     */
    public function order_success($booking_id) {
        $booking_id = intval($booking_id);
        $booking = $this->db->select('b.*, pl.name as lab_name, pl.address as lab_address, pl.mobile as lab_mobile')
                            ->from('path_book b')
                            ->join('pathlab pl', 'pl.id = b.pathlab_id', 'left')
                            ->where('b.booking_id', $booking_id)
                            ->get()
                            ->row();

        if (!$booking) {
            $this->session->set_flashdata('flashmsg', '<div class="alert alert-danger">Booking record not found.</div>');
            redirect('mytest');
            return;
        }

        $tests = $this->db->where('booking_id', $booking_id)->get('path_book_test')->result();

        $data['booking']      = $booking;
        $data['tests']        = $tests;
        $data['reference_no'] = "UPC-LAB-" . str_pad($booking_id, 5, '0', STR_PAD_LEFT);

        $this->load->view('mytest_order_success', $data);
    }

    /**
     * Private helper to calculate cart totals
     */
    private function _calculate_cart_totals($cart) {
        $subtotal  = 0;
        $total_mrp = 0;

        foreach ($cart as $item) {
            $amt = floatval($item['amount']);
            $mrp = isset($item['mrp']) ? floatval($item['mrp']) : round($amt * 1.35);
            $subtotal  += $amt;
            $total_mrp += $mrp;
        }

        $savings = max(0, $total_mrp - $subtotal);

        return [
            'subtotal'  => $subtotal,
            'total_mrp' => $total_mrp,
            'savings'   => $savings
        ];
    }
}
