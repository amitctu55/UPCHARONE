<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recruitment_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all jobs with applicant statistics
     */
    public function get_all_jobs($status = null) {
        $this->db->select('j.*, 
            COUNT(c.career_id) as total_applicants,
            SUM(CASE WHEN c.status_stage = "applied" THEN 1 ELSE 0 END) as count_applied,
            SUM(CASE WHEN c.status_stage = "screened" THEN 1 ELSE 0 END) as count_screened,
            SUM(CASE WHEN c.status_stage = "interviewing" THEN 1 ELSE 0 END) as count_interviewing,
            SUM(CASE WHEN c.status_stage = "offered" THEN 1 ELSE 0 END) as count_offered,
            SUM(CASE WHEN c.status_stage = "hired" THEN 1 ELSE 0 END) as count_hired,
            SUM(CASE WHEN c.status_stage = "rejected" THEN 1 ELSE 0 END) as count_rejected
        ');
        $this->db->from('career_jobs j');
        $this->db->join('career c', 'c.job_id = j.job_id', 'left');
        
        if (!empty($status)) {
            $this->db->where('j.status', $status);
        }
        
        $this->db->group_by('j.job_id');
        $this->db->order_by('j.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    /**
     * Get single job by ID
     */
    public function get_job_by_id($job_id) {
        $this->db->where('job_id', $job_id);
        return $this->db->get('career_jobs')->row_array();
    }

    /**
     * Insert or update job
     */
    public function save_job($data) {
        $this->db->insert('career_jobs', $data);
        return $this->db->insert_id();
    }

    public function update_job($job_id, $data) {
        $this->db->where('job_id', $job_id);
        return $this->db->update('career_jobs', $data);
    }

    public function toggle_job_status($job_id) {
        $job = $this->get_job_by_id($job_id);
        if (!$job) return false;
        $new_status = ($job['status'] === 'active') ? 'closed' : 'active';
        $this->db->where('job_id', $job_id);
        return $this->db->update('career_jobs', ['status' => $new_status]);
    }

    /**
     * Get candidate counts by stage
     */
    public function get_stage_counts($job_id = null) {
        $counts = [
            'all' => 0,
            'applied' => 0,
            'screened' => 0,
            'interviewing' => 0,
            'offered' => 0,
            'hired' => 0,
            'rejected' => 0
        ];

        $this->db->select('status_stage, COUNT(*) as cnt');
        $this->db->from('career');
        if (!empty($job_id)) {
            $this->db->where('job_id', $job_id);
        }
        $this->db->group_by('status_stage');
        $res = $this->db->get()->result_array();

        $total = 0;
        foreach ($res as $row) {
            $st = strtolower(trim($row['status_stage']));
            if (isset($counts[$st])) {
                $counts[$st] = (int)$row['cnt'];
            }
            $total += (int)$row['cnt'];
        }
        $counts['all'] = $total;
        return $counts;
    }

    /**
     * Get candidates with filters
     */
    public function get_candidates($stage = null, $job_id = null, $search = null) {
        $this->db->select('c.*, j.title as job_title, j.department as job_department, j.location as job_location, j.salary_range as job_salary');
        $this->db->from('career c');
        $this->db->join('career_jobs j', 'j.job_id = c.job_id', 'left');

        if (!empty($stage) && $stage !== 'all') {
            $this->db->where('c.status_stage', strtolower($stage));
        }

        if (!empty($job_id)) {
            $this->db->where('c.job_id', $job_id);
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('c.name', $search);
            $this->db->or_like('c.email', $search);
            $this->db->or_like('c.mobile', $search);
            $this->db->or_like('c.designation', $search);
            $this->db->or_like('c.qualification', $search);
            $this->db->or_like('j.title', $search);
            $this->db->group_end();
        }

        $this->db->order_by('c.career_id', 'DESC');
        return $this->db->get()->result_array();
    }

    /**
     * Get single candidate by ID with job details and timeline notes
     */
    public function get_candidate_by_id($candidate_id) {
        $this->db->select('c.*, j.title as job_title, j.department as job_department, j.location as job_location, j.salary_range as job_salary, j.job_type, j.experience_required as job_exp_req');
        $this->db->from('career c');
        $this->db->join('career_jobs j', 'j.job_id = c.job_id', 'left');
        $this->db->where('c.career_id', $candidate_id);
        $candidate = $this->db->get()->row_array();

        if ($candidate) {
            $candidate['notes'] = $this->get_candidate_notes($candidate_id);
        }
        return $candidate;
    }

    /**
     * Get candidate timeline notes
     */
    public function get_candidate_notes($candidate_id) {
        $this->db->where('career_id', $candidate_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('career_notes')->result_array();
    }

    /**
     * Add timeline note for candidate
     */
    public function add_candidate_note($candidate_id, $note_text, $note_by = 'HR Lead', $stage = 'applied') {
        $data = [
            'career_id' => $candidate_id,
            'note_text' => $note_text,
            'note_by' => $note_by,
            'stage_at_time' => $stage,
            'created_at' => date('Y-m-d H:i:s')
        ];
        return $this->db->insert('career_notes', $data);
    }

    /**
     * Update candidate stage with audit trail note
     */
    public function update_candidate_stage($candidate_id, $stage, $note = null, $author = 'HR Lead') {
        $candidate = $this->get_candidate_by_id($candidate_id);
        if (!$candidate) return false;

        $old_stage = $candidate['status_stage'];
        $new_stage = strtolower($stage);

        $this->db->where('career_id', $candidate_id);
        $res = $this->db->update('career', ['status_stage' => $new_stage]);

        if ($res && $old_stage !== $new_stage) {
            $audit_note = "Pipeline stage advanced from " . ucfirst($old_stage) . " to " . ucfirst($new_stage);
            if (!empty($note)) {
                $audit_note .= ". Note: " . $note;
            }
            $this->add_candidate_note($candidate_id, $audit_note, $author, $new_stage);
        }
        return $res;
    }

    /**
     * Fast save candidate
     */
    public function save_candidate($data) {
        $this->db->insert('career', $data);
        $candidate_id = $this->db->insert_id();
        
        $this->add_candidate_note($candidate_id, 'Candidate profile created and added to ' . ucfirst($data['status_stage'] ?? 'applied') . ' stage.', 'HR Lead', $data['status_stage'] ?? 'applied');
        return $candidate_id;
    }

    /**
     * Onboard candidate to staff directory
     */
    public function onboard_candidate_to_staff($candidate_id, $staff_data) {
        $candidate = $this->get_candidate_by_id($candidate_id);
        if (!$candidate) {
            return ['status' => false, 'message' => 'Candidate record not found'];
        }

        // Check if employee_id already exists
        if (!empty($staff_data['employee_id'])) {
            $chk = $this->db->get_where('staff', ['employee_id' => $staff_data['employee_id']])->row_array();
            if ($chk) {
                return ['status' => false, 'message' => 'Employee ID ' . $staff_data['employee_id'] . ' is already assigned to another staff member.'];
            }
        }

        $this->db->insert('staff', $staff_data);
        $staff_id = $this->db->insert_id();

        // Mark candidate as hired
        $this->update_candidate_stage($candidate_id, 'hired', 'Successfully onboarded into Staff Directory as Employee ID: ' . ($staff_data['employee_id'] ?? 'UP-EMP-' . $staff_id));

        return ['status' => true, 'staff_id' => $staff_id, 'employee_id' => $staff_data['employee_id'] ?? ''];
    }

    /**
     * Delete candidate
     */
    public function delete_candidate($candidate_id) {
        $this->db->where('career_id', $candidate_id)->delete('career_notes');
        $this->db->where('career_id', $candidate_id)->delete('career');
        return true;
    }
}
