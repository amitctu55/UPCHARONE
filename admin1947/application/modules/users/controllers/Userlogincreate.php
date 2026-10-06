<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userlogincreate extends CI_Controller {

	 function __construct() {
		 parent::__construct();
		 date_default_timezone_set("Asia/Kolkata");
		 $this->load->model('user');
		 $this->load->helper(array('query_string_helper', 'dbquery_helper', 'admin_helper'));
	}
	 
	public function index()
	{
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('userlogin');
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
	
	public function create()
	{
		if (isset($_POST['submit'])) {
			if ($this->user->insert()) {
				$msg = "<div class='alert alert-success'><strong>Success!</strong> Patient Account Created Successfully</div>";
				$this->session->set_flashdata('flashmsg', $msg);
			} else {
				$msg = "<div class='alert alert-danger'><strong>Failed!</strong> Something went wrong. Please try again.</div>";
				$this->session->set_flashdata('flashmsg', $msg);
			}
		}
		redirect(base_url('users/userlogincreate/userview'));
	}

	public function userview()
	{
		$pagesize            = (int) $this->input->get_post('pagesize');
		$config['limit']	 = ($pagesize > 0) ? $pagesize : 10;	
		$offset              = ($this->input->get_post('per_page') > 0) ? $this->input->get_post('per_page') : 0;	
		$base_url            = current_url_query_string(array('filter' => 'result'), array('per_page'));

		$data['userlogin']   = $this->user->get_users($config['limit'], $offset);
		$config['total_rows'] = get_found_rows();
		$data['total_rows']  = $config['total_rows'];
		$data['page_links']  = admin_pagination($base_url, $config['total_rows'], $config['limit'], $offset);

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('userview', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	public function delete()
	{
		$id = $this->input->get_post('USERID');
		if ($id) {
			$this->user->delete($id);
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>Patient Record Deleted Successfully</div>");
		}
		redirect(base_url('users/userlogincreate/userview'));
	}

	public function bulk_delete()
	{
		$user_ids = $this->input->post('user_ids');
		if (is_array($user_ids) && !empty($user_ids)) {
			$this->user->bulk_delete($user_ids);
			$msg = count($user_ids) . " Patient records deleted successfully.";
			if ($this->input->is_ajax_request()) {
				echo json_encode(array('status' => 'success', 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		} else {
			if ($this->input->is_ajax_request()) {
				echo json_encode(array('status' => 'error', 'message' => 'No patient records selected for deletion.'));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>No patient records selected.</div>");
		}
		redirect(base_url('users/userlogincreate/userview'));
	}

	public function reset_password()
	{
		$user_id      = $this->input->post('USERID');
		$new_password = $this->input->post('new_password');

		if (!empty($user_id) && !empty($new_password)) {
			$this->user->reset_password($user_id, $new_password);
			$msg = "Password reset successfully for Patient ID #" . $user_id;

			if ($this->input->is_ajax_request()) {
				echo json_encode(array('status' => 'success', 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		} else {
			if ($this->input->is_ajax_request()) {
				echo json_encode(array('status' => 'error', 'message' => 'User ID and New Password are required.'));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'>Invalid password reset request.</div>");
		}
		redirect(base_url('users/userlogincreate/userview'));
	}

	public function gmail_users()
	{
		$this->gmail();
	}

	public function gmail()
	{
		$this->db->select('userlogin.*, (SELECT COUNT(*) FROM appointment WHERE appointment.user_id = userlogin.USERID) as total_appointments, (SELECT points_balance FROM user_wallet WHERE user_wallet.user_id = userlogin.USERID LIMIT 1) as wallet_points');
		$this->db->from('userlogin');
		$this->db->where('GUID !=', '');
		$this->db->where('GUID IS NOT NULL', NULL, FALSE);
		$this->db->order_by('USERID', 'DESC');
		$data['userlogin'] = $this->db->get()->result();

		$data['heading_title'] = 'Google / Gmail Social Auth Registrations';
		$data['module']        = 'User Management';

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('gmail', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	public function facebook_users()
	{
		$this->facebook();
	}

	public function facebook()
	{
		$data['userlogin'] = $this->db->get_where('userlogin', array('FBUID !=' => ''))->result();

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('facebook', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	public function app_download_users()
	{
		$this->website();
	}

	public function website_users()
	{
		$this->website();
	}

	public function website()
	{
		$data['userlogin'] = $this->db->order_by('USERID', 'DESC')->get('userlogin')->result();
		$data['total_patients'] = $this->db->count_all('userlogin');
		$data['total_staff']    = $this->db->count_all('login');

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('userwebsite', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	/**
	 * Dynamic POST Action: Handles User & Patient Onboarding
	 */
	public function create_unified()
	{
		if (!$this->input->post()) {
			redirect(base_url('users/userlogincreate/website_users'));
			return;
		}

		$role_type = $this->input->post('role_type') ?: 'patient';
		$fname     = trim($this->input->post('fname'));
		$lname     = trim($this->input->post('lname'));
		$email     = trim($this->input->post('email'));
		$mobile    = trim($this->input->post('mobile'));
		$password  = $this->input->post('password');

		// Server-Side Validation
		$errors = [];
		if (empty($fname)) $errors[] = "First Name is required.";
		if (empty($mobile) || !preg_match('/^[0-9]{10}$/', $mobile)) $errors[] = "Mobile must be a valid 10-digit numeric number.";
		if (empty($password) || strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
		if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Please provide a valid email address.";

		if ($role_type === 'patient') {
			if (empty($this->input->post('dob'))) $errors[] = "Date of Birth is mandatory for clinical patient registration.";
		}

		if (!empty($errors)) {
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'><strong>Validation Error:</strong><br>" . implode('<br>', $errors) . "</div>");
			redirect(base_url('users/userlogincreate/website_users'));
			return;
		}

		// Delegate to Model Transaction
		$result = $this->user->create_unified_account($this->input->post());

		if ($result['status'] !== 'success') {
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'><strong>Registration Failed:</strong> " . htmlspecialchars($result['message']) . "</div>");
			redirect(base_url('users/userlogincreate/website_users'));
			return;
		}

		// -------------------------------------------------------------
		// SERVICE DISPATCH 1: Resilient SMTP Email Notification
		// -------------------------------------------------------------
		$notify_email = $this->input->post('notify_email');
		if ($notify_email && !empty($result['email'])) {
			$this->dispatch_welcome_email($result);
		}

		// -------------------------------------------------------------
		// SERVICE DISPATCH 2: SMS / WhatsApp Gateway Hook
		// -------------------------------------------------------------
		$notify_sms = $this->input->post('notify_sms');
		if ($notify_sms && !empty($result['mobile'])) {
			$this->dispatch_welcome_sms($result);
		}

		$badge_label = ucfirst(str_replace('_', ' ', $result['role']));
		$success_msg = "<div class='alert alert-success'><strong>Success!</strong> {$badge_label} account for <strong>" . htmlspecialchars($result['name']) . "</strong> created successfully (ID #{$result['user_id']}). Notifications dispatched.</div>";
		$this->session->set_flashdata('flashmsg', $success_msg);

		redirect(base_url('users/userlogincreate/website_users'));
	}

	/**
	 * Dispatch Branded Welcome Email via Upchar Notification Service
	 */
	protected function dispatch_welcome_email($user_info)
	{
		$service = null;
		if (class_exists('Notification_service')) {
			$service = new Notification_service();
		} else {
			$p1 = APPPATH . 'libraries/Notification_service.php';
			$p2 = FCPATH . 'application/libraries/Notification_service.php';
			if (file_exists($p1)) {
				require_once($p1);
				$service = new Notification_service();
			} elseif (file_exists($p2)) {
				require_once($p2);
				$service = new Notification_service();
			}
		}

		if ($service) {
			$name = htmlspecialchars($user_info['name']);
			$email = $user_info['email'];
			$pass = htmlspecialchars($user_info['temp_pass']);
			$portal_url = base_url('login');

			$subject = "Welcome to Upchar Healthcare - Your Account is Ready";
			$html = '
			<div style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, sans-serif; max-width: 600px; margin: 0 auto; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;">
				<div style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); padding: 24px; text-align: center; border-bottom: 3px solid #00A896;">
					<h1 style="color: #ffffff; margin: 0; font-size: 24px;">UPCHAR<span style="color:#00A896;">.INFO</span></h1>
					<p style="color: #94A3B8; font-size: 12px; margin: 4px 0 0; text-transform: uppercase; letter-spacing: 1px;">Healthcare & Medical Solutions</p>
				</div>
				<div style="padding: 28px;">
					<h2 style="color: #0F172A; font-size: 19px; margin: 0 0 12px;">Welcome, ' . $name . '!</h2>
					<p style="color: #475569; font-size: 14px; line-height: 1.6;">Your healthcare profile on Upchar has been successfully provisioned by the administrative desk. You can now log in to view clinical reports, book doctor appointments, and manage your health records.</p>
					<div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; padding: 16px; margin: 20px 0;">
						<div style="font-size: 13px; color: #334155; margin-bottom: 6px;"><strong>Registered Login:</strong> ' . $email . '</div>
						<div style="font-size: 13px; color: #334155;"><strong>Temporary Password:</strong> <code style="background: #E2E8F0; padding: 2px 6px; border-radius: 4px; color: #0d9488;">' . $pass . '</code></div>
					</div>
					<div style="text-align: center; margin: 28px 0;">
						<a href="' . $portal_url . '" style="background: #00A896; color: #ffffff; text-decoration: none; font-weight: 700; padding: 12px 30px; border-radius: 8px; font-size: 14px; display: inline-block;">Access Patient Portal &rarr;</a>
					</div>
					<p style="font-size: 12px; color: #94A3B8; line-height: 1.5; margin: 0;">Please change your password immediately upon your first login for maximum security.</p>
				</div>
			</div>';

			try {
				@$service->send_email($email, $subject, $html);
			} catch (\Throwable $e) {}
		}
	}

	/**
	 * Dispatch SMS / WhatsApp Alert
	 */
	protected function dispatch_welcome_sms($user_info)
	{
		$mobile = $user_info['mobile'];
		$name   = $user_info['name'];
		$pass   = $user_info['temp_pass'];

		$sms_msg = "Hello {$name}, your Upchar Healthcare account is active. Login at upchar.info with Mobile: {$mobile} and Pass: {$pass}. Helpline: 8448449603";

		if (function_exists('sendsms')) {
			@sendsms($sms_msg, $mobile);
		}
	}

	public function toggle_user_status($id = null)
	{
		$uid = $id ?: $this->input->get('USERID');
		if ($uid) {
			$u = $this->db->get_where('userlogin', array('USERID' => $uid))->row();
			if ($u) {
				$newSt = ($u->STATUS == '1') ? '2' : '1';
				$this->db->where('USERID', $uid)->update('userlogin', array('STATUS' => $newSt));
				$this->session->set_flashdata('flashmsg', '<div class="alert alert-info">User status updated to ' . ($newSt == '1' ? 'ACTIVE' : 'BLOCKED') . '.</div>');
			}
		}
		redirect($_SERVER['HTTP_REFERER'] ?: base_url('users/userlogincreate/gmail_users'));
	}
}
