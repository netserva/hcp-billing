<?php

declare(strict_types=1);

class Page extends MY_Model
{
    public $rules = [
        'title' => [
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'trim|required|xss_clean',
        ],
        'slug' => [
            'field' => 'slug',
            'label' => 'Slug',
            'rules' => 'trim|required|max_length[100]|xss_clean',
        ],
        'body' => [
            'field' => 'body',
            'label' => 'Body',
            'rules' => 'trim|required',
        ],
        'meta_title' => [
            'field' => 'meta_title',
            'label' => 'Page Title',
            'rules' => 'trim|max_length[100]|xss_clean',
        ],
        'meta_desc' => [
            'field' => 'meta_desc',
            'label' => 'Page Description',
            'rules' => 'trim|max_length[200]|xss_clean',
        ],
        'video' => [
            'field' => 'video',
            'label' => 'Video URL',
            'rules' => 'trim|max_length[200]|xss_clean',
        ],
    ];
    protected $_table_name = 'posts';
    protected $_primary_key = 'posts.id';
    protected $_order_by = 'pubdate desc, posts.id desc';
    protected $_timestamps = true;

    public function get_new()
    {
        $page = new stdClass();
        $page->title = '';
        $page->slug = '';
        $page->body = '';
        $page->status = 1;
        $page->menu = 0;
        $page->sidebar_right = 0;
        $page->sidebar_left = 0;
        $page->post_type = 'page';
        $page->pubdate = date('Y-m-d');
        $page->user_id = $this->session->userdata('user_id');
        $page->order = '0';

        return $page;
    }

    public function get($id = null, $single = false, $published = false)
    {
        $this->db->where('posts.post_type', 'page');
        $this->db->select('*');
        if (false != $published) {
            $this->set_published();
        }
        $this->_primary_key = 'posts.id';

        return parent::get($id, $single);
    }

    public function get_by_slug()
    {
        $slug = get_slug();
        $this->db->where('post_type', 'page');
        $this->db->where('slug', $slug);
        $this->db->select('*');

        return $this->db->get('posts')->row();
    }

    public function get_by($where = false, $single = false, $like = false)
    {
        if (false != $where) {
            $this->db->where($where);
        }
        if (false != $like) {
            $this->db->like($like);
        }

        return $this->get(null, $single, true);
    }

    public function get_by_id($id = null, $single = false, $published = false)
    {
        if (false != $published) {
            $this->set_published();
        }
        $this->_primary_key = 'posts.id';

        return $this->get($id, $single);
    }

    public function set_published(): void
    {
        $this->db->where('pubdate <=', date('Y-m-d'));
        $this->db->where('status', 1);
    }

    public function get_pages($published = false)
    {
        $this->db->where('posts.post_type', 'page');
        $this->db->select('title, slug');
        if (false != $published) {
            $this->set_published();
        }
        $this->_primary_key = 'posts.id';

        return parent::get();
    }
}
