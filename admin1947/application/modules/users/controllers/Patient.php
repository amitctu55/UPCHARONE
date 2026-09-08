<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('Patient_model');
        $this->load->helper(array('query_string_helper', 'dbquery_helper', 'admin_helper'));
    }

    public function index() {
        $pagesize = (int) $this->input->get_post('pagesize');
        $limit    = ($pagesize > 0) ? $pagesize : 10;
        $offset   = (int) $this->input->get_post('per_page');

        $filters = array(
            'keyword'     => trim($this->input->get_post('keyword')),
            'mobile'      => trim($this->input->get_post('mobile')),
            'status'      => $this->input->get_post('status'),
            'blood_group' => $this->input->get_post('blood_group')
        );

        $data['patients']   = $this->Patient_model->get_patients($limit, $offset, $filters);
        $total_rows         = get_found_rows();
        $data['total_rows'] = $total_rows;

        $base_url           = current_url_query_string(array('filter' => 'result'), array('per_page'));
        $data['page_links'] = admin_pagination($base_url, $total_rows, $limit, $offset);

        // High-level KPI Counters
        $data['total_all_patients'] = $this->db->count_all('userlogin');
        $data['total_active_patients'] = $this->db->where('STATUS', '1')->count_all_results('userlogin');
        $data['total_bookings'] = $this->db->table_exists('appointment') ? $this->db->count_all('appointment') : 0;
        
        $pts_q = $this->db->table_exists('user_wallet') ? $this->db->select_sum('points_balance')->get('user_wallet')->row() : null;
        $data['total_wallet_points'] = ($pts_q && isset($pts_q->points_balance)) ? floatval($pts_q->points_balance) : 0;

        $data['filters']       = $filters;
        $data['heading_title'] = 'Patient & User Management';
        $data['module']        = 'Patients';

        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('patient_directory_view', $data);
        $this->load->view('sidebar');
        $this->load->view('inc/headersetting');
        $this->load->view('inc/footerlink');
        $this->load->view('inc/table_footer');
    }

    /**
     * AJAX endpoint returning structured JSON for all 5 modal tabs
     */
    public function details_ajax($patient_id = 0) {
        $patient_id = (int)$patient_id ?: (int)$this->input->get_post('patient_id');
        if (!$patient_id) {
            echo json_encode(array('status' => 'error', 'message' => 'Invalid Patient ID.'));
            return;
        }

        $profile = $this->Patient_model->get_patient_profile($patient_id);
        if (!$profile) {
            echo json_encode(array('status' => 'error', 'message' => 'Patient profile not found.'));
            return;
        }

        $response = array(
            'status'          => 'success',
            'profile'         => $profile,
            'appointments'    => $this->Patient_model->get_patient_appointments($patient_id),
            'medical_history' => $this->Patient_model->get_patient_medical_history($patient_id),
            'payments'        => $this->Patient_model->get_patient_payments($patient_id),
            'rewards'         => $this->Patient_model->get_patient_rewards($patient_id)
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * Export filtered patient records to CSV
     */
    public function export_csv() {
        $filters = array(
            'keyword'     => trim($this->input->get('keyword')),
            'mobile'      => trim($this->input->get('mobile')),
            'status'      => $this->input->get('status'),
            'blood_group' => $this->input->get('blood_group')
        );

        $patients = $this->Patient_model->get_patients(5000, 0, $filters);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=upchar_patients_' . date('Ymd_His') . '.csv');

        $output = fopen('php://output', 'w');
        fputcsv($output, array('Medical ID', 'First Name', 'Last Name', 'Mobile', 'Email', 'Gender', 'DOB', 'Blood Group', 'Wallet Points', 'Total Bookings', 'Status', 'Registered At'));

        foreach ($patients as $p) {
            fputcsv($output, array(
                $p['medical_id'],
                $p['FNAME'],
                $p['LNAME'],
                $p['MOBILE'],
                $p['EMAIL'],
                $p['GENDER'],
                $p['DOB'],
                $p['BGROUP'],
                $p['wallet_points'],
                $p['total_appointments'],
                ($p['STATUS'] == '1' ? 'ACTIVE' : 'BLOCKED'),
                $p['REG_DATE']
            ));
        }
        fclose($output);
        exit;
    }

    /**
     * Toggle status (Active / Blocked)
     */
    public function toggle_status() {
        $patient_id = (int)$this->input->get_post('patient_id');
        $new_st = $this->Patient_model->toggle_status($patient_id);

        if ($this->input->is_ajax_request()) {
            echo json_encode(array(
                'status' => 'success',
                'new_status' => $new_st,
                'status_label' => ($new_st == '1' ? 'ACTIVE' : 'BLOCKED'),
                'message' => 'Status updated successfully'
            ));
            return;
        }

        $this->session->set_flashdata('flashmsg', '<div class="alert alert-success">Patient account status updated.</div>');
        redirect($_SERVER['HTTP_REFERER'] ?: base_url('users/patient'));
    }

    /**
     * Admin Reset Password
     */
    public function reset_password() {
        $patient_id   = (int)$this->input->post('patient_id');
        $new_password = $this->input->post('new_password');

        if ($patient_id && !empty($new_password)) {
            $this->Patient_model->reset_password($patient_id, $new_password);
            $msg = "Password reset successfully for Patient ID #" . $patient_id;

            if ($this->input->is_ajax_request()) {
                echo json_encode(array('status' => 'success', 'message' => $msg));
                return;
            }
            $this->session->set_flashdata('flashmsg', '<div class="alert alert-success">' . $msg . '</div>');
        } else {
            if ($this->input->is_ajax_request()) {
                echo json_encode(array('status' => 'error', 'message' => 'Missing patient ID or password'));
                return;
            }
            $this->session->set_flashdata('flashmsg', '<div class="alert alert-danger">Failed to reset password.</div>');
        }
        redirect($_SERVER['HTTP_REFERER'] ?: base_url('users/patient'));
    }
}
