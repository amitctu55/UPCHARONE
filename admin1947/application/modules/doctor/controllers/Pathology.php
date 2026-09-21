<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pathology extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->load->helper(array('query_string_helper','dbquery_helper','admin_helper','text'));
		$this->load->model(array('doctor/pathology_model', 'doctor/Audit_footprint_model', 'masters/managementmodel'));
	}

	private function _ensure_tables()
	{
		try {
			if ($this->db) {
				if (!$this->db->table_exists('path_lab_test')) {
					$this->db->query("CREATE TABLE IF NOT EXISTS `path_lab_test` (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`test_id` int(11) DEFAULT 0,
						`path_lab_id` int(11) DEFAULT 0,
						`lab_price` decimal(10,2) DEFAULT 0.00,
						`comment` text DEFAULT NULL,
						`status` varchar(10) DEFAULT '1',
						`created_date` datetime DEFAULT NULL,
						`updated_date` datetime DEFAULT NULL,
						PRIMARY KEY (`id`),
						KEY `test_id` (`test_id`),
						KEY `path_lab_id` (`path_lab_id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
				}
				if (!$this->db->table_exists('pathtest')) {
					$this->db->query("CREATE TABLE IF NOT EXISTS `pathtest` (
						`test_id` int(11) NOT NULL AUTO_INCREMENT,
						`test_name` varchar(255) DEFAULT '',
						`short_name` varchar(100) DEFAULT '',
						`code` varchar(50) DEFAULT '',
						`department` varchar(100) DEFAULT 'Biochemistry',
						`container_color` varchar(50) DEFAULT 'Purple (EDTA)',
						`specimen_type` varchar(100) DEFAULT 'Whole Blood',
						`fasting_required` tinyint(1) DEFAULT 0,
						`standard_tat_hours` int(11) DEFAULT 24,
						`method` varchar(255) DEFAULT '',
						`amount` decimal(10,2) DEFAULT 0.00,
						`status` varchar(10) DEFAULT '1',
						PRIMARY KEY (`test_id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
				}
			}
		} catch (Throwable $e) {}
	}
	
	/**
	 * Executive Master Pathology Dashboard
	 */
	public function dashboard()
	{
		$this->_ensure_tables();
		$data['metrics'] = $this->pathology_model->get_dashboard_metrics();
		$data['recent_bookings'] = $this->pathology_model->get_custody_bookings(6, 0);
		$data['heading_title'] = 'Pathology Executive Dashboard';
		$data['module'] = 'Pathology Dashboard';

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('pathology/dashboard', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	/**
	 * Master Diagnostic Test Creator (/doctor/pathology/add)
	 */
	public function add()
	{
		$this->_ensure_tables();

		if ($this->input->post('submit') || $this->input->post('test_name')) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('test_name', 'Test Name', 'trim|required|min_length[3]');
			$this->form_validation->set_rules('department', 'Department', 'trim|required');
			$this->form_validation->set_rules('amount', 'Base Price', 'trim|required|numeric');

			if ($this->form_validation->run() == TRUE) {
				$test_id = $this->pathology_model->insert_master_test();
				if ($test_id) {
					$postData = $this->input->post();
					$this->Audit_footprint_model->log_footprint(
						'master_test',
						$test_id,
						'CREATED',
						null,
						$postData,
						"Master Diagnostic Test '{$postData['test_name']}' created in catalog"
					);

					$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Success!</strong> Master Diagnostic Test <strong>".htmlspecialchars($postData['test_name'])."</strong> created successfully.</div>");
					redirect(base_url('doctor/pathology/assign_test'));
					return;
				} else {
					$this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'>Failed to insert test. Please check database.</div>");
				}
			} else {
				$this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'><strong>Validation Error:</strong><br>" . validation_errors() . "</div>");
			}
		}

		$data['heading_title'] = 'Create Master Diagnostic Test';
		$data['module']        = 'Master Diagnostic Catalog';

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('pathology/master_test_add', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	/**
	 * Lab-Test Assignment with Pricing Logic (/doctor/pathology/assign_test)
	 */
	public function assign_test()
	{
		$this->_ensure_tables();

		if ($this->input->post('submit') || ($this->input->post('path_lab_id') && $this->input->post('test_id'))) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('path_lab_id', 'Pathology Center', 'trim|required|numeric');
			$this->form_validation->set_rules('test_id', 'Diagnostic Test', 'trim|required|numeric');
			$this->form_validation->set_rules('lab_price', 'Lab Base Price', 'trim|required|numeric');

			if ($this->form_validation->run() == TRUE) {
				$path_lab_id = (int)$this->input->post('path_lab_id');
				$test_id     = (int)$this->input->post('test_id');

				// Duplicate check
				$existing = $this->db->get_where('path_lab_test', array(
					'path_lab_id' => $path_lab_id,
					'test_id'     => $test_id
				))->row();

				if ($existing) {
					$this->session->set_flashdata('flashmsg', '<div class="alert alert-warning"><strong>Notice:</strong> This diagnostic test is already assigned to this laboratory. You can edit the existing mapping below.</div>');
					redirect(base_url('doctor/pathology/index'));
					return;
				}

				$inserted_id = $this->pathology_model->insert_assign_test();
				if ($inserted_id) {
					$labRow = $this->db->get_where('pathlab', array('id' => $path_lab_id))->row();
					$testRow = $this->db->get_where('pathtest', array('test_id' => $test_id))->row();

					$this->Audit_footprint_model->log_footprint(
						'test_mapping',
						$inserted_id,
						'CREATED',
						null,
						array('lab_id' => $path_lab_id, 'test_id' => $test_id, 'lab_price' => $this->input->post('lab_price')),
						"Test '".($testRow ? $testRow->test_name : $test_id)."' assigned to Lab '".($labRow ? $labRow->name : $path_lab_id)."'"
					);

					$msg = "<div class='alert alert-success'><strong>Success!</strong> Test assigned to laboratory with pricing successfully.</div>";
					$this->session->set_flashdata('flashmsg', $msg);
					redirect(base_url('doctor/pathology/index'));
					return;
				} else {
					$this->session->set_flashdata('flashmsg', '<div class="alert alert-danger"><strong>Error:</strong> Failed to assign test. Please try again.</div>');
				}
			}
		}

		$data['heading_title'] = 'Assign Diagnostic Test to Lab';
		$data['module']        = 'Pathology Test Assignment';
		$data['test']          = $this->pathology_model->get_test(array('status'=>'1'));
		$data['pathlab']       = $this->pathology_model->get_pathlab(array('approved'=>'1'));

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('pathology/assign_test_add', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	/**
	 * Assigned Tests Directory (/doctor/pathology/index)
	 */
	public function index()
	{	
		$this->_ensure_tables();
		$pagesize               = (int) $this->input->get_post('pagesize');
		$config['limit']	    = ( $pagesize > 0 ) ? $pagesize : 15;	
		$offset                 = ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;	
		$base_url               = function_exists('current_url_query_string') ? current_url_query_string(array('filter'=>'result'),array('per_page')) : current_url();
		$data['result'] 		= $this->pathology_model->get_assign_test($config['limit'],$offset);
		$config['total_rows']   = function_exists('get_found_rows') ? get_found_rows() : (is_array($data['result']) ? count($data['result']) : 0);
		$data['heading_title'] 	= 'Assigned Diagnostic Tests Directory';
		$data['module'] 		= 'Assigned Tests';
		$data['page_links'] 	= function_exists('admin_pagination') ? admin_pagination($base_url, $config['total_rows'],$config['limit'],$offset) : '';
		
		if ($this->input->post('status_action')!='') {
			try {
				if ($this->db && $this->db->table_exists('path_lab_test')) {
					$this->managementmodel->update_status('path_lab_test','id');			
				}
			} catch (Throwable $e) {}
		}

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('pathology/assign_test', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	/**
	 * Edit Lab-Test Assignment
	 */
	public function edit($id = null)
	{
		$id = (int)($id ?: $this->uri->segment(4));
		$assignment = $this->pathology_model->get_assign_test_row($id);

		if (!$assignment) {
			$this->session->set_flashdata('flashmsg', '<div class="alert alert-danger">Assigned test record not found.</div>');
			redirect(base_url('doctor/pathology/index'));
			return;
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('path_lab_id', 'Pathology Center', 'trim|required|numeric');
		$this->form_validation->set_rules('test_id', 'Diagnostic Test', 'trim|required|numeric');

		if ($this->input->post('submit') && $this->form_validation->run() == TRUE) {
			$before = $assignment;
			$this->pathology_model->update_assign_test($id);
			$after = $this->pathology_model->get_assign_test_row($id);

			$this->Audit_footprint_model->log_footprint(
				'test_mapping',
				$id,
				'UPDATED',
				$before,
				$after,
				"Updated pricing/terms for test assignment #{$id}"
			);

			$this->session->set_flashdata('flashmsg', '<div class="alert alert-success"><strong>Success!</strong> Test assignment updated successfully.</div>');
			redirect(base_url('doctor/pathology/index'));
			return;
		}

		$data['heading_title'] = 'Edit Test Assignment';
		$data['module']        = 'Pathology Test Assignment';
		$data['res']           = $assignment;
		$data['test']          = $this->pathology_model->get_test(array('status'=>'1'));
		$data['pathlab']       = $this->pathology_model->get_pathlab(array('approved'=>'1'));

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('pathology/assign_test_edit', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	/**
	 * Toggle status of test assignment
	 */
	public function toggle_status($id = null)
	{
		$id = (int)($id ?: ($this->input->get('id') ?: $this->input->post('id')));
		if (!$id) {
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 0, 'message' => 'Invalid assignment ID.'));
				return;
			}
			redirect(base_url('doctor/pathology/index'));
			return;
		}

		$before = $this->pathology_model->get_assign_test_row($id);
		$new_status = $this->pathology_model->toggle_status_assign($id);
		if ($new_status !== false) {
			$this->Audit_footprint_model->log_footprint(
				'test_mapping',
				$id,
				'STATUS_UPDATED',
				array('status' => $before ? $before['status'] : null),
				array('status' => $new_status),
				"Toggled status of test assignment #{$id} to {$new_status}"
			);

			$status_label = ($new_status == '1') ? 'Enabled / Active' : 'Disabled / Inactive';
			$msg = "Assignment #$id status changed to $status_label successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array(
					'status'       => 1,
					'new_status'   => $new_status,
					'status_label' => ($new_status == '1' ? 'Active' : 'Inactive'),
					'message'      => $msg
				));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		} else {
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 0, 'message' => 'Failed to toggle status.'));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'>Failed to toggle status.</div>");
		}
		redirect(base_url('doctor/pathology/index'));
	}

	public function bulk_action()
	{
		$action = trim($this->input->post('bulk_action', TRUE));
		$ids    = $this->input->post('ids');

		if (empty($ids) || !is_array($ids)) {
			$msg = 'Please select at least one test assignment.';
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 0, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>$msg</div>");
			redirect(base_url('doctor/pathology/index'));
			return;
		}

		$clean_ids = array_filter(array_map('intval', $ids));
		$count = count($clean_ids);

		if ($action === 'enable' || $action === '1') {
			$this->pathology_model->bulk_update_status($clean_ids, '1');
			$msg = "$count test assignment(s) enabled successfully.";
			$status = 1;
		} elseif ($action === 'disable' || $action === '0') {
			$this->pathology_model->bulk_update_status($clean_ids, '0');
			$msg = "$count test assignment(s) disabled successfully.";
			$status = 1;
		} elseif ($action === 'delete') {
			$this->pathology_model->bulk_delete_assign($clean_ids);
			$msg = "$count test assignment(s) deleted successfully.";
			$status = 1;
		} else {
			$msg = 'Invalid bulk action selected.';
			$status = 0;
		}

		$this->Audit_footprint_model->log_footprint(
			'test_mapping',
			0,
			'STATUS_UPDATED',
			null,
			array('action' => $action, 'affected_ids' => $clean_ids),
			"Bulk action '$action' performed on $count test assignments"
		);

		if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
			echo json_encode(array('status' => $status, 'count' => $count, 'message' => $msg));
			return;
		}

		$alertClass = ($status === 1) ? 'alert-success' : 'alert-danger';
		$this->session->set_flashdata('flashmsg', "<div class='alert $alertClass'>$msg</div>");
		redirect(base_url('doctor/pathology/index'));
	}

	public function assign_test_delete($id = null)
    {
		if ($this->input->post('ids') && is_array($this->input->post('ids'))) {
			$this->bulk_delete();
			return;
		}

		$del_id = $id ? $id : ($this->input->post('id') ? $this->input->post('id') : ($this->input->get('id') ? $this->input->get('id') : $this->uri->segment(4)));
		if ($del_id) {
			$before = $this->pathology_model->get_assign_test_row($del_id);
			$this->pathology_model->assign_test_delete($del_id);

			$this->Audit_footprint_model->log_footprint(
				'test_mapping',
				$del_id,
				'DELETED',
				$before,
				null,
				"Deleted test assignment #{$del_id}"
			);

			$msg = "Assigned test deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax') || $this->input->post('id')) {
				echo json_encode(array('status' => 1, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		}
		redirect(base_url('doctor/pathology/index'));
    }

	public function bulk_delete()
	{
		$ids = $this->input->post('ids');
		if (!empty($ids) && is_array($ids)) {
			$deleted_count = 0;
			foreach ($ids as $aid) {
				$aid = (int)$aid;
				if ($aid > 0) {
					$this->pathology_model->assign_test_delete($aid);
					$deleted_count++;
				}
			}
			$msg = "$deleted_count assigned test(s) deleted successfully.";
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 1, 'count' => $deleted_count, 'message' => $msg));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
		} else {
			if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
				echo json_encode(array('status' => 0, 'message' => 'No tests selected.'));
				return;
			}
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>No tests selected.</div>");
		}
		redirect(base_url('doctor/pathology/index'));
	}

	/**
	 * Phlebotomy & Specimen Chain-of-Custody Desk
	 */
	public function custody()
	{
		$stage   = trim($this->input->get('stage', TRUE) ?? '');
		$keyword = trim($this->input->get('keyword', TRUE) ?? '');

		$filters = array('stage' => $stage, 'keyword' => $keyword);
		$pagesize = 25;
		$offset = (int)$this->input->get('per_page') ?: 0;

		$data['bookings'] = $this->pathology_model->get_custody_bookings($pagesize, $offset, $filters);
		$data['total_rows'] = $this->pathology_model->count_custody_bookings($filters);
		$data['phlebotomists'] = $this->db->get('staff')->result();
		$data['stage'] = $stage;
		$data['keyword'] = $keyword;
		$data['heading_title'] = 'Specimen Chain-of-Custody Handover Desk';
		$data['module'] = 'Custody Desk';

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('pathology/custody', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	/**
	 * Assign Phlebotomist to booking
	 */
	public function custody_assign()
	{
		$bId = (int)$this->input->post('booking_id');
		$sId = (int)$this->input->post('staff_id');
		$bc  = trim($this->input->post('barcode'));
		$temp = (float)$this->input->post('temperature_c');

		if ($bId > 0 && $sId > 0) {
			$res = $this->pathology_model->assign_phlebotomist($bId, $sId, $bc, $temp);

			$this->Audit_footprint_model->log_footprint(
				'specimen',
				$bId,
				'SPECIMEN_HANDOVER',
				null,
				array('staff_id' => $sId, 'barcode' => $res['barcode'], 'temperature' => $temp, 'otp' => $res['otp']),
				"Phlebotomist #{$sId} dispatched for Booking #{$bId}. Barcode: {$res['barcode']}"
			);

			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Dispatched!</strong> Phlebotomist assigned. Vial Barcode: <strong>{$res['barcode']}</strong> | Handover OTP: <strong>{$res['otp']}</strong></div>");
		} else {
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'>Invalid booking or phlebotomist selected.</div>");
		}
		redirect(base_url('doctor/pathology/custody'));
	}

	/**
	 * Complete double-handshake handover to lab desk
	 */
	public function custody_handover()
	{
		$bId      = (int)$this->input->post('booking_id');
		$receiver = trim($this->input->post('receiver_name'));
		$otp      = trim($this->input->post('otp'));
		$cond     = trim($this->input->post('condition'));

		if ($bId > 0 && !empty($receiver)) {
			$this->pathology_model->verify_lab_handover($bId, $receiver, $otp, $cond);

			$this->Audit_footprint_model->log_footprint(
				'specimen',
				$bId,
				'HANDOVER',
				array('stage' => 'IN_TRANSIT'),
				array('receiver' => $receiver, 'otp_verified' => $otp, 'condition' => $cond, 'stage' => 'RECEIVED_AT_LAB'),
				"Specimen custody transferred to Lab Desk ({$receiver}). Quality: ".strtoupper($cond)
			);

			$this->session->set_flashdata('flashmsg', "<div class='alert alert-success'><strong>Handover Complete!</strong> Specimen received at lab desk by {$receiver}. Status updated to RECEIVED_AT_LAB.</div>");
		} else {
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'>Failed to complete handover. Receiver name required.</div>");
		}
		redirect(base_url('doctor/pathology/custody'));
	}

	/**
	 * View vertical visual chain-of-custody stepper
	 */
	public function custody_timeline($booking_id = null)
	{
		$bId = (int)($booking_id ?: $this->uri->segment(4));
		$timeline = $this->pathology_model->get_booking_timeline($bId);

		if (!$timeline || !$timeline['booking']) {
			$this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'>Booking #{$bId} not found.</div>");
			redirect(base_url('doctor/pathology/custody'));
			return;
		}

		$data['timeline']      = $timeline;
		$data['heading_title'] = "Chain of Custody Stepper #UP-BK-{$bId}";
		$data['module']        = 'Custody Stepper';

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('pathology/custody_timeline', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}

	/**
	 * Dedicated Audit Footprint Ledger View
	 */
	public function audit_logs()
	{
		$filters = array(
			'entity_type' => trim($this->input->get('entity_type', TRUE) ?? ''),
			'entity_id'   => (int)$this->input->get('entity_id'),
			'action'      => trim($this->input->get('action', TRUE) ?? ''),
			'from_date'   => trim($this->input->get('from_date', TRUE) ?? ''),
			'to_date'     => trim($this->input->get('to_date', TRUE) ?? ''),
			'keyword'     => trim($this->input->get('keyword', TRUE) ?? '')
		);

		$limit = 50;
		$offset = (int)$this->input->get('per_page') ?: 0;

		$data['footprints']    = $this->Audit_footprint_model->get_footprints($limit, $offset, $filters);
		$total                 = $this->Audit_footprint_model->count_footprints($filters);
		$data['filters']       = $filters;
		$data['heading_title'] = 'System Audit Footprints & Governance';
		$data['module']        = 'Audit Logs';

		$base_url              = function_exists('current_url_query_string') ? current_url_query_string(array('filter'=>'result'), array('per_page')) : current_url();
		$data['page_links']    = function_exists('admin_pagination') ? admin_pagination($base_url, $total, $limit, $offset) : '';

		$this->load->view('inc/topheaderlink');
		$this->load->view('inc/topheader');
		$this->load->view('pathology/audit_logs', $data);
		$this->load->view('sidebar');
		$this->load->view('inc/headersetting');
		$this->load->view('inc/footerlink');
		$this->load->view('inc/table_footer');
	}
}