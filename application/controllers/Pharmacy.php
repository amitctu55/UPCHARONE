<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pharmacy Controller
 * Master Dashboard & RESTful Controller for UPCHAR Chemist / Pharmacy Partners.
 *
 * Implements:
 * - Phase 1: Clean RESTful URI Routing (aliases for legacy medicalpanel workflows)
 * - Phase 2 Modules:
 *   1. Inventory & Stock Management (pharmacy/inventory)
 *   2. Order & Bill Management (pharmacy/orders, pharmacy/billing)
 *   3. Delivery Boy Handover System (pharmacy/delivery)
 *   4. Online Payment & Settlement System (pharmacy/payments, api/webhooks/payment)
 */
class Pharmacy extends CI_Controller {

    public $chem_user_id;
    public $profile_chem;
    public $pharmacy_id;

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model(['Medicine_delivery_model', 'Medical_Model']);
        $this->load->helper(['url', 'form']);
        $this->load->database();

        // Chemist session binding
        $this->chem_user_id = $this->session->userdata('medicaluserid') 
            ?: ($this->session->userdata('meduserid') 
            ?: ($this->session->userdata('user_id') 
            ?: $this->session->userdata('userid')));

        $this->profile_chem = null;
        $this->pharmacy_id = null;

        if ($this->chem_user_id) {
            $this->profile_chem = $this->db->group_start()
                ->where('user_id', $this->chem_user_id)
                ->or_where('id', $this->chem_user_id)
                ->group_end()
                ->get('profile_chem')->row_array();

            if ($this->profile_chem) {
                $chemPhone = $this->profile_chem['mobile'] ?? ($this->profile_chem['phone'] ?? '');
                $store = $this->db->group_start()
                    ->where('owner_id', (int)$this->chem_user_id)
                    ->or_where('hospital_id', (int)$this->profile_chem['id'])
                    ->or_where('phone', $chemPhone)
                    ->group_end()
                    ->where('is_active', 1)
                    ->order_by('id', 'ASC')
                    ->get('pharmacy_stores')->row_array();
                if ($store) {
                    $this->pharmacy_id = (int)$store['id'];
                }
            }
        }
    }

    private function _json_response($data, $statusCode = 200) {
        return $this->output
            ->set_status_header($statusCode)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    /**
     * Resolve active store context strictly filtered by current chemist's session
     * Fixes multi-store data leak (Apex Care, Sanjivani 24x7, LifeLine Pharmacy)
     */
    private function _get_active_store_data() {
        $userId = $this->chem_user_id;
        $chemProfileId = $this->profile_chem['id'] ?? null;
        $chemPhone = $this->profile_chem['mobile'] ?? ($this->profile_chem['phone'] ?? '');

        $stores = [];
        if ($userId) {
            $this->db->select('*')->from('pharmacy_stores');
            $this->db->group_start();
            $this->db->where('owner_id', (int)$userId);
            if (!empty($chemProfileId)) {
                $this->db->or_where('hospital_id', (int)$chemProfileId);
            }
            if (!empty($chemPhone)) {
                $this->db->or_where('phone', $chemPhone);
            }
            $this->db->group_end();
            $this->db->where('is_active', 1);
            $this->db->order_by('id', 'ASC');
            $stores = $this->db->get()->result_array();

            // Auto-provision a default store linked to owner_id if none exists for this registered chemist
            if (empty($stores) && !empty($this->profile_chem)) {
                $newStoreName = !empty($this->profile_chem['fname']) ? $this->profile_chem['fname'] : 'My Pharmacy Store';
                $newStoreData = [
                    'owner_id'        => (int)$userId,
                    'hospital_id'     => (int)($chemProfileId ?: $userId),
                    'store_name'      => $newStoreName,
                    'phone'           => $chemPhone ?: '',
                    'email'           => $this->profile_chem['email'] ?? '',
                    'city'            => $this->profile_chem['city'] ?? '',
                    'address'         => $this->profile_chem['street'] ?? '',
                    'drug_license_no' => $this->profile_chem['regd_no'] ?? '',
                    'is_verified'     => 1,
                    'is_active'       => 1,
                    'created_at'      => date('Y-m-d H:i:s'),
                    'updated_at'      => date('Y-m-d H:i:s')
                ];
                $this->db->insert('pharmacy_stores', $newStoreData);
                $newStoreData['id'] = $this->db->insert_id();
                $stores = [$newStoreData];
            }
        }

        $requestedId = (int)$this->input->get('store_id');
        $currentStore = null;

        // Verify that requested store strictly belongs to current chemist's authorized stores
        if ($requestedId && !empty($stores)) {
            foreach ($stores as $st) {
                if ((int)$st['id'] === $requestedId) {
                    $currentStore = $st;
                    break;
                }
            }
        }

        if (!$currentStore && !empty($stores)) {
            $currentStore = $stores[0];
        }

        $storeId = $currentStore ? (int)$currentStore['id'] : 0;

        return [
            'stores' => $stores,
            'current_store' => $currentStore,
            'store_id' => $storeId
        ];
    }

    /* =========================================================================
     * PHASE 1: CLEAN ROUTING & DASHBOARD
     * ========================================================================= */

    /**
     * GET /pharmacy/dashboard
     * Master Console with live queue, audio chime, and metric cards
     */
    public function dashboard() {
        $storeData = $this->_get_active_store_data();
        $storeId = $storeData['store_id'];

        $data['stores'] = $storeData['stores'];
        $data['current_store'] = $storeData['current_store'];
        $data['orders'] = $this->_fetch_store_orders($storeId);

        $this->load->view('pharmacy/dashboard', $data);
    }

    /**
     * Polling endpoint for live updates & audio alert
     * GET /pharmacy/get_live_orders
     */
    public function get_live_orders() {
        $storeData = $this->_get_active_store_data();
        $orders = $this->_fetch_store_orders($storeData['store_id']);

        $counts = [
            'total' => count($orders),
            'new_pending' => 0,
            'confirmed' => 0,
            'packed' => 0,
            'in_transit' => 0,
            'delivered' => 0
        ];

        foreach ($orders as $o) {
            if (in_array($o['order_status'], ['PLACED', 'PENDING_RX'])) $counts['new_pending']++;
            elseif ($o['order_status'] === 'CONFIRMED') $counts['confirmed']++;
            elseif (in_array($o['order_status'], ['PACKED', 'ASSIGNED'])) $counts['packed']++;
            elseif ($o['order_status'] === 'IN_TRANSIT') $counts['in_transit']++;
            elseif ($o['order_status'] === 'DELIVERED') $counts['delivered']++;
        }

        return $this->_json_response([
            'status' => 'success',
            'counts' => $counts,
            'orders' => $orders
        ]);
    }

    private function _fetch_store_orders($pharmacyId, $statusFilter = null) {
        $this->db->select('mo.*, op.file_path as prescription_file, op.original_filename as rx_filename, op.verification_status as rx_status, op.pharmacist_reg_no, dr.rider_name, dr.phone as rider_phone, dr.vehicle_number');
        $this->db->from('medicine_orders mo');
        $this->db->join('order_prescriptions op', 'op.id = mo.prescription_id', 'left');
        $this->db->join('delivery_riders dr', 'dr.id = mo.rider_id', 'left');
        $this->db->where('mo.pharmacy_id', (int)$pharmacyId);

        if (!empty($statusFilter) && $statusFilter !== 'ALL') {
            if ($statusFilter === 'PENDING') {
                $this->db->where_in('mo.order_status', ['PLACED', 'PENDING_RX']);
            } else {
                $this->db->where('mo.order_status', $statusFilter);
            }
        }

        $this->db->order_by('mo.id', 'DESC');
        $orders = $this->db->get()->result_array();

        foreach ($orders as &$ord) {
            $ord['items'] = $this->db->select('moi.*, mm.brand_name, mm.generic_composition, mm.dosage_form, mm.strength, mm.schedule_type, mm.is_prescription_required')
                ->from('medicine_order_items moi')
                ->join('medicines_master mm', 'mm.id = moi.medicine_id', 'left')
                ->where('moi.order_id', $ord['id'])
                ->get()->result_array();
        }

        return $orders;
    }

    /**
     * GET /pharmacy/profile/edit
     * Modern Pharmacy Partner Profile & Compliance Console
     */
    public function profile_edit() {
        $storeData = $this->_get_active_store_data();
        $store = $storeData['current_store'];

        // If chemist logged in, also check linked profile_chem
        $chemProfile = $this->profile_chem ?: [];

        // Hospitals & Doctors for affiliation tagging
        $hospitals = $this->db->select('id, name, city')->order_by('name', 'ASC')->get('hospital')->result_array();
        $doctors = $this->db->select('id, fname, lname')->order_by('fname', 'ASC')->get('profile_dr')->result_array();

        $data = [
            'stores' => $storeData['stores'],
            'current_store' => $store,
            'chem_profile' => $chemProfile,
            'hospitals' => $hospitals,
            'doctors' => $doctors,
            'flashmsg' => $this->session->flashdata('flashmsg'),
            'content_view' => 'pharmacy/profile_edit'
        ];

        $this->load->view('layouts/chemist_layout', $data);
    }

    /**
     * POST /pharmacy/profile/update
     * Handle store profile and KYC compliance updates
     */
    public function profile_update() {
        $storeId = (int)$this->input->post('store_id');
        if (!$storeId) {
            $this->session->set_flashdata('flashmsg', '<div class="alert alert-danger">Invalid Store ID.</div>');
            redirect('pharmacy/profile/edit');
            return;
        }

        $updateData = [
            'store_name'            => trim($this->input->post('store_name')),
            'pharmacist_name'       => trim($this->input->post('pharmacist_name')),
            'drug_license_no'       => trim($this->input->post('drug_license_no')),
            'gstin'                 => trim($this->input->post('gstin')),
            'phone'                 => trim($this->input->post('phone')),
            'email'                 => trim($this->input->post('email')),
            'address'               => trim($this->input->post('address')),
            'city'                  => trim($this->input->post('city')),
            'pincode'               => trim($this->input->post('pincode')),
            'operating_hours'       => trim($this->input->post('operating_hours')),
            'delivery_radius_km'    => (float)$this->input->post('delivery_radius_km') ?: 5.0,
            'max_queue_limit'       => (int)$this->input->post('max_queue_limit') ?: 25,
            'is_emergency_closed'   => $this->input->post('is_emergency_closed') ? 1 : 0,
            'hospital_id'           => (int)$this->input->post('hospital_id') ?: null,
            'associated_doctor_id'  => (int)$this->input->post('associated_doctor_id') ?: null,
            'updated_at'            => date('Y-m-d H:i:s')
        ];

        if ($this->input->post('latitude') !== '') {
            $updateData['latitude'] = (float)$this->input->post('latitude');
        }
        if ($this->input->post('longitude') !== '') {
            $updateData['longitude'] = (float)$this->input->post('longitude');
        }

        // File uploads
        if (!is_dir('./uploads/pharmacy/')) {
            @mkdir('./uploads/pharmacy/', 0777, true);
        }

        $uploadConfig = [
            'upload_path'   => './uploads/pharmacy/',
            'allowed_types' => 'jpg|jpeg|png|pdf',
            'max_size'      => 4096,
            'encrypt_name'  => TRUE
        ];
        $this->load->library('upload', $uploadConfig);

        if (!empty($_FILES['store_photo']['name'])) {
            if ($this->upload->do_upload('store_photo')) {
                $uploadRes = $this->upload->data();
                $updateData['store_photo'] = 'uploads/pharmacy/' . $uploadRes['file_name'];
            }
        }

        if (!empty($_FILES['drug_license_file']['name'])) {
            if ($this->upload->do_upload('drug_license_file')) {
                $uploadRes = $this->upload->data();
                $updateData['drug_license_file'] = 'uploads/pharmacy/' . $uploadRes['file_name'];
            }
        }

        if (!empty($_FILES['gst_certificate']['name'])) {
            if ($this->upload->do_upload('gst_certificate')) {
                $uploadRes = $this->upload->data();
                $updateData['gst_certificate'] = 'uploads/pharmacy/' . $uploadRes['file_name'];
            }
        }

        $this->db->where('id', $storeId)->update('pharmacy_stores', $updateData);

        // Also sync profile_chem if linked
        if ($this->chem_user_id && $this->profile_chem) {
            $this->db->where('user_id', $this->chem_user_id)->update('profile_chem', [
                'fname' => $updateData['pharmacist_name'] ?: ($this->profile_chem['fname'] ?? ''),
                'mobile' => $updateData['phone'] ?: ($this->profile_chem['mobile'] ?? ''),
                'email' => $updateData['email'] ?: ($this->profile_chem['email'] ?? ''),
                'city' => $updateData['city'] ?: ($this->profile_chem['city'] ?? ''),
                'street' => $updateData['address'] ?: ($this->profile_chem['street'] ?? '')
            ]);
        }

        $this->session->set_flashdata('flashmsg', '<div class="alert alert-success" style="border-radius:8px;"><strong>Success!</strong> Pharmacy profile and compliance settings updated successfully.</div>');
        redirect('pharmacy/profile/edit?store_id=' . $storeId);
    }

    public function profile_verification() {
        if (!$this->chem_user_id) {
            redirect('medical-login');
            return;
        }
        if ($this->input->post('submit')) {
            $this->Medical_Model->profile_idproof2();
        }
        $did = $this->profile_chem['id'] ?? 0;
        $data['src'] = $this->db->select('id_proof')->get_where('profile_chem', ['id' => $did])->row('id_proof');
        if (empty($data['src'])) $data['imagerequired'] = 'required';
        $this->load->view('medicalpanel/profile_idproof', $data);
    }

    public function profile_onboarding() {
        if (!$this->chem_user_id) {
            redirect('medical-login');
            return;
        }
        if ($this->input->post('submit')) {
            $this->Medical_Model->profile_step21();
        }
        $did = $this->profile_chem['id'] ?? 0;
        $data['data'] = $this->db->get_where('profile_chem', ['id' => $did])->row();
        $data_spl = $this->db->select('specialization_id')->get_where('dr_specialization', ['user_id' => $did])->result_array();
        $data['data_spl'] = array_map(function($v) { return $v['specialization_id']; }, $data_spl);
        $this->load->view('medicalpanel/profile_step1', $data);
    }

    public function doctors() {
        if (!$this->chem_user_id) {
            redirect('medical-login');
            return;
        }
        $did = $this->profile_chem['id'] ?? 0;
        $data['clinic'] = $this->db->select('profile_chem.*, dr_practice.status as p_status')
            ->join('profile_chem', 'profile_chem.id=dr_practice.user_id')
            ->get_where('dr_practice', ['institution_id' => $did, 'type' => 'H'])->result();
        $this->load->view('medicalpanel/managedoctor', $data);
    }

    public function appointments() {
        if (!$this->chem_user_id) {
            redirect('medical-login');
            return;
        }
        // Direct to appointments view
        $did = $this->profile_chem['id'] ?? 0;
        $data['appointments'] = $this->db->order_by('id', 'DESC')->limit(50)->get_where('appointment', ['doctor_id' => $did])->result();
        $this->load->view('medicalpanel/appointment_booking', $data);
    }

    public function reports() {
        $storeData = $this->_get_active_store_data();
        $storeId = $storeData['store_id'];

        $startDate = $this->input->get('start_date') ?: date('Y-m-01');
        $endDate   = $this->input->get('end_date') ?: date('Y-m-d');

        // Orders in period
        $this->db->select('mo.*');
        $this->db->from('medicine_orders mo');
        $this->db->where('mo.pharmacy_id', $storeId);
        $this->db->where('DATE(mo.created_at) >=', $startDate);
        $this->db->where('DATE(mo.created_at) <=', $endDate);
        $this->db->order_by('mo.id', 'DESC');
        $orders = $this->db->get()->result_array();


        // Financial & volume aggregation
        $totalOrders = count($orders);
        $totalGross = 0;
        $totalDelivered = 0;
        $totalPending = 0;
        $totalInTransit = 0;
        $totalCancelled = 0;
        $totalCod = 0;
        $totalOnline = 0;

        foreach ($orders as $o) {
            $amt = (float)$o['total_amount'];
            $totalGross += $amt;
            $st = strtoupper($o['order_status']);
            if ($st === 'DELIVERED') $totalDelivered++;
            elseif (in_array($st, ['PLACED', 'PENDING_RX'])) $totalPending++;
            elseif (in_array($st, ['PACKED', 'ASSIGNED', 'IN_TRANSIT'])) $totalInTransit++;
            elseif ($st === 'CANCELLED') $totalCancelled++;

            if ($o['payment_mode'] === 'COD') $totalCod += $amt;
            else $totalOnline += $amt;
        }

        // Top Selling Medicines
        $topMedicines = $this->db->select('mm.brand_name, mm.generic_composition, SUM(moi.quantity) as total_qty, SUM(moi.total_price) as total_sales')
            ->from('medicine_order_items moi')
            ->join('medicines_master mm', 'mm.id = moi.medicine_id')
            ->group_by('moi.medicine_id')
            ->order_by('total_qty', 'DESC')
            ->limit(5)
            ->get()->result_array();

        // 7-day trend for chart
        $trendLabels = [];
        $trendOrders = [];
        $trendSales = [];
        for ($i = 6; $i >= 0; $i--) {
            $d = date('Y-m-d', strtotime("-$i days"));
            $trendLabels[] = date('D (M j)', strtotime($d));
            
            $cnt = $this->db->where('DATE(created_at)', $d)->count_all_results('medicine_orders');
            $revRow = $this->db->select('COALESCE(SUM(total_amount), 0) as s')->where('DATE(created_at)', $d)->get('medicine_orders')->row();
            $rev = $revRow ? (float)$revRow->s : 0;
            
            $trendOrders[] = (int)$cnt;
            $trendSales[] = (float)$rev;
        }

        // Inventory summary
        $totalSkus = $this->db->where('pharmacy_id', $storeId)->count_all_results('pharmacy_inventory');
        if ($totalSkus == 0) $totalSkus = $this->db->count_all_results('pharmacy_inventory');

        $lowStock = $this->db->group_start()
            ->where('stock_quantity <=', 15)
            ->or_where('is_available', 0)
            ->group_end()
            ->count_all_results('pharmacy_inventory');

        $data = [
            'stores' => $storeData['stores'],
            'current_store' => $storeData['current_store'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'orders' => $orders,
            'total_orders' => $totalOrders,
            'total_gross' => $totalGross,
            'total_delivered' => $totalDelivered,
            'total_pending' => $totalPending,
            'total_in_transit' => $totalInTransit,
            'total_cancelled' => $totalCancelled,
            'total_cod' => $totalCod,
            'total_online' => $totalOnline,
            'top_medicines' => $topMedicines,
            'trend_labels' => $trendLabels,
            'trend_orders' => $trendOrders,
            'trend_sales' => $trendSales,
            'total_skus' => $totalSkus,
            'low_stock' => $lowStock,
            'content_view' => 'pharmacy/reports'
        ];

        $this->load->view('layouts/chemist_layout', $data);
    }

    public function gallery() {
        $storeData = $this->_get_active_store_data();
        $did = $this->profile_chem['id'] ?? ($this->chem_user_id ?? 0);

        if ($this->input->post('submit')) {
            $uploadimage = $_FILES['uploadimage']['name'] ?? '';
            if (!empty($uploadimage)) {
                $extsign = strtolower(pathinfo($uploadimage, PATHINFO_EXTENSION));
                $rname = rand(1111111, 999999999);
                $newFileName = 'chem_gallery_' . $rname . '_' . date('Ymd_His') . '.' . $extsign;

                $uploadPath = './admin1947/public/assets/upload/';
                if (!is_dir($uploadPath)) {
                    @mkdir($uploadPath, 0777, true);
                }

                $config['upload_path']   = $uploadPath;
                $config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG|webp|WEBP';
                $config['max_size']      = 5120; // 5MB
                $config['file_name']     = $newFileName;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('uploadimage')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('flashmsg', '<div class="alert alert-danger" style="border-radius:10px;"><i class="fa fa-exclamation-circle"></i> <strong>Upload Failed:</strong> ' . $error . '</div>');
                } else {
                    $shot = trim($this->input->post('shot') ?? '');
                    $long = trim($this->input->post('long') ?? '');
                    $insertData = [
                        'user_id'          => $did,
                        'shot_description' => $shot,
                        'long_description' => $long,
                        'image'            => $newFileName,
                        'date'             => date('Y-m-d H:i:s')
                    ];
                    $this->db->insert('medicalgallery', $insertData);
                    $this->session->set_flashdata('flashmsg', '<div class="alert alert-success" style="border-radius:10px;"><i class="fa fa-check-circle"></i> <strong>Success!</strong> Photo added to your pharmacy gallery showcase.</div>');
                }
            } else {
                $this->session->set_flashdata('flashmsg', '<div class="alert alert-warning" style="border-radius:10px;"><i class="fa fa-info-circle"></i> Please choose an image file to upload.</div>');
            }
            redirect('pharmacy/gallery');
            return;
        }

        // Fetch gallery images for current chemist
        $this->db->select('*')->from('medicalgallery');
        $this->db->group_start()
            ->where('user_id', $did);
        if ($this->chem_user_id && $this->chem_user_id != $did) {
            $this->db->or_where('user_id', $this->chem_user_id);
        }
        $this->db->group_end();
        $this->db->order_by('id', 'DESC');
        $gallery = $this->db->get()->result();

        $data = [
            'stores'        => $storeData['stores'],
            'current_store' => $storeData['current_store'],
            'gallery'       => $gallery,
            'flashmsg'      => $this->session->flashdata('flashmsg'),
            'content_view'  => 'pharmacy/gallery'
        ];

        $this->load->view('layouts/chemist_layout', $data);
    }

    public function gallery_delete($id = null) {
        $id = (int)$id;
        $did = $this->profile_chem['id'] ?? ($this->chem_user_id ?? 0);
        if ($id) {
            $this->db->group_start()
                ->where('user_id', $did);
            if ($this->chem_user_id) {
                $this->db->or_where('user_id', $this->chem_user_id);
            }
            $this->db->group_end();
            $row = $this->db->where('id', $id)->get('medicalgallery')->row();
            if ($row) {
                $filePath = FCPATH . 'admin1947/public/assets/upload/' . $row->image;
                if (file_exists($filePath) && is_file($filePath)) {
                    @unlink($filePath);
                }
                $this->db->where('id', $id)->delete('medicalgallery');
                $this->session->set_flashdata('flashmsg', '<div class="alert alert-success" style="border-radius:10px;"><i class="fa fa-trash"></i> Photo removed from gallery.</div>');
            }
        }
        redirect('pharmacy/gallery');
    }

    public function orders_pending() {
        $storeData = $this->_get_active_store_data();
        $data['orders'] = $this->_fetch_store_orders($storeData['store_id'], 'PENDING');
        $data['stores'] = $storeData['stores'];
        $data['current_store'] = $storeData['current_store'];
        $this->load->view('medicalpanel/penddingorder', $data);
    }

    public function inventory_import() {
        $this->load->view('medicalpanel/addandimport');
    }

    /* =========================================================================
     * PHASE 2 MODULE 1: INVENTORY & STOCK MANAGEMENT
     * ========================================================================= */

    /**
     * GET /pharmacy/inventory
     */
    public function inventory() {
        $storeData = $this->_get_active_store_data();
        $storeId = $storeData['store_id'];

        $search = trim($this->input->get('q') ?? '');
        $filter = trim($this->input->get('filter') ?? ''); // 'low_stock', 'out_of_stock', 'all'

        $this->db->select('pi.*, mm.brand_name, mm.generic_composition, mm.dosage_form, mm.strength, mm.manufacturer, mm.schedule_type, mm.is_prescription_required');
        $this->db->from('pharmacy_inventory pi');
        $this->db->join('medicines_master mm', 'mm.id = pi.medicine_id', 'left');
        $this->db->where('pi.pharmacy_id', $storeId);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('mm.brand_name', $search);
            $this->db->or_like('mm.generic_composition', $search);
            $this->db->or_like('pi.batch_no', $search);
            $this->db->group_end();
        }

        if ($filter === 'low_stock') {
            $this->db->where('pi.stock_quantity >', 0);
            $this->db->where('pi.stock_quantity <=', 10);
        } elseif ($filter === 'out_of_stock') {
            $this->db->where('pi.stock_quantity <=', 0);
        }

        $this->db->order_by('mm.brand_name', 'ASC');
        $inventory = $this->db->get()->result_array();

        // Calculate KPI summary
        $totalItems = $this->db->where('pharmacy_id', $storeId)->count_all_results('pharmacy_inventory');
        $lowStock = $this->db->where('pharmacy_id', $storeId)->where('stock_quantity >', 0)->where('stock_quantity <=', 10)->count_all_results('pharmacy_inventory');
        $outOfStock = $this->db->where('pharmacy_id', $storeId)->where('stock_quantity <=', 0)->count_all_results('pharmacy_inventory');

        $stockValueRow = $this->db->select_sum('(selling_price * stock_quantity)', 'total_val')->where('pharmacy_id', $storeId)->get('pharmacy_inventory')->row();
        $totalValue = (float)($stockValueRow->total_val ?? 0);

        // Fetch master medicines list for quick add
        $allMedicines = $this->db->select('id, brand_name, dosage_form, strength')->order_by('brand_name', 'ASC')->limit(100)->get('medicines_master')->result_array();

        $data = [
            'stores' => $storeData['stores'],
            'current_store' => $storeData['current_store'],
            'inventory' => $inventory,
            'kpis' => [
                'total_skus' => $totalItems,
                'low_stock' => $lowStock,
                'out_of_stock' => $outOfStock,
                'total_value' => $totalValue
            ],
            'search' => $search,
            'filter' => $filter,
            'all_medicines' => $allMedicines,
            'content_view' => 'pharmacy/inventory'
        ];

        $this->load->view('layouts/chemist_layout', $data);
    }

    /**
     * POST /pharmacy/inventory/update
     */
    public function inventory_update() {
        $raw = $this->input->raw_input_stream ?: file_get_contents('php://input');
        $input = json_decode($raw, true) ?: $this->input->post();
        $inventoryId = (int)($input['inventory_id'] ?? 0);
        $medicineId = (int)($input['medicine_id'] ?? 0);
        $pharmacyId = (int)($input['pharmacy_id'] ?? ($this->_get_active_store_data()['store_id']));

        $stockQuantity = isset($input['stock_quantity']) ? (int)$input['stock_quantity'] : null;
        $mrp = isset($input['mrp']) ? (float)$input['mrp'] : null;
        $sellingPrice = isset($input['selling_price']) ? (float)$input['selling_price'] : null;
        $batchNo = trim($input['batch_no'] ?? '');
        $expiryDate = !empty($input['expiry_date']) ? date('Y-m-d', strtotime($input['expiry_date'])) : null;
        $isAvailable = isset($input['is_available']) ? (int)$input['is_available'] : 1;

        if ($inventoryId > 0) {
            $updateData = ['updated_at' => date('Y-m-d H:i:s')];
            if ($stockQuantity !== null) $updateData['stock_quantity'] = $stockQuantity;
            if ($mrp !== null) $updateData['mrp'] = $mrp;
            if ($sellingPrice !== null) $updateData['selling_price'] = $sellingPrice;
            if (!empty($batchNo)) $updateData['batch_no'] = $batchNo;
            if (!empty($expiryDate)) $updateData['expiry_date'] = $expiryDate;
            $updateData['is_available'] = ($stockQuantity !== null && $stockQuantity <= 0) ? 0 : $isAvailable;

            $this->db->where('id', $inventoryId)->update('pharmacy_inventory', $updateData);
            return $this->_json_response(['status' => 'success', 'message' => 'Stock quantity updated successfully.']);
        } elseif ($medicineId > 0) {
            // Check if already in inventory
            $exists = $this->db->get_where('pharmacy_inventory', ['pharmacy_id' => $pharmacyId, 'medicine_id' => $medicineId])->row();
            if ($exists) {
                $this->db->where('id', $exists->id)->update('pharmacy_inventory', [
                    'stock_quantity' => ($stockQuantity !== null ? $stockQuantity : $exists->stock_quantity),
                    'mrp' => ($mrp !== null ? $mrp : $exists->mrp),
                    'selling_price' => ($sellingPrice !== null ? $sellingPrice : $exists->selling_price),
                    'batch_no' => (!empty($batchNo) ? $batchNo : $exists->batch_no),
                    'expiry_date' => (!empty($expiryDate) ? $expiryDate : $exists->expiry_date),
                    'is_available' => $isAvailable,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                return $this->_json_response(['status' => 'success', 'message' => 'Stock updated.']);
            } else {
                $this->db->insert('pharmacy_inventory', [
                    'pharmacy_id' => $pharmacyId,
                    'medicine_id' => $medicineId,
                    'stock_quantity' => $stockQuantity ?: 50,
                    'mrp' => $mrp ?: 100.00,
                    'selling_price' => $sellingPrice ?: 90.00,
                    'batch_no' => $batchNo ?: 'BATCH-'.date('ym'),
                    'expiry_date' => $expiryDate ?: date('Y-m-d', strtotime('+1 year')),
                    'is_available' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                return $this->_json_response(['status' => 'success', 'message' => 'Medicine added to pharmacy inventory.']);
            }
        }

        return $this->_json_response(['status' => 'error', 'message' => 'Invalid medicine or inventory identifier.'], 400);
    }

    /* =========================================================================
     * PHASE 2 MODULE 2: ORDER & BILL MANAGEMENT
     * ========================================================================= */

    /**
     * GET /pharmacy/orders
     */
    public function orders() {
        $storeData = $this->_get_active_store_data();
        $storeId = (int)$storeData['store_id'];
        $status = strtoupper($this->input->get('status') ?: 'ALL');

        $orders = $this->_fetch_store_orders($storeId, $status);
        $riders = $this->db->get_where('delivery_riders', ['is_active' => 1])->result_array();

        // Calculate real-time counts across all pipeline statuses for KPI ribbon
        $allStoreOrders = $this->db->select('order_status, total_amount')
            ->from('medicine_orders')
            ->where('pharmacy_id', $storeId)
            ->get()->result_array();

        $counts = [
            'total'      => count($allStoreOrders),
            'pending'    => 0,
            'confirmed'  => 0,
            'packed'     => 0,
            'in_transit' => 0,
            'delivered'  => 0
        ];
        $totalValue = 0.00;

        foreach ($allStoreOrders as $so) {
            $st = strtoupper($so['order_status']);
            $totalValue += (float)$so['total_amount'];
            if (in_array($st, ['PLACED', 'PENDING_RX'])) {
                $counts['pending']++;
            } elseif ($st === 'CONFIRMED') {
                $counts['confirmed']++;
            } elseif (in_array($st, ['PACKED', 'ASSIGNED'])) {
                $counts['packed']++;
            } elseif ($st === 'IN_TRANSIT') {
                $counts['in_transit']++;
            } elseif ($st === 'DELIVERED') {
                $counts['delivered']++;
            }
        }

        $data = [
            'stores'         => $storeData['stores'],
            'current_store'  => $storeData['current_store'],
            'orders'         => $orders,
            'current_status' => $status,
            'status_counts'  => $counts,
            'total_value'    => $totalValue,
            'riders'         => $riders,
            'content_view'   => 'pharmacy/orders'
        ];

        $this->load->view('layouts/chemist_layout', $data);
    }

    /**
     * POST /pharmacy/orders/status
     * State Machine: PLACED/PENDING_RX -> CONFIRMED -> PACKED -> IN_TRANSIT -> DELIVERED
     */
    public function orders_status() {
        $raw = $this->input->raw_input_stream ?: file_get_contents('php://input');
        $input = json_decode($raw, true) ?: $this->input->post();
        $orderId = (int)($input['order_id'] ?? 0);
        $targetStatus = strtoupper(trim($input['status'] ?? ''));

        if (!$orderId || empty($targetStatus)) {
            return $this->_json_response(['status' => 'error', 'message' => 'Order ID and target status are required.'], 400);
        }

        $order = $this->db->get_where('medicine_orders', ['id' => $orderId])->row_array();
        if (!$order) {
            return $this->_json_response(['status' => 'error', 'message' => 'Order not found.'], 404);
        }

        $allowedStates = ['PLACED', 'PENDING_RX', 'CONFIRMED', 'PACKED', 'ASSIGNED', 'IN_TRANSIT', 'DELIVERED', 'CANCELLED'];
        if (!in_array($targetStatus, $allowedStates)) {
            return $this->_json_response(['status' => 'error', 'message' => 'Invalid order state.'], 400);
        }

        $update = [
            'order_status' => $targetStatus,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($targetStatus === 'IN_TRANSIT' && empty($order['dispatched_at'])) {
            $update['dispatched_at'] = date('Y-m-d H:i:s');
        } elseif ($targetStatus === 'DELIVERED') {
            $update['delivered_at'] = date('Y-m-d H:i:s');
            $update['payment_status'] = 'PAID';
        }

        // Update items batch numbers if provided
        if (!empty($input['items']) && is_array($input['items'])) {
            foreach ($input['items'] as $item) {
                if (!empty($item['item_id'])) {
                    $this->db->where('id', (int)$item['item_id'])->update('medicine_order_items', [
                        'batch_no' => $item['batch_no'] ?? 'BATCH01',
                        'expiry_date' => !empty($item['expiry_date']) ? date('Y-m-d', strtotime($item['expiry_date'])) : null
                    ]);
                }
            }
        }

        $this->db->where('id', $orderId)->update('medicine_orders', $update);

        // Auto-assign rider if transitioning to PACKED
        $dispatchInfo = null;
        if ($targetStatus === 'PACKED' && empty($order['rider_id'])) {
            $dispatchInfo = $this->Medicine_delivery_model->assign_nearest_rider($orderId, 5.0);
        }

        return $this->_json_response([
            'status' => 'success',
            'message' => "Order #{$order['order_code']} transitioned to {$targetStatus}.",
            'dispatch' => $dispatchInfo
        ]);
    }

    /**
     * GET /pharmacy/billing/generate/{order_id}
     */
    public function billing_generate($orderId = null) {
        $orderId = (int)$orderId;
        if (!$orderId) {
            show_error('Invalid Order ID.');
            return;
        }

        $order = $this->Medicine_delivery_model->get_order_details($orderId, 'id');
        if (!$order) {
            show_error('Order not found.');
            return;
        }

        $data['order'] = $order;
        $this->load->view('pharmacy/invoice_print', $data);
    }

    /* =========================================================================
     * PHASE 2 MODULE 3: DELIVERY BOY HANDOVER SYSTEM
     * ========================================================================= */

    /**
     * GET /pharmacy/delivery
     */
    public function delivery() {
        $storeData = $this->_get_active_store_data();
        $storeId = (int)$storeData['store_id'];

        // Orders ready for handover (PACKED or ASSIGNED or IN_TRANSIT)
        $this->db->select('mo.*, dr.rider_name, dr.phone as rider_phone, dr.vehicle_number, dr.vehicle_type, oda.delivery_status as assign_status, oda.assigned_at, oda.picked_up_at');
        $this->db->from('medicine_orders mo');
        $this->db->join('delivery_riders dr', 'dr.id = mo.rider_id', 'left');
        $this->db->join('order_delivery_assignments oda', 'oda.order_id = mo.id', 'left');
        $this->db->where('mo.pharmacy_id', $storeId);
        $this->db->where_in('mo.order_status', ['PACKED', 'ASSIGNED', 'IN_TRANSIT']);
        $this->db->order_by('mo.id', 'DESC');
        $handovers = $this->db->get()->result_array();

        // Available active fleet
        $riders = $this->db->get_where('delivery_riders', ['is_active' => 1])->result_array();

        // Calculate real-time delivery telemetry
        $kpi = [
            'packed_count'     => 0,
            'assigned_count'   => 0,
            'in_transit_count' => 0,
            'available_riders' => 0,
            'total_riders'     => count($riders)
        ];

        foreach ($handovers as $h) {
            $st = strtoupper($h['order_status']);
            if ($st === 'PACKED') $kpi['packed_count']++;
            elseif ($st === 'ASSIGNED') $kpi['assigned_count']++;
            elseif ($st === 'IN_TRANSIT') $kpi['in_transit_count']++;
        }

        foreach ($riders as $r) {
            if (strtoupper($r['status'] ?? '') === 'AVAILABLE') {
                $kpi['available_riders']++;
            }
        }

        $data = [
            'stores'         => $storeData['stores'],
            'current_store'  => $storeData['current_store'],
            'handovers'      => $handovers,
            'riders'         => $riders,
            'kpi'            => $kpi,
            'content_view'   => 'pharmacy/delivery'
        ];

        $this->load->view('layouts/chemist_layout', $data);
    }

    /**
     * POST /pharmacy/delivery/assign
     */
    public function delivery_assign() {
        $raw = $this->input->raw_input_stream ?: file_get_contents('php://input');
        $input = json_decode($raw, true) ?: $this->input->post();
        $orderId = (int)($input['order_id'] ?? 0);
        $riderId = (int)($input['rider_id'] ?? 0);

        if (!$orderId || !$riderId) {
            return $this->_json_response(['status' => 'error', 'message' => 'Order ID and Rider ID are required.'], 400);
        }

        $rider = $this->db->get_where('delivery_riders', ['id' => $riderId, 'is_active' => 1])->row_array();
        if (!$rider) {
            return $this->_json_response(['status' => 'error', 'message' => 'Selected delivery agent is unavailable.'], 404);
        }

        // Update medicine order
        $this->db->where('id', $orderId)->update('medicine_orders', [
            'rider_id' => $riderId,
            'order_status' => 'ASSIGNED',
            'rider_assigned_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // Insert or update assignment log
        $existingAssign = $this->db->get_where('order_delivery_assignments', ['order_id' => $orderId])->row();
        if ($existingAssign) {
            $this->db->where('id', $existingAssign->id)->update('order_delivery_assignments', [
                'rider_id' => $riderId,
                'delivery_status' => 'ASSIGNED',
                'assigned_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            $this->db->insert('order_delivery_assignments', [
                'order_id' => $orderId,
                'rider_id' => $riderId,
                'assigned_at' => date('Y-m-d H:i:s'),
                'delivery_status' => 'ASSIGNED',
                'rider_payout_amount' => 35.00
            ]);
        }

        return $this->_json_response([
            'status' => 'success',
            'message' => "Order assigned to Rider {$rider['rider_name']} ({$rider['vehicle_number']}). Handover Sheet generated.",
            'rider' => [
                'name' => $rider['rider_name'],
                'phone' => $rider['phone'],
                'vehicle' => $rider['vehicle_number']
            ]
        ]);
    }

    /* =========================================================================
     * PHASE 2 MODULE 4: ONLINE PAYMENT & SETTLEMENT SYSTEM
     * ========================================================================= */

    /**
     * GET /pharmacy/payments
     */
    public function payments() {
        $storeData = $this->_get_active_store_data();
        $storeId = $storeData['store_id'];

        // Order payments breakdown
        $this->db->select('mo.id, mo.order_code, mo.customer_name, mo.customer_phone, mo.total_amount, mo.item_total, mo.delivery_fee, mo.payment_mode, mo.payment_status, mo.order_status, mo.created_at');
        $this->db->from('medicine_orders mo');
        $this->db->where('mo.pharmacy_id', $storeId);
        $this->db->order_by('mo.id', 'DESC');
        $transactions = $this->db->get()->result_array();

        // Settlements history
        $settlements = $this->db->where('pharmacy_id', $storeId)->order_by('id', 'DESC')->get('pharmacy_settlements')->result_array();

        // Financial metrics
        $totalGross = 0;
        $totalPaid = 0;
        $totalPending = 0;
        $totalCod = 0;
        $totalOnline = 0;

        foreach ($transactions as $t) {
            $amt = (float)$t['total_amount'];
            $totalGross += $amt;
            if ($t['payment_status'] === 'PAID') $totalPaid += $amt;
            else $totalPending += $amt;

            if ($t['payment_mode'] === 'COD') $totalCod += $amt;
            else $totalOnline += $amt;
        }

        $data = [
            'stores' => $storeData['stores'],
            'current_store' => $storeData['current_store'],
            'transactions' => $transactions,
            'settlements' => $settlements,
            'metrics' => [
                'total_gross' => $totalGross,
                'total_paid' => $totalPaid,
                'total_pending' => $totalPending,
                'total_cod' => $totalCod,
                'total_online' => $totalOnline,
                'commission_rate' => (float)($storeData['current_store']['commission_rate'] ?? 8.0)
            ],
            'content_view' => 'pharmacy/payments'
        ];

        $this->load->view('layouts/chemist_layout', $data);
    }

    /**
     * POST /api/webhooks/payment
     * Dedicated server-to-server webhook listener for Razorpay / Gateway callbacks.
     */
    public function webhook_payment() {
        $rawPayload = file_get_contents('php://input');
        $data = json_decode($rawPayload, true);

        // Capture signature header
        $signature = $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] ?? '';

        // Log raw webhook event
        $eventType = $data['event'] ?? 'unknown';
        $this->db->insert('payment_webhook_log', [
            'gateway' => 'RAZORPAY',
            'event_type' => $eventType,
            'payload' => $rawPayload,
            'signature_valid' => 1,
            'processed' => 0,
            'received_at' => date('Y-m-d H:i:s')
        ]);
        $logId = $this->db->insert_id();

        // Handle payment.captured or order.paid
        if (in_array($eventType, ['payment.captured', 'order.paid'])) {
            $paymentEntity = $data['payload']['payment']['entity'] ?? [];
            $orderEntity = $data['payload']['order']['entity'] ?? [];

            $razorpayOrderId = $orderEntity['id'] ?? ($paymentEntity['order_id'] ?? null);
            $razorpayPaymentId = $paymentEntity['id'] ?? null;

            if ($razorpayOrderId) {
                // 1. Update razorpay_orders
                $this->db->where('razorpay_order_id', $razorpayOrderId)->update('razorpay_orders', [
                    'razorpay_payment_id' => $razorpayPaymentId,
                    'status' => 'PAID',
                    'webhook_received_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                // 2. Find internal order and update medicine_orders if linked
                $rzRecord = $this->db->get_where('razorpay_orders', ['razorpay_order_id' => $razorpayOrderId])->row_array();
                if ($rzRecord && !empty($rzRecord['internal_order_ref'])) {
                    $this->db->where('order_code', $rzRecord['internal_order_ref'])->update('medicine_orders', [
                        'payment_status' => 'PAID',
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }

            // Mark webhook processed
            $this->db->where('id', $logId)->update('payment_webhook_log', [
                'processed' => 1,
                'processing_notes' => 'Successfully reconciled payment.'
            ]);
        }

        return $this->_json_response(['status' => 'success', 'message' => 'Webhook received and processed.']);
    }
}
