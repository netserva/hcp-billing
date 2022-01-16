<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Promotions extends Hosting_Billing
{
    public function __construct()
    {
        parent::__construct();
        User::logged_in();
        $this->load->module('layouts');
        $this->load->library('template');
    }

    public function index($id = null): void
    {
        $promotions = $this->db->get('promotions')->result();
        $this->template->title(lang('promotions'));
        $data['promotions'] = $promotions;
        $data['page'] = lang('promotions');
        $data['form'] = true;
        $data['datepicker'] = true;
        $data['datatables'] = true;
        $this->template
            ->set_layout('users')
            ->build('index', $data ?? null)
        ;
    }

    public function add_promotion(): void
    {
        if ($this->input->post()) {
            Applib::is_demo();

            $_POST['apply_to'] = serialize($this->input->post('apply_to'));
            $_POST['required'] = serialize($this->input->post('required'));
            $_POST['billing_cycle'] = serialize($this->input->post('billing_cycle'));
            if (App::save_data('promotions', $this->input->post())) {
                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('server_added'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $data['form'] = true;
            $data['datepicker'] = true;
            $this->load->view('modal/add_promotion');
        }
    }

    public function edit($id = null): void
    {
        if ($this->input->post()) {
            Applib::is_demo();

            $_POST['apply_to'] = serialize($this->input->post('apply_to'));
            $_POST['required'] = serialize($this->input->post('required'));
            $_POST['billing_cycle'] = serialize($this->input->post('billing_cycle'));

            $this->db->where('id', $this->input->post('id'));
            if ($this->db->update('promotions', $_POST)) {
                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('promotion_edited'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $data['form'] = true;
            $data['datepicker'] = true;
            $data['promo'] = $this->db->where(['id' => $id])->get('promotions')->row();
            $this->load->view('modal/edit_promotion', $data);
        }
    }

    public function delete($id = null): void
    {
        if ($this->input->post()) {
            Applib::is_demo();
            App::delete('promotions', ['id' => $this->input->post('id', true)]);
            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('promotion_deleted_successfully'));
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data['id'] = $id;
            $this->load->view('modal/delete_promotion', $data);
        }
    }
}

// End of file Servers.php
