<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2017, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2017, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter URL Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/helpers/url_helper.html
 */

// ------------------------------------------------------------------------

if ( ! function_exists('is_loggedin'))
{
	
	function is_loggedin()
	{
		$uid=get_instance()->session->userdata('userid');
        //get_instance()->session->set_userdata('useremail', $row->EMAIL);				           
		//get_instance()->session->set_userdata('username', $row->FNAME);
		if($uid!=''){
			return true;
		}else{
			return false;
		}
		//return get_instance()->config->site_url($uri, $protocol);
	}
}

if ( ! function_exists('get_userid'))
{
	
	function get_userid()
	{
		$uid=get_instance()->session->userdata('userid');
        
		return $uid;
		//return get_instance()->config->site_url($uri, $protocol);
	}
}
if ( ! function_exists('formateDate'))
{
	function formateDate($date)
	{
		return $date;
	}
}
if( ! function_exists('getMeta'))
{
	function getMeta()
	{
		$CI = get_instance();
		$uri_page = $CI->uri->uri_string!='' ? $CI->uri->uri_string : "home";	
		if(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']!='')
		{
			 $uri_page.="?".$_SERVER['QUERY_STRING'];
		}
		
		$res=$CI->db->query("SELECT * FROM meta_tags WHERE page_url='".$uri_page."' ")->row();
		
		if( is_object($res) )
		{
			return array(
			
				"meta_title"=>$res->meta_title,
				"meta_keyword"=>$res->meta_keyword,
				"meta_description"=>$res->meta_description
			 );
									
									
		}else
		{			
				  return array("meta_title"=>"Upchar One Place of Healthcare",
				  "meta_keyword"=>"Upchar One Place of Healthcare, Doctor Appointment, Hospitals, Pathology, Diagnostic Labs",
				   "meta_description"=>"Upchar One Place of Healthcare - Find and book appointments with verified doctors, hospitals, clinics, and pathology labs.",
				   'dynamic_meta'=>TRUE 
				);
		}
	}	
}

if ( ! function_exists('enforce_single_session_role'))
{
    /**
     * Enforce Strictly Single Active Role per Browser Session
     * Admin, Staff, and Patient/User cannot be simultaneously logged in on the same browser session.
     */
    function enforce_single_session_role($intendedRole)
    {
        $CI = get_instance();

        // 1. Patient / User Login: Clears all Admin, Staff, and Provider credentials
        if ($intendedRole === 'user') {
            $staff_keys = ['staff_user_id', 'staff_code', 'staff_name', 'staff_email', 'staff_phone', 'staff_role', 'staff_dept', 'staff_designation', 'staff_logged_in'];
            $admin_keys = ['adminuserid', 'userid_admin', 'adminusername', 'code'];
            $partner_keys = ['doctor_id', 'hospital_id', 'pathology_id', 'chemist_id', 'clinic_id', 'pathdoctor_id'];
            $CI->session->unset_userdata(array_merge($staff_keys, $admin_keys, $partner_keys));
            $CI->session->set_userdata('active_auth_role', 'user');
            @setcookie('ci_admin_session', '', time() - 3600, '/');
        }
        // 2. Staff / Logistics Login: Clears Patient and Provider credentials
        elseif ($intendedRole === 'staff') {
            $user_keys = ['userid', 'USERID', 'user_id', 'useremail', 'username', 'signupuserid', 'forgotuserid'];
            $admin_keys = ['adminuserid', 'userid_admin', 'adminusername'];
            $partner_keys = ['doctor_id', 'hospital_id', 'pathology_id', 'chemist_id', 'clinic_id', 'pathdoctor_id'];
            $CI->session->unset_userdata(array_merge($user_keys, $admin_keys, $partner_keys));
            $CI->session->set_userdata('active_auth_role', 'staff');
        }
        // 3. Admin1947 Login: Clears Patient and Provider credentials
        elseif ($intendedRole === 'admin') {
            $user_keys = ['userid', 'USERID', 'user_id', 'useremail', 'username', 'signupuserid', 'forgotuserid'];
            $partner_keys = ['doctor_id', 'hospital_id', 'pathology_id', 'chemist_id', 'clinic_id', 'pathdoctor_id'];
            $CI->session->unset_userdata(array_merge($user_keys, $partner_keys));
            $CI->session->set_userdata('active_auth_role', 'admin');
        }
        // 4. Healthcare Partner (Doctor / Hospital / Lab): Clears User and Staff credentials
        elseif ($intendedRole === 'partner') {
            $user_keys = ['userid', 'USERID', 'user_id', 'useremail', 'username', 'signupuserid', 'forgotuserid'];
            $staff_keys = ['staff_user_id', 'staff_code', 'staff_name', 'staff_email', 'staff_phone', 'staff_role', 'staff_dept', 'staff_designation', 'staff_logged_in'];
            $admin_keys = ['adminuserid', 'userid_admin', 'adminusername'];
            $CI->session->unset_userdata(array_merge($user_keys, $staff_keys, $admin_keys));
            $CI->session->set_userdata('active_auth_role', 'partner');
        }
    }
}

