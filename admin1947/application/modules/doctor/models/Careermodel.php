<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Careermodel extends CI_Model
{       
    /**
     * Get candidate applications with job details and filters
     */
    public function get_career($limit = 10, $offset = 0, $param = array())
    {	
        $id         = isset($param['id']) ? $param['id'] : '';
        $keyword    = $this->input->get('keyword', TRUE);
        $stage      = $this->input->get('stage', TRUE);
        $job_id     = $this->input->get('job_id', TRUE);

        if ($id != '') {
            $this->db->where("career.career_id", $id);
        }
        if (!empty($keyword)) {
            $keyword = $this->db->escape_like_str(trim($keyword));
            $this->db->where("(career.name LIKE '%{$keyword}%' OR career.email LIKE '%{$keyword}%' OR career.mobile LIKE '%{$keyword}%' OR career.designation LIKE '%{$keyword}%')");
        }
        if (!empty($stage)) {
            $this->db->where("career.status_stage", $stage);
        }
        if (!empty($job_id)) {
            $this->db->where("career.job_id", (int)$job_id);
        }

        $this->db->select('SQL_CALC_FOUND_ROWS career.*, career_jobs.title as job_title, career_jobs.department as job_department, career_jobs.location as job_location', FALSE);
        $this->db->join('career_jobs', 'career.job_id = career_jobs.job_id', 'left');
        $this->db->order_by('career.career_id', 'DESC');
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get('career');
        $result = $query->result_array();
        
        return ($limit == 1) ? (@$result[0] ?: null) : $result;
    }

    /**
     * Get single career application by ID
     */
    public function get_career_by_id($id)
    {
        return $this->get_career(1, 0, array('id' => (int)$id));
    }

    /**
     * Update application recruitment stage
     */
    public function update_career_status($id, $stage)
    {
        $valid_stages = array('pending', 'reviewing', 'shortlisted', 'interview', 'selected', 'rejected');
        if (!in_array($stage, $valid_stages)) {
            $stage = 'pending';
        }
        $this->db->where('career_id', (int)$id);
        return $this->db->update('career', array('status_stage' => $stage));
    }

    /**
     * Get recruitment & application statistics
     */
    public function get_stats()
    {
        $stats = array(
            'total_applications' => 0,
            'pending'            => 0,
            'shortlisted'        => 0,
            'interview'          => 0,
            'selected'           => 0,
            'rejected'           => 0,
            'active_jobs'        => 0,
            'total_jobs'         => 0,
        );

        $row = $this->db->query("
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status_stage = 'pending' OR status_stage = '' OR status_stage IS NULL THEN 1 ELSE 0 END) as pending_cnt,
                SUM(CASE WHEN status_stage = 'shortlisted' THEN 1 ELSE 0 END) as shortlisted_cnt,
                SUM(CASE WHEN status_stage = 'interview' THEN 1 ELSE 0 END) as interview_cnt,
                SUM(CASE WHEN status_stage = 'selected' THEN 1 ELSE 0 END) as selected_cnt,
                SUM(CASE WHEN status_stage = 'rejected' THEN 1 ELSE 0 END) as rejected_cnt
            FROM career
        ")->row_array();

        if ($row) {
            $stats['total_applications'] = (int)$row['total'];
            $stats['pending']            = (int)$row['pending_cnt'];
            $stats['shortlisted']        = (int)$row['shortlisted_cnt'];
            $stats['interview']          = (int)$row['interview_cnt'];
            $stats['selected']           = (int)$row['selected_cnt'];
            $stats['rejected']           = (int)$row['rejected_cnt'];
        }

        $job_row = $this->db->query("
            SELECT 
                COUNT(*) as total_jobs,
                SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_jobs
            FROM career_jobs
        ")->row_array();

        if ($job_row) {
            $stats['total_jobs']  = (int)$job_row['total_jobs'];
            $stats['active_jobs'] = (int)$job_row['active_jobs'];
        }

        return $stats;
    }

    /**
     * Get list of jobs with applicant count
     */
    public function get_jobs($limit = 20, $offset = 0, $param = array())
    {
        $keyword = $this->input->get('job_keyword', TRUE);
        $status  = $this->input->get('job_status', TRUE);
        $dept    = $this->input->get('job_dept', TRUE);

        if (!empty($keyword)) {
            $keyword = $this->db->escape_like_str(trim($keyword));
            $this->db->where("(career_jobs.title LIKE '%{$keyword}%' OR career_jobs.location LIKE '%{$keyword}%' OR career_jobs.requirements LIKE '%{$keyword}%')");
        }
        if (!empty($status)) {
            $this->db->where("career_jobs.status", $status);
        }
        if (!empty($dept)) {
            $this->db->where("career_jobs.department", $dept);
        }

        $this->db->select('SQL_CALC_FOUND_ROWS career_jobs.*, (SELECT COUNT(*) FROM career WHERE career.job_id = career_jobs.job_id) as applicant_count', FALSE);
        $this->db->order_by('career_jobs.job_id', 'DESC');
        $this->db->limit($limit, $offset);

        $query = $this->db->get('career_jobs');
        return $query->result_array();
    }

    /**
     * Get single job by ID
     */
    public function get_job_by_id($id)
    {
        $this->db->select('career_jobs.*, (SELECT COUNT(*) FROM career WHERE career.job_id = career_jobs.job_id) as applicant_count');
        $this->db->where('job_id', (int)$id);
        return $this->db->get('career_jobs')->row_array();
    }

    /**
     * Save job (create or update)
     */
    public function save_job($data, $id = null)
    {
        if ($id && (int)$id > 0) {
            $this->db->where('job_id', (int)$id);
            return $this->db->update('career_jobs', $data);
        } else {
            return $this->db->insert('career_jobs', $data);
        }
    }

    /**
     * Delete job
     */
    public function delete_job($id)
    {
        // Nullify foreign key references in career table
        $this->db->where('job_id', (int)$id)->update('career', array('job_id' => null));
        return $this->db->where('job_id', (int)$id)->delete('career_jobs');
    }

    /**
     * Toggle job status (active / closed)
     */
    public function toggle_job_status($id)
    {
        $job = $this->get_job_by_id($id);
        if (!$job) return false;

        $new_status = ($job['status'] == 'active') ? 'closed' : 'active';
        $this->db->where('job_id', (int)$id)->update('career_jobs', array('status' => $new_status));
        return $new_status;
    }

    /**
     * Get all active jobs for dropdowns / filters
     */
    public function get_active_jobs_dropdown()
    {
        return $this->db->order_by('title', 'ASC')->where('status', 'active')->get('career_jobs')->result_array();
    }
}