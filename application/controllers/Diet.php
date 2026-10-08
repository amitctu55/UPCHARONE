<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diet extends CI_Controller {

    private $user_id = 0;          // Active patient ID being tracked
    private $user_obj = null;       // Patient record
    private $user_role = 'guest';   // 'patient', 'doctor', 'hospital', 'guest'
    private $entity_ids = [];       // Doctor ID(s) or Hospital ID(s)
    private $entity_obj = null;     // Doctor or Hospital profile row
    private $is_practitioner = false;

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
        $this->load->model('Diet_model');
        $this->load->helper(['url', 'form']);
        $this->resolve_session_and_role();
    }

    /**
     * Resolve active user session, role (Doctor / Hospital / Patient), and permissions
     */
    private function resolve_session_and_role() {
        // 1. Check Doctor Session
        $druserid = $this->session->userdata('druserid') ?: $this->session->userdata('doctor_id') ?: $this->session->userdata('did');
        if (!empty($druserid)) {
            $this->user_role = 'doctor';
            $this->is_practitioner = true;

            $dr_row = $this->db->where('user_id', $druserid)->or_where('id', $druserid)->get('profile_dr')->row();
            $this->entity_obj = $dr_row;

            $this->entity_ids = array_unique(array_filter([
                intval($druserid),
                $dr_row && isset($dr_row->id) ? intval($dr_row->id) : null,
                $dr_row && isset($dr_row->user_id) ? intval($dr_row->user_id) : null
            ]));
            return;
        }

        // 2. Check Hospital Session
        $hospuserid = $this->session->userdata('hospital_id') ?: $this->session->userdata('hospuserid') ?: $this->session->userdata('hospital_admin');
        if (!empty($hospuserid)) {
            $this->user_role = 'hospital';
            $this->is_practitioner = true;

            $hosp_row = $this->db->where('user_id', $hospuserid)->or_where('id', $hospuserid)->get('profile_hospital')->row();
            $this->entity_obj = $hosp_row;

            $this->entity_ids = array_unique(array_filter([
                intval($hospuserid),
                $hosp_row && isset($hosp_row->id) ? intval($hosp_row->id) : null,
                $hosp_row && isset($hosp_row->user_id) ? intval($hosp_row->user_id) : null
            ]));
            return;
        }

        // 3. Check Patient Session
        $userid    = $this->session->userdata('userid') ?: $this->session->userdata('user_id') ?: $this->session->userdata('USERID');
        $useremail = $this->session->userdata('useremail');
        $username  = $this->session->userdata('username');

        if (!empty($userid)) {
            $this->user_obj = $this->db->get_where('userlogin', ['USERID' => $userid])->row();
        }

        if (!$this->user_obj && !empty($useremail)) {
            $this->user_obj = $this->db->get_where('userlogin', ['EMAIL' => $useremail])->row();
            if ($this->user_obj) {
                $this->session->set_userdata('userid', $this->user_obj->USERID);
            }
        }

        if (!$this->user_obj && !empty($username)) {
            $this->user_obj = $this->db->group_start()
                ->where('EMAIL', $username)
                ->or_where('MOBILE', $username)
                ->or_where('FNAME', $username)
                ->group_end()
                ->get('userlogin')->row();
            if ($this->user_obj) {
                $this->session->set_userdata('userid', $this->user_obj->USERID);
            }
        }

        // Admin fallback if viewing patient panel in same session
        if (!$this->user_obj && $this->session->userdata('adminuserid')) {
            $admin = $this->db->get_where('login', ['id' => $this->session->userdata('adminuserid')])->row();
            if ($admin && !empty($admin->email)) {
                $this->user_obj = $this->db->get_where('userlogin', ['EMAIL' => $admin->email])->row();
                if ($this->user_obj) {
                    $this->session->set_userdata('userid', $this->user_obj->USERID);
                }
            }
        }

        if ($this->user_obj) {
            $this->user_id = intval($this->user_obj->USERID);
            $this->user_role = 'patient';
        }
    }

    /**
     * Resolve target patient based on role, parameters, and appointment status authorization
     */
    private function resolve_target_patient($param_patient_id = null) {
        if (!$this->is_practitioner) {
            return $this->user_id;
        }

        $req_id = intval($param_patient_id ?: ($this->input->get('patient_id') ?: $this->input->post('patient_id')));

        // If specific patient requested, verify strict authorization
        if ($req_id > 0) {
            $is_auth = $this->Diet_model->is_patient_authorized($req_id, $this->user_role, $this->entity_ids);
            if ($is_auth) {
                $this->user_id = $req_id;
                $this->user_obj = $this->db->get_where('userlogin', ['USERID' => $req_id])->row();
                return $this->user_id;
            } else {
                return 0; // Unauthorized
            }
        }

        // If no patient requested, default to first authorized patient
        $authorized = $this->Diet_model->get_authorized_patients($this->user_role, $this->entity_ids);
        if (!empty($authorized)) {
            $first = $authorized[0];
            $this->user_id = intval($first['user_id']);
            $this->user_obj = $this->db->get_where('userlogin', ['USERID' => $this->user_id])->row();
            return $this->user_id;
        }

        return 0;
    }

    /**
     * Verify session or return JSON 401
     */
    private function require_login() {
        if ($this->is_practitioner || $this->user_id > 0) return true;

        $is_ajax = $this->input->is_ajax_request()
            || $this->input->post('ajax')
            || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
            || (isset($_SERVER['HTTP_ACCEPT']) && stripos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);

        if ($is_ajax) {
            $this->output
                ->set_status_header(401)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'status'   => 'error',
                    'message'  => 'Your session has expired. Please login to track or view diet.',
                    'redirect' => base_url('login')
                ]));
            exit;
        }

        $this->session->set_userdata('last_page', current_url());
        $this->session->set_flashdata('flashmsg', '<div class="alert alert-warning">Please login to access the Daily Diet Tracker.</div>');
        redirect('login');
        exit;
    }

    /**
     * Main Daily Diet Tracker Dashboard
     */
    public function index() {
        $this->require_login();

        $authorized_patients = [];
        $unauthorized_access = false;

        if ($this->is_practitioner) {
            // Fetch patients strictly with pending or active appointments
            $authorized_patients = $this->Diet_model->get_authorized_patients($this->user_role, $this->entity_ids);
            
            $req_patient_id = intval($this->input->get('patient_id'));
            if ($req_patient_id > 0) {
                $target_id = $this->resolve_target_patient($req_patient_id);
                if ($target_id === 0) {
                    $unauthorized_access = true;
                }
            } else {
                $this->resolve_target_patient();
            }
        }

        $selected_date = $this->Diet_model->normalize_date($this->input->get('date'));
        
        $data['summary'] = ($this->user_id > 0 && !$unauthorized_access) 
            ? $this->Diet_model->get_daily_summary($this->user_id, $selected_date) 
            : null;

        $data['user'] = $this->user_obj;
        $data['active_tab'] = 'diet';
        $data['is_practitioner'] = $this->is_practitioner;
        $data['user_role'] = $this->user_role;
        $data['authorized_patients'] = $authorized_patients;
        $data['active_patient_id'] = $this->user_id;
        $data['unauthorized_access'] = $unauthorized_access;
        $data['practitioner_obj'] = $this->entity_obj;

        // Choose appropriate header/footer based on role
        if ($this->user_role === 'doctor') {
            $this->load->view('assets/includes/header.php');
            $this->load->view('assets/includes/leftmenu.php');
            $this->load->view('diet_tracker', $data);
            $this->load->view('assets/includes/footer.php');
        } elseif ($this->user_role === 'hospital') {
            $this->load->view('assets/includes/header.php');
            $this->load->view('assets/includes/leftmenu.php');
            $this->load->view('diet_tracker', $data);
            $this->load->view('assets/includes/footer.php');
        } else {
            $this->load->view('patient_header', $data);
            $this->load->view('diet_tracker', $data);
            $this->load->view('patient_footer');
        }
    }

    /**
     * API: Get authorized patients list strictly for active/pending appointments
     */
    public function get_patients() {
        $this->require_login();

        if (!$this->is_practitioner) {
            $this->output
                ->set_status_header(403)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Available only for Doctor & Hospital Panel partners.']));
            return;
        }

        $patients = $this->Diet_model->get_authorized_patients($this->user_role, $this->entity_ids);

        $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'status' => 'success',
                'role'   => $this->user_role,
                'count'  => count($patients),
                'data'   => $patients
            ]));
    }

    /**
     * AJAX: Search food items for autocomplete
     */
    public function search_food() {
        $keyword = $this->input->get('q', TRUE) ?: ($this->input->post('q', TRUE) ?: ($this->input->get('keyword', TRUE) ?: ''));
        
        $results = $this->Diet_model->search_foods($keyword, 25);

        $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'status' => 'success',
                'count'  => count($results),
                'data'   => $results
            ]));
    }

    /**
     * AJAX: Add food log entry to a meal category
     */
    public function add_food_log() {
        $this->require_login();

        $target_user_id = $this->user_id;
        if ($this->is_practitioner) {
            $req_pid = intval($this->input->post('patient_id') ?: $this->input->get('patient_id'));
            $target_user_id = $this->resolve_target_patient($req_pid);
            if ($target_user_id <= 0) {
                $this->output
                    ->set_status_header(403)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode([
                        'status'  => 'error',
                        'message' => 'Unauthorized: Patient details can only be modified for patients with active or pending appointments.'
                    ]));
                return;
            }
        }

        if ($target_user_id <= 0) {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode(['status' => 'error', 'message' => 'No active patient selected.']));
            return;
        }

        $meal_category = strtolower(trim($this->input->post('meal_category', TRUE) ?: 'breakfast'));
        $allowed = ['breakfast', 'brunch', 'lunch', 'snacks', 'dinner'];
        if (!in_array($meal_category, $allowed)) {
            $meal_category = 'breakfast';
        }

        $quantity  = max(0.1, floatval($this->input->post('quantity', TRUE) ?: 1));
        $food_id   = intval($this->input->post('food_id', TRUE) ?: 0);
        $food_name = trim($this->input->post('food_name', TRUE) ?: '');
        $log_date  = $this->Diet_model->normalize_date($this->input->post('log_date', TRUE));

        if ($food_id <= 0 && empty($food_name)) {
            $this->output
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'status'  => 'error',
                    'message' => 'Please select a food item or enter a food name.'
                ]));
            return;
        }

        // Base nutritional values
        $base_food = null;
        if ($food_id > 0) {
            $base_food = $this->Diet_model->get_food_by_id($food_id);
            if ($base_food && empty($food_name)) {
                $food_name = $base_food['name'];
            }
        }

        $serving_unit = trim($this->input->post('serving_unit', TRUE) ?: ($base_food['serving_unit'] ?? 'serving'));

        if ($base_food) {
            $base_serv  = floatval($base_food['serving_size']) > 0 ? floatval($base_food['serving_size']) : 1.0;
            $multiplier = $quantity / $base_serv;

            $calories  = round(floatval($base_food['calories'] ?? 0) * $multiplier, 1);
            $protein   = round(floatval($base_food['protein'] ?? 0) * $multiplier, 1);
            $carbs     = round(floatval($base_food['carbs'] ?? 0) * $multiplier, 1);
            $fats      = round(floatval($base_food['fats'] ?? 0) * $multiplier, 1);
            $fiber     = round(floatval($base_food['fiber'] ?? 0) * $multiplier, 1);
            $iron      = round(floatval($base_food['iron'] ?? 0) * $multiplier, 2);
            $calcium   = round(floatval($base_food['calcium'] ?? 0) * $multiplier, 1);
            $vitamin_c = round(floatval($base_food['vitamin_c'] ?? 0) * $multiplier, 1);
        } else {
            $calories  = round(floatval($this->input->post('calories', TRUE) ?: 0), 1);
            $protein   = round(floatval($this->input->post('protein', TRUE) ?: 0), 1);
            $carbs     = round(floatval($this->input->post('carbs', TRUE) ?: 0), 1);
            $fats      = round(floatval($this->input->post('fats', TRUE) ?: 0), 1);
            $fiber     = round(floatval($this->input->post('fiber', TRUE) ?: 0), 1);
            $iron      = round(floatval($this->input->post('iron', TRUE) ?: 0), 2);
            $calcium   = round(floatval($this->input->post('calcium', TRUE) ?: 0), 1);
            $vitamin_c = round(floatval($this->input->post('vitamin_c', TRUE) ?: 0), 1);
        }

        $log_data = [
            'user_id'       => $target_user_id,
            'food_id'       => $food_id > 0 ? $food_id : null,
            'food_name'     => $food_name,
            'meal_category' => $meal_category,
            'quantity'      => $quantity,
            'serving_unit'  => $serving_unit,
            'log_date'      => $log_date,
            'calories'      => $calories,
            'protein'       => $protein,
            'carbs'         => $carbs,
            'fats'          => $fats,
            'fiber'         => $fiber,
            'iron'          => $iron,
            'calcium'       => $calcium,
            'vitamin_c'     => $vitamin_c,
            'notes'         => trim($this->input->post('notes', TRUE) ?: '')
        ];

        $insert_id = $this->Diet_model->insert_diet_log($log_data);

        if ($insert_id) {
            $summary = $this->Diet_model->get_daily_summary($target_user_id, $log_date);

            $this->output
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'status'        => 'success',
                    'message'       => 'Logged "' . $food_name . '" to ' . ucfirst($meal_category) . '!',
                    'insert_id'     => $insert_id,
                    'meal_category' => $meal_category,
                    'logged_item'   => [
                        'id'           => $insert_id,
                        'food_id'      => $food_id,
                        'food_name'    => $food_name,
                        'meal_category'=> $meal_category,
                        'quantity'     => $quantity,
                        'serving_unit' => $serving_unit,
                        'calories'     => $calories,
                        'protein'      => $protein,
                        'carbs'        => $carbs,
                        'fats'         => $fats,
                        'fiber'        => $fiber,
                        'iron'         => $iron,
                        'calcium'      => $calcium,
                        'vitamin_c'    => $vitamin_c,
                        'notes'        => $log_data['notes']
                    ],
                    'summary'       => $summary
                ]));
        } else {
            $this->output
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'status'  => 'error',
                    'message' => 'Unable to save food log. Please try again.'
                ]));
        }
    }

    public function add_log() {
        return $this->add_food_log();
    }

    /**
     * AJAX: Delete a logged item
     */
    public function delete_log() {
        $this->require_login();

        $target_user_id = $this->user_id;
        if ($this->is_practitioner) {
            $req_pid = intval($this->input->post('patient_id') ?: $this->input->get('patient_id'));
            $target_user_id = $this->resolve_target_patient($req_pid);
            if ($target_user_id <= 0) {
                $this->output
                    ->set_status_header(403)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode(['status' => 'error', 'message' => 'Unauthorized access to patient data.']));
                return;
            }
        }

        $log_id   = intval($this->input->post('log_id', TRUE) ?: ($this->input->get('log_id', TRUE) ?: 0));
        $log_date = $this->Diet_model->normalize_date($this->input->post('log_date', TRUE) ?: ($this->input->get('log_date', TRUE) ?: date('Y-m-d')));

        if ($log_id <= 0) {
            $this->output
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Invalid log entry ID.']));
            return;
        }

        $res = $this->Diet_model->delete_log($log_id, $target_user_id);
        if ($res) {
            $summary = $this->Diet_model->get_daily_summary($target_user_id, $log_date);
            $this->output
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'status'  => 'success',
                    'message' => 'Food entry removed.',
                    'summary' => $summary
                ]));
        } else {
            $this->output
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Could not remove item.']));
        }
    }

    /**
     * AJAX: Fetch complete summary for given date
     */
    public function get_summary() {
        $this->require_login();

        $target_user_id = $this->user_id;
        if ($this->is_practitioner) {
            $req_pid = intval($this->input->get('patient_id') ?: $this->input->post('patient_id'));
            $target_user_id = $this->resolve_target_patient($req_pid);
            if ($target_user_id <= 0) {
                $this->output
                    ->set_status_header(403)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode(['status' => 'error', 'message' => 'Unauthorized access to patient summary.']));
                return;
            }
        }

        $date = $this->Diet_model->normalize_date($this->input->get('date', TRUE) ?: ($this->input->post('date', TRUE) ?: date('Y-m-d')));

        $summary = $this->Diet_model->get_daily_summary($target_user_id, $date);

        $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'status'  => 'success',
                'summary' => $summary
            ]));
    }

    /**
     * AJAX: Add custom food item to database
     */
    public function add_custom_food() {
        $this->require_login();

        $name = trim($this->input->post('name', TRUE));
        if (empty($name)) {
            $this->output
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Food name is required.']));
            return;
        }

        $food_id = $this->Diet_model->add_custom_food($this->input->post(NULL, TRUE));
        $food = $this->Diet_model->get_food_by_id($food_id);

        $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'status'  => 'success',
                'message' => 'Custom food saved to database!',
                'food'    => $food
            ]));
    }
}
