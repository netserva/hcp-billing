<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Clients extends Hosting_Billing
{
    public function __construct()
    {
        parent::__construct();
        User::logged_in();

        if (!User::is_admin()) {
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->applib->set_locale();
    }

    public function index(): void
    {
        $this->load->module('layouts');
        $this->load->library('template');
        $this->template->title(lang('welcome').' - '.config_item('company_name'));
        $data['page'] = lang('dashboard');
        $this->template
            ->set_layout('users')
            ->build('client_area', $data ?? null)
        ;
    }
}

// End of file clients.php
