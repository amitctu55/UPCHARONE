<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2018, British Columbia Institute of Technology
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
 * @copyright	Copyright (c) 2014 - 2018, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter FDDI Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Azad Hussain
 */

// ------------------------------------------------------------------------

if ( ! function_exists('formateDate'))
{
	
	function formateDate($date){
		return ($date) ? date("d/m/Y", strtotime($date)) : '';
	}
}

if ( ! function_exists('getUserId'))
{
	function getUserId(){
		return get_instance()->session->userdata('adminuserid');
	}
}
if ( ! function_exists('getInstitutionId'))
{
	function getInstitutionId(){
		return get_instance()->session->userdata('institution_id');
	}
}

if ( ! function_exists('getUserName'))
{
	function getUserName(){
		return get_instance()->session->userdata('username');
	}
}

if ( ! function_exists('getUserType'))
{
	function getUserType(){
		return get_instance()->session->userdata('code');
	}
}

if ( ! function_exists('getUserIP'))
{
	function getUserIP(){
		return get_instance()->input->ip_address();
	}
}

if ( ! function_exists('getUserAgent'))
{
	function getUserAgent(){
		return get_instance()->input->user_agent();
	}
}

if ( ! function_exists('getFY'))
{
	function getFY($date){
		$d = explode('-',$date);
		$y = $d[0];
		$m = $d[1];
		
		if($m >=4)
			return ($date) ? $y.'-'.($y+1) : '';
		else
			return ($date) ? ($y-1).'-'.$y : ''; 
	}
}


if ( ! function_exists('last_query'))
{
	function last_query(){
		echo get_instance()->db->last_query();
	}
}

if ( ! function_exists('getBlockList'))
{
	function getBlockList($district){
		try {
			$ci = get_instance();
			if ($ci->db && $ci->db->table_exists('lgd_block')) {
				$res = $ci->db->select('block_name,block_code')->order_by('block_name','ASC')->get_where('lgd_block',array('district_code'=>$district));
				return ($res && is_object($res)) ? $res->result() : array();
			}
		} catch (Throwable $e) {}
		return array();
	}
}

if ( ! function_exists('getVillageList'))
{
	function getVillageList($block){
		try {
			$ci = get_instance();
			if ($ci->db && $ci->db->table_exists('lgd_villages')) {
				$res = $ci->db->select('village_name,village_code')->order_by('village_name','ASC')->get_where('lgd_villages',array('block_code'=>$block));
				return ($res && is_object($res)) ? $res->result() : array();
			}
		} catch (Throwable $e) {}
		return array();
	}
}
/****************************************************/
if ( ! function_exists('getCityName'))
{
	function getCityName($id){
		try {
			$ci = get_instance();
			if ($ci->db && $ci->db->table_exists('master_city')) {
				$res = $ci->db->select('name')->get_where('master_city',array('id'=>$id));
				if ($res && is_object($res) && $res->num_rows() > 0) {
					$row = $res->row();
					return !empty($row->name) ? $row->name : '';
				}
			}
		} catch (Throwable $e) {}
		return '';
	}
}

if ( ! function_exists('getsectionName'))
{
	function getsectionName($id){
		try {
			$ci = get_instance();
			if ($ci->db && $ci->db->table_exists('master_sections')) {
				$res = $ci->db->select('section_name')->get_where('master_sections',array('section_id'=>$id));
				if ($res && is_object($res) && $res->num_rows() > 0) {
					$row = $res->row();
					return !empty($row->section_name) ? $row->section_name : '';
				}
			}
		} catch (Throwable $e) {}
		return '';
	}
}

if ( ! function_exists('getRegdcouncilName'))
{
	function getRegdcouncilName($id){
		try {
			$ci = get_instance();
			if ($ci->db && $ci->db->table_exists('master_council')) {
				$res = $ci->db->select('name')->get_where('master_council',array('id'=>$id));
				if ($res && is_object($res) && $res->num_rows() > 0) {
					$row = $res->row();
					return !empty($row->name) ? $row->name : '';
				}
			}
		} catch (Throwable $e) {}
		return '';
	}
}


if ( ! function_exists('getQualificationName'))
{
	function getQualificationName($id){
		try {
			$ci = get_instance();
			if ($ci->db && $ci->db->table_exists('master_degree')) {
				$res = $ci->db->select('name')->get_where('master_degree',array('id'=>$id));
				if ($res && is_object($res) && $res->num_rows() > 0) {
					$row = $res->row();
					return !empty($row->name) ? $row->name : '';
				}
			}
		} catch (Throwable $e) {}
		return '';
	}
}

if ( ! function_exists('getSpecilizationName'))
{
	function getSpecilizationName($id){
		try {
			$ci = get_instance();
			if ($ci->db && $ci->db->table_exists('master_specialization')) {
				$res = $ci->db->select('name')->get_where('master_specialization',array('id'=>$id));
				if ($res && is_object($res) && $res->num_rows() > 0) {
					$row = $res->row();
					return !empty($row->name) ? $row->name : '';
				}
			}
		} catch (Throwable $e) {}
		return '';
	}
}

if ( ! function_exists('gethospitalName'))
{
	function gethospitalName($id){
		try {
			$ci = get_instance();
			if ($ci->db && $ci->db->table_exists('hospital')) {
				$res = $ci->db->select('name')->get_where('hospital',array('id'=>$id));
				if ($res && is_object($res) && $res->num_rows() > 0) {
					$row = $res->row();
					return !empty($row->name) ? $row->name : '';
				}
			}
		} catch (Throwable $e) {}
		return '';
	}
}

if ( ! function_exists('getdoctorName'))
{
	function getdoctorName($id){
		try {
			$ci = get_instance();
			if ($ci->db && $ci->db->table_exists('profile_dr')) {
				$res = $ci->db->select('fname')->get_where('profile_dr',array('id'=>$id));
				if ($res && is_object($res) && $res->num_rows() > 0) {
					$row = $res->row();
					return !empty($row->fname) ? $row->fname : '';
				}
			}
		} catch (Throwable $e) {}
		return '';
	}
}

if ( ! function_exists('getServicesName'))
{
	function getServicesName($id){
		try {
			$ci = get_instance();
			if ($ci->db && $ci->db->table_exists('master_services')) {
				$res = $ci->db->select('name')->get_where('master_services',array('id'=>$id));
				if ($res && is_object($res) && $res->num_rows() > 0) {
					$row = $res->row();
					return !empty($row->name) ? $row->name : '';
				}
			}
		} catch (Throwable $e) {}
		return '';
	}
}
if ( ! function_exists('getModuleName'))
{
	function getModuleName($module_id){
		try {
			$ci = get_instance();
			if ($ci->db && $ci->db->table_exists('master_management')) {
				$res = $ci->db->select('module_name')->get_where('master_management',array('module_id'=>$module_id));
				if ($res && is_object($res) && $res->num_rows() > 0) {
					$row = $res->row();
					return !empty($row->module_name) ? $row->module_name : '';
				}
			}
		} catch (Throwable $e) {}
		return '';
	}
}
if ( ! function_exists('getRoleName'))
{
	function getRoleName($level_id){
		if (empty($level_id)) {
			return 'Administrator';
		}
		try {
			$ci = get_instance();
			if ($ci->db && $ci->db->table_exists('rolewise')) {
				$res = $ci->db->select('level_name')->get_where('rolewise',array('level_id'=>$level_id));
				if ($res && is_object($res) && $res->num_rows() > 0) {
					$row = $res->row();
					return !empty($row->level_name) ? $row->level_name : 'Administrator';
				}
			}
		} catch (Throwable $e) {}
		return 'Administrator';
	}
}
if ( ! function_exists('getCityName'))
{
	function getCityName($id){
		try {
			$ci = get_instance();
			if ($ci->db && $ci->db->table_exists('master_city')) {
				$res = $ci->db->select('name')->get_where('master_city',array('id'=>$id));
				if ($res && is_object($res) && $res->num_rows() > 0) {
					$row = $res->row();
					return !empty($row->name) ? $row->name : '';
				}
			}
		} catch (Throwable $e) {}
		return '';
	}
}
if ( ! function_exists('getInstituteName'))
{
	function getInstituteName($id,$type='H'){
		try {
			$table = ($type=='C') ? 'clinic' : 'hospital';
			$ci = get_instance();
			if ($ci->db && $ci->db->table_exists($table)) {
				$res = $ci->db->select('name')->get_where($table,array('id'=>$id));
				if ($res && is_object($res) && $res->num_rows() > 0) {
					$row = $res->row();
					return !empty($row->name) ? $row->name : '';
				}
			}
		} catch (Throwable $e) {}
		return '';
	}
}
if(!function_exists('sendsms'))
{
	function sendsms($msg,$contacts)
	{
		$api_key = '45C6DA05EDD0DC';
		//$from = 'UPCHAR';
		$from = 'Upcare';
		$sms_text = urlencode($msg);
		//$api_url = "http://bulksms.smsroot.com/app/smsapi/index.php?key=".$api_key."&campaign=0&routeid=13&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text;
		$api_url='http://bulksms.smsroot.com/app/smsapi/index.php?key=45C6DA05EDD0DC&campaign=0&routeid=13&type=text&contacts='. $contacts .'&senderid=UPCARE&msg='. urlencode( $msg ) .'&template_id=1507161519686689997';
		//$api_url = "http://bulksms.smsroot.com/app/smsapi/index.php?key=".$api_key."&campaign=0&routeid=13&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text."&template_id=".$template_id."";
		//$response = file_get_contents( $api_url);
		// Step 1
		$cSession = curl_init(); 
		// Step 2
		curl_setopt($cSession,CURLOPT_URL,$api_url);
		curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($cSession,CURLOPT_HEADER, false); 
		// Step 3
		$result=curl_exec($cSession);
		// Step 4
		curl_close($cSession);
		// Step 5
		return $result;
				//return  $response;
	}	
}

if( ! function_exists('removeImage'))
{
	function removeImage($cfgs)
	{	
		if($cfgs['source_file']!='')
		{
			$pathImage=UPLOAD_DIR."/".$cfgs['source_file'];
			if(file_exists($pathImage))
			{
				unlink($pathImage);
			}
		}
	}	
}



