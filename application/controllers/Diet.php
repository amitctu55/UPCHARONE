<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diet extends CI_Controller {

    private $user_id = 0;
    private $user_obj = null;

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
        $this->load->model('Diet_model');
        $this->load->helper(['url', 'form']);
        $this->resolve_user();
    }

    /**
     * Resolve active patient user from session
     */
    private function resolve_user() {
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
        }
    }

    /**
     * Verify session or return JSON 401
     */
    private function require_login() {
        if ($this->user_id > 0) return true;

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
                    'message'  => 'Your session has expired. Please login to track your diet.',
                    'redirect' => base_url('login')
                ]));
            exit;
        }

        $this->session->set_userdata('last_page', current_url());
        $this->session->set_flashdata('flashmsg', '<div class="alert alert-warning">Please login to access your Daily Diet Tracker.</div>');
        redirect('login');
        exit;
    }

    /**
     * Main Daily Diet Tracker Dashboard
     */
    public function index() {
        $this->require_login();

        $selected_date = $this->input->get('date') ? date('Y-m-d', strtotime($this->input->get('date'))) : date('Y-m-d');
        $data['summary'] = $this->Diet_model->get_daily_summary($this->user_id, $selected_date);
        $data['user'] = $this->user_obj;
        $data['active_tab'] = 'diet';

        $this->load->view('patient_header', $data);
        $this->load->view('diet_tracker', $data);
        $this->load->view('patient_footer');
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
     * AJAX: Log a food item into a meal category
     */
    public function add_log() {
        $this->require_login();

        $meal_category = strtolower(trim($this->input->post('meal_category', TRUE) ?: 'breakfast'));
        $allowed = ['breakfast', 'brunch', 'lunch', 'snacks', 'dinner'];
        if (!in_array($meal_category, $allowed)) {
            $meal_category = 'breakfast';
        }

        $quantity = max(0.1, floatval($this->input->post('quantity', TRUE) ?: 1));
        $food_id  = intval($this->input->post('food_id', TRUE) ?: 0);
        $food_name = trim($this->input->post('food_name', TRUE) ?: '');
        $log_date = $this->input->post('log_date', TRUE) ? date('Y-m-d', strtotime($this->input->post('log_date', TRUE))) : date('Y-m-d');

        if ($food_id <= 0 && empty($food_name)) {
            $this->output
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'status'  => 'error',
                    'message' => 'Please select a food item or enter a food name.'
                ]));
            return;
        }

        $log_data = [
            'food_id'       => $food_id > 0 ? $food_id : null,
            'food_name'     => $food_name,
            'meal_category' => $meal_category,
            'quantity'      => $quantity,
            'serving_unit'  => trim($this->input->post('serving_unit', TRUE) ?: 'serving'),
            'log_date'      => $log_date,
            'calories'      => floatval($this->input->post('calories', TRUE) ?: 0),
            'protein'       => floatval($this->input->post('protein', TRUE) ?: 0),
            'carbs'         => floatval($this->input->post('carbs', TRUE) ?: 0),
            'fats'          => floatval($this->input->post('fats', TRUE) ?: 0),
            'fiber'         => floatval($this->input->post('fiber', TRUE) ?: 0),
            'iron'          => floatval($this->input->post('iron', TRUE) ?: 0),
            'calcium'       => floatval($this->input->post('calcium', TRUE) ?: 0),
            'vitamin_c'     => floatval($this->input->post('vitamin_c', TRUE) ?: 0),
            'notes'         => trim($this->input->post('notes', TRUE) ?: '')
        ];

        $insert_id = $this->Diet_model->log_meal($this->user_id, $log_data);

        if ($insert_id) {
            $summary = $this->Diet_model->get_daily_summary($this->user_id, $log_date);
            $this->output
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'status'    => 'success',
                    'message'   => 'Food logged successfully to ' . ucfirst($meal_category) . '!',
                    'insert_id' => $insert_id,
                    'summary'   => $summary
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

    /**
     * AJAX: Delete a logged item
     */
    public function delete_log() {
        $this->require_login();

        $log_id   = intval($this->input->post('log_id', TRUE) ?: ($this->input->get('log_id', TRUE) ?: 0));
        $log_date = $this->input->post('log_date', TRUE) ?: ($this->input->get('log_date', TRUE) ?: date('Y-m-d'));
        $log_date = date('Y-m-d', strtotime($log_date));

        if ($log_id <= 0) {
            $this->output
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Invalid log entry ID.']));
            return;
        }

        $res = $this->Diet_model->delete_log($log_id, $this->user_id);
        if ($res) {
            $summary = $this->Diet_model->get_daily_summary($this->user_id, $log_date);
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

        $date = $this->input->get('date', TRUE) ?: ($this->input->post('date', TRUE) ?: date('Y-m-d'));
        $date = date('Y-m-d', strtotime($date));

        $summary = $this->Diet_model->get_daily_summary($this->user_id, $date);

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
