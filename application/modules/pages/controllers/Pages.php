<?php

declare(strict_types=1);

class Pages extends Hosting_Billing
{
    public function __construct()
    {
        parent::__construct();
        User::logged_in();

        $this->load->module('layouts');
        $this->load->library(['template', 'form_validation']);
    }

    public function index(): void
    {
        if (User::is_client()) {
            Applib::go_to('clients', 'error', lang('access_denied'));
        }
        $data['pages'] = $this->Page->get();
        $this->template->title(lang('page').' - '.config_item('company_name'));
        $data['page'] = lang('pages');
        $data['datatables'] = true;
        $this->template
            ->set_layout('users')
            ->build('index', $data ?? null)
        ;
    }

    public function page($slug): void
    {
        $data['content'] = $this->Page->get_by_slug();

        $this->template->title((empty($data['content']->meta_title)) ? $data['content']->title : $data['content']->meta_title.' | '.config_item('site_name'));
        $this->template->set_metadata('description', (empty($data['content']->meta_desc)) ? config_item('site_desc') : $data['content']->meta_desc);
        $this->template->set_breadcrumb($data['content']->title, base_url().$slug);
        $data['page'] = $data['content']->title;

        $this->template->set_theme(config_item('active_theme'));
        $this->template->set_partial('header', 'sections/header');
        $this->template->set_partial('footer', 'sections/footer');
        $this->template
            ->set_layout('main')
            ->build('/pages/page', $data ?? null)
        ;
    }

    public function edit($id = null): void
    {
        if (User::is_client()) {
            Applib::go_to('clients', 'error', lang('access_denied'));
        }

        if ($id) {
            $data['content'][] = $this->Page->get($id);
            $oldSlug = $data['content'][0]->slug;

            count($data['content']) || $data['errors'][] = 'page could not be found';
            $data['page_title'] = lang('edit');
        } else {
            $this->_unique_slug();
            $data['content'][] = $this->Page->get_new();
            $data['item_id'] = 0;
            $data['page_title'] = lang('add');
        }

        if ($this->input->post()) {
            Applib::is_demo();
            $rules = $this->Page->rules;
            $this->form_validation->set_rules($rules);

            if (true == $this->form_validation->run($this)) {
                if (!$id && $this->db->where('slug', $this->input->post('slug'))->get('posts')->num_rows() > '0') {
                    $this->session->set_flashdata('response_status', 'warning');
                    $this->session->set_flashdata('message', lang('path_exists'));
                    redirect($_SERVER['HTTP_REFERER']);
                }

                $pageArray = [
                    'title',
                    'slug',
                    'status',
                    'sidebar_right',
                    'sidebar_left',
                    'meta_title',
                    'meta_desc',
                    'knowledge',
                    'faq',
                    'menu',
                    'faq_id',
                    'knowledge_id',
                    'video',
                ];

                $data = $this->Page->array_from_post($pageArray);

                if (null == $id) {
                    array_push($pageArray, 'user_id', $this->session->userdata('user_id'));
                }

                $data['sidebar_right'] = ('on' == $data['sidebar_right']) ? 1 : 0;
                $data['sidebar_left'] = ('on' == $data['sidebar_left']) ? 1 : 0;
                $data['status'] = ('on' == $data['status']) ? 1 : 0;
                $data['knowledge'] = ('on' == $data['knowledge']) ? 1 : 0;
                $data['faq'] = ('on' == $data['faq']) ? 1 : 0;
                $data['meta_title'] = ('' == $data['meta_title']) ? $data['title'] : $data['meta_title'];
                $data['meta_desc'] = ('' == $data['meta_desc']) ? config_item('site_desc') : $data['meta_desc'];
                $data['post_type'] = 'page';
                $data['category_id'] = '0';

                if ($post_id = $this->Page->save($data, $id)) {
                    $sql = "UPDATE hd_posts 
                        SET body = '".$this->db->escape_str($this->input->post('body', false))."' WHERE id ='".$post_id."'";
                    $this->db->simple_query($sql);

                    if ('home' != $this->input->post('slug')) {
                        $menu = [];
                        if (null == $id) {
                            $menu['title'] = $this->input->post('title');
                            $menu['url'] = $this->input->post('slug');
                            $menu['group_id'] = $this->input->post('menu');
                            $menu['page'] = $post_id;
                            $menu['active'] = 1;
                            $this->db->insert('menu', $menu);
                        }
                        if ($id && $this->input->post('menu') > 0) {
                            $menu['title'] = $this->input->post('title');
                            $menu['url'] = $this->input->post('slug');
                            $menu['group_id'] = $this->input->post('menu');
                            $menu['page'] = $id;
                            $menu['active'] = 1;
                            if ('0' == $this->db->where('page', $id)->get('menu')->num_rows()) {
                                $this->db->insert('menu', $menu);
                            } else {
                                $this->db->where('page', $id);
                                $this->db->update('menu', $menu);
                            }
                        }
                    }

                    if ($id && 0 == $this->input->post('menu')) {
                        $this->db->where('page', $id);
                        $this->db->delete('menu');
                    }
                }

                $this->session->set_flashdata('message', lang('saved', lang('page')));
                redirect('pages');
            }
        }

        $data['menu_groups'] = $this->Menu->get_menu_groups();
        $this->template->title(lang('page').' - '.config_item('company_name'));
        $data['page'] = lang('page');
        $data['pages'] = true;
        $data['editor'] = true;
        $data['sidebar_right'] = true;
        $data['sidebar_left'] = true;

        $this->template
            ->set_layout('users')
            ->build('edit', $data ?? null)
        ;
    }

    public function delete_multi(): void
    {
        $id = $this->input->post('id');

        if ('TRUE' != config_item('demo_mode')) {
            $this->Page->delete_multi($id);
            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('operation_succesfull'));
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->session->set_flashdata('response_status', 'warning');
            $this->session->set_flashdata('message', lang('demo_warning'));
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function delete($id): void
    {
        if (User::is_client()) {
            Applib::go_to('clients', 'error', lang('access_denied'));
        }

        if ('TRUE' != config_item('demo_mode')) {
            $this->Page->delete($id);
            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('page_deleted'));
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->session->set_flashdata('response_status', 'warning');
            $this->session->set_flashdata('message', lang('demo_warning'));
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function _unique_slug()
    {
        $id = $this->uri->segment(4);
        $this->db->where('posts.slug', $this->input->post('slug'));
        $this->db->where('posts.post_type', 'page');
        !$id || $this->db->where('posts.id !=', $id);
        $post = $this->Page->get();

        if (count($post)) {
            $this->form_validation->set_message('_unique_slug', 'This %s is currently used for another page.');

            return false;
        }

        return true;
    }
}
