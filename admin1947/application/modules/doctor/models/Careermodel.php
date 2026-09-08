<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Careermodel extends CI_Model
{       
    public function __construct()
    {
        parent::__construct();
        $this->ensure_schema();
    }

    /**
     * Auto-migrate schema if career_jobs table or career columns are missing
     */
    private function ensure_schema()
    {
        try {
            // 1. Ensure career_jobs table exists
            if (!$this->db->table_exists('career_jobs')) {
                $sql = "CREATE TABLE IF NOT EXISTS `career_jobs` (
                  `job_id` INT(11) NOT NULL AUTO_INCREMENT,
                  `title` VARCHAR(255) NOT NULL,
                  `department` VARCHAR(100) NOT NULL,
                  `job_type` VARCHAR(50) NOT NULL DEFAULT 'Full Time',
                  `location` VARCHAR(150) NOT NULL DEFAULT 'Gorakhpur, UP',
                  `experience_required` VARCHAR(100) NOT NULL DEFAULT '1-3 Years',
                  `openings` INT(11) NOT NULL DEFAULT 1,
                  `salary_range` VARCHAR(100) DEFAULT 'Best in Industry / Negotiable',
                  `description` TEXT,
                  `requirements` TEXT,
                  `status` ENUM('active','closed') NOT NULL DEFAULT 'active',
                  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                  PRIMARY KEY (`job_id`),
                  KEY `idx_status` (`status`),
                  KEY `idx_dept` (`department`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
                $this->db->query($sql);
                $this->seed_initial_jobs();
            }

            // 2. Ensure columns in career table
            if ($this->db->table_exists('career')) {
                if (!$this->db->field_exists('job_id', 'career')) {
                    @$this->db->query("ALTER TABLE `career` ADD `job_id` INT(11) NULL DEFAULT NULL AFTER `career_id`, ADD KEY `idx_job_id` (`job_id`)");
                }
                if (!$this->db->field_exists('experience', 'career')) {
                    @$this->db->query("ALTER TABLE `career` ADD `experience` VARCHAR(100) NULL DEFAULT NULL AFTER `qualification`");
                }
                if (!$this->db->field_exists('status_stage', 'career')) {
                    @$this->db->query("ALTER TABLE `career` ADD `status_stage` VARCHAR(50) NOT NULL DEFAULT 'pending' AFTER `status`");
                }
            }
        } catch (Throwable $e) {
            log_message('error', 'Careermodel::ensure_schema error: ' . $e->getMessage());
        }
    }

    /**
     * Seed initial healthcare jobs if table is empty
     */
    private function seed_initial_jobs()
    {
        try {
            if (!$this->db->table_exists('career_jobs')) return;
            $cnt = $this->db->count_all('career_jobs');
            if ($cnt == 0) {
                $seed_jobs = [
                    [
                        'title' => 'Duty Medical Officer (MBBS)',
                        'department' => 'Medical & Clinical',
                        'job_type' => 'Full Time',
                        'location' => 'Gorakhpur, UP',
                        'experience_required' => '1 - 4 Years',
                        'openings' => 3,
                        'salary_range' => 'Rs. 60,000 - Rs. 95,000 / month',
                        'description' => 'Responsible for inpatient patient management, emergency triage, routine clinical duties, coordinating with senior specialist consultants, and managing patient recovery protocols in day/night shifts.',
                        'requirements' => 'MBBS degree with valid State Medical Council registration. Good clinical assessment skills, ICU/Emergency exposure preferred, strong communication with patients and families.',
                        'status' => 'active'
                    ],
                    [
                        'title' => 'Staff Nurse (ICU & Inpatient Ward)',
                        'department' => 'Nursing',
                        'job_type' => 'Full Time',
                        'location' => 'Gorakhpur, UP',
                        'experience_required' => '1 - 3 Years',
                        'openings' => 6,
                        'salary_range' => 'Rs. 22,000 - Rs. 35,000 / month',
                        'description' => 'Deliver compassionate bedside nursing care, medication administration, vital signs monitoring, patient chart maintenance, and assist doctors during surgical or diagnostic procedures.',
                        'requirements' => 'GNM or B.Sc Nursing with State Nursing Council registration. Prior experience in Critical Care / Emergency Ward is an added advantage.',
                        'status' => 'active'
                    ],
                    [
                        'title' => 'Senior Pathology & Lab Technician',
                        'department' => 'Diagnostics & Lab',
                        'job_type' => 'Full Time',
                        'location' => 'Gorakhpur, UP',
                        'experience_required' => '2 - 5 Years',
                        'openings' => 2,
                        'salary_range' => 'Rs. 25,000 - Rs. 40,000 / month',
                        'description' => 'Operate fully automated biochemistry, hematology, and immunology analyzers. Handle sample collection (phlebotomy), calibration, quality control protocols, and rapid reporting.',
                        'requirements' => 'DMLT or B.Sc MLT with sound knowledge of laboratory equipment and NABL standards.',
                        'status' => 'active'
                    ],
                    [
                        'title' => 'Registered Pharmacist',
                        'department' => 'Pharmacy',
                        'job_type' => 'Full Time',
                        'location' => 'Gorakhpur, UP',
                        'experience_required' => '1 - 3 Years',
                        'openings' => 2,
                        'salary_range' => 'Rs. 20,000 - Rs. 30,000 / month',
                        'description' => 'Dispense prescription medications, verify dosages and contraindications, manage inventory in pharmacy software, handle cold-chain storage compliance, and provide patient counseling.',
                        'requirements' => 'B.Pharm or D.Pharm with active State Pharmacy Council registration license.',
                        'status' => 'active'
                    ]
                ];
                $this->db->insert_batch('career_jobs', $seed_jobs);
            }
        } catch (Throwable $e) {
            log_message('error', 'Careermodel::seed_initial_jobs error: ' . $e->getMessage());
        }
    }

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
        if (!empty($stage) && $this->db->field_exists('status_stage', 'career')) {
            $this->db->where("career.status_stage", $stage);
        }
        if (!empty($job_id) && $this->db->field_exists('job_id', 'career')) {
            $this->db->where("career.job_id", (int)$job_id);
        }

        if ($this->db->table_exists('career_jobs') && $this->db->field_exists('job_id', 'career')) {
            $this->db->select('SQL_CALC_FOUND_ROWS career.*, career_jobs.title as job_title, career_jobs.department as job_department, career_jobs.location as job_location', FALSE);
            $this->db->join('career_jobs', 'career.job_id = career_jobs.job_id', 'left');
        } else {
            $this->db->select('SQL_CALC_FOUND_ROWS career.*, career.designation as job_title, "" as job_department, "" as job_location', FALSE);
        }

        $this->db->order_by('career.career_id', 'DESC');
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get('career');
        $result = $query ? $query->result_array() : [];
        
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
        $update_data = array('status' => ($stage === 'rejected' ? '0' : '1'));
        if ($this->db->field_exists('status_stage', 'career')) {
            $update_data['status_stage'] = $stage;
        }
        return $this->db->update('career', $update_data);
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

        if ($this->db->table_exists('career')) {
            $has_stage = $this->db->field_exists('status_stage', 'career');
            if ($has_stage) {
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
            } else {
                $row = $this->db->query("
                    SELECT 
                        COUNT(*) as total,
                        SUM(CASE WHEN status = '1' THEN 1 ELSE 0 END) as pending_cnt,
                        0 as shortlisted_cnt,
                        0 as interview_cnt,
                        0 as selected_cnt,
                        SUM(CASE WHEN status = '0' THEN 1 ELSE 0 END) as rejected_cnt
                    FROM career
                ")->row_array();
            }

            if ($row) {
                $stats['total_applications'] = (int)($row['total'] ?? 0);
                $stats['pending']            = (int)($row['pending_cnt'] ?? 0);
                $stats['shortlisted']        = (int)($row['shortlisted_cnt'] ?? 0);
                $stats['interview']          = (int)($row['interview_cnt'] ?? 0);
                $stats['selected']           = (int)($row['selected_cnt'] ?? 0);
                $stats['rejected']           = (int)($row['rejected_cnt'] ?? 0);
            }
        }

        if ($this->db->table_exists('career_jobs')) {
            $job_row = $this->db->query("
                SELECT 
                    COUNT(*) as total_jobs,
                    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_jobs
                FROM career_jobs
            ")->row_array();

            if ($job_row) {
                $stats['total_jobs']  = (int)($job_row['total_jobs'] ?? 0);
                $stats['active_jobs'] = (int)($job_row['active_jobs'] ?? 0);
            }
        }

        return $stats;
    }

    /**
     * Get list of jobs with applicant count
     */
    public function get_jobs($limit = 20, $offset = 0, $param = array())
    {
        if (!$this->db->table_exists('career_jobs')) {
            return [];
        }

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

        $has_job_id = $this->db->table_exists('career') && $this->db->field_exists('job_id', 'career');
        if ($has_job_id) {
            $this->db->select('SQL_CALC_FOUND_ROWS career_jobs.*, (SELECT COUNT(*) FROM career WHERE career.job_id = career_jobs.job_id) as applicant_count', FALSE);
        } else {
            $this->db->select('SQL_CALC_FOUND_ROWS career_jobs.*, 0 as applicant_count', FALSE);
        }

        $this->db->order_by('career_jobs.job_id', 'DESC');
        $this->db->limit($limit, $offset);

        $query = $this->db->get('career_jobs');
        return $query ? $query->result_array() : [];
    }

    /**
     * Get single job by ID
     */
    public function get_job_by_id($id)
    {
        if (!$this->db->table_exists('career_jobs')) return null;

        $has_job_id = $this->db->table_exists('career') && $this->db->field_exists('job_id', 'career');
        if ($has_job_id) {
            $this->db->select('career_jobs.*, (SELECT COUNT(*) FROM career WHERE career.job_id = career_jobs.job_id) as applicant_count');
        } else {
            $this->db->select('career_jobs.*, 0 as applicant_count');
        }
        $this->db->where('job_id', (int)$id);
        $res = $this->db->get('career_jobs');
        return $res ? $res->row_array() : null;
    }

    /**
     * Save job (create or update)
     */
    public function save_job($data, $id = null)
    {
        if (!$this->db->table_exists('career_jobs')) return false;

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
        if (!$this->db->table_exists('career_jobs')) return false;

        if ($this->db->table_exists('career') && $this->db->field_exists('job_id', 'career')) {
            $this->db->where('job_id', (int)$id)->update('career', array('job_id' => null));
        }
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
        if (!$this->db->table_exists('career_jobs')) return [];
        $res = $this->db->order_by('title', 'ASC')->where('status', 'active')->get('career_jobs');
        return $res ? $res->result_array() : [];
    }
}
