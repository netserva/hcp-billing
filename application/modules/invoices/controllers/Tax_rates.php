<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Tax_rates extends Hosting_Billing
{
    public function __construct()
    {
        parent::__construct();
        if (!User::is_admin() && !User::is_staff()) {
            redirect('clients');
        }
        $this->load->library(['form_validation']);
        $this->load->model(['Invoice', 'App']);
        $this->load->module('layouts');
        $this->load->library('template');
        $this->applib->set_locale();
    }

    public function index(): void
    {
        $this->template->title(lang('tax_rates'));
        $data['page'] = lang('tax_rates');
        $data['datatables'] = true;
        $data['rates'] = Invoice::get_tax_rates();

        $this->template
            ->set_layout('users')
            ->build('rates', $data ?? null)
        ;
    }

    public function add(): void
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('tax_rate_name', 'Rate Name', 'required');
            $this->form_validation->set_rules('tax_rate_percent', 'Rate Percent', 'required');

            if (false == $this->form_validation->run()) {
                $_POST = '';
                Applib::go_to('invoices/tax_rates/', 'error', lang('error_in_form'));
            } else {
                if (Invoice::save_tax($this->input->post())) {
                    Applib::go_to('invoices/tax_rates/', 'success', lang('tax_added_successfully'));
                }
            }
        } else {
            $this->load->view('modal/add_rate');
        }
    }

    public function edit(): void
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('tax_rate_name', 'Rate Name', 'required');
            $this->form_validation->set_rules('tax_rate_percent', 'Rate Percent', 'required');

            if (false == $this->form_validation->run()) {
                $_POST = '';
                Applib::go_to('invoices/tax_rates', 'error', lang('error_in_form'));
            } else {
                $data = [
                    'tax_rate_name' => $this->input->post('tax_rate_name'),
                    'tax_rate_percent' => $this->input->post('tax_rate_percent'),
                ];

                Invoice::update_tax($this->input->post('tax_rate_id'), $data);
                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('tax_updated_successfully'));
                redirect('invoices/tax_rates');
            }
        } else {
            $data['id'] = $this->uri->segment(4);
            $this->load->view('modal/edit_rate', $data);
        }
    }

    public function delete(): void
    {
        if ($this->input->post()) {
            $tax_rate_id = $this->input->post('tax_rate_id', true);

            if (Invoice::delete_tax($tax_rate_id)) {
                Applib::go_to('invoices/tax_rates', 'success', lang('tax_deleted_successfully'));
            }
        } else {
            $data['tax_rate_id'] = $this->uri->segment(4);
            $this->load->view('modal/delete_tax', $data);
        }
    }
}

// End of file invoices.php
