<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Blog_model');
        $this->load->library('pagination');
        $this->load->helper(['url', 'text']);
    }

    // Blog Listing Page
    public function index($offset = 0) {
        $limit = 6;
        $total_rows = $this->Blog_model->count_published_posts();

        // Pagination setup
        $config['base_url'] = base_url('blog/page');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $config['use_page_numbers'] = FALSE;

        // Bootstrap Pagination Markup
        $config['full_tag_open'] = '<nav aria-label="Blog pagination"><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        // Data array passed to templates
        $data['active_menu']       = 'blog'; // Active tab indicator for header.php
        $data['active_tab']        = 'blog';
        $data['page_title']        = 'Healthcare Insights & Medical Blog | UPCHAR';
        $data['meta_description']  = 'Read the latest healthcare advice, cardiology guides, and emergency medical insights by UPCHAR.';
        $data['meta_array']        = [
            'meta_title'       => 'Healthcare Insights & Medical Blog | UPCHAR',
            'meta_description' => 'Read the latest healthcare advice, cardiology guides, and emergency medical insights by UPCHAR.',
            'meta_keyword'     => 'healthcare blog, medical insights, cardiology, emergency care, medicine guides, upchar'
        ];
        $data['posts']             = $this->Blog_model->get_published_posts($limit, (int)$offset);
        $data['categories']        = $this->Blog_model->get_categories();
        $data['pagination']        = $this->pagination->create_links();

        $this->load->view('templates/header', $data);
        $this->load->view('blog/index', $data);
        $this->load->view('templates/footer', $data);
    }

    // Category Filter View
    public function category($slug, $offset = 0) {
        $category = $this->Blog_model->get_category_by_slug($slug);
        if (empty($category)) {
            show_404();
        }

        $limit = 6;
        $total_rows = $this->Blog_model->count_published_posts($category['id']);

        $config['base_url'] = base_url('blog/category/' . $slug);
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $config['uri_segment'] = 4;
        $config['full_tag_open'] = '<nav aria-label="Category pagination"><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        $data['active_menu']       = 'blog';
        $data['active_tab']        = 'blog';
        $data['page_title']        = $category['name'] . ' - UPCHAR Blog';
        $data['meta_description']  = !empty($category['description']) ? $category['description'] : 'Browse medical and healthcare articles under ' . $category['name'];
        $data['meta_array']        = [
            'meta_title'       => $category['name'] . ' - UPCHAR Blog',
            'meta_description' => $data['meta_description'],
            'meta_keyword'     => $category['name'] . ', health articles, medical blog, upchar'
        ];
        $data['current_category']  = $category;
        $data['posts']             = $this->Blog_model->get_published_posts($limit, (int)$offset, $category['id']);
        $data['categories']        = $this->Blog_model->get_categories();
        $data['pagination']        = $this->pagination->create_links();

        $this->load->view('templates/header', $data);
        $this->load->view('blog/index', $data);
        $this->load->view('templates/footer', $data);
    }

    // Single Article View
    public function single($slug) {
        $post = $this->Blog_model->get_post_by_slug($slug);
        if (empty($post)) {
            show_404();
        }

        // Increment view count
        $this->Blog_model->increment_views($post['id']);

        $data['active_menu']       = 'blog';
        $data['active_tab']        = 'blog';
        $data['page_title']        = $post['title'] . ' | UPCHAR Health Insights';
        $data['meta_description']  = !empty($post['excerpt']) ? $post['excerpt'] : character_limiter(strip_tags($post['content']), 150);
        $data['meta_array']        = [
            'meta_title'       => $post['title'] . ' | UPCHAR Health Insights',
            'meta_description' => $data['meta_description'],
            'meta_keyword'     => $post['title'] . ', ' . ($post['category_name'] ?? 'Healthcare') . ', Upchar blog'
        ];
        $data['post']              = $post;
        $data['categories']        = $this->Blog_model->get_categories();

        $this->load->view('templates/header', $data);
        $this->load->view('blog/single', $data);
        $this->load->view('templates/footer', $data);
    }
}
