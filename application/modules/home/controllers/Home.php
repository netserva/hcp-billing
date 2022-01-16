<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends Hosting_Billing
{
    public function __construct()
    {
        parent::__construct();
        $this->load->module('layouts');
        $this->load->library('template');
        if (!$this->session->userdata('cart')) {
            $this->session->set_userdata('cart', []);
        }
    }

    public function index(): void
    {
        $data['content'] = $this->Page->get_by_slug('home', true, true);
        $this->template->set_breadcrumb('home');

        $this->template->title((empty($data['content']->meta_title)) ? $data['content']->title : $data['content']->meta_title);
        $this->template->set_metadata('description', (empty($data['content']->meta_desc)) ? config_item('site_desc') : $data['content']->meta_desc);

        $data['page'] = $data['content']->title;
        $data['datatables'] = true;
        $this->template->set_theme(config_item('active_theme'));
        $this->template->set_partial('header', 'sections/header');
        $this->template->set_partial('footer', 'sections/footer');
        $this->template
            ->set_layout('main')
            ->build('pages/home', $data ?? null)
        ;
    }
}

// End of file home.php
