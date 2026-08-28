<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model{
	
	public function insert()
	{
	    $date = date('Y-m-d H:i:s');
	    $fname  = $this->input->post('fname');
	    $lname  = $this->input->post('lname');
	    $pwd    = md5($this->input->post('password'));
	    $email  = $this->input->post('email');
	    $gender = $this->input->post('activeradio');
	    $dob    = $this->input->post('dob');
	    $height = $this->input->post('height');
	    $weight = $this->input->post('weight');
	    $blood  = $this->input->post('blood');
	    $mobile = $this->input->post('mobile');
	    
	    $data = array(
	        'MOBILE'   => $mobile,
	        'FNAME'    => $fname,
	        'LNAME'    => $lname,
	        'PASSWORD' => $pwd,
	        'EMAIL'    => $email,
	        'DOB'      => $dob,
	        'REG_DATE' => $date,
	        'GENDER'   => $gender,
	        'BGROUP'   => $blood,
	        'HEIGHT'   => $height,
	        'WEIGHT'   => $weight,
	        'status'   => '1'
	    );
	   
	    return $this->db->insert('userlogin', $data);
	}

	public function get_users($limit = 10, $offset = 0)
	{
		$keyword = $this->input->get_post('keyword');
		$mobile  = $this->input->get_post('mobile');

		$this->db->select('SQL_CALC_FOUND_ROWS userlogin.*', FALSE);
		$this->db->from('userlogin');
		$this->db->where('status', '1');

		if (!empty($keyword)) {
			$this->db->group_start();
			$this->db->like('FNAME', $keyword);
			$this->db->or_like('LNAME', $keyword);
			$this->db->or_like('EMAIL', $keyword);
			$this->db->group_end();
		}

		if (!empty($mobile)) {
			$this->db->like('MOBILE', $mobile);
		}

		$this->db->order_by('USERID', 'DESC');
		$this->db->limit($limit, $offset);
		
		return $this->db->get()->result();
	}

    public function delete($id)
    {
        $this->db->where('USERID', $id)->delete('userlogin');
    }

    public function bulk_delete($ids)
    {
    	if (is_array($ids) && !empty($ids)) {
    		$this->db->where_in('USERID', $ids)->delete('userlogin');
    		return TRUE;
    	}
    	return FALSE;
    }

    public function reset_password($id, $new_password)
    {
    	$pwd = md5($new_password);
    	$this->db->where('USERID', $id)->update('userlogin', array('PASSWORD' => $pwd));
    	return TRUE;
    }
}
