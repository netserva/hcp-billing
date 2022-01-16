<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Account extends Hosting_Billing
{
    public function __construct()
    {
        parent::__construct();
        if (!User::is_admin() && !User::perm_allowed(User::get_id(), 'edit_settings')) {
            redirect('dashboard');
        }
        $this->load->helper('security');
    }

    public function index(): void
    {
        $this->active();
    }

    public function active(): void
    {
        $this->load->module('layouts');
        $this->load->library('template');
        $this->template->title(lang('users').' - '.config_item('company_name'));
        $data['page'] = lang('users');
        $data['datatables'] = true;
        $data['form'] = true;
        $this->template
            ->set_layout('users')
            ->build('users', $data ?? null)
        ;
    }

    public function permissions(): void
    {
        if ($_POST) {
            $permissions = json_encode($_POST);
            $data = ['allowed_modules' => $permissions];
            App::update('account_details', ['user_id' => $_POST['user_id']], $data);

            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('settings_updated_successfully'));
            redirect(base_url().'users/account');
        } else {
            $staff_id = $this->uri->segment(4);

            if ('3' != User::login_info($staff_id)->role_id) {
                $this->session->set_flashdata('response_status', 'error');
                $this->session->set_flashdata('message', lang('operation_failed'));
                redirect($_SERVER['HTTP_REFERRER']);
            }
            $data['user_id'] = $staff_id;
            $this->load->view('modal/edit_permissions', $data ?? null);
        }
    }

    public function update(): void
    {
        if ($this->input->post()) {
            if ('TRUE' == config_item('demo_mode')) {
                $this->session->set_flashdata('response_status', 'error');
                $this->session->set_flashdata('message', lang('demo_warning'));
                redirect('users/account');
            }
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span><br>');
            $this->form_validation->set_rules('fullname', 'Full Name', 'required');

            if (false == $this->form_validation->run()) {
                $this->session->set_flashdata('response_status', 'error');
                $this->session->set_flashdata('message', lang('operation_failed'));
                redirect('users/account');
            } else {
                $user_id = $this->input->post('user_id');
                $profile_data = [
                    'fullname' => $this->input->post('fullname'),
                    'company' => $this->input->post('company'),
                    'phone' => $this->input->post('phone'),
                    'mobile' => $this->input->post('mobile'),
                    'skype' => $this->input->post('skype'),
                    'language' => $this->input->post('language'),
                    'locale' => $this->input->post('locale'),
                    'hourly_rate' => $this->input->post('hourly_rate'),
                ];
                if (isset($_POST['department'])) {
                    $profile_data['department'] = json_encode($_POST['department']);
                }
                App::update('account_details', ['user_id' => $user_id], $profile_data);

                $data = [
                    'module' => 'users',
                    'module_field_id' => $user_id,
                    'user' => User::get_id(),
                    'activity' => 'activity_updated_system_user',
                    'icon' => 'fa-edit',
                    'value1' => User::displayName($user_id),
                    'value2' => '',
                ];
                App::Log($data);

                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('user_edited_successfully'));
                redirect('users/account');
            }
        } else {
            $data['id'] = $this->uri->segment(4);
            $this->load->view('modal/edit_user', $data);
        }
    }

    public function ban(): void
    {
        if ($_POST) {
            $user_id = $this->input->post('user_id');
            $ban_reason = $this->input->post('ban_reason');
            $action = ('1' == User::login_info($user_id)->banned) ? '0' : '1';

            $data = ['banned' => $action, 'ban_reason' => $ban_reason];
            App::update('users', ['id' => $user_id], $data);

            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('settings_updated_successfully'));

            redirect(base_url().'users/account');
        } else {
            $user_id = $this->uri->segment(4);
            $data['user_id'] = $user_id;
            $data['username'] = User::login_info($user_id)->username;
            $this->load->view('modal/ban_user', $data ?? null);
        }
    }

    public function auth(): void
    {
        if ($this->input->post()) {
            Applib::is_demo();

            $user_password = $this->input->post('password');
            $username = $this->input->post('username');
            $this->config->load('tank_auth', true);

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span><br>');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('username', 'User Name', 'required|trim|xss_clean');

            if (!empty($user_password)) {
                $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length[4]|max_length[32]');
                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');
            }

            if (false == $this->form_validation->run()) {
                $this->session->set_flashdata('response_status', 'error');
                $this->session->set_flashdata('message', lang('operation_failed'));
                redirect('users/account');
            } else {
                date_default_timezone_set(config_item('timezone'));
                $user_id = $this->input->post('user_id');
                $args = [
                    'email' => $this->input->post('email'),
                    'role_id' => $this->input->post('role_id'),
                    'modified' => date('Y-m-d H:i:s'),
                ];

                $db_debug = $this->db->db_debug; //save setting
            $this->db->db_debug = false; //disable debugging for queries
            $result = $this->db->set('username', $username)
                ->where('id', $user_id)
                ->update('users') //run query
            ;
            $this->db->db_debug = $db_debug; //restore setting

            if (!$result) {
                $this->session->set_flashdata('response_status', 'error');
                $this->session->set_flashdata('message', lang('username_not_available'));
                redirect('users/account');
            }

                App::update('users', ['id' => $user_id], $args);

                if (!empty($user_password)) {
                    $this->tank_auth->set_new_password($user_id, $user_password);
                }

                $data = [
                    'module' => 'users',
                    'module_field_id' => $user_id,
                    'user' => User::get_id(),
                    'activity' => 'activity_updated_system_user',
                    'icon' => 'fa-edit',
                    'value1' => User::displayName($user_id),
                    'value2' => '',
                ];
                App::Log($data);

                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('user_edited_successfully'));
                redirect('users/account');
            }
        } else {
            $data['id'] = $this->uri->segment(4);
            $this->load->view('modal/edit_login', $data);
        }
    }

    public function delete(): void
    {
        if ($this->input->post()) {
            Applib::is_demo();

            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_id', 'User ID', 'required');
            if (false == $this->form_validation->run()) {
                $this->session->set_flashdata('response_status', 'error');
                $this->session->set_flashdata('message', lang('delete_failed'));
                $this->input->post('r_url');
            } else {
                $user = $this->input->post('user_id', true);
                $deleted_user = User::displayName($user);

                if ('default_avatar.jpg' != User::profile_info($user)->avatar) {
                    if (is_file('./resource/avatar/'.User::profile_info($user)->avatar)) {
                        unlink('./resource/avatar/'.User::profile_info($user)->avatar);
                    }
                }
                $user_companies = App::get_by_where('companies', ['primary_contact' => $user]);
                foreach ($user_companies as $co) {
                    $ar = ['primary_contact' => ''];
                    App::update('companies', ['primary_contact' => $user], $ar);
                }
                $user_tickets = App::get_by_where('tickets', ['reporter' => $user]);
                foreach ($user_tickets as $ticket) {
                    App::delete('tickets', ['reporter' => $user]);
                }

                App::delete('activities', ['user' => $user]);

                App::delete('account_details', ['user_id' => $user]);
                App::delete('users', ['id' => $user]);

                // Log activity
                $data = [
                    'module' => 'users',
                    'module_field_id' => $user,
                    'user' => User::get_id(),
                    'activity' => 'activity_deleted_system_user',
                    'icon' => 'fa-trash-o',
                    'value1' => $deleted_user,
                    'value2' => '',
                ];
                App::Log($data);

                Applib::make_flashdata([
                    'response_status' => 'success',
                    'message' => lang('user_deleted_successfully'),
                ]);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $data['user_id'] = $this->uri->segment(4);
            $this->load->view('modal/delete_user', $data);
        }
    }
}

// End of file account.php
