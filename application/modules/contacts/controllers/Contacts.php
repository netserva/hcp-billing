<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Contacts extends Hosting_Billing
{
    public function __construct()
    {
        parent::__construct();
        User::logged_in();

        if (!User::is_admin()) {
            $this->session->set_flashdata('message', lang('access_denied'));
            redirect('');
        }
        $this->applib->set_locale();
    }

    public function index(): void
    {
        redirect();
    }

    public function update(): void
    {
        if ($this->input->post()) {
            Applib::is_demo();

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="text-danger"', '</span><br>');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('company', 'Company', 'required');
            $this->form_validation->set_rules('fullname', 'Full Name', 'required');
            $company = $this->input->post('company');
            if (false == $this->form_validation->run()) {
                $this->session->set_flashdata('response_status', 'error');
                $this->session->set_flashdata('message', lang('operation_failed'));
                redirect('companies/view/'.$company);
            } else {
                $user_id = $this->input->post('user_id', true);
                $args = [
                    'fullname' => $this->input->post('fullname', true),
                    'company' => $this->input->post('company'),
                    'phone' => $this->input->post('phone'),
                    'language' => $this->input->post('language'),
                    'mobile' => $this->input->post('mobile'),
                    'skype' => $this->input->post('skype'),
                    'locale' => $this->input->post('locale'),
                ];
                App::update('account_details', ['user_id' => $user_id], $args);
                date_default_timezone_set(config_item('timezone'));
                $user_data = [
                    'email' => $this->input->post('email'),
                    'modified' => date('Y-m-d H:i:s'),
                ];
                App::update('users', ['id' => $user_id], $user_data);

                $data = [
                    'module' => 'contacts',
                    'module_field_id' => $user_id,
                    'user' => User::get_id(),
                    'activity' => 'activity_contact_edited',
                    'icon' => 'fa-edit',
                    'value1' => $this->input->post('fullname'),
                    'value2' => '',
                ];
                App::Log($data);

                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('user_edited_successfully'));
                Applib::go_to($_SERVER['HTTP_REFERER'], 'success', lang('user_edited_successfully'));
            }
        } else {
            $data['id'] = $this->uri->segment(3);
            $this->load->view('modal/edit_contact', $data);
        }
    }

    public function add(): void
    {
        if ($this->input->post()) {
            redirect('contacts');
        } else {
            $data['company'] = $this->uri->segment(3);
            $this->load->view('modal/add_client', $data);
        }
    }

    public function username_check(): void
    {
        $username = $this->input->post('username', true);
        $users = $this->db->where('username', $username)->get('users')->num_rows();
        if ($users > 0) {
            echo '<div class="alert alert-danger">Username already in use</div>';

            exit;
        }
        echo '<div class="alert alert-success">Awesome! Your username is available!</div>';

        exit;
    }

    public function email_check(): void
    {
        $email = $this->input->post('email', true);
        $users = $this->db->where('email', $email)->get('users')->num_rows();
        if ($users > 0) {
            echo '<div class="alert alert-danger">Email already in use</div>';

            exit;
        }
        echo '<div class="alert alert-success">Great! The email entered is available</div>';

        exit;
    }
}
// End of file contacts.php
