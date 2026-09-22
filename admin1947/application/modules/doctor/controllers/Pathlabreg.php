<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pathlabreg extends CI_Controller 
{
	function __construct() 
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->load->model('Pathlabregmodel');
		$this->load->model('Audit_footprint_model');
		$this->load->helper(array('query_string_helper','dbquery_helper','admin_helper','text'));
		$this->_ensure_tables();
	}

	private function _ensure_tables()
	{
		try {
			if (!$this->db) return;
			if ($this->db->table_exists('pathlab')) {
				$fields = $this->db->list_fields('pathlab');
				if (!in_array('commission_rate', $fields)) {
					$this->db->query("ALTER TABLE `pathlab` ADD COLUMN `commission_rate` DECIMAL(5,2) DEFAULT 15.00 AFTER `status`");
				}
				if (!in_array('nabl_accredited', $fields)) {
					$this->db->query("ALTER TABLE `pathlab` ADD COLUMN `nabl_accredited` TINYINT(1) DEFAULT 0 AFTER `commission_rate`");
				}
				if (!in_array('license_number', $fields)) {
					$this->db->query("ALTER TABLE `pathlab` ADD COLUMN `license_number` VARCHAR(100) DEFAULT NULL AFTER `nabl_accredited`");
				}
				if (!in_array('raw_password_temp', $fields)) {
					$this->db->query("ALTER TABLE `pathlab` ADD COLUMN `raw_password_temp` VARCHAR(100) DEFAULT NULL AFTER `license_number`");
				}
			}
		} catch (Throwable $e) {}
	}
	 
	/**
	 * Complete Lab Directory & Onboarding Dashboard
	 */
	public function index()
	{
		$this->viewpathology();
	}

	/**
	 * Standalone Add Pathlab Form (for direct linking)
	 */
	public function add()
	{
		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('pathlabreg');
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	/**
	 * Onboard new partner lab and provision access credentials
	 */
	public function create()
	{
		if (isset($_POST['submit']) || $this->input->post('name') || $this->input->is_ajax_request()) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name', 'Pathology / Diagnostic Center Name', 'trim|required|min_length[3]|max_length[255]');
			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
			$this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('password', 'Account Password', 'trim|min_length[6]');

			if ($this->form_validation->run() == FALSE) {
				if ($this->input->is_ajax_request()) {
					echo json_encode(array('status' => 0, 'message' => validation_errors()));
					return;
				}
				$msg = "<div class='alert alert-danger'><strong>Validation Error:</strong><br>" . validation_errors() . "</div>";
				$this->session->set_flashdata('flashmsg', $msg);
				redirect(base_url('doctor/pathlabreg/index'));
				exit();
			}

			$check = $this->Pathlabregmodel->pathlab_duplicacy_check();
			if ($check != 'OK') {
				if ($check == 'MOBILE')
					$emsg = 'Mobile Number Already Exists';
				else if ($check == 'EMAIL')
					$emsg = 'Email Address Already Exists';
				else if ($check == 'BOTH')
					$emsg = 'Email Address and Mobile Number Already Exist';
				else
					$emsg = 'Required fields missing';
				
				if ($this->input->is_ajax_request()) {
					echo json_encode(array('status' => 0, 'message' => $emsg));
					return;
				}
				$msg = "<div class='alert alert-danger'><strong>Failed!</strong> $emsg</div>";
				$this->session->set_flashdata('flashmsg', $msg);
				redirect(base_url('doctor/pathlabreg/index'));
				exit();
			}

			$uploadimage = '';
			$uploadimage2 = '';
			$uploadimage3 = '';
			$typename = 'pathlab';

			$config['upload_path']   = './public/assets/upload/';
			$config['allowed_types'] = 'jpg|png|jpeg|JPG|PNG|JPEG|pdf|PDF';
			$config['max_size']      = 5120;
			$this->load->library('upload', $config);

			if (!empty($_FILES['uploadimage']['name'])) {
				$ext = pathinfo($_FILES['uploadimage']['name'], PATHINFO_EXTENSION);
				$uploadimage = $typename . '_profile_pic_' . rand(1111111,999999999) . date('Y-m-d') . '.' . $ext;
				$config['file_name'] = $uploadimage;
				$this->upload->initialize($config);
				$this->upload->do_upload('uploadimage');
			}
			if (!empty($_FILES['idproof']['name'])) {
				$ext2 = pathinfo($_FILES['idproof']['name'], PATHINFO_EXTENSION);
				$uploadimage2 = $typename . '_id_proof_' . rand(1111111,999999999) . date('Y-m-d') . '.' . $ext2;
				$config['file_name'] = $uploadimage2;
				$this->upload->initialize($config);
				$this->upload->do_upload('idproof');
			}
			if (!empty($_FILES['regproof']['name'])) {
				$ext3 = pathinfo($_FILES['regproof']['name'], PATHINFO_EXTENSION);
				$uploadimage3 = $typename . '_reg_proof_' . rand(1111111,999999999) . date('Y-m-d') . '.' . $ext3;
				$config['file_name'] = $uploadimage3;
				$this->upload->initialize($config);
				$this->upload->do_upload('regproof');
			}

			$createdLab = $this->Pathlabregmodel->traineereginsert($uploadimage, $uploadimage2, $uploadimage3);
			if ($createdLab && is_array($createdLab)) {
				// Audit Footprint
				$this->Audit_footprint_model->log_footprint(
					'lab',
					$createdLab['id'],
					'CREATED',
					null,
					$createdLab,
					"Lab '{$createdLab['name']}' onboarded with credentials provisioning"
				);

				$credMsg = "<div class='alert alert-success' style='border-left: 5px solid #10b981;'>
					<h4 style='margin-top: 0; font-weight: 700;'><i class='fa fa-check-circle'></i> Lab Successfully Registered &amp; Credentials Provisioned!</h4>
					<p style='margin-bottom: 8px;'>The login credentials for <strong>".htmlspecialchars($createdLab['name'])."</strong> have been generated:</p>
					<div style='background: #ffffff; padding: 12px; border-radius: 6px; border: 1px dashed #cbd5e1; font-family: monospace; font-size: 13px; color: #1e293b; max-width: 450px;'>
						<div><strong>Lab Portal:</strong> <a href='".base_url('../pathlabpanel')."' target='_blank'>".base_url('../pathlabpanel')."</a></div>
						<div><strong>Login Email:</strong> <span id='flash-cred-email'>".htmlspecialchars($createdLab['email'])."</span></div>
						<div><strong>Password:</strong> <span id='flash-cred-pwd'>".htmlspecialchars($createdLab['password'])."</span></div>
					</div>
					<div style='margin-top: 10px;'>
						<button type='button' class='btn btn-xs btn-default' onclick='navigator.clipboard.writeText(\"Portal: ".base_url('../pathlabpanel')."\\nEmail: {$createdLab['email']}\\nPassword: {$createdLab['password']}\"); alert(\"Credentials copied to clipboard!\");' style='font-weight: 600;'>
							<i class='fa fa-copy'></i> Copy Login Credentials
						</button>
					</div>
				</div>";

				if ($this->input->is_ajax_request()) {
					echo json_encode(array(
						'status'  => 1,
						'message' => 'Pathology Lab Onboarded Successfully',
						'lab'     => $createdLab
					));
					return;
				}

				$this->session->set_flashdata('flashmsg', $credMsg);
			} else {
				$msg = "<div class='alert alert-danger'><strong>Failed!</strong> Something went wrong during lab registration.</div>";
				if ($this->input->is_ajax_request()) {
					echo json_encode(array('status' => 0, 'message' => 'Failed to save lab details'));
					return;
				}
				$this->session->set_flashdata('flashmsg', $msg);
			}
		}
		redirect(base_url('doctor/pathlabreg/index'));
	}
	
	/**
	 * Reset / Re-generate Lab Credentials
	 */
	public function reset_credentials($id = null)
	{
		$labId = $id ? $id : (int)$this->input->post('id');
		if (!$labId) {
			echo json_encode(array('status' => 0, 'message' => 'Lab ID is required'));
			return;
		}

		$newPwd = $this->input->post('new_password') ? trim($this->input->post('new_password')) : null;
		$res = $this->Pathlabregmodel->reset_lab_credentials($labId, $newPwd);

		if ($res) {
			$this->Audit_footprint_model->log_footprint(
				'lab',
				$labId,
				'CREDENTIALS_PROVISIONED',
				null,
				array('email' => $res['email']),
				"Admin regenerated portal credentials for Lab #{$labId}"
			);

			echo json_encode(array(
				'status'   => 1,
				'message'  => 'Password updated successfully',
				'email'    => $res['email'],
				'password' => $res['password']
			));
		} else {
			echo json_encode(array('status' => 0, 'message' => 'Failed to reset credentials'));
		}
	}

	/**
	 * Inline update commission rate for a lab
	 */
	public function update_commission()
	{
		$labId = (int)$this->input->post('id');
		$rate  = (float)$this->input->post('commission_rate');

		if ($labId > 0 && $rate >= 0) {
			$before = $this->db->select('id, name, commission_rate')->get_where('pathlab', array('id' => $labId))->row();
			$this->db->where('id', $labId)->update('pathlab', array('commission_rate' => $rate));

			$this->Audit_footprint_model->log_footprint(
				'lab',
				$labId,
				'PRICE_CHANGED',
				$before,
				array('commission_rate' => $rate),
				"Platform commission rate adjusted to {$rate}% for Lab #{$labId}"
			);

			echo json_encode(array('status' => 1, 'message' => 'Commission rate updated to ' . $rate . '%'));
		} else {
			echo json_encode(array('status' => 0, 'message' => 'Invalid rate or lab ID'));
		}
	}
          
	public function viewpathology()
	{
		$keyword       = $this->db->escape_str($this->input->get('keyword', TRUE));
		$status_filter = $this->db->escape_str($this->input->get('status_filter', TRUE));

		if ($keyword != '') {
			$this->db->where("(pathlab.name LIKE '%".$keyword."%' OR pathlab.email LIKE '%".$keyword."%' OR pathlab.mobile LIKE '%".$keyword."%' OR pathlab.city LIKE '%".$keyword."%')");
		}
		if ($status_filter == 'approved' || $status_filter == 'registered') {
			$this->db->where('pathlab.approved', '1');
			$this->db->where('pathlab.verified', '1');
		} elseif ($status_filter == 'pending' || $status_filter == 'pending_verification') {
			$this->db->where("(pathlab.approved = '0' OR pathlab.verified = '0')");
		} elseif ($status_filter == 'verified') {
			$this->db->where('pathlab.verified', '1');
		} elseif ($status_filter == 'unverified') {
			$this->db->where('pathlab.verified', '0');
		} elseif ($status_filter == 'pending_approval') {
			$this->db->where('pathlab.approved', '0');
		}
		$this->db->where('pathlab.status !=', '2');
		$this->db->order_by('pathlab.id', 'desc');
		$data['pathlab'] = $this->db->get('pathlab')->result();
		$data['module']  = 'pathlab';

		$data['approved_count'] = $this->db->where('approved', '1')->where('verified', '1')->where('status !=', '2')->count_all_results('pathlab');
		$data['pending_count']  = $this->db->group_start()->where('approved', '0')->or_where('verified', '0')->group_end()->where('status !=', '2')->count_all_results('pathlab');
		$data['total_count']    = $this->db->where('status !=', '2')->count_all_results('pathlab');

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('pathlabview', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	public function pathlabapprove($id = null)
	{
		$did = $this->input->post('did') ? $this->input->post('did') : ($id ? $id : $this->uri->segment(4));
		$row = $this->db->select('approved, name')->get_where('pathlab', array('id' => $did))->row();
		$current = $row ? $row->approved : '0';
		if ($current == '1') {
			$this->db->set('approved', '0')->where(array('id' => $did))->update('pathlab');
			$status = '0';
			$msg = 'Pathology Lab approval status updated to Pending.';
		} else {
			$this->db->set('approved', '1')->where(array('id' => $did))->update('pathlab');
			$status = '1';
			$msg = 'Pathology Lab has been Approved successfully.';
		}

		$this->Audit_footprint_model->log_footprint(
			'lab',
			$did,
			'STATUS_UPDATED',
			array('approved' => $current),
			array('approved' => $status),
			"Approval toggled to {$status} for Lab #{$did} (".($row ? $row->name : '').")"
		);

		if ($this->input->is_ajax_request() || $this->input->post('did')) {
			echo json_encode(array('status' => $status, 'message' => $msg));
			return;
		}
		$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		redirect(base_url('doctor/pathlabreg/index'));
	}
	 
	public function pathlabverify($id = null)
	{
		$did = $this->input->post('did') ? $this->input->post('did') : ($id ? $id : $this->uri->segment(4));
		$row = $this->db->select('verified, name')->get_where('pathlab', array('id' => $did))->row();
		$current = $row ? $row->verified : '0';
		if ($current == '1') {
			$this->db->set('verified', '0')->where(array('id' => $did))->update('pathlab');
			$status = '0';
			$msg = 'Pathology Lab verification status updated to Unverified.';
		} else {
			$this->db->set('verified', '1')->where(array('id' => $did))->update('pathlab');
			$status = '1';
			$msg = 'Pathology Lab has been Verified successfully.';
		}

		$this->Audit_footprint_model->log_footprint(
			'lab',
			$did,
			'STATUS_UPDATED',
			array('verified' => $current),
			array('verified' => $status),
			"Verification toggled to {$status} for Lab #{$did} (".($row ? $row->name : '').")"
		);

		if ($this->input->is_ajax_request() || $this->input->post('did')) {
			echo json_encode(array('status' => $status, 'message' => $msg));
			return;
		}
		$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		redirect(base_url('doctor/pathlabreg/index'));
	}
	 
	public function pathlabview($id)
	{
		$pathlab = $this->db->get_where('pathlab', array('id' => $id))->row();
		if (!$pathlab) {
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'>Pathology Lab not found!</div>");
			redirect(base_url('doctor/pathlabreg/index'));
			return;
		}

		$data['pathlab'] = $pathlab;
		$data['module']  = 'pathlab';
		$data['tests']   = $this->db->get_where('path_lab_test', array('path_lab_id' => $id))->result();
		$data['footprints'] = $this->Audit_footprint_model->get_footprints(20, 0, array('entity_type' => 'lab', 'entity_id' => $id));

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('pathlabview_profile', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	public function pathlabupdate($id)
	{
		$data['pathlab'] = $this->db->get_where('pathlab', array('id' => $id))->row();
		$data['module']  = 'pathlab';

		if (isset($_POST['submit'])) {
			$before = (array)$data['pathlab'];
			$this->Pathlabregmodel->updatepathlab($id);
			$after = (array)$this->db->get_where('pathlab', array('id' => $id))->row();

			$this->Audit_footprint_model->log_footprint('lab', $id, 'UPDATED', $before, $after, "Updated Lab details for #{$id}");

			$msg = "<div class='alert alert-success'><strong>Success!</strong> Pathology Lab Updated Successfully</div>";
			$this->session->set_flashdata('flashmsg', $msg);
			redirect(base_url('doctor/pathlabreg/index'));
		}

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('updatepathlab', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	public function deletepathlab($id = null)
	{
		if ($this->input->post('ids') && is_array($this->input->post('ids'))) {
			$this->bulk_delete_pathlab();
			return;
		}

		$del_id = $id ? $id : ($this->input->post('id') ? $this->input->post('id') : ($this->input->get('id') ? $this->input->get('id') : $this->uri->segment(4)));
		if ($del_id) {
			$labBefore = $this->db->get_where('pathlab', array('id' => $del_id))->row();
			$this->Pathlabregmodel->deletepathlab($del_id);
			
			$this->Audit_footprint_model->log_footprint(
				'lab', 
				$del_id, 
				'DELETED', 
				$labBefore, 
				null, 
				"Deleted Pathology Lab #{$del_id} (".($labBefore ? $labBefore->name : '').")"
			);

			$msg = "Pathology Lab record deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax') || $this->input->post('id')) {
				echo json_encode(array('status' => 1, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		}
		redirect(base_url('doctor/pathlabreg/index'));
	}

	public function bulk_delete_pathlab()
	{
		$ids = $this->input->post('ids');
		if (!empty($ids) && is_array($ids)) {
			$deleted_count = 0;
			foreach ($ids as $lid) {
				$lid = (int)$lid;
				if ($lid > 0) {
					$labBefore = $this->db->get_where('pathlab', array('id' => $lid))->row();
					$this->Pathlabregmodel->deletepathlab($lid);
					$this->Audit_footprint_model->log_footprint(
						'lab', 
						$lid, 
						'DELETED', 
						$labBefore, 
						null, 
						"Bulk deleted Pathology Lab #{$lid}"
					);
					$deleted_count++;
				}
			}
			$msg = "$deleted_count pathology lab record(s) deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 1, 'count' => $deleted_count, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> $msg</div>");
		} else {
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 0, 'message' => 'No pathlabs selected.'));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>No labs selected.</div>");
		}
		redirect(base_url('doctor/pathlabreg/index'));
	}
}