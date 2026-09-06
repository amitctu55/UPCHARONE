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

		 if(!$this->session->userdata('userid') && !$this->session->userdata('username'))
		 {
			 redirect(base_url().'login');
		 }
	}
	public function index()
    {
        // Safe default structure
        $data = array(
            'approved_hospitals' => 0,
            'pending_hospitals'  => 0,
            'total_hospitals'    => 0,
            'total_clinics'      => 0,
            'total_doctors'      => 0,
            'total_appointments' => 0,
            'total_users'        => 0,
            'recent_appointments'=> 0,
            'recent_users'       => 0,
            'appointment_status' => array(),
            'user_trend'         => array(),
            'specialization_dist'=> array(),
            'hospital_status'    => array(),
            'status_labels'      => array(
                '0' => 'Pending',
                '1' => 'Confirmed',
                '2' => 'Cancelled',
                '3' => 'Completed'
            ),
            'hospital_labels'    => array(
                '1_1' => 'Approved & Verified',
                '1_0' => 'Approved (Unverified)',
                '0_1' => 'Pending (Verified)',
                '0_0' => 'Pending'
            ),
            'total_abha_ids'              => 0,
            'active_abha_ids'             => 0,
            'total_consent_records'       => 0,
            'active_consent_records'      => 0,
            'total_hpr_registrations'     => 0,
            'approved_hpr_registrations'  => 0,
            'total_hfr_registrations'     => 0,
            'approved_hfr_registrations'  => 0,
            'total_staff'                 => 0,
            'today_attendance'            => 0,
            'today_late'                  => 0,
            'pending_leaves'              => 0,
            'total_path_orders'           => 0,
            'active_pickups'              => 0,
            'pending_handoffs'            => 0,
            'pending_expenses'            => 0,
            'total_crm_leads'             => 0,
            'crm_pipeline_val'            => 0.00,
            'total_gmail_users'           => 0,
            'active_ads_count'            => 0,
        );

        try {
            // General statistics
            if ($this->db->table_exists('hospital')) {
                $data['approved_hospitals'] = $this->db->where('approved', '1')->where('verified', '1')->where('status !=', '2')->count_all_results('hospital');
                $data['pending_hospitals']  = $this->db->group_start()->where('approved', '0')->or_where('verified', '0')->group_end()->where('status !=', '2')->count_all_results('hospital');
                $data['total_hospitals']    = $data['approved_hospitals'];
            }
            if ($this->db->table_exists('clinic')) {
                $data['total_clinics'] = $this->db->where('status', '1')->count_all_results('clinic');
            }
            if ($this->db->table_exists('profile_dr')) {
                $data['total_doctors'] = $this->db->where('approved', '1')->where('verified', '1')->count_all_results('profile_dr');
            }
            if ($this->db->table_exists('appointment')) {
                $data['total_appointments']  = $this->db->count_all_results('appointment');
                $data['recent_appointments'] = $this->db->where('appointment_date >=', date('Y-m-d', strtotime('-30 days')))->count_all_results('appointment');
            }
            if ($this->db->table_exists('userlogin')) {
                $data['total_users']  = $this->db->where('STATUS', '1')->where('APPROVED', '1')->count_all_results('userlogin');
                $data['recent_users'] = $this->db->where('REG_DATE >=', date('Y-m-d', strtotime('-30 days')))->where('STATUS', '1')->where('APPROVED', '1')->count_all_results('userlogin');
            }

            // Appointment status breakdown
            if ($this->db->table_exists('appointment')) {
                $this->db->select('status, COUNT(*) as count');
                $this->db->from('appointment');
                $this->db->group_by('status');
                $appt_q = $this->db->get();
                $data['appointment_status'] = ($appt_q && is_object($appt_q)) ? $appt_q->result_array() : [];
            }

            // User registration trend (last 6 months)
            if ($this->db->table_exists('userlogin')) {
                $this->db->select("DATE_FORMAT(REG_DATE, '%Y-%m') as month, COUNT(*) as count");
                $this->db->from('userlogin');
                $this->db->where('STATUS', '1');
                $this->db->where('APPROVED', '1');
                $this->db->group_by("DATE_FORMAT(REG_DATE, '%Y-%m')");
                $this->db->order_by("month", "DESC");
                $this->db->limit(6);
                $trend_q = $this->db->get();
                $user_trend = ($trend_q && is_object($trend_q)) ? $trend_q->result_array() : [];
                $data['user_trend'] = array_reverse($user_trend);
            }

            // Doctor specialization distribution (top 8)
            if ($this->db->table_exists('profile_dr') && $this->db->table_exists('master_specialization')) {
                $this->db->select('ms.name as specialization, COUNT(pd.id) as count');
                $this->db->from('profile_dr pd');
                $this->db->join('master_specialization ms', 'pd.specialization = ms.id');
                $this->db->where('pd.approved', '1');
                $this->db->where('pd.verified', '1');
                $this->db->group_by(array('pd.specialization', 'ms.name'));
                $this->db->order_by('count', 'DESC');
                $this->db->limit(8);
                $spec_q = $this->db->get();
                $data['specialization_dist'] = ($spec_q && is_object($spec_q)) ? $spec_q->result_array() : [];
            }

            // Hospital approval status
            if ($this->db->table_exists('hospital')) {
                $this->db->select('approved, verified, COUNT(*) as count');
                $this->db->from('hospital');
                $this->db->group_by(array('approved', 'verified'));
                $hosp_q = $this->db->get();
                $data['hospital_status'] = ($hosp_q && is_object($hosp_q)) ? $hosp_q->result_array() : [];
            }

            // ABDM statistics from model safely
            if (isset($this->abdm_model) && method_exists($this->abdm_model, 'get_abdm_stats')) {
                $abdm_stats = $this->abdm_model->get_abdm_stats();
                $data = array_merge($data, $abdm_stats);
            } elseif ($this->db->table_exists('abdm_users')) {
                try {
                    @$this->load->model('abdm/Abdm_model');
                    if (isset($this->Abdm_model) && method_exists($this->Abdm_model, 'get_abdm_stats')) {
                        $data = array_merge($data, $this->Abdm_model->get_abdm_stats());
                    } elseif (isset($this->abdm_model) && method_exists($this->abdm_model, 'get_abdm_stats')) {
                        $data = array_merge($data, $this->abdm_model->get_abdm_stats());
                    }
                } catch (Throwable $e) {}
            }

            // Enterprise Multi-Role & Logistics Suite Metrics
            $today = date('Y-m-d');
            $data['total_staff']       = $this->db->table_exists('staff_users') ? $this->db->where('status', 'active')->count_all_results('staff_users') : 0;
            $data['today_attendance']  = $this->db->table_exists('staff_attendance') ? $this->db->where('punch_date', $today)->where('status', 'present')->count_all_results('staff_attendance') : 0;
            $data['today_late']        = $this->db->table_exists('staff_attendance') ? $this->db->where('punch_date', $today)->where('status', 'late')->count_all_results('staff_attendance') : 0;
            $data['pending_leaves']    = $this->db->table_exists('staff_leave_requests') ? $this->db->where('status', 'pending')->count_all_results('staff_leave_requests') : 0;
            
            $data['total_path_orders'] = $this->db->table_exists('path_book') ? $this->db->count_all_results('path_book') : 0;
            $data['active_pickups']    = $this->db->table_exists('path_book') ? $this->db->where_in('collection_status', ['assigned', 'en_route', 'arrived'])->count_all_results('path_book') : 0;
            $data['pending_handoffs']  = $this->db->table_exists('path_book') ? $this->db->where('collection_status', 'sample_collected')->count_all_results('path_book') : 0;
            $data['pending_expenses']  = $this->db->table_exists('staff_expense_claims') ? $this->db->where('status', 'submitted')->count_all_results('staff_expense_claims') : 0;

            $data['total_crm_leads']   = $this->db->table_exists('staff_crm_leads') ? $this->db->count_all_results('staff_crm_leads') : 0;
            $crm_sum = null;
            if ($this->db->table_exists('staff_crm_leads')) {
                $crm_q = $this->db->select_sum('est_monthly_revenue')->get('staff_crm_leads');
                $crm_sum = ($crm_q && is_object($crm_q)) ? $crm_q->row() : null;
            }
            $data['crm_pipeline_val']  = $crm_sum ? floatval($crm_sum->est_monthly_revenue) : 0.00;

            if ($this->db->table_exists('userlogin') && $this->db->field_exists('GUID', 'userlogin')) {
                $data['total_gmail_users'] = $this->db->where('GUID IS NOT NULL')->where('GUID !=', '')->count_all_results('userlogin');
            }
            $data['active_ads_count']  = $this->db->table_exists('advertisement') ? $this->db->where('status', '1')->count_all_results('advertisement') : 0;
        } catch (Throwable $e) {
            log_message('error', 'Error in Dashboard index: ' . $e->getMessage());
        }

        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('dashboard', $data);
        $this->load->view('inc/sidebar');
        $this->load->view('inc/headersetting');
        $this->load->view('inc/footerlink');
        $this->load->view('inc/table_footer');
    }
	
}
