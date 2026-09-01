<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Attendance Controller
 * Mobile Geofenced GPS & Selfie Punch-in Engine
 */
class Attendance extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Staff_model');
        $this->load->model('Attendance_model');
        $this->load->helper(['url', 'form']);
        $this->_check_auth();
    }

    private function _check_auth() {
        // Allow instant role switcher via query parameter
        $switchId = intval($this->input->get('staff_id'));
        if ($switchId > 0) {
            $u = $this->Staff_model->get_user_by_id($switchId);
            if ($u) {
                $this->session->set_userdata([
                    'staff_user_id' => $u['id'],
                    'staff_name'    => $u['name'],
                    'staff_email'   => $u['email'],
                    'staff_role'    => $u['role'],
                    'staff_dept'    => $u['department']
                ]);
            }
        }

        // If no staff user session is set, auto-set default active staff user (Demo Mode)
        if (!$this->session->userdata('staff_user_id')) {
            $defaultStaff = $this->db->where('status', 'active')->order_by('id', 'asc')->get('staff_users')->row_array();
            if ($defaultStaff) {
                $this->session->set_userdata([
                    'staff_user_id' => $defaultStaff['id'],
                    'staff_name'    => $defaultStaff['name'],
                    'staff_email'   => $defaultStaff['email'],
                    'staff_role'    => $defaultStaff['role'],
                    'staff_dept'    => $defaultStaff['department']
                ]);
            } else {
                $this->session->set_flashdata('error_msg', 'Please login to access attendance punch-in.');
                redirect('staff/login');
            }
        }
    }

    /**
     * Mobile Punch-in / Punch-out Screen
     */
    public function punch() {
        $userId = $this->session->userdata('staff_user_id');
        $today  = date('Y-m-d');

        $data['today_punch'] = $this->Attendance_model->get_today_punch($userId, $today);
        $data['user']        = $this->Staff_model->get_user_by_id($userId);
        $data['all_staff']   = $this->db->where('status', 'active')->order_by('role', 'asc')->get('staff_users')->result_array();
        $data['recent_logs'] = $this->Attendance_model->get_user_logs($userId, date('m'), date('Y'));

        $this->load->view('attendance/punch', $data);
    }

    /**
     * Reset Today's Punch (For Testing & Demo)
     */
    public function reset_today_punch() {
        $userId = $this->session->userdata('staff_user_id');
        $today  = date('Y-m-d');
        $this->db->where(['user_id' => $userId, 'punch_date' => $today])->delete('staff_attendance');
        $this->session->set_flashdata('success_msg', "Today's attendance punch reset successfully.");
        redirect('attendance/punch');
    }

    /**
     * AJAX: Submit Punch In
     */
    public function record_punch_in() {
        $userId   = $this->session->userdata('staff_user_id');
        $lat      = floatval($this->input->post('lat')) ?: 26.8467;
        $lng      = floatval($this->input->post('lng')) ?: 80.9462;
        $selfie   = $this->input->post('selfie'); // base64 string
        $notes    = trim($this->input->post('notes', TRUE)) ?: 'Mobile WebRTC Punch';

        $res = $this->Attendance_model->punch_in($userId, $lat, $lng, $selfie, $notes);
        echo json_encode($res);
    }

    /**
     * AJAX: Submit Punch Out
     */
    public function record_punch_out() {
        $userId   = $this->session->userdata('staff_user_id');
        $lat      = floatval($this->input->post('lat')) ?: 26.8467;
        $lng      = floatval($this->input->post('lng')) ?: 80.9462;
        $notes    = trim($this->input->post('notes', TRUE)) ?: 'End of Day Check-out';

        $res = $this->Attendance_model->punch_out($userId, $lat, $lng, $notes);
        echo json_encode($res);
    }

    /**
     * Monthly Punch History
     */
    public function history() {
        $userId = $this->session->userdata('staff_user_id');
        $month  = $this->input->get('month') ?: date('m');
        $year   = $this->input->get('year') ?: date('Y');

        $data['user']  = $this->Staff_model->get_user_by_id($userId);
        $data['logs']  = $this->Attendance_model->get_user_logs($userId, $month, $year);
        $data['month'] = $month;
        $data['year']  = $year;
        $this->load->view('attendance/history', $data);
    }
}
