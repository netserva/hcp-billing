<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Sidebar extends Hosting_Billing
{
    public function __construct()
    {
        parent::__construct();
    }

    public function admin_menu(): void
    {
        $this->load->view('admin_menu', $data ?? null);
    }

    public function staff_menu(): void
    {
        $this->load->view('staff_menu', $data ?? null);
    }

    public function client_menu(): void
    {
        $this->load->view('user_menu', $data ?? null);
    }

    public function top_header(): void
    {
        $data['updates'] = [];

        $this->load->view('top_header', $data ?? null);
    }

    public function scripts(): void
    {
        $this->load->view('scripts/app_scripts', $data ?? null);
    }

    public function flash_msg(): void
    {
        $this->load->view('flash_msg', $data ?? null);
    }
}
// End of file sidebar.php
