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
		$data['userlogin'] = $this->db->get_where('userlogin', array('USERID !=' => ''))->result();

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('userwebsite', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
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
