<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meta extends CI_Controller
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
                echo json_encode(['status' => 'error', 'message' => 'Session expired. Please log in again.']);
                exit;
            }
            redirect(base_url() . 'login');
        }

        $this->load->helper(['url', 'form', 'text']);
        $this->load->library(['form_validation', 'pagination']);
        $this->load->model('meta_model');
    }

    /**
     * Complete SEO Management Dashboard & Listing
     */
    public function index()
    {
        // Filters
        $search   = trim($this->input->get('search', TRUE) ?: $this->input->get('meta_title', TRUE) ?: '');
        $status   = trim($this->input->get('status', TRUE) ?: '');
        $issue    = trim($this->input->get('issue', TRUE) ?: '');
        $pagesize = (int)($this->input->get('pagesize', TRUE) ?: 15);
        if ($pagesize < 5 || $pagesize > 100) {
            $pagesize = 15;
        }

        $filters = [
            'search' => $search,
            'status' => $status,
            'issue'  => $issue
        ];

        // Pagination setup
        $total_rows = $this->meta_model->get_meta_count($filters);
        $offset = (int)($this->input->get('per_page', TRUE) ?: 0);
        if ($offset < 0) {
            $offset = 0;
        }

        // Query string retention for pagination
        $query_params = $_GET;
        unset($query_params['per_page']);
        $base_url = base_url('seo/meta/index') . (!empty($query_params) ? '?' . http_build_query($query_params) : '');

        $config = [
            'base_url'             => $base_url,
            'total_rows'           => $total_rows,
            'per_page'             => $pagesize,
            'page_query_string'    => TRUE,
            'query_string_segment' => 'per_page',
            'full_tag_open'        => '<ul class="pagination pagination-sm" style="margin: 0; display: inline-flex; gap: 2px;">',
            'full_tag_close'       => '</ul>',
            'first_link'           => '&laquo; First',
            'first_tag_open'       => '<li>',
            'first_tag_close'      => '</li>',
            'last_link'            => 'Last &raquo;',
            'last_tag_open'        => '<li>',
            'last_tag_close'       => '</li>',
            'next_link'            => 'Next &rsaquo;',
            'next_tag_open'        => '<li>',
            'next_tag_close'       => '</li>',
            'prev_link'            => '&lsaquo; Prev',
            'prev_tag_open'        => '<li>',
            'prev_tag_close'       => '</li>',
            'cur_tag_open'         => '<li class="active"><span style="background: #0d9488; border-color: #0d9488; color: #fff; font-weight: 600;">',
            'cur_tag_close'        => '</span></li>',
            'num_tag_open'         => '<li>',
            'num_tag_close'        => '</li>'
        ];

        $this->pagination->initialize($config);

        $data['heading_title'] = 'SEO & Meta Tags Management';
        $data['stats']         = $this->meta_model->get_seo_stats();
        $data['data']          = $this->meta_model->get_meta_list($pagesize, $offset, $filters);
        $data['total_rows']    = $total_rows;
        $data['offset']        = $offset;
        $data['pagesize']      = $pagesize;
        $data['filters']       = $filters;
        $data['page_links']    = $this->pagination->create_links();

        // Load complete AdminLTE Layout
        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('meta_list_view', $data);
        $this->load->view('inc/sidebar');
        $this->load->view('inc/headersetting');
        $this->load->view('inc/footerlink');
        $this->load->view('inc/table_footer');
    }

    /**
     * Add New Meta Tag
     */
    public function add()
    {
        $data['heading_title'] = 'Add New SEO Meta Tag';
        $data['is_edit'] = false;
        $data['res'] = [];

        if ($this->input->method(TRUE) === 'POST') {
            $raw_url = trim($this->input->post('page_url', TRUE) ?: '');
            $clean_url = $this->_normalize_url($raw_url);

            $this->form_validation->set_rules('page_url', 'Page URL Route', 'trim|required');
            $this->form_validation->set_rules('meta_title', 'Meta Title', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('meta_description', 'Meta Description', 'trim|max_length[1000]');
            $this->form_validation->set_rules('meta_keyword', 'Meta Keywords', 'trim|max_length[500]');

            $url_exists = $this->meta_model->check_url_exists($clean_url);

            if ($url_exists) {
                $this->session->set_flashdata('flashmsg', "<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert'>&times;</button><i class='fa fa-exclamation-triangle'></i> A meta configuration for URL <strong>/{$clean_url}</strong> already exists! Please edit the existing entry.</div>");
            } elseif ($this->form_validation->run() === TRUE) {
                $insert_data = [
                    'page_url'            => $clean_url,
                    'meta_title'          => trim($this->input->post('meta_title', TRUE)),
                    'meta_description'    => trim($this->input->post('meta_description', TRUE) ?: ''),
                    'meta_keyword'        => trim($this->input->post('meta_keyword', TRUE) ?: ''),
                    'canonical_url'       => trim($this->input->post('canonical_url', TRUE) ?: ''),
                    'robots_meta'         => trim($this->input->post('robots_meta', TRUE) ?: 'index, follow'),
                    'og_title'            => trim($this->input->post('og_title', TRUE) ?: ''),
                    'og_description'      => trim($this->input->post('og_description', TRUE) ?: ''),
                    'og_image'            => trim($this->input->post('og_image', TRUE) ?: ''),
                    'og_type'             => trim($this->input->post('og_type', TRUE) ?: 'website'),
                    'twitter_title'       => trim($this->input->post('twitter_title', TRUE) ?: ''),
                    'twitter_description' => trim($this->input->post('twitter_description', TRUE) ?: ''),
                    'twitter_image'       => trim($this->input->post('twitter_image', TRUE) ?: ''),
                    'schema_markup'       => trim($this->input->post('schema_markup', FALSE) ?: ''),
                    'status'              => $this->input->post('status') === '0' ? '0' : '1',
                    'meta_date_added'     => date('Y-m-d H:i:s'),
                    'updated_at'          => date('Y-m-d H:i:s')
                ];

                $new_id = $this->meta_model->insert_meta($insert_data);

                if ($new_id) {
                    $this->session->set_flashdata('flashmsg', "<div class='alert alert-success alert-dismissible' style='border-radius: 8px;'><button type='button' class='close' data-dismiss='alert'>&times;</button><i class='fa fa-check-circle'></i> Meta tag created successfully for <strong>/{$clean_url}</strong>!</div>");
                    redirect('seo/meta/index');
                } else {
                    $this->session->set_flashdata('flashmsg', "<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert'>&times;</button><i class='fa fa-exclamation-circle'></i> Failed to save meta tag to database. Please check your inputs.</div>");
                }
            }
        }

        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('meta_add_view', $data);
        $this->load->view('inc/sidebar');
        $this->load->view('inc/headersetting');
        $this->load->view('inc/footerlink');
        $this->load->view('inc/table_footer');
    }

    /**
     * Edit Existing Meta Tag
     */
    public function edit($id = 0)
    {
        $meta_id = (int)$id ?: (int)$this->uri->segment(4);
        if ($meta_id <= 0) {
            redirect('seo/meta/index');
        }

        $record = $this->meta_model->get_meta_by_id($meta_id);
        if (!$record) {
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert'>&times;</button><i class='fa fa-exclamation-circle'></i> Meta tag #{$meta_id} not found.</div>");
            redirect('seo/meta/index');
        }

        $data['heading_title'] = 'Edit SEO Meta Tag #' . $meta_id;
        $data['is_edit'] = true;
        $data['res'] = $record;

        if ($this->input->method(TRUE) === 'POST') {
            $raw_url = trim($this->input->post('page_url', TRUE) ?: '');
            $clean_url = $this->_normalize_url($raw_url);

            $this->form_validation->set_rules('page_url', 'Page URL Route', 'trim|required');
            $this->form_validation->set_rules('meta_title', 'Meta Title', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('meta_description', 'Meta Description', 'trim|max_length[1000]');
            $this->form_validation->set_rules('meta_keyword', 'Meta Keywords', 'trim|max_length[500]');

            $url_exists = $this->meta_model->check_url_exists($clean_url, $meta_id);

            if ($url_exists) {
                $this->session->set_flashdata('flashmsg', "<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert'>&times;</button><i class='fa fa-exclamation-triangle'></i> A meta configuration for URL <strong>/{$clean_url}</strong> is already used by another record!</div>");
            } elseif ($this->form_validation->run() === TRUE) {
                $update_data = [
                    'page_url'            => $clean_url,
                    'meta_title'          => trim($this->input->post('meta_title', TRUE)),
                    'meta_description'    => trim($this->input->post('meta_description', TRUE) ?: ''),
                    'meta_keyword'        => trim($this->input->post('meta_keyword', TRUE) ?: ''),
                    'canonical_url'       => trim($this->input->post('canonical_url', TRUE) ?: ''),
                    'robots_meta'         => trim($this->input->post('robots_meta', TRUE) ?: 'index, follow'),
                    'og_title'            => trim($this->input->post('og_title', TRUE) ?: ''),
                    'og_description'      => trim($this->input->post('og_description', TRUE) ?: ''),
                    'og_image'            => trim($this->input->post('og_image', TRUE) ?: ''),
                    'og_type'             => trim($this->input->post('og_type', TRUE) ?: 'website'),
                    'twitter_title'       => trim($this->input->post('twitter_title', TRUE) ?: ''),
                    'twitter_description' => trim($this->input->post('twitter_description', TRUE) ?: ''),
                    'twitter_image'       => trim($this->input->post('twitter_image', TRUE) ?: ''),
                    'schema_markup'       => trim($this->input->post('schema_markup', FALSE) ?: ''),
                    'status'              => $this->input->post('status') === '0' ? '0' : '1',
                    'updated_at'          => date('Y-m-d H:i:s')
                ];

                $this->meta_model->update_meta($meta_id, $update_data);

                $this->session->set_flashdata('flashmsg', "<div class='alert alert-success alert-dismissible' style='border-radius: 8px;'><button type='button' class='close' data-dismiss='alert'>&times;</button><i class='fa fa-check-circle'></i> Meta tag #{$meta_id} (/{$clean_url}) updated successfully!</div>");
                redirect('seo/meta/index');
            }
        }

        $this->load->view('inc/topheaderlink');
        $this->load->view('inc/topheader');
        $this->load->view('meta_edit_view', $data);
        $this->load->view('inc/sidebar');
        $this->load->view('inc/headersetting');
        $this->load->view('inc/footerlink');
        $this->load->view('inc/table_footer');
    }

    /**
     * Delete Single Meta Tag
     */
    public function delete($id = 0)
    {
        $meta_id = (int)$id ?: (int)$this->input->post('meta_id');
        $is_ajax = $this->input->is_ajax_request() || $this->input->post('is_ajax');

        if ($meta_id > 0) {
            $record = $this->meta_model->get_meta_by_id($meta_id);
            $this->meta_model->delete_meta($meta_id);
            $msg = "Meta tag #" . $meta_id . ($record ? " (/{$record['page_url']})" : "") . " deleted successfully.";

            if ($is_ajax) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['status' => 'success', 'message' => $msg]);
                return;
            }
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-success alert-dismissible' style='border-radius: 8px;'><button type='button' class='close' data-dismiss='alert'>&times;</button><i class='fa fa-trash'></i> {$msg}</div>");
        } else {
            if ($is_ajax) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['status' => 'error', 'message' => 'Invalid meta ID provided.']);
                return;
            }
        }

        redirect('seo/meta/index');
    }

    /**
     * Bulk Delete Selected Meta Tags
     */
    public function bulk_delete()
    {
        $is_ajax = $this->input->is_ajax_request() || $this->input->post('is_ajax');
        $ids = $this->input->post('ids');

        if (empty($ids) || !is_array($ids)) {
            if ($is_ajax) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['status' => 'error', 'message' => 'No items selected for deletion.']);
                return;
            }
            $this->session->set_flashdata('flashmsg', "<div class='alert alert-warning alert-dismissible'><button type='button' class='close' data-dismiss='alert'>&times;</button><i class='fa fa-exclamation-circle'></i> No items selected.</div>");
            redirect('seo/meta/index');
        }

        $count = $this->meta_model->bulk_delete_meta($ids);
        $msg = "Successfully deleted {$count} selected meta tags.";

        if ($is_ajax) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'success', 'message' => $msg, 'deleted_count' => $count]);
            return;
        }

        $this->session->set_flashdata('flashmsg', "<div class='alert alert-success alert-dismissible' style='border-radius: 8px;'><button type='button' class='close' data-dismiss='alert'>&times;</button><i class='fa fa-trash'></i> {$msg}</div>");
        redirect('seo/meta/index');
    }

    /**
     * Bulk Update Status (Active / Inactive)
     */
    public function bulk_status()
    {
        $is_ajax = $this->input->is_ajax_request() || $this->input->post('is_ajax');
        $ids = $this->input->post('ids');
        $status = $this->input->post('status') === '1' ? '1' : '0';

        if (empty($ids) || !is_array($ids)) {
            if ($is_ajax) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['status' => 'error', 'message' => 'No items selected.']);
                return;
            }
            redirect('seo/meta/index');
        }

        $count = $this->meta_model->bulk_update_status($ids, $status);
        $label = ($status === '1') ? 'Activated' : 'Deactivated';
        $msg = "Successfully {$label} {$count} meta tags.";

        if ($is_ajax) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'success', 'message' => $msg, 'updated_count' => $count]);
            return;
        }

        $this->session->set_flashdata('flashmsg', "<div class='alert alert-success alert-dismissible' style='border-radius: 8px;'><button type='button' class='close' data-dismiss='alert'>&times;</button><i class='fa fa-check-circle'></i> {$msg}</div>");
        redirect('seo/meta/index');
    }

    /**
     * Toggle status for a single meta tag
     */
    public function toggle_status($id = 0)
    {
        $meta_id = (int)$id ?: (int)$this->uri->segment(4);
        $new_status = $this->meta_model->toggle_status($meta_id);

        if ($this->input->is_ajax_request() || $this->input->post('is_ajax')) {
            header('Content-Type: application/json; charset=utf-8');
            if ($new_status !== false) {
                echo json_encode([
                    'status'     => 'success',
                    'new_status' => $new_status,
                    'message'    => "Meta tag status changed to " . ($new_status === '1' ? 'Active' : 'Inactive') . "."
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to toggle status.']);
            }
            return;
        }

        $this->session->set_flashdata('flashmsg', "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert'>&times;</button><i class='fa fa-check-circle'></i> Status updated.</div>");
        redirect('seo/meta/index');
    }

    /**
     * Quick preview data endpoint for preview modal
     */
    public function quick_preview($id = 0)
    {
        $meta_id = (int)$id ?: (int)$this->uri->segment(4);
        $record = $this->meta_model->get_meta_by_id($meta_id);

        header('Content-Type: application/json; charset=utf-8');
        if ($record) {
            echo json_encode(['status' => 'success', 'data' => $record]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Record not found.']);
        }
    }

    /**
     * Normalize URL slug (strips protocol, domain name, leading/trailing slashes)
     */
    private function _normalize_url($url)
    {
        $url = trim($url);
        // Remove protocol & domain
        $url = preg_replace('#^https?://[^/]+/#i', '', $url);
        $url = preg_replace('#^https?://[^/]+$#i', '', $url);
        // Remove base url if present
        $url = str_replace([base_url(), 'upchar.info/'], '', $url);
        // Trim leading and trailing slashes
        $url = trim($url, '/');
        // Default root URL to 'home'
        if ($url === '' || $url === '/') {
            $url = 'home';
        }
        return $url;
    }
}
