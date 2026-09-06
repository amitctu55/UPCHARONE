<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Career extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");

        // Auth verification
        if (!$this->session->userdata('adminuserid') && !$this->session->userdata('userid') && !$this->session->userdata('username')) {
            $is_ajax = $this->input->is_ajax_request() || $this->input->post('is_ajax');
            if ($is_ajax) {
                header('Content-Type: application/json; charset=utf-8', true, 401);
                echo json_encode(['status' => 0, 'message' => 'Session expired. Please log in again.']);
                exit;
            }
            redirect(base_url() . 'login');
        }

        $this->load->model(array('careermodel', 'masters/managementmodel'));
        $this->load->helper(array('url', 'form', 'query_string_helper', 'dbquery_helper', 'admin_helper'));
    }

    /**
     * Main Career Portal Dashboard (Applications & Job Openings)
     */
    public function index()
    {	
        $tab = $this->input->get('tab', TRUE) ?: 'applications';
        $data['active_tab'] = $tab;
        $data['stats']      = $this->careermodel->get_stats();
        $data['active_jobs'] = $this->careermodel->get_active_jobs_dropdown();

        $pagesize = (int)$this->input->get_post('pagesize');
        $limit    = ($pagesize > 0) ? $pagesize : 10;
        $offset   = ((int)$this->input->get_post('per_page') > 0) ? (int)$this->input->get_post('per_page') : 0;

        if ($tab === 'jobs') {
            $base_url               = current_url_query_string(array('tab' => 'jobs', 'filter' => 'result'), array('per_page'));
            $data['jobs']           = $this->careermodel->get_jobs($limit, $offset);
            $total_rows             = get_found_rows();
            $data['page_links']     = admin_pagination($base_url, $total_rows, $limit, $offset);
            $data['heading_title']  = 'Career & Job Openings Management';
            $data['module']         = 'Job Openings';
        } else {
            $base_url               = current_url_query_string(array('tab' => 'applications', 'filter' => 'result'), array('per_page'));
            $data['career']         = $this->careermodel->get_career($limit, $offset);
            $total_rows             = get_found_rows();
            $data['page_links']     = admin_pagination($base_url, $total_rows, $limit, $offset);
            $data['heading_title']  = 'Career Applications & Recruitment Pipeline';
            $data['module']         = 'Career';
        }

        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('career_view', $data);
        $this->load->view('inc/sidebar'); // Fixed: was previously 'sidebar' which threw 404 view error
        $this->load->view('inc/headersetting');
        $this->load->view('inc/footerlink');
        $this->load->view('inc/table_footer');
    }

    /**
     * Update Recruitment Status Stage (Pending, Reviewing, Shortlisted, Interview, Selected, Rejected)
     */
    public function update_status()
    {
        $id    = (int)$this->input->post('id');
        $stage = trim($this->input->post('stage'));

        if ($id <= 0 || empty($stage)) {
            echo json_encode(array('status' => 0, 'message' => 'Invalid parameters provided.'));
            return;
        }

        $res = $this->careermodel->update_career_status($id, $stage);
        if ($res) {
            echo json_encode(array(
                'status'  => 1, 
                'message' => 'Candidate application status updated to ' . ucfirst($stage) . ' successfully.',
                'stage'   => $stage
            ));
        } else {
            echo json_encode(array('status' => 0, 'message' => 'Failed to update application status.'));
        }
    }

    /**
     * View Applicant Full Details (for Modal display)
     */
    public function view_applicant($id = null)
    {
        $cid = (int)($id ?: $this->input->get('id') ?: $this->input->post('id'));
        if ($cid <= 0) {
            echo json_encode(array('status' => 0, 'message' => 'Invalid applicant ID.'));
            return;
        }

        $applicant = $this->careermodel->get_career_by_id($cid);
        if (!$applicant) {
            echo json_encode(array('status' => 0, 'message' => 'Applicant not found.'));
            return;
        }

        $applicant['resume_url'] = !empty($applicant['resume']) ? base_url('admin1947/public/assets/document/' . $applicant['resume']) : '';
        echo json_encode(array('status' => 1, 'data' => $applicant));
    }

    /**
     * Delete Single Candidate Application
     */
    public function delete($id = null)
    {
        if ($this->input->post('ids') && is_array($this->input->post('ids'))) {
            $this->bulk_delete();
            return;
        }

        $del_id = $id ? $id : ($this->input->post('id') ? $this->input->post('id') : $this->uri->segment(4));
        if ($del_id) {
            // Fetch resume to remove file if needed
            $row = $this->db->where('career_id', (int)$del_id)->get('career')->row_array();
            if ($row && !empty($row['resume'])) {
                $filepath = FCPATH . 'admin1947/public/assets/document/' . $row['resume'];
                if (file_exists($filepath)) {
                    @unlink($filepath);
                }
            }

            $this->db->where('career_id', (int)$del_id)->delete('career');
            $msg = "Candidate application deleted successfully.";
            if ($this->input->is_ajax_request() || $this->input->post('is_ajax') || $this->input->post('id')) {
                echo json_encode(array('status' => 1, 'message' => $msg));
                return;
            }
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
        }
        redirect(base_url('doctor/career'));
    }

    /**
     * Bulk Delete Candidate Applications
     */
    public function bulk_delete()
    {
        $ids = $this->input->post('ids');
        if (!empty($ids) && is_array($ids)) {
            $deleted_count = 0;
            foreach ($ids as $cid) {
                $cid = (int)$cid;
                if ($cid > 0) {
                    $row = $this->db->where('career_id', $cid)->get('career')->row_array();
                    if ($row && !empty($row['resume'])) {
                        $filepath = FCPATH . 'admin1947/public/assets/document/' . $row['resume'];
                        if (file_exists($filepath)) {
                            @unlink($filepath);
                        }
                    }
                    $this->db->where('career_id', $cid)->delete('career');
                    $deleted_count++;
                }
            }
            $msg = "$deleted_count candidate application(s) deleted successfully.";
            if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
                echo json_encode(array('status' => 1, 'count' => $deleted_count, 'message' => $msg));
                return;
            }
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
        } else {
            if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
                echo json_encode(array('status' => 0, 'message' => 'No records selected.'));
                return;
            }
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-warning'>No records selected.</div>");
        }
        redirect(base_url('doctor/career'));
    }

    /**
     * Create or Update Job Vacancy Opening
     */
    public function save_job()
    {
        $job_id = (int)$this->input->post('job_id');
        
        $title       = trim($this->input->post('title', TRUE));
        $department  = trim($this->input->post('department', TRUE));
        $job_type    = trim($this->input->post('job_type', TRUE)) ?: 'Full Time';
        $location    = trim($this->input->post('location', TRUE)) ?: 'Gorakhpur, UP';
        $exp         = trim($this->input->post('experience_required', TRUE)) ?: '1-3 Years';
        $openings    = (int)$this->input->post('openings') ?: 1;
        $salary      = trim($this->input->post('salary_range', TRUE)) ?: 'Best in Industry';
        $description = trim($this->input->post('description', TRUE));
        $requirements= trim($this->input->post('requirements', TRUE));
        $status      = trim($this->input->post('status', TRUE)) ?: 'active';

        if (empty($title) || empty($department)) {
            $msg = "Job Title and Department are required fields.";
            if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
                echo json_encode(array('status' => 0, 'message' => $msg));
                return;
            }
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-danger'>$msg</div>");
            redirect(base_url('doctor/career?tab=jobs'));
            return;
        }

        $data = array(
            'title'               => $title,
            'department'          => $department,
            'job_type'            => $job_type,
            'location'            => $location,
            'experience_required' => $exp,
            'openings'            => $openings,
            'salary_range'        => $salary,
            'description'         => $description,
            'requirements'        => $requirements,
            'status'              => $status,
        );

        if ($job_id > 0) {
            $this->careermodel->save_job($data, $job_id);
            $msg = "Job opening '{$title}' updated successfully.";
        } else {
            $this->careermodel->save_job($data);
            $msg = "New job opening '{$title}' published successfully.";
        }

        if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
            echo json_encode(array('status' => 1, 'message' => $msg));
            return;
        }

        $this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
        redirect(base_url('doctor/career?tab=jobs'));
    }

    /**
     * Fetch Single Job Data (for Edit Modal)
     */
    public function get_job($id = null)
    {
        $jid = (int)($id ?: $this->input->get('id') ?: $this->input->post('id'));
        if ($jid <= 0) {
            echo json_encode(array('status' => 0, 'message' => 'Invalid job ID.'));
            return;
        }

        $job = $this->careermodel->get_job_by_id($jid);
        if (!$job) {
            echo json_encode(array('status' => 0, 'message' => 'Job opening not found.'));
            return;
        }

        echo json_encode(array('status' => 1, 'data' => $job));
    }

    /**
     * Delete Job Vacancy Opening
     */
    public function delete_job($id = null)
    {
        $jid = (int)($id ?: $this->input->post('id') ?: $this->uri->segment(4));
        if ($jid > 0) {
            $this->careermodel->delete_job($jid);
            $msg = "Job opening deleted successfully.";
            if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
                echo json_encode(array('status' => 1, 'message' => $msg));
                return;
            }
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
        }
        redirect(base_url('doctor/career?tab=jobs'));
    }

    /**
     * Toggle Job Active / Closed Status
     */
    public function toggle_job_status($id = null)
    {
        $jid = (int)($id ?: $this->input->post('id') ?: $this->uri->segment(4));
        if ($jid > 0) {
            $new_status = $this->careermodel->toggle_job_status($jid);
            $msg = "Job opening status updated to " . ucfirst($new_status) . ".";
            if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
                echo json_encode(array('status' => 1, 'new_status' => $new_status, 'message' => $msg));
                return;
            }
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-success'>$msg</div>");
        }
        redirect(base_url('doctor/career?tab=jobs'));
    }

    /**
     * Export Applications to CSV
     */
    public function export_applications()
    {
        $applications = $this->careermodel->get_career(1000, 0);
        $filename = "upchar_career_applications_" . date('Ymd_His') . ".csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');
        fputcsv($output, array('ID', 'Name', 'Email', 'Mobile', 'Designation / Job', 'Department', 'Qualification', 'Experience', 'Status Stage', 'Applied Date', 'Message'));

        if (!empty($applications)) {
            foreach ($applications as $row) {
                fputcsv($output, array(
                    $row['career_id'],
                    $row['name'],
                    $row['email'],
                    $row['mobile'],
                    !empty($row['job_title']) ? $row['job_title'] : $row['designation'],
                    $row['job_department'] ?: 'General',
                    $row['qualification'],
                    $row['experience'] ?: 'N/A',
                    ucfirst($row['status_stage'] ?: 'pending'),
                    $row['creat_date'],
                    $row['message']
                ));
            }
        }
        fclose($output);
        exit;
    }
}