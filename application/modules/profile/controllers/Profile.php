<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Profile extends Hosting_Billing
{
    public function __construct()
    {
        parent::__construct();
        User::logged_in();
        $this->load->model(['App', 'Client']);
        $this->applib->set_locale();
    }

    public function index(): void
    {
        redirect('profile/settings');
    }

    public function switch(): void
    {
        $user = User::view_user($this->input->post('user_id'));
        $this->session->set_userdata([
            'user_id' => $user->id,
            'username' => $user->username,
            'role_id' => $user->role_id,
        ]);
        redirect(base_url('clients'));
    }

    public function switch_back(): void
    {
        $user = $this->session->userdata('admin');
        $this->session->set_userdata([
            'user_id' => $user[0],
            'username' => $user[1],
            'role_id' => $user[2],
        ]);
        redirect(base_url('dashboard'));
    }

    public function settings(): void
    {
        if ($_POST) {
            Applib::is_demo();

            $custom_fields = [];
            foreach ($_POST as $key => &$value) {
                if (str_starts_with($key, 'cust_')) {
                    $custom_fields[$key] = $value;
                    unset($_POST[$key]);
                }
            }

            $this->load->library('form_validation');
            $this->form_validation->set_rules('fullname', 'Full Name', 'required');
            $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span><br>');

            if (false == $this->form_validation->run()) { // validation hasn't been passed
                $this->session->set_flashdata('response_status', 'error');
                $this->session->set_flashdata('message', lang('error_in_form'));
                $_POST = '';
                $this->settings();
            //redirect('profile/settings');
            } else {
                $id = $this->input->post('co_id', true);

                foreach ($custom_fields as $key => $f) {
                    $key = str_replace('cust_', '', $key);
                    $r = $this->db->where(['client_id' => $id, 'meta_key' => $key])->get('formmeta');
                    $cf = $this->db->where('name', $key)->get('fields');
                    $data = [
                        'module' => 'clients',
                        'field_id' => $cf->row()->id,
                        'client_id' => $id,
                        'meta_key' => $cf->row()->name,
                        'meta_value' => is_array($f) ? json_encode($f) : $f,
                    ];
                    (0 == $r->num_rows()) ? $this->db->insert('formmeta', $data) : $this->db->where(['client_id' => $id, 'meta_key' => $cf->row()->name])->update('formmeta', $data);
                }

                if (isset($_POST['company_data'])) {
                    $company_data = $_POST['company_data'];
                    Client::update($id, $company_data);
                    unset($_POST['company_data']);
                }
                unset($_POST['co_id']);
                App::update('account_details', ['user_id' => User::get_id()], $this->input->post());

                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('profile_updated_successfully'));
                redirect('profile/settings');
            }
        } else {
            $this->load->module('layouts');
            $this->load->library('template');
            $this->template->title(lang('profile').' - '.config_item('company_name'));
            $data['page'] = lang('manage_profile');
            $data['form'] = true;
            $this->template
                ->set_layout('users')
                ->build('edit_profile', $data ?? null)
            ;
        }
    }

    public function changeavatar(): void
    {
        if ($this->input->post()) {
            Applib::is_demo();

            if (file_exists($_FILES['userfile']['tmp_name']) || is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                $current_avatar = User::profile_info(User::get_id())->avatar;

                $config['upload_path'] = './resource/avatar/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                // $config['file_name'] = strtoupper('USER-'.$this->tank_auth->get_username()).'-AVATAR';
                $config['overwrite'] = false;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload()) {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', lang('avatar_upload_error'));
                    redirect($this->input->post('r_url', true));
                } else {
                    $data = $this->upload->data();
                    $ar = ['avatar' => $data['file_name']];
                    App::update('account_details', ['user_id' => User::get_id()], $ar);

                    if (file_exists('./resource/avatar/'.$current_avatar)
                                    && 'default_avatar.jpg' != $current_avatar) {
                        unlink('./resource/avatar/'.$current_avatar);
                    }
                }
            }

            if (isset($_POST['use_gravatar']) && 'on' == $_POST['use_gravatar']) {
                $ar = ['use_gravatar' => 'Y'];
                App::update('account_details', ['user_id' => User::get_id()], $ar);
            } else {
                $ar = ['use_gravatar' => 'N'];
                App::update('account_details', ['user_id' => User::get_id()], $ar);
            }

            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('avatar_uploaded_successfully'));
            redirect($this->input->post('r_url', true));
        } else {
            $this->session->set_flashdata('response_status', 'error');
            $this->session->set_flashdata('message', lang('no_avatar_selected'));
            redirect('profile/settings');
        }
    }

    public function activities(): void
    {
        $this->load->module('layouts');
        $this->load->library('template');
        $this->template->title(lang('profile').' - '.config_item('company_name'));
        $data['page'] = lang('activities');
        $data['datatables'] = true;
        $data['lastseen'] = config_item('last_seen_activities');
        $this->db->where('config_key', 'last_seen_activities')->update('config', ['value' => time()]);
        $this->template
            ->set_layout('users')
            ->build('activities', $data ?? null)
        ;
    }

    public function help(): void
    {
        $this->load->model('profile_model');
        $this->load->module('layouts');
        $this->load->library('template');
        $this->template->title(lang('profile').' - '.config_item('company_name'));
        $data['page'] = lang('home');
        $this->template
            ->set_layout('users')
            ->build('intro', $data ?? null)
        ;
    }
}

// End of file profile.php
