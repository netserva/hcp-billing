<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Registrars extends Hosting_Billing
{
    public function __construct()
    {
        parent::__construct();
        User::logged_in();

        $this->load->module('layouts');
        $this->load->library(['form_validation', 'settings', 'template']);
        $this->load->helper('form');

        if (User::is_client()) {
            Applib::go_to('dashboard', 'error', lang('access_denied'));
        }
    }

    public function index($id = null): void
    {
        $this->template->title(lang('domain_registrars'));
        $data['page'] = lang('domain_registrars');
        $data['datatables'] = true;
        $this->template
            ->set_layout('users')
            ->build('index', $data ?? null)
        ;
    }

    public function config($registrar = null): void
    {
        if ($this->input->post()) {
            Applib::is_demo();
            Applib::update(
                'plugins',
                ['plugin_id' => $this->input->post('id')],
                ['config' => serialize($this->input->post())]
            );
            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', ucfirst($this->input->post('system_name')).' '.lang('settings_updated'));
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data['config'] = Plugin::get_plugin($registrar);
            $this->load->view('modal/config', $data);
        }
    }

    public function check_balance($registrar): void
    {
        $module = modules::run($registrar.'/check_balance', '');
        $data['response'] = $module['response'] ?? '';
        $data['registrar'] = $registrar;
        $this->load->view('balance', $data);
    }
}

// End of file Registrars.php
