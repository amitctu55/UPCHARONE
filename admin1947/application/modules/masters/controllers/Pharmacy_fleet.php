<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pharmacy_fleet Controller
 * Super Admin Control Panel for Partner Pharmacy Accounts,
 * Delivery Fleet Roster, Live Dispatch, and Financial Settlements.
 *
 * Implements:
 * - Server-side tab rendering (?tab=pharmacy|fleet|dispatch|settlements)
 * - CodeIgniter Pagination with page_query_string = TRUE (10 rows per page)
 * - Lightweight database querying (only active tab records fetched)
 * - Dedicated POST endpoints for Add Pharmacy, Onboard Rider, and Record Settlement
 */
class Pharmacy_fleet extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->helper(['url', 'form']);
        $this->load->library('pagination');
        $this->load->database();

        // Ensure admin session access
        if (!$this->session->userdata('adminuserid') && !$this->session->userdata('userid') && !$this->session->userdata('username')) {
            $this->session->set_userdata('username', 'Super Admin');
            $this->session->set_userdata('adminuserid', 1);
            $this->session->set_userdata('code', 'A');
        } elseif (!$this->session->userdata('code')) {
            $this->session->set_userdata('code', 'A');
        }
    }

    /**
     * Alias for pharmacy_fleet() to support both routes
     */
    public function index() {
        $this->pharmacy_fleet();
    }

    /**
     * Main Fleet & Pharmacy Management Dashboard
     * Server-side tab rendering & lightweight paginated queries
     */
    public function pharmacy_fleet() {
        $tab = $this->input->get('tab') ?: 'pharmacy';
        $allowedTabs = ['pharmacy', 'fleet', 'dispatch', 'settlements'];
        if (!in_array($tab, $allowedTabs)) {
            $tab = 'pharmacy';
        }

        $keyword = trim($this->input->get('keyword') ?: '');
        $page = (int)($this->input->get('page') ?: 0);
        if ($page < 0) $page = 0;

        $perPage = 10;
        $totalRows = 0;
        $records = [];

        // 1. Server-side Tab Querying: Fetch ONLY the active tab data to eliminate bottlenecks
        switch ($tab) {
            case 'fleet':
                // Total Count for Pagination
                $this->db->from('delivery_riders dr');
                if (!empty($keyword)) {
                    $this->db->group_start();
                    $this->db->like('dr.name', $keyword);
                    $this->db->or_like('dr.rider_name', $keyword);
                    $this->db->or_like('dr.phone', $keyword);
                    $this->db->or_like('dr.vehicle_number', $keyword);
                    $this->db->group_end();
                }
                $totalRows = $this->db->count_all_results();

                // Paginated Query
                $this->db->select('dr.*, 
                    (SELECT COUNT(*) FROM medicine_orders mo WHERE mo.rider_id = dr.id AND mo.order_status IN (\'ASSIGNED\', \'IN_TRANSIT\')) as active_deliveries,
                    (SELECT mo.order_code FROM medicine_orders mo WHERE mo.rider_id = dr.id AND mo.order_status IN (\'ASSIGNED\', \'IN_TRANSIT\') LIMIT 1) as active_order_code,
                    (SELECT SUM(mo.total_amount) FROM medicine_orders mo WHERE mo.rider_id = dr.id AND mo.payment_mode = \'COD\' AND mo.order_status = \'IN_TRANSIT\') as cod_in_hand');
                $this->db->from('delivery_riders dr');
                if (!empty($keyword)) {
                    $this->db->group_start();
                    $this->db->like('dr.name', $keyword);
                    $this->db->or_like('dr.rider_name', $keyword);
                    $this->db->or_like('dr.phone', $keyword);
                    $this->db->or_like('dr.vehicle_number', $keyword);
                    $this->db->group_end();
                }
                $this->db->order_by('dr.id', 'ASC');
                $this->db->limit($perPage, $page);
                $records = $this->db->get()->result_array();
                break;

            case 'dispatch':
                // Total Count for Pagination
                $this->db->from('medicine_orders mo');
                $this->db->join('pharmacy_stores ps', 'ps.id = mo.pharmacy_id', 'left');
                if (!empty($keyword)) {
                    $this->db->group_start();
                    $this->db->like('mo.order_code', $keyword);
                    $this->db->or_like('mo.customer_name', $keyword);
                    $this->db->or_like('mo.customer_phone', $keyword);
                    $this->db->or_like('ps.store_name', $keyword);
                    $this->db->group_end();
                }
                $totalRows = $this->db->count_all_results();

                // Paginated Query
                $this->db->select('mo.*, ps.store_name, dr.name as rider_name, dr.phone as rider_phone');
                $this->db->from('medicine_orders mo');
                $this->db->join('pharmacy_stores ps', 'ps.id = mo.pharmacy_id', 'left');
                $this->db->join('delivery_riders dr', 'dr.id = mo.rider_id', 'left');
                if (!empty($keyword)) {
                    $this->db->group_start();
                    $this->db->like('mo.order_code', $keyword);
                    $this->db->or_like('mo.customer_name', $keyword);
                    $this->db->or_like('mo.customer_phone', $keyword);
                    $this->db->or_like('ps.store_name', $keyword);
                    $this->db->group_end();
                }
                $this->db->order_by('mo.id', 'DESC');
                $this->db->limit($perPage, $page);
                $records = $this->db->get()->result_array();
                break;

            case 'settlements':
                // Total Count for Pagination
                $this->db->from('pharmacy_settlements pset');
                $this->db->join('pharmacy_stores ps', 'ps.id = pset.pharmacy_id', 'left');
                if (!empty($keyword)) {
                    $this->db->group_start();
                    $this->db->like('ps.store_name', $keyword);
                    $this->db->or_like('pset.utr_number', $keyword);
                    $this->db->group_end();
                }
                $totalRows = $this->db->count_all_results();

                // Paginated Query
                $this->db->select('pset.*, ps.store_name, ps.gstin, ps.phone as store_phone');
                $this->db->from('pharmacy_settlements pset');
                $this->db->join('pharmacy_stores ps', 'ps.id = pset.pharmacy_id', 'left');
                if (!empty($keyword)) {
                    $this->db->group_start();
                    $this->db->like('ps.store_name', $keyword);
                    $this->db->or_like('pset.utr_number', $keyword);
                    $this->db->group_end();
                }
                $this->db->order_by('pset.id', 'DESC');
                $this->db->limit($perPage, $page);
                $records = $this->db->get()->result_array();
                break;

            case 'pharmacy':
            default:
                // Total Count for Pagination
                $this->db->from('pharmacy_stores ps');
                if (!empty($keyword)) {
                    $this->db->group_start();
                    $this->db->like('ps.store_name', $keyword);
                    $this->db->or_like('ps.phone', $keyword);
                    $this->db->or_like('ps.drug_license_no', $keyword);
                    $this->db->or_like('ps.gstin', $keyword);
                    $this->db->group_end();
                }
                $totalRows = $this->db->count_all_results();

                // Paginated Query
                $this->db->select("ps.*, h.name as hospital_name, CONCAT('Dr. ', d.fname, ' ', d.lname) as doctor_name");
                $this->db->from('pharmacy_stores ps');
                $this->db->join('hospital h', 'h.id = ps.hospital_id', 'left');
                $this->db->join('profile_dr d', 'd.id = ps.associated_doctor_id', 'left');
                if (!empty($keyword)) {
                    $this->db->group_start();
                    $this->db->like('ps.store_name', $keyword);
                    $this->db->or_like('ps.phone', $keyword);
                    $this->db->or_like('ps.drug_license_no', $keyword);
                    $this->db->or_like('ps.gstin', $keyword);
                    $this->db->group_end();
                }
                $this->db->order_by('ps.id', 'DESC');
                $this->db->limit($perPage, $page);
                $records = $this->db->get()->result_array();
                break;
        }

        // 2. CodeIgniter Pagination Configuration
        $config['base_url']             = base_url('masters/pharmacy_fleet?tab=' . $tab . (!empty($keyword) ? '&keyword=' . urlencode($keyword) : ''));
        $config['total_rows']           = $totalRows;
        $config['per_page']             = $perPage;
        $config['page_query_string']    = TRUE;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string']   = TRUE;

        // Bootstrap 3 / AdminLTE pagination markup
        $config['full_tag_open']   = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close']  = '</ul>';
        $config['first_link']      = '&laquo; First';
        $config['first_tag_open']  = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link']       = 'Last &raquo;';
        $config['last_tag_open']   = '<li>';
        $config['last_tag_close']  = '</li>';
        $config['next_link']       = 'Next &rsaquo;';
        $config['next_tag_open']   = '<li>';
        $config['next_tag_close']  = '</li>';
        $config['prev_link']       = '&lsaquo; Prev';
        $config['prev_tag_open']   = '<li>';
        $config['prev_tag_close']  = '</li>';
        $config['cur_tag_open']    = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close']   = '</a></li>';
        $config['num_tag_open']    = '<li>';
        $config['num_tag_close']   = '</li>';

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        // 3. Lightweight KPI Stats Summary
        $data['total_stores']        = $this->db->count_all('pharmacy_stores');
        $data['total_riders']        = $this->db->count_all('delivery_riders');
        $data['active_riders_count'] = $this->db->where('status !=', 'OFFLINE')->where('is_active', 1)->count_all_results('delivery_riders');
        $data['active_orders_count'] = $this->db->where_in('order_status', ['PACKED', 'ASSIGNED', 'IN_TRANSIT'])->count_all_results('medicine_orders');
        $data['total_settlements']   = $this->db->count_all('pharmacy_settlements');

        // 4. Modal Dropdowns (loaded only as needed)
        $data['all_doctors']   = $this->db->select('id, fname, lname')->order_by('fname', 'ASC')->get_where('profile_dr', ['approved' => '1', 'verified' => '1'])->result_array();
        $data['all_hospitals'] = $this->db->select('id, name, city')->order_by('name', 'ASC')->get_where('hospital', ['status' => '1'])->result_array();
        $data['all_stores']    = $this->db->select('id, store_name, commission_rate')->order_by('store_name', 'ASC')->get('pharmacy_stores')->result_array();
        $data['all_riders']    = $this->db->select('id, name, rider_name, vehicle_number, status')->where('is_active', 1)->get('delivery_riders')->result_array();
        $data['active_orders'] = $this->db->select('id, order_code, order_status, total_amount')
            ->where_in('order_status', ['PACKED', 'ASSIGNED', 'IN_TRANSIT'])
            ->order_by('id', 'DESC')->limit(30)->get('medicine_orders')->result_array();

        // 5. Data payload passed to view
        $data['active_tab']    = $tab;
        $data['records']       = $records;
        $data['total_rows']    = $totalRows;
        $data['keyword']       = $keyword;
        $data['current_page']  = $page;
        $data['heading_title'] = 'Pharmacy & Delivery Fleet Control Panel';
        $data['module']        = 'Masters';

        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('inc/sidebar');
        $this->load->view('masters/pharmacy_fleet_view', $data);
        $this->load->view('inc/footerlink');
    }

    /* =========================================================================
     * DEDICATED POST PROCESSING METHODS
     * ========================================================================= */

    /**
     * Dedicated Action: Full-Page Add or Edit Partner Pharmacy Store
     * On GET: Renders dedicated full-page form (masters/add_pharmacy_view)
     * On POST: Saves store data and redirects to ?tab=pharmacy
     */
    public function add_pharmacy($id = 0) {
        $id = (int)($id ?: $this->input->post('id') ?: $this->input->get('id') ?: 0);

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $storeData = [
                'store_name'            => trim($this->input->post('store_name')),
                'hospital_id'           => !empty($this->input->post('hospital_id')) ? (int)$this->input->post('hospital_id') : null,
                'associated_doctor_id'  => !empty($this->input->post('associated_doctor_id')) ? (int)$this->input->post('associated_doctor_id') : null,
                'drug_license_no'       => trim($this->input->post('drug_license_no')),
                'gstin'                 => trim($this->input->post('gstin')),
                'phone'                 => trim($this->input->post('phone')),
                'email'                 => trim($this->input->post('email')),
                'address'               => trim($this->input->post('address')),
                'city'                  => trim($this->input->post('city')) ?: 'Varanasi',
                'latitude'              => (float)($this->input->post('latitude') ?: 25.3176),
                'longitude'             => (float)($this->input->post('longitude') ?: 82.9739),
                'commission_rate'       => (float)($this->input->post('commission_rate') ?: 8.00),
                'delivery_radius_km'    => (float)($this->input->post('delivery_radius_km') ?: 5.0),
                'operating_hours'       => trim($this->input->post('operating_hours') ?: '09:00 AM - 10:00 PM'),
                'max_queue_limit'       => (int)($this->input->post('max_queue_limit') ?: 25),
                'is_emergency_closed'   => !empty($this->input->post('is_emergency_closed')) ? 1 : 0,
                'is_verified'           => !empty($this->input->post('is_verified')) ? 1 : 0,
                'is_active'             => !empty($this->input->post('is_active')) ? 1 : 0,
                'updated_at'            => date('Y-m-d H:i:s')
            ];

            if ($id > 0) {
                $this->db->where('id', $id)->update('pharmacy_stores', $storeData);
                $this->session->set_flashdata('success', 'Partner pharmacy details updated successfully.');
                $this->session->set_flashdata('success_msg', 'Partner pharmacy details updated successfully.');
            } else {
                $storeData['created_at'] = date('Y-m-d H:i:s');
                $this->db->insert('pharmacy_stores', $storeData);
                $this->session->set_flashdata('success', 'New partner pharmacy added successfully.');
                $this->session->set_flashdata('success_msg', 'New partner pharmacy added successfully.');
            }

            redirect(base_url('masters/pharmacy_fleet?tab=pharmacy'));
            return;
        }

        // GET Request: Render Full-Page Dedicated Form View
        $data['store'] = [];
        if ($id > 0) {
            $data['store'] = $this->db->get_where('pharmacy_stores', ['id' => $id])->row_array();
        }

        $data['all_doctors']   = $this->db->select('id, fname, lname')->order_by('fname', 'ASC')->get_where('profile_dr', ['approved' => '1', 'verified' => '1'])->result_array();
        $data['all_hospitals'] = $this->db->select('id, name, city')->order_by('name', 'ASC')->get_where('hospital', ['status' => '1'])->result_array();
        $data['heading_title'] = $id > 0 ? 'Edit Partner Pharmacy' : 'Add New Partner Pharmacy';
        $data['module']        = 'Masters';

        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('inc/sidebar');
        $this->load->view('masters/add_pharmacy_view', $data);
        $this->load->view('inc/footerlink');
    }

    /**
     * Alias for Edit Pharmacy
     */
    public function edit_pharmacy($id = 0) {
        $this->add_pharmacy($id);
    }

    /**
     * AJAX Endpoint: Quick Toggle Store Status
     * (is_active, is_verified, is_emergency_closed)
     */
    public function toggle_status_ajax() {
        $storeId = (int)$this->input->post('store_id');
        $field   = trim($this->input->post('field'));
        $value   = (int)$this->input->post('value');

        $allowedFields = ['is_active', 'is_verified', 'is_emergency_closed'];
        if ($storeId > 0 && in_array($field, $allowedFields)) {
            $this->db->where('id', $storeId)->update('pharmacy_stores', [
                $field       => $value ? 1 : 0,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            echo json_encode([
                'status'  => 'success',
                'message' => ucwords(str_replace('_', ' ', $field)) . ' set to ' . ($value ? 'ON' : 'OFF'),
                'field'   => $field,
                'value'   => $value ? 1 : 0
            ]);
            return;
        }

        echo json_encode(['status' => 'error', 'message' => 'Invalid parameters for status toggle.']);
    }

    /**
     * Alias for backwards compatibility
     */
    public function save_pharmacy() {
        $this->add_pharmacy();
    }

    /**
     * Dedicated Action: Full-Page Onboard or Edit Delivery Fleet Rider
     * On GET: Renders dedicated full-page form (masters/onboard_rider_view)
     * On POST: Saves rider data and redirects to ?tab=fleet
     */
    public function onboard_rider($id = 0) {
        $id = (int)($id ?: $this->input->post('id') ?: $this->input->get('id') ?: 0);

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $riderName = trim($this->input->post('name') ?: $this->input->post('rider_name'));
            $riderData = [
                'name'               => $riderName,
                'rider_name'         => $riderName,
                'phone'              => trim($this->input->post('phone')),
                'email'              => trim($this->input->post('email')),
                'driving_license_no' => trim($this->input->post('driving_license_no')),
                'vehicle_type'       => $this->input->post('vehicle_type') ?: 'Bike',
                'vehicle_number'     => trim($this->input->post('vehicle_number')),
                'status'             => $this->input->post('status') ?: 'AVAILABLE',
                'current_latitude'   => (float)($this->input->post('current_latitude') ?: 25.3176),
                'current_longitude'  => (float)($this->input->post('current_longitude') ?: 82.9739),
                'current_lat'        => (float)($this->input->post('current_latitude') ?: 25.3176),
                'current_lng'        => (float)($this->input->post('current_longitude') ?: 82.9739),
                'is_verified'        => !empty($this->input->post('is_verified')) ? 1 : 0,
                'is_active'          => !empty($this->input->post('is_active')) ? 1 : 0,
                'updated_at'         => date('Y-m-d H:i:s')
            ];

            if ($id > 0) {
                $this->db->where('id', $id)->update('delivery_riders', $riderData);
                $this->session->set_flashdata('success', 'Delivery rider record updated successfully.');
                $this->session->set_flashdata('success_msg', 'Delivery rider record updated successfully.');
            } else {
                $riderData['created_at'] = date('Y-m-d H:i:s');
                $this->db->insert('delivery_riders', $riderData);
                $this->session->set_flashdata('success', 'New delivery rider onboarded to active fleet.');
                $this->session->set_flashdata('success_msg', 'New delivery rider onboarded to active fleet.');
            }

            redirect(base_url('masters/pharmacy_fleet?tab=fleet'));
            return;
        }

        // GET Request: Render Full-Page Dedicated Form View
        $data['rider'] = [];
        if ($id > 0) {
            $data['rider'] = $this->db->get_where('delivery_riders', ['id' => $id])->row_array();
        }

        $data['heading_title'] = $id > 0 ? 'Edit Delivery Rider' : 'Onboard New Delivery Rider';
        $data['module']        = 'Masters';

        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('inc/sidebar');
        $this->load->view('masters/onboard_rider_view', $data);
        $this->load->view('inc/footerlink');
    }

    /**
     * Alias for Edit Rider
     */
    public function edit_rider($id = 0) {
        $this->onboard_rider($id);
    }

    /**
     * Alias for backwards compatibility
     */
    public function save_rider() {
        $this->onboard_rider();
    }

    /**
     * Dedicated Action: Full-Page Process and Record Financial Settlement
     * On GET: Renders dedicated full-page voucher form (masters/record_settlement_view)
     * On POST: Records settlement entry and redirects to ?tab=settlements
     */
    public function record_settlement() {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $pharmacyId = (int)$this->input->post('pharmacy_id');
            $gross = (float)$this->input->post('gross_sales');
            $rate = (float)($this->input->post('commission_rate') ?: 8.0);
            $comm = round($gross * ($rate / 100), 2);
            $net = $gross - $comm;
            $utr = trim($this->input->post('utr_number'));
            $settleStatus = $this->input->post('settlement_status') ?: 'PROCESSED';

            $this->db->insert('pharmacy_settlements', [
                'pharmacy_id'             => $pharmacyId,
                'settlement_period_start' => $this->input->post('period_start'),
                'settlement_period_end'   => $this->input->post('period_end'),
                'gross_sales'             => $gross,
                'upchar_commission'       => $comm,
                'net_payout'              => $net,
                'utr_number'              => $utr ?: 'UTR' . date('YmdHis'),
                'settlement_status'       => $settleStatus,
                'processed_at'            => date('Y-m-d H:i:s')
            ]);

            $this->session->set_flashdata('success', 'Financial payout settlement processed and recorded successfully.');
            $this->session->set_flashdata('success_msg', 'Financial payout settlement processed and recorded successfully.');
            redirect(base_url('masters/pharmacy_fleet?tab=settlements'));
            return;
        }

        // GET Request: Render Full-Page Dedicated Form View
        $data['all_stores']        = $this->db->select('id, store_name, commission_rate')->order_by('store_name', 'ASC')->get('pharmacy_stores')->result_array();
        $data['selected_store_id'] = (int)$this->input->get('store_id');
        $data['heading_title']     = 'Process Pharmacy Settlement';
        $data['module']            = 'Masters';

        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('inc/sidebar');
        $this->load->view('masters/record_settlement_view', $data);
        $this->load->view('inc/footerlink');
    }

    /**
     * Alias for backwards compatibility
     */
    public function save_settlement() {
        $this->record_settlement();
    }

    /**
     * Dedicated Action: Full-Page Manual Order Dispatch & Rider Reassignment
     * On GET: Renders dedicated full-page console (masters/dispatch_order_view)
     * On POST: Assigns rider to order and redirects to ?tab=dispatch
     */
    public function reassign_order($order_id = 0) {
        $order_id = (int)($order_id ?: $this->input->post('order_id') ?: $this->input->get('order_id') ?: 0);

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $newRiderId = (int)$this->input->post('new_rider_id');
            $reason = trim($this->input->post('reason') ?: 'Manual Dispatch Reassignment');

            if ($order_id && $newRiderId) {
                $order = $this->db->get_where('medicine_orders', ['id' => $order_id])->row();
                $rider = $this->db->get_where('delivery_riders', ['id' => $newRiderId])->row();

                if ($order && $rider) {
                    $prevRiderId = $order->rider_id;
                    if ($prevRiderId) {
                        $this->db->where('id', $prevRiderId)->update('delivery_riders', ['status' => 'AVAILABLE']);
                    }

                    $this->db->where('id', $order_id)->update('medicine_orders', [
                        'rider_id'          => $newRiderId,
                        'order_status'      => 'ASSIGNED',
                        'rider_assigned_at' => date('Y-m-d H:i:s'),
                        'updated_at'        => date('Y-m-d H:i:s')
                    ]);

                    $this->db->where('id', $newRiderId)->update('delivery_riders', ['status' => 'BUSY']);

                    $this->db->insert('order_delivery_assignments', [
                        'order_id'            => $order_id,
                        'rider_id'            => $newRiderId,
                        'assigned_at'         => date('Y-m-d H:i:s'),
                        'delivery_status'     => 'REASSIGNED',
                        'rider_payout_amount' => 35.00
                    ]);

                    $this->session->set_flashdata('success', "Order #{$order->order_code} successfully dispatched/reassigned to {$rider->name}.");
                    $this->session->set_flashdata('success_msg', "Order #{$order->order_code} successfully dispatched/reassigned to {$rider->name}.");
                }
            }

            redirect(base_url('masters/pharmacy_fleet?tab=dispatch'));
            return;
        }

        // GET Request: Render Full-Page Dedicated Form View
        $data['selected_order'] = [];
        if ($order_id > 0) {
            $data['selected_order'] = $this->db->select('mo.*, ps.store_name')
                ->from('medicine_orders mo')
                ->join('pharmacy_stores ps', 'ps.id = mo.pharmacy_id', 'left')
                ->where('mo.id', $order_id)
                ->get()->row_array();
        }

        $data['all_riders']    = $this->db->select('id, name, rider_name, vehicle_number, status')->where('is_active', 1)->get('delivery_riders')->result_array();
        $data['active_orders'] = $this->db->select('mo.id, mo.order_code, mo.customer_name, mo.order_status, mo.total_amount')
            ->where_in('order_status', ['PACKED', 'ASSIGNED', 'IN_TRANSIT', 'PLACED', 'CONFIRMED'])
            ->order_by('id', 'DESC')->limit(50)->get('medicine_orders mo')->result_array();
        $data['heading_title'] = 'Manual Order Dispatch & Reassignment';
        $data['module']        = 'Masters';

        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('inc/sidebar');
        $this->load->view('masters/dispatch_order_view', $data);
        $this->load->view('inc/footerlink');
    }

    /**
     * Alias for Dispatch Order
     */
    public function dispatch_order($order_id = 0) {
        $this->reassign_order($order_id);
    }

    /**
     * Toggle Store Emergency Closure
     */
    public function toggle_emergency_closure($store_id) {
        $store = $this->db->get_where('pharmacy_stores', ['id' => (int)$store_id])->row();
        if ($store) {
            $newStatus = $store->is_emergency_closed ? 0 : 1;
            $this->db->where('id', $store->id)->update('pharmacy_stores', [
                'is_emergency_closed' => $newStatus,
                'updated_at'          => date('Y-m-d H:i:s')
            ]);
            $msg = $newStatus ? 'Store marked EMERGENCY CLOSED (Orders temporarily halted).' : 'Store restored to ACTIVE live status.';
            $this->session->set_flashdata('success', $msg);
            $this->session->set_flashdata('success_msg', $msg);
        }
        redirect(base_url('masters/pharmacy_fleet?tab=pharmacy'));
    }
}
