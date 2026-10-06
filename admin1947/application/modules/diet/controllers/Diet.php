<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diet extends CI_Controller {

    private $admin_id = 0;

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('diet/Admin_diet_model', 'Admin_diet_model');
        $this->load->helper(['url', 'form', 'query_string_helper', 'admin_helper']);

        $this->check_auth();
    }

    /**
     * Verify admin session or return 401 for AJAX
     */
    private function check_auth() {
        $this->admin_id = $this->session->userdata('adminuserid') ?: ($this->session->userdata('userid') ?: 0);
        $username = $this->session->userdata('username');

        // Check signed cookie guard fallback
        if (!$this->admin_id && empty($username) && !empty($_COOKIE['upchar_admin_guard'])) {
            try {
                $guard = json_decode(base64_decode($_COOKIE['upchar_admin_guard']), true);
                if (!empty($guard['adminuserid'])) {
                    $expectedSig = hash_hmac('sha256', $guard['adminuserid'] . '|' . ($guard['username'] ?? '') . '|super_admin', 'UpcharMasterAdminSecret2026');
                    if (isset($guard['sig']) && hash_equals($expectedSig, $guard['sig'])) {
                        $this->admin_id = intval($guard['adminuserid']);
                        $username = $guard['username'] ?? 'Admin';
                        $this->session->set_userdata('adminuserid', $this->admin_id);
                        $this->session->set_userdata('username', $username);
                    }
                }
            } catch (Throwable $e) {}
        }

        if (!$this->admin_id && empty($username)) {
            $is_ajax = $this->input->is_ajax_request()
                || $this->input->post('is_ajax')
                || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
                || (isset($_SERVER['HTTP_ACCEPT']) && stripos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);

            if ($is_ajax) {
                while (ob_get_level()) { ob_end_clean(); }
                header('Content-Type: application/json; charset=utf-8', true, 401);
                echo json_encode([
                    'status'   => 'error',
                    'message'  => 'Your admin session has expired. Please log in again.',
                    'redirect' => base_url('login')
                ]);
                exit;
            }
            redirect(base_url('login'));
            exit;
        }
    }

    /* ==========================================================
       1. FOOD MASTER DATABASE (CRUD)
       ========================================================== */

    /**
     * View List: All foods in food_master
     */
    public function index() {
        $this->foods();
    }

    public function foods() {
        $pagesize = (int) $this->input->get_post('pagesize');
        $limit    = ($pagesize > 0) ? $pagesize : 25;
        $offset   = (int) $this->input->get_post('per_page');

        $filters = [
            'keyword'  => trim($this->input->get_post('keyword')),
            'category' => trim($this->input->get_post('category')),
            'status'   => $this->input->get_post('status') ?: 'all',
            'is_veg'   => $this->input->get_post('is_veg') !== null ? $this->input->get_post('is_veg') : 'all',
            'sort_col' => $this->input->get_post('sort_col') ?: 'name',
            'sort_dir' => $this->input->get_post('sort_dir') ?: 'asc'
        ];

        $data['foods']      = $this->Admin_diet_model->get_foods($limit, $offset, $filters);
        $total_rows         = $this->Admin_diet_model->get_total_foods($filters);
        $data['total_rows'] = $total_rows;

        $base_url           = current_url_query_string(['filter' => 'result'], ['per_page']);
        $data['page_links'] = admin_pagination($base_url, $total_rows, $limit, $offset);

        $data['categories']    = $this->Admin_diet_model->get_categories();
        $data['kpis']          = $this->Admin_diet_model->get_diet_kpis();
        $data['filters']       = $filters;
        $data['heading_title'] = 'Food Database Master';
        $data['module']        = 'Diet';

        $this->load_admin_view('food_list_view', $data);
    }

    /**
     * Add New Food Item
     */
    public function add_food() {
        if ($this->input->method() === 'post') {
            $this->save_food_action(0);
            return;
        }

        $data['food']          = null;
        $data['categories']    = $this->Admin_diet_model->get_categories();
        $data['heading_title'] = 'Add New Food Item';
        $data['module']        = 'Diet';

        $this->load_admin_view('food_form_view', $data);
    }

    /**
     * Edit Food Item
     */
    public function edit_food($id = 0) {
        $id = (int)$id ?: (int)$this->input->get_post('id');
        $food = $this->Admin_diet_model->get_food_by_id($id);

        if (!$food) {
            $this->session->set_flashdata('flashmsg', '<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Food item not found.</div>');
            redirect(base_url('diet/foods'));
            return;
        }

        if ($this->input->method() === 'post') {
            $this->save_food_action($id);
            return;
        }

        $data['food']          = $food;
        $data['categories']    = $this->Admin_diet_model->get_categories();
        $data['heading_title'] = 'Edit Food Item: ' . html_escape($food->name);
        $data['module']        = 'Diet';

        $this->load_admin_view('food_form_view', $data);
    }

    /**
     * Handle Add/Edit save logic (Supports AJAX & Form POST)
     */
    private function save_food_action($id = 0) {
        $is_ajax = $this->input->is_ajax_request() || $this->input->post('ajax');

        $name = trim($this->input->post('name', TRUE));
        if (empty($name)) {
            if ($is_ajax) {
                echo json_encode(['status' => 'error', 'message' => 'Food Name is mandatory.']);
                return;
            }
            $this->session->set_flashdata('flashmsg', '<div class="alert alert-danger">Food Name is mandatory.</div>');
            redirect(base_url($id ? 'diet/edit_food/' . $id : 'diet/add_food'));
            return;
        }

        $post_data = [
            'name'         => $name,
            'category'     => trim($this->input->post('category', TRUE) ?: 'General'),
            'serving_size' => max(0.1, floatval($this->input->post('serving_size', TRUE) ?: 1)),
            'serving_unit' => trim($this->input->post('serving_unit', TRUE) ?: 'serving'),
            'calories'     => max(0, floatval($this->input->post('calories', TRUE) ?: 0)),
            'protein'      => max(0, floatval($this->input->post('protein', TRUE) ?: 0)),
            'carbs'        => max(0, floatval($this->input->post('carbs', TRUE) ?: 0)),
            'fats'         => max(0, floatval($this->input->post('fats', TRUE) ?: 0)),
            'fiber'        => max(0, floatval($this->input->post('fiber', TRUE) ?: 0)),
            'iron'         => max(0, floatval($this->input->post('iron', TRUE) ?: 0)),
            'calcium'      => max(0, floatval($this->input->post('calcium', TRUE) ?: 0)),
            'vitamin_c'    => max(0, floatval($this->input->post('vitamin_c', TRUE) ?: 0)),
            'is_veg'       => intval($this->input->post('is_veg', TRUE) ?: 0),
            'status'       => $this->input->post('status', TRUE) ?: 'active'
        ];

        $saved_id = $this->Admin_diet_model->save_food($post_data, $id);

        $action_word = $id ? 'updated' : 'added';
        $msg = "Food item \"{$name}\" successfully {$action_word}!";

        if ($is_ajax) {
            echo json_encode([
                'status'  => 'success',
                'message' => $msg,
                'id'      => $saved_id
            ]);
            return;
        }

        $this->session->set_flashdata('flashmsg', '<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' . $msg . '</div>');
        redirect(base_url('diet/foods'));
    }

    /**
     * AJAX: Get single food details for modal editing
     */
    public function get_food_ajax($id = 0) {
        $id = (int)$id ?: (int)$this->input->get_post('id');
        $food = $this->Admin_diet_model->get_food_by_id($id);

        if (!$food) {
            echo json_encode(['status' => 'error', 'message' => 'Food not found']);
            return;
        }

        echo json_encode([
            'status' => 'success',
            'data'   => $food
        ]);
    }

    /**
     * Delete food item
     */
    public function delete_food($id = 0) {
        $id = (int)$id ?: (int)$this->input->get_post('id');
        $is_ajax = $this->input->is_ajax_request() || $this->input->post('ajax');

        $food = $this->Admin_diet_model->get_food_by_id($id);
        if (!$food) {
            if ($is_ajax) {
                echo json_encode(['status' => 'error', 'message' => 'Food item not found']);
                return;
            }
            redirect(base_url('diet/foods'));
            return;
        }

        $this->Admin_diet_model->delete_food($id);
        $msg = "Food \"{$food->name}\" deleted successfully.";

        if ($is_ajax) {
            echo json_encode(['status' => 'success', 'message' => $msg]);
            return;
        }

        $this->session->set_flashdata('flashmsg', '<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' . $msg . '</div>');
        redirect(base_url('diet/foods'));
    }

    /**
     * AJAX: Toggle food active / inactive status
     */
    public function toggle_status($id = 0) {
        $id = (int)$id ?: (int)$this->input->get_post('id');
        $new_status = $this->Admin_diet_model->toggle_food_status($id);

        if (!$new_status) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update status']);
            return;
        }

        echo json_encode([
            'status'     => 'success',
            'new_status' => $new_status,
            'message'    => 'Food status changed to ' . ucfirst($new_status)
        ]);
    }

    /* ==========================================================
       2. PATIENT DIET TARGET MANAGEMENT
       ========================================================== */

    /**
     * Patient Diet Target Form & Dossier
     */
    public function targets($patient_id = 0) {
        $patient_id = (int)$patient_id ?: (int)$this->input->get_post('patient_id');

        if ($this->input->method() === 'post') {
            $this->save_patient_targets_action($patient_id);
            return;
        }

        $data['patient_id']    = $patient_id;
        $data['patient_data']  = $patient_id ? $this->Admin_diet_model->get_patient_targets($patient_id) : null;
        $data['recent_patients']= $this->Admin_diet_model->search_patients('', 10);
        $data['heading_title'] = 'Patient Diet Targets Management';
        $data['module']        = 'Diet';

        $this->load_admin_view('patient_targets_view', $data);
    }

    /**
     * Save patient custom targets
     */
    private function save_patient_targets_action($patient_id = 0) {
        $is_ajax = $this->input->is_ajax_request() || $this->input->post('ajax');
        $patient_id = (int)$patient_id ?: (int)$this->input->post('patient_id');

        if ($patient_id <= 0) {
            if ($is_ajax) {
                echo json_encode(['status' => 'error', 'message' => 'Please select a valid patient.']);
                return;
            }
            $this->session->set_flashdata('flashmsg', '<div class="alert alert-danger">Please select a valid patient.</div>');
            redirect(base_url('diet/targets'));
            return;
        }

        $target_data = [
            'target_calories' => max(800, floatval($this->input->post('target_calories', TRUE) ?: 2000)),
            'protein_g'       => max(10, floatval($this->input->post('protein_g', TRUE) ?: 65)),
            'carbs_g'         => max(10, floatval($this->input->post('carbs_g', TRUE) ?: 250)),
            'fat_g'           => max(10, floatval($this->input->post('fat_g', TRUE) ?: 55)),
            'fiber_g'         => max(0, floatval($this->input->post('fiber_g', TRUE) ?: 30)),
            'iron_mg'         => max(0, floatval($this->input->post('iron_mg', TRUE) ?: 18)),
            'calcium_mg'      => max(0, floatval($this->input->post('calcium_mg', TRUE) ?: 1000)),
            'vitamin_c_mg'    => max(0, floatval($this->input->post('vitamin_c_mg', TRUE) ?: 75)),
            'activity_level'  => trim($this->input->post('activity_level', TRUE) ?: 'moderate'),
            'fitness_goal'    => trim($this->input->post('fitness_goal', TRUE) ?: 'clinical_custom'),
            'clinical_notes'  => trim($this->input->post('clinical_notes', TRUE) ?: ''),
            'height_cm'       => floatval($this->input->post('height_cm', TRUE) ?: 0),
            'weight_kg'       => floatval($this->input->post('weight_kg', TRUE) ?: 0)
        ];

        $this->Admin_diet_model->save_patient_targets($patient_id, $target_data, $this->admin_id);

        $msg = "Clinical diet targets updated successfully for Patient #{$patient_id}!";

        if ($is_ajax) {
            echo json_encode(['status' => 'success', 'message' => $msg]);
            return;
        }

        $this->session->set_flashdata('flashmsg', '<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' . $msg . '</div>');
        redirect(base_url('diet/targets/' . $patient_id));
    }

    /**
     * AJAX: Search patients by keyword for autocomplete
     */
    public function search_patients_ajax() {
        $keyword = trim($this->input->get_post('q') ?: $this->input->get_post('keyword'));
        $patients = $this->Admin_diet_model->search_patients($keyword, 15);

        echo json_encode([
            'status' => 'success',
            'count'  => count($patients),
            'data'   => $patients
        ]);
    }

    /* ==========================================================
       3. PATIENT LOG MONITORING (VIEW ONLY)
       ========================================================== */

    /**
     * Patient Log Monitoring View
     */
    public function logs($patient_id = 0) {
        $patient_id = (int)$patient_id ?: (int)$this->input->get_post('patient_id');
        $date = $this->input->get_post('date') ? date('Y-m-d', strtotime($this->input->get_post('date'))) : date('Y-m-d');

        $data['patient_id']     = $patient_id;
        $data['selected_date']  = $date;
        $data['patient_data']   = $patient_id ? $this->Admin_diet_model->get_patient_targets($patient_id) : null;
        $data['log_summary']    = $patient_id ? $this->Admin_diet_model->get_patient_logs_by_date($patient_id, $date) : null;
        $data['recent_patients'] = $this->Admin_diet_model->search_patients('', 10);
        $data['heading_title']  = 'Patient Meal Log Monitor';
        $data['module']         = 'Diet';

        $this->load_admin_view('patient_logs_view', $data);
    }

    /**
     * Load view wrapped in Admin Layout
     */
    private function load_admin_view($view_name, $data = []) {
        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view($view_name, $data);
        $this->load->view('sidebar');
        $this->load->view('inc/headersetting');
        $this->load->view('inc/footerlink');
        $this->load->view('inc/table_footer');
    }
}
