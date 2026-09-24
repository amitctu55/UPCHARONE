<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Fetch published posts with pagination & category filter
    public function get_published_posts($limit, $offset, $category_id = null) {
        $this->db->select('p.*, c.name as category_name, c.slug as category_slug');
        $this->db->from('upchar_blog_posts p');
        $this->db->join('upchar_blog_categories c', 'c.id = p.category_id', 'left');
        $this->db->where('p.status', 'published');

        if (!empty($category_id)) {
            $this->db->where('p.category_id', (int)$category_id);
        }

        $this->db->order_by('p.created_at', 'DESC');
        $this->db->limit((int)$limit, (int)$offset);
        return $this->db->get()->result_array();
    }

    // Count published posts
    public function count_published_posts($category_id = null) {
        $this->db->where('status', 'published');
        if (!empty($category_id)) {
            $this->db->where('category_id', (int)$category_id);
        }
        return $this->db->count_all_results('upchar_blog_posts');
    }

    // Single article by slug
    public function get_post_by_slug($slug) {
        $this->db->select('p.*, c.name as category_name, c.slug as category_slug');
        $this->db->from('upchar_blog_posts p');
        $this->db->join('upchar_blog_categories c', 'c.id = p.category_id', 'left');
        $this->db->where('p.slug', $slug);
        $this->db->where('p.status', 'published');
        return $this->db->get()->row_array();
    }

    // Increment post view counter
    public function increment_views($post_id) {
        $this->db->set('views_count', 'views_count + 1', FALSE);
        $this->db->where('id', (int)$post_id);
        $this->db->update('upchar_blog_posts');
    }

    // All categories with post count
    public function get_categories() {
        $this->db->select('c.*, COUNT(p.id) as total_posts');
        $this->db->from('upchar_blog_categories c');
        $this->db->join('upchar_blog_posts p', 'p.category_id = c.id AND p.status = "published"', 'left');
        $this->db->group_by('c.id');
        $this->db->order_by('c.name', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_category_by_slug($slug) {
        return $this->db->get_where('upchar_blog_categories', ['slug' => $slug])->row_array();
    }

    // ADMIN CRUD METHODS
    public function get_all_posts($limit = 20, $offset = 0) {
        $this->db->select('p.*, c.name as category_name');
        $this->db->from('upchar_blog_posts p');
        $this->db->join('upchar_blog_categories c', 'c.id = p.category_id', 'left');
        $this->db->order_by('p.created_at', 'DESC');
        $this->db->limit((int)$limit, (int)$offset);
        return $this->db->get()->result_array();
    }

    public function count_all_posts() {
        return $this->db->count_all('upchar_blog_posts');
    }

    public function get_post_by_id($id) {
        return $this->db->get_where('upchar_blog_posts', ['id' => (int)$id])->row_array();
    }

    public function insert_post($data) {
        return $this->db->insert('upchar_blog_posts', $data);
    }

    public function update_post($id, $data) {
        $this->db->where('id', (int)$id);
        return $this->db->update('upchar_blog_posts', $data);
    }

    public function delete_post($id) {
        $post = $this->get_post_by_id($id);
        if (!empty($post['featured_image']) && file_exists('./uploads/blog/' . $post['featured_image'])) {
            @unlink('./uploads/blog/' . $post['featured_image']);
        }
        return $this->db->delete('upchar_blog_posts', ['id' => (int)$id]);
    }
}
