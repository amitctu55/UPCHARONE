<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pathology_model extends CI_Model
{ 
	public function get_assign_test($limit='10',$offset='0',$param=array())
	{	
		try {
			if (!$this->db || !$this->db->table_exists('path_lab_test')) {
				return array();
			}
			$test_id	= @$param['test_id'];
			$keyword 	= $this->db->escape_str($this->input->get('keyword',TRUE));
		
			if($test_id!='')
			{
				$this->db->where("path_lab_test.test_id",$test_id);
			}
			if($keyword!='')
			{
				if ($this->db->table_exists('pathlab')) {
					$this->db->where("(pathlab.name LIKE '%".$keyword."%' )");
				}
			}
			$this->db->order_by('path_lab_test.id','desc');
			$this->db->limit($limit,$offset);
			$this->db->select('SQL_CALC_FOUND_ROWS path_lab_test.*,pathlab.name,pathtest.test_name',FALSE);

			if ($this->db->table_exists('pathtest')) {
				$this->db->join('pathtest','path_lab_test.test_id=pathtest.test_id','left');
			}
			if ($this->db->table_exists('pathlab')) {
				$this->db->join('pathlab','pathlab.id=path_lab_test.path_lab_id','left');
			}
			$q = $this->db->get('path_lab_test');
			$result = ($q && is_object($q)) ? $q->result_array() : array();
			$result = ($limit=='1') ? @$result[0]: $result;	
			return $result ?: array();
		} catch (Throwable $e) {
			return array();
		}
	}
	
	
	
	public function insert_assign_test($test_id = null, $path_lab_id = null, $lab_price = 0, $comment = '')
	{	
		$tid   = $test_id !== null ? $test_id : $this->input->post('test_id');
		$pid   = $path_lab_id !== null ? $path_lab_id : $this->input->post('path_lab_id');
		$price = $lab_price ? $lab_price : (int)$this->input->post('lab_price');
		$comm  = $comment ? $comment : $this->input->post('comment');
		$stat  = $this->input->post('status') !== null ? $this->input->post('status') : '1';

		$data = array(
			'test_id'      => (int)$tid,
			'path_lab_id'  => (int)$pid,
			'lab_price'    => (int)$price,
			'comment'      => $comm,
			'status'       => $stat,
			'created_date' => date('Y-m-d H:i:s'),
			'updated_date' => date('Y-m-d H:i:s')
		);
		$this->db->insert('path_lab_test', $data);
		return $this->db->insert_id();
	}
	
	function assign_test_delete($id)
	{
		$this->db->query("delete from path_lab_test where id='".$id."'");
	}

	public function get_assign_test_row($id)
	{
		$this->db->select('path_lab_test.*, pathlab.name as lab_name, pathtest.test_name');
		$this->db->join('pathtest', 'path_lab_test.test_id = pathtest.test_id', 'left');
		$this->db->join('pathlab', 'pathlab.id = path_lab_test.path_lab_id', 'left');
		$this->db->where('path_lab_test.id', (int)$id);
		$q = $this->db->get('path_lab_test');
		return ($q && is_object($q)) ? $q->row_array() : null;
	}

	public function update_assign_test($id)
	{
		$tid   = $this->input->post('test_id');
		$pid   = $this->input->post('path_lab_id');
		$price = (int)$this->input->post('lab_price');
		$comm  = $this->input->post('comment');
		$stat  = $this->input->post('status') !== null ? $this->input->post('status') : '1';

		$data = array(
			'test_id'      => (int)$tid,
			'path_lab_id'  => (int)$pid,
			'lab_price'    => (int)$price,
			'comment'      => $comm,
			'status'       => $stat,
			'updated_date' => date('Y-m-d H:i:s')
		);
		$this->db->where('id', (int)$id);
		return $this->db->update('path_lab_test', $data);
	}

	public function toggle_status_assign($id)
	{
		$row = $this->db->get_where('path_lab_test', array('id' => (int)$id))->row();
		if ($row) {
			$new_status = ($row->status == '1') ? '0' : '1';
			$this->db->where('id', (int)$id)->update('path_lab_test', array(
				'status'       => $new_status,
				'updated_date' => date('Y-m-d H:i:s')
			));
			return $new_status;
		}
		return false;
	}

	public function bulk_update_status($ids, $status)
	{
		if (!empty($ids) && is_array($ids)) {
			$this->db->where_in('id', $ids);
			return $this->db->update('path_lab_test', array(
				'status'       => $status,
				'updated_date' => date('Y-m-d H:i:s')
			));
		}
		return false;
	}

	public function bulk_delete_assign($ids)
	{
		if (!empty($ids) && is_array($ids)) {
			$this->db->where_in('id', $ids);
			return $this->db->delete('path_lab_test');
		}
		return false;
	}
	
	public  function get_test($page=array())
	{		
		try {
			if ($this->db && $this->db->table_exists('pathtest')) {
				$this->db->select('test_id,test_name');
				if( is_array($page) && !empty($page) ) {
					$q = $this->db->get_where('pathtest',$page);
				} else {
					$q = $this->db->get('pathtest');
				}
				if ($q && is_object($q)) {
					$result = $q->result_array();
					if( is_array($result) && !empty($result) ) {
						return $result;
					}
				}
			}
		} catch (Throwable $e) {}
		return array();
	}
	
	public  function get_pathlab($page=array())
	{		
		try {
			if ($this->db && $this->db->table_exists('pathlab')) {
				$this->db->select('id,name');
				if( is_array($page) && !empty($page) ) {
					$q = $this->db->get_where('pathlab',$page);
				} else {
					$q = $this->db->get('pathlab');
				}
				if ($q && is_object($q)) {
					$result = $q->result_array();
					if( is_array($result) && !empty($result) ) {
						return $result;
					}
				}
			}
		} catch (Throwable $e) {}
		return array();
	}
	
	public function test_insert()
	{
		$data	=	array(
						'category_id'		=>$this->input->post('category_id'),
						'path_id'			=>$this->input->post('path_id'),
						'test_name'			=>$this->input->post('test_name'),
						'short_name'		=>$this->input->post('short_name'),
						'test_type'			=>$this->input->post('test_type'),
						'sub_category'		=>$this->input->post('sub_category'),
						'method'			=>$this->input->post('method'),
						'report_day'		=>$this->input->post('report_day'),
						'charge_category'	=>$this->input->post('charge_category'),
						'code'				=>$this->input->post('code'),
						'amount'			=>$this->input->post('amount'),
						'status'			=>$this->input->post('status'),
						'approved'			=>$this->input->post('approved'),
						'creat_date'		=>date('Y-m-d h:i:s'),
						);
		$this->db->insert('pathtest',$data);
		$test_id = $this->db->insert_id();
		return $test_id;
	}
	
	public function update($test_id)
	{	
		$data	=array(
						'category_id'		=>$this->input->post('category_id'),
						'path_id'			=>$this->input->post('path_id'),
						'test_name'			=>$this->input->post('test_name'),
						'short_name'		=>$this->input->post('short_name'),
						'test_type'			=>$this->input->post('test_type'),
						'sub_category'		=>$this->input->post('sub_category'),
						'method'			=>$this->input->post('method'),
						'report_day'		=>$this->input->post('report_day'),
						'charge_category'	=>$this->input->post('charge_category'),
						'code'				=>$this->input->post('code'),
						'amount'			=>$this->input->post('amount'),
						'status'			=>$this->input->post('status'),
						'approved'			=>$this->input->post('approved'),
						'creat_date'		=>date('Y-m-d h:i:s'),
					);
		$this->db->where('test_id',$test_id);
		$this->db->update('pathtest',$data);
		return $test_id;
	}
	
	public  function get_unit_all($page=array())
	{		
		if( is_array($page) && !empty($page) )
		{
			$this->db->select('unit_id,unit_name');
			$result =  $this->db->get_where('path_unit',$page)->result_array();
			if( is_array($result) && !empty($result) )
			{
				return $result;
			}
		}
	}
	
	public function get_path_parameter($limit='10',$offset='0',$param=array())
	{		
		$parameter_id			=   @$param['parameter_id'];
		
		$keyword 		= $this->db->escape_str($this->input->get_post('keyword',TRUE));
		if($parameter_id!='')
		{	
			$this->db->where("path_parameter.parameter_id",$parameter_id);
		}
		if($keyword!='')
		{
			$this->db->where("(parameter_name LIKE '%".$keyword."%' )");
		}
		$this->db->order_by('parameter_id','desc');
		$this->db->limit($limit,$offset);
		$this->db->select('SQL_CALC_FOUND_ROWS path_parameter.*,path_unit.unit_name',FALSE);
		$this->db->join('path_unit','path_unit.unit_id=path_parameter.unit_id','left');
		$result = $this->db->get('path_parameter')->result();
		$result = ($limit=='1') ? @$result[0]: $result;	
		return $result;
	}
	
	function parameterrecord($id)
	{
		$this->db->query("delete from path_parameter where parameter_id='".$id."'");
	}
	
	public function parameterinsert()
	{
		$data	=	array(
						'parameter_name'			=>$this->input->post('parameter_name'),
						'reference_range'			=>$this->input->post('reference_range'),
						'unit_id'					=>$this->input->post('unit_id'),
						'description'				=>$this->input->post('description'),
						'creat_date'				=>date('Y-m-d h:i:s'),
						'created_by'				=>getUserId(),
						);
		$this->db->insert('path_parameter',$data);
		$parameter_id = $this->db->insert_id();
		return $parameter_id;
	}
	public function updateparameter($unit_id)
	{	
		$data	=array(
						'parameter_name'			=>$this->input->post('parameter_name'),
						'reference_range'			=>$this->input->post('reference_range'),
						'unit_id'					=>$this->input->post('unit_id'),
						'description'				=>$this->input->post('description'),
						'status'					=>$this->input->post('status'),
						'creat_date'				=>date('Y-m-d h:i:s'),
						'created_by'				=>getUserId(),
					);
		$this->db->where('parameter_id', $unit_id);
		$this->db->update('path_parameter', $data);
		return $unit_id;
	}

	public function insert_master_test($data = array())
	{
		if (empty($data)) {
			$data = array(
				'test_name'          => trim($this->input->post('test_name')),
				'short_name'         => trim($this->input->post('short_name') ?: $this->input->post('test_name')),
				'code'               => trim($this->input->post('code') ?: ('UP-' . strtoupper(substr(preg_replace('/[^a-zA-Z0-9]/', '', $this->input->post('test_name')), 0, 4)) . '-' . rand(10,99))),
				'department'         => trim($this->input->post('department') ?: 'Biochemistry'),
				'specimen_type'      => trim($this->input->post('specimen_type') ?: 'Whole Blood EDTA'),
				'container_color'    => trim($this->input->post('container_color') ?: 'Purple (EDTA)'),
				'fasting_required'   => $this->input->post('fasting_required') ? 1 : 0,
				'standard_tat_hours' => (int)($this->input->post('standard_tat_hours') ?: 24),
				'amount'             => (float)($this->input->post('amount') ?: 0),
				'method'             => trim($this->input->post('method') ?: 'Automated Analyzer'),
				'category_id'        => (int)($this->input->post('category_id') ?: 1),
				'path_id'            => (int)($this->input->post('path_id') ?: 0),
				'test_type'          => trim($this->input->post('department') ?: 'Pathology'),
				'status'             => '1',
				'approved'           => '1',
				'creat_date'         => date('Y-m-d H:i:s')
			);
		}
		$this->db->insert('pathtest', $data);
		return $this->db->insert_id();
	}

	public function get_lab_commission_rate($lab_id)
	{
		$row = $this->db->select('commission_rate')->get_where('pathlab', array('id' => (int)$lab_id))->row();
		return $row ? (float)$row->commission_rate : 15.00;
	}

	public function get_dashboard_metrics()
	{
		$stats = array(
			'total_labs'          => 0,
			'approved_labs'       => 0,
			'total_tests'         => 0,
			'total_assignments'   => 0,
			'active_assignments'  => 0,
			'total_bookings'      => 0,
			'pending_collection'  => 0,
			'in_transit'          => 0,
			'received_at_lab'     => 0,
			'completed_reports'   => 0,
			'active_phlebos'      => 0,
			'recent_footprints'   => array()
		);

		try {
			if ($this->db && $this->db->table_exists('pathlab')) {
				$stats['total_labs']    = $this->db->count_all('pathlab');
				$stats['approved_labs'] = $this->db->where('approved', '1')->count_all_results('pathlab');
			}
			if ($this->db && $this->db->table_exists('pathtest')) {
				$stats['total_tests'] = $this->db->count_all('pathtest');
			}
			if ($this->db && $this->db->table_exists('path_lab_test')) {
				$stats['total_assignments']  = $this->db->count_all('path_lab_test');
				$stats['active_assignments'] = $this->db->where('status', '1')->count_all_results('path_lab_test');
			}
			if ($this->db && $this->db->table_exists('path_book')) {
				$stats['total_bookings'] = $this->db->count_all('path_book');
				$bookFields = $this->db->list_fields('path_book');
				if (in_array('order_stage', $bookFields)) {
					$stats['pending_collection'] = $this->db->group_start()->where('order_stage', 'BOOKED')->or_where('order_stage', 'PENDING')->or_where('order_stage IS NULL', NULL, FALSE)->group_end()->count_all_results('path_book');
					$stats['in_transit']         = $this->db->where('order_stage', 'IN_TRANSIT')->count_all_results('path_book');
					$stats['received_at_lab']    = $this->db->group_start()->where('order_stage', 'RECEIVED_AT_LAB')->or_where('order_stage', 'SAMPLE_COLLECTED')->group_end()->count_all_results('path_book');
					$stats['completed_reports']  = $this->db->group_start()->where('order_stage', 'REPORT_READY')->or_where('order_stage', 'COMPLETED')->group_end()->count_all_results('path_book');
				}
			}
			if ($this->db && $this->db->table_exists('staff')) {
				$stats['active_phlebos'] = $this->db->count_all('staff');
			}
			if ($this->db && $this->db->table_exists('system_audit_footprints')) {
				$this->db->order_by('id', 'DESC');
				$this->db->limit(10);
				$q = $this->db->get('system_audit_footprints');
				$stats['recent_footprints'] = ($q && is_object($q)) ? $q->result() : array();
			}
		} catch (Throwable $e) {
			log_message('error', 'get_dashboard_metrics: ' . $e->getMessage());
		}

		return $stats;
	}

	public function get_custody_bookings($limit = 20, $offset = 0, $filters = array())
	{
		try {
			if (!$this->db || !$this->db->table_exists('path_book')) {
				return array();
			}

			$hasCustodyTable = $this->db->table_exists('sample_custody_tracking');
			$hasStaffTable   = $this->db->table_exists('staff');
			$hasLabTable     = $this->db->table_exists('pathlab');
			$bookFields      = $this->db->list_fields('path_book');

			$select = 'path_book.*';
			if ($hasLabTable) {
				$select .= ', pathlab.name as lab_name';
			}
			if ($hasStaffTable) {
				$select .= ', staff.name as phlebo_name, staff.surname as phlebo_surname, staff.contact_no as phlebo_mobile';
			}
			if ($hasCustodyTable) {
				$select .= ', sample_custody_tracking.id as custody_id, sample_custody_tracking.barcode_number, sample_custody_tracking.collection_temperature_c, sample_custody_tracking.status as custody_status, sample_custody_tracking.handover_verification_otp, sample_custody_tracking.sample_condition_on_receipt';
			}

			$this->db->select($select);
			$this->db->from('path_book');

			if ($hasLabTable) {
				$this->db->join('pathlab', 'pathlab.id = path_book.pathlab_id', 'left');
			}
			if ($hasStaffTable && in_array('assigned_collector_id', $bookFields)) {
				$this->db->join('staff', 'staff.id = path_book.assigned_collector_id', 'left');
			}
			if ($hasCustodyTable) {
				$this->db->join('sample_custody_tracking', 'sample_custody_tracking.booking_id = path_book.booking_id', 'left');
			}

			if (!empty($filters['stage']) && in_array('order_stage', $bookFields)) {
				$this->db->where('path_book.order_stage', $filters['stage']);
			}
			if (!empty($filters['keyword'])) {
				$kw = $this->db->escape_str($filters['keyword']);
				$cond = "(path_book.patient_name LIKE '%{$kw}%' OR path_book.booking_id LIKE '%{$kw}%' OR path_book.patient_mobile LIKE '%{$kw}%'";
				if ($hasCustodyTable) {
					$cond .= " OR sample_custody_tracking.barcode_number LIKE '%{$kw}%'";
				}
				$cond .= ")";
				$this->db->where($cond);
			}

			$this->db->order_by('path_book.booking_id', 'DESC');
			$this->db->limit($limit, $offset);
			$q = $this->db->get();
			return ($q && is_object($q)) ? $q->result() : array();
		} catch (Throwable $e) {
			log_message('error', 'get_custody_bookings: ' . $e->getMessage());
			return array();
		}
	}

	public function count_custody_bookings($filters = array())
	{
		try {
			if (!$this->db || !$this->db->table_exists('path_book')) {
				return 0;
			}

			$hasCustodyTable = $this->db->table_exists('sample_custody_tracking');
			$bookFields      = $this->db->list_fields('path_book');

			$this->db->from('path_book');
			if ($hasCustodyTable) {
				$this->db->join('sample_custody_tracking', 'sample_custody_tracking.booking_id = path_book.booking_id', 'left');
			}

			if (!empty($filters['stage']) && in_array('order_stage', $bookFields)) {
				$this->db->where('path_book.order_stage', $filters['stage']);
			}
			if (!empty($filters['keyword'])) {
				$kw = $this->db->escape_str($filters['keyword']);
				$cond = "(path_book.patient_name LIKE '%{$kw}%' OR path_book.booking_id LIKE '%{$kw}%' OR path_book.patient_mobile LIKE '%{$kw}%'";
				if ($hasCustodyTable) {
					$cond .= " OR sample_custody_tracking.barcode_number LIKE '%{$kw}%'";
				}
				$cond .= ")";
				$this->db->where($cond);
			}
			return (int)$this->db->count_all_results();
		} catch (Throwable $e) {
			return 0;
		}
	}

	public function assign_phlebotomist($booking_id, $staff_id, $barcode = null, $temp = null)
	{
		$bId = (int)$booking_id;
		$sId = (int)$staff_id;

		if (empty($barcode)) {
			$barcode = 'BC-' . rand(100000, 999999);
		}
		$otp = (string)rand(1000, 9999);

		// Update path_book
		$this->db->where('booking_id', $bId)->update('path_book', array(
			'assigned_collector_id' => $sId,
			'vial_barcode'          => $barcode,
			'order_stage'           => 'IN_TRANSIT',
			'collection_status'     => 'assigned'
		));

		// Check or insert sample_custody_tracking
		$existing = $this->db->get_where('sample_custody_tracking', array('booking_id' => $bId))->row();
		if ($existing) {
			$this->db->where('id', $existing->id)->update('sample_custody_tracking', array(
				'phlebotomist_user_id'     => $sId,
				'barcode_number'           => $barcode,
				'collected_at'             => date('Y-m-d H:i:s'),
				'collection_temperature_c' => $temp ? (float)$temp : 4.5,
				'handover_verification_otp'=> $otp,
				'status'                   => 'in_transit'
			));
			$custodyId = $existing->id;
		} else {
			$this->db->insert('sample_custody_tracking', array(
				'booking_id'               => $bId,
				'barcode_number'           => $barcode,
				'phlebotomist_user_id'     => $sId,
				'sample_type'              => 'Whole Blood & Serum',
				'collected_at'             => date('Y-m-d H:i:s'),
				'collection_temperature_c' => $temp ? (float)$temp : 4.5,
				'handover_verification_otp'=> $otp,
				'status'                   => 'in_transit',
				'created_at'               => date('Y-m-d H:i:s')
			));
			$custodyId = $this->db->insert_id();
		}

		return array(
			'custody_id' => $custodyId,
			'barcode'    => $barcode,
			'otp'        => $otp
		);
	}

	public function verify_lab_handover($booking_id, $receiver_name = 'Lab Technician', $otp = null, $condition = 'intact')
	{
		$bId = (int)$booking_id;
		$cond = in_array($condition, ['intact', 'hemolyzed', 'lipemic', 'leaked', 'quantity_insufficient']) ? $condition : 'intact';

		$this->db->where('booking_id', $bId)->update('sample_custody_tracking', array(
			'handover_to_lab_at'          => date('Y-m-d H:i:s'),
			'lab_receiver_name'           => $receiver_name,
			'sample_condition_on_receipt' => $cond,
			'status'                      => ($cond == 'intact') ? 'accepted_by_lab' : 'rejected_by_lab'
		));

		$newStage = ($cond == 'intact') ? 'RECEIVED_AT_LAB' : 'SAMPLE_REJECTED';
		$this->db->where('booking_id', $bId)->update('path_book', array(
			'order_stage'       => $newStage,
			'collection_status' => 'handed_to_lab'
		));

		return true;
	}

	public function get_booking_timeline($booking_id)
	{
		$bId = (int)$booking_id;
		$booking = $this->db->select('path_book.*, pathlab.name as lab_name, pathlab.address as lab_address, staff.name as phlebo_name, staff.surname as phlebo_surname, staff.contact_no as phlebo_mobile')
			->from('path_book')
			->join('pathlab', 'pathlab.id = path_book.pathlab_id', 'left')
			->join('staff', 'staff.id = path_book.assigned_collector_id', 'left')
			->where('path_book.booking_id', $bId)
			->get()
			->row();

		if (!$booking) return null;

		$custody = $this->db->get_where('sample_custody_tracking', array('booking_id' => $bId))->row();
		$reports = $this->db->get_where('path_reports', array('booking_id' => $bId))->result();
		$footprints = $this->db->order_by('id', 'ASC')->get_where('system_audit_footprints', array('entity_type' => 'booking', 'entity_id' => $bId))->result();

		return array(
			'booking'    => $booking,
			'custody'    => $custody,
			'reports'    => $reports,
			'footprints' => $footprints
		);
	}
}