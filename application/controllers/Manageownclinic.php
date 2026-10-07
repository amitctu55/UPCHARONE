<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Manageownclinic Controller
 * Dedicated controller for doctor clinics management
 */
class Manageownclinic extends CI_Controller 
{
    protected $did = null;

    public function __construct() 
    {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('Doctor_Model');
        $this->load->database();

        // Doctor Authentication Check
        if (!$this->session->userdata('druserid')) {
            if ($this->input->is_ajax_request()) {
                header('Content-Type: application/json');
                echo json_encode(array('status' => 'error', 'message' => 'Your doctor session has expired. Please log in again.'));
                exit;
            }
            redirect('doctor-login');
            return;
        }

        $druserid = $this->session->userdata('druserid');
        $row = $this->db->where('user_id', $druserid)->or_where('id', $druserid)->get('profile_dr')->row();
        $this->did = ($row && isset($row->id)) ? $row->id : $druserid;
    }

    /**
     * Main listing of doctor's own/claimed clinics
     * Route: /manageownclinic
     */
    public function index()
    {
        // Handle Clinic Profile Form Submission
        if ($this->input->post('submit')) {
            $this->Doctor_Model->profile_step2();
        }

        $clinics = array();
        if ($this->did && $this->db->table_exists('clinic_claimed') && $this->db->table_exists('clinic')) {
            $clinics = $this->db->select('clinic.*, clinic_claimed.status as claim_status')
                ->join('clinic', 'clinic.id = clinic_claimed.clinic_id')
                ->get_where('clinic_claimed', array('clinic_claimed.did' => $this->did))
                ->result();
        }

        $data['data'] = $clinics;
        $this->load->view('doctorpanel/manageownclinic', $data);
    }

    /**
     * Add new clinic chamber
     * Route: /manageownclinic/addclinic
     */
    public function addclinic()
    {
        redirect('doctorpanel/addclinic');
    }

    /**
     * Update existing clinic chamber
     * Route: /manageownclinic/updateclinic/:id
     */
    public function updateclinic($id = 0)
    {
        redirect('doctorpanel/updateclinic/' . intval($id));
    }
}
