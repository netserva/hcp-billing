<?php

declare(strict_types=1);
defined('BASEPATH') or exit('No direct script access allowed');

class Set_language extends Hosting_Billing
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(): void
    {
        $this->session->set_userdata('lang', $this->input->get('lang'));
        setcookie('fo_lang', $this->input->get('lang'), time() + 86400);
        redirect($_SERVER['HTTP_REFERER']);
    }
}
// End of file sys_language.php
// Location: ./application/controllers/sys_language.php
