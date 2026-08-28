<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment_model extends CI_Model {

    public function get_user_appointments($user_id) {
        if (!$user_id) {
            return array();
        }

        $this->db->select('a.*, a.appointment_name as patient_name, d.fname as doctor_fname, d.lname as doctor_lname');
        $this->db->from('appointment a');
        $this->db->join('profile_dr d', 'd.id = a.doctor_id', 'left');
        $this->db->where('a.user_id', $user_id);
        $this->db->where('a.status !=', '0');
        $this->db->order_by('a.appointment_date', 'DESC');
        $this->db->order_by('a.appointment_id', 'DESC');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $results = $query->result();
            foreach ($results as $row) {
                // Determine institute table (clinic or hospital)
                $table = (!empty($row->institution_type) && $row->institution_type == 'C') ? 'clinic' : 'hospital';
                $institute = $this->db->select('name')->where('id', $row->institute_id)->get($table)->row();
                $row->institute_name = $institute ? $institute->name : 'Medical Center';
                
                $doc_name = trim(($row->doctor_fname ?: '') . ' ' . ($row->doctor_lname ?: ''));
                $row->doctor_name = !empty($doc_name) ? 'Dr. ' . $doc_name : 'Doctor';
            }
            return $results;
        }

        return array();
    }
}
