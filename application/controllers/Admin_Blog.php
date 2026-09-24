<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Blog extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Blog_model');
        $this->load->library(['form_validation', 'session', 'upload', 'pagination']);
        $this->load->helper(['url', 'string', 'form']);

        // Check for admin session if needed
        // if (!$this->session->userdata('is_admin_logged_in')) {
        //     redirect('admin/login');
        // }
    }

    public function index($offset = 0) {
        $limit = 15;
        $total_rows = $this->Blog_model->count_all_posts();

        $config['base_url'] = base_url('admin/blog');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $config['attributes'] = ['class' => 'page-link'];
        $config['full_tag_open'] = '<nav><ul class="pagination pagination-sm justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);

        $data['page_title'] = 'Manage Blog Posts - UPCHAR Admin';
        $data['posts'] = $this->Blog_model->get_all_posts($limit, (int)$offset);
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/blog/index', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    public function create() {
        $data['page_title'] = 'Create New Article';
        $data['categories'] = $this->Blog_model->get_categories();
        $data['post'] = null;

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/blog/form', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    public function store() {
        $this->form_validation->set_rules('title', 'Title', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('category_id', 'Category', 'required|integer');
        $this->form_validation->set_rules('content', 'Content', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[draft,published]');

        if ($this->form_validation->run() === FALSE) {
            $this->create();
            return;
        }

        $title = $this->input->post('title', TRUE);
        $slug = url_title($title, 'dash', TRUE);

        // Ensure unique slug
        if ($this->Blog_model->get_post_by_slug($slug)) {
            $slug = $slug . '-' . random_string('numeric', 4);
        }

        $image_name = null;
        if (!empty($_FILES['featured_image']['name'])) {
            $image_name = $this->_handle_image_upload();
        }

        $save_data = [
            'category_id'    => (int)$this->input->post('category_id'),
            'title'          => $title,
            'slug'           => $slug,
            'excerpt'        => $this->input->post('excerpt', TRUE),
            'content'        => $this->input->post('content'), // Raw HTML from TinyMCE
            'featured_image' => $image_name,
            'status'         => $this->input->post('status')
        ];

        $this->Blog_model->insert_post($save_data);
        $this->session->set_flashdata('success', 'Article published successfully.');
        redirect('admin/blog');
    }

    public function edit($id) {
        $post = $this->Blog_model->get_post_by_id($id);
        if (empty($post)) {
            show_404();
        }

        $data['page_title'] = 'Edit Article: ' . $post['title'];
        $data['categories'] = $this->Blog_model->get_categories();
        $data['post'] = $post;

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/blog/form', $data);
        $this->load->view('admin/templates/footer', $data);
    }

    public function update($id) {
        $post = $this->Blog_model->get_post_by_id($id);
        if (empty($post)) {
            show_404();
        }

        $this->form_validation->set_rules('title', 'Title', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('category_id', 'Category', 'required|integer');
        $this->form_validation->set_rules('content', 'Content', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
            return;
        }

        $image_name = $post['featured_image'];
        if (!empty($_FILES['featured_image']['name'])) {
            $new_image = $this->_handle_image_upload();
            if ($new_image) {
                if (!empty($image_name) && file_exists('./uploads/blog/' . $image_name)) {
                    @unlink('./uploads/blog/' . $image_name);
                }
                $image_name = $new_image;
            }
        }

        $update_data = [
            'category_id'    => (int)$this->input->post('category_id'),
            'title'          => $this->input->post('title', TRUE),
            'excerpt'        => $this->input->post('excerpt', TRUE),
            'content'        => $this->input->post('content'),
            'featured_image' => $image_name,
            'status'         => $this->input->post('status')
        ];

        $this->Blog_model->update_post($id, $update_data);
        $this->session->set_flashdata('success', 'Article updated.');
        redirect('admin/blog');
    }

    public function delete($id) {
        $this->Blog_model->delete_post($id);
        $this->session->set_flashdata('success', 'Post deleted.');
        redirect('admin/blog');
    }

    private function _handle_image_upload() {
        $config['upload_path']   = './uploads/blog/';
        $config['allowed_types'] = 'jpg|jpeg|png|webp';
        $config['max_size']      = 3072; // 3MB
        $config['encrypt_name']  = TRUE;

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, TRUE);
        }

        $this->upload->initialize($config);
        if ($this->upload->do_upload('featured_image')) {
            $upload_data = $this->upload->data();
            return $upload_data['file_name'];
        }
        return null;
    }
}
