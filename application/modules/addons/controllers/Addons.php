<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Addons extends Hosting_Billing
{
    public function __construct()
    {
        parent::__construct();
        $this->load->module('layouts');
        $this->load->library(['form_validation', 'template']);
        $this->load->helper('form');
    }

    public function index(): void
    {
        $this->list_items();
        $this->can_access();
    }

    public function can_access(): void
    {
        if (!User::is_admin() && !User::is_staff()) {
            redirect('clients');
        }
    }

    public function list_items(): void
    {
        $this->can_access();
        $this->template->title(lang('addons').' - '.config_item('company_name'));
        $data['page'] = lang('addons');
        $data['datatables'] = true;
        $data['form'] = true;
        $data['addons'] = Addon::all();
        $this->template
            ->set_layout('users')
            ->build('addons', $data ?? null)
        ;
    }

    public function add(): void
    {
        if ($this->input->post()) {
            Applib::is_demo();

            $_POST['apply_to'] = serialize($this->input->post('apply_to'));
            if (App::save_data('addons', $this->input->post())) {
                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('server_added'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $data['form'] = true;
            $data['datepicker'] = true;
            $this->load->view('modal/add');
        }
    }
}

// End of file addons.php
