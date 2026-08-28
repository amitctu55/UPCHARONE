<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller 
{
	function __construct()
	{
		 parent::__construct();
		 date_default_timezone_set("Asia/Kolkata");
		 $this->load->helper(array('query_string_helper','dbquery_helper','admin_helper'));
		 $this->load->model('Dashboardmodel');
		 $this->load->model('abdm/abdm_model'); // Load ABDM model

		 if(!$this->session->userdata('userid') && !$this->session->userdata('username'))
		 {
			 redirect(base_url().'login');
		 }
	}
	public function index()
    {
        // Get general statistics
        $data['approved_hospitals'] = $this->db->where('approved', '1')->where('verified', '1')->where('status !=', '2')->count_all_results('hospital');
        $data['pending_hospitals']  = $this->db->group_start()->where('approved', '0')->or_where('verified', '0')->group_end()->where('status !=', '2')->count_all_results('hospital');
        $data['total_hospitals']    = $data['approved_hospitals'];
        $data['total_clinics']      = $this->db->where('status', '1')->count_all_results('clinic');
        $data['total_doctors']      = $this->db->where('approved', '1')->where('verified', '1')->count_all_results('profile_dr');
        $data['total_appointments'] = $this->db->count_all_results('appointment');
        $data['total_users']        = $this->db->where('STATUS', '1')->where('APPROVED', '1')->count_all_results('userlogin');

        // Recent statistics (last 30 days)
        $data['recent_appointments'] = $this->db->where('appointment_date >=', date('Y-m-d', strtotime('-30 days')))->count_all_results('appointment');
        $data['recent_users'] = $this->db->where('REG_DATE >=', date('Y-m-d', strtotime('-30 days')))->where('STATUS', '1')->where('APPROVED', '1')->count_all_results('userlogin');

        // Appointment status breakdown
        $this->db->select('status, COUNT(*) as count');
        $this->db->from('appointment');
        $this->db->group_by('status');
        $appointment_status = $this->db->get()->result_array();
        $data['appointment_status'] = $appointment_status;

        // User registration trend (last 6 months)
        $this->db->select("DATE_FORMAT(REG_DATE, '%Y-%m') as month, COUNT(*) as count");
        $this->db->from('userlogin');
        $this->db->where('STATUS', '1');
        $this->db->where('APPROVED', '1');
        $this->db->group_by("DATE_FORMAT(REG_DATE, '%Y-%m')");
        $this->db->order_by("REG_DATE", "DESC");
        $this->db->limit(6);
        $user_trend = $this->db->get()->result_array();
        $data['user_trend'] = array_reverse($user_trend); // Oldest first for chart

        // Doctor specialization distribution (top 8)
        $this->db->select('ms.name as specialization, COUNT(pd.id) as count');
        $this->db->from('profile_dr pd');
        $this->db->join('master_specialization ms', 'pd.specialization = ms.id');
        $this->db->where('pd.approved', '1');
        $this->db->where('pd.verified', '1');
        $this->db->group_by('pd.specialization');
        $this->db->order_by('count', 'DESC');
        $this->db->limit(8);
        $spec_dist = $this->db->get()->result_array();
        $data['specialization_dist'] = $spec_dist;

        // Hospital approval status
        $this->db->select('approved, verified, COUNT(*) as count');
        $this->db->from('hospital');
        $this->db->group_by('approved, verified');
        $hospital_status = $this->db->get()->result_array();
        $data['hospital_status'] = $hospital_status;

        // Labels for charts
        $data['status_labels'] = [
            '0' => 'Pending',
            '1' => 'Confirmed',
            '2' => 'Cancelled',
            '3' => 'Completed'
        ];
        $data['hospital_labels'] = [
            '1_1' => 'Approved & Verified',
            '1_0' => 'Approved (Unverified)',
            '0_1' => 'Pending (Verified)',
            '0_0' => 'Pending'
        ];

        // Get ABDM statistics from model
        $abdm_stats = $this->abdm_model->get_abdm_stats();
        $data = array_merge($data, $abdm_stats);

        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('dashboard', $data);
        $this->load->view('inc/sidebar');
        $this->load->view('inc/headersetting');
        $this->load->view('inc/footerlink');
        $this->load->view('inc/table_footer');
    }
	
}
