<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Reports extends Hosting_Billing
{
    public function __construct()
    {
        parent::__construct();
        User::logged_in();

        $this->load->module('layouts');
        $this->load->library(['template', 'form_validation']);
        $this->template->title(lang('reports').' - '.config_item('company_name'));
        if (!User::is_admin() && !User::is_staff()) {
            redirect('clients');
        }
        if (isset($_GET['setyear'])) {
            $this->session->set_userdata('chart_year', $_GET['setyear']);
        }
    }

    public function index(): void
    {
        $data = [
            'page' => lang('reports'),
        ];
        $this->template
            ->set_layout('users')
            ->build('dashboard', $data ?? null)
        ;
    }

    public function view($report_view = null): void
    {
        switch ($report_view) {
                case 'invoicesreport':
                    $this->_invoicesreport();

                    break;

                case 'invoicesbyclient':
                    $this->_invoicesbyclient();

                    break;

                case 'paymentsreport':
                    $this->_paymentsreport();

                    break;

                case 'ticketsreport':
                    $this->_ticketsreport();

                    break;

                default:
                    // code...
                    break;
            }
    }

    public function _invoicesreport(): void
    {
        $data = ['page' => lang('reports'), 'form' => true];
        if ($this->input->post()) {
            $range = explode('-', $this->input->post('range'));
            $start_date = date('Y-m-d', strtotime($range[0]));
            $end_date = date('Y-m-d', strtotime($range[1]));
            $data['report_by'] = $this->input->post('report_by');
            $data['invoices'] = Invoice::by_range($start_date, $end_date, $data['report_by']);
            $data['range'] = [$start_date, $end_date];
        } else {
            $data['invoices'] = Invoice::by_range(date('Y-m').'-01', date('Y-m-d'));
            $data['range'] = [date('Y-m').'-01', date('Y-m-d')];
        }
        $this->template
            ->set_layout('users')
            ->build('report/invoicesreport', $data ?? null)
        ;
    }

    public function _invoicesbyclient(): void
    {
        $data = ['page' => lang('reports'), 'form' => true];
        if ($this->input->post()) {
            $client = $this->input->post('client');
            $data['invoices'] = Invoice::get_client_invoices($client);
            $data['client'] = $client;
        } else {
            $data['invoices'] = [];
            $data['client'] = null;
        }
        $this->template
            ->set_layout('users')
            ->build('report/invoicesbyclient', $data ?? null)
        ;
    }

    public function _paymentsreport(): void
    {
        $data = ['page' => lang('reports'), 'form' => true];
        if ($this->input->post()) {
            $range = explode('-', $this->input->post('range'));
            $start_date = date('Y-m-d', strtotime($range[0]));
            $end_date = date('Y-m-d', strtotime($range[1]));
            $data['payments'] = Payment::by_range($start_date, $end_date);
            $data['range'] = [$start_date, $end_date];
        } else {
            $data['payments'] = Payment::by_range(date('Y-m').'-01', date('Y-m-d'));
            $data['range'] = [date('Y-m').'-01', date('Y-m-d')];
        }
        $this->template
            ->set_layout('users')
            ->build('report/paymentsreport', $data ?? null)
        ;
    }

    public function invoicespdf(): void
    {
        if ($this->uri->segment(4)) {
            $start_date = date('Y-m-d', $this->uri->segment(3));
            $end_date = date('Y-m-d', $this->uri->segment(4));
            $data['report_by'] = $this->uri->segment(5);
            $data['invoices'] = Invoice::by_range($start_date, $end_date, $data['report_by']);
            $data['range'] = [$start_date, $end_date];
            $data['page'] = lang('reports');
            $html = $this->load->view('pdf/invoices', $data, true);
            $file_name = lang('reports').'_'.$start_date.'To'.$end_date.'.pdf';
        } else {
            $data['client'] = $this->uri->segment(3);
            $data['invoices'] = Invoice::get_client_invoices($data['client']);
            $data['page'] = lang('reports');
            $html = $this->load->view('pdf/clientinvoices', $data, true);
            $file_name = lang('reports').'_'.Client::view_by_id($data['client'])->company_name.'.pdf';
        }

        $pdf = [
            'html' => $html,
            'title' => lang('invoices_report'),
            'author' => config_item('company_name'),
            'creator' => config_item('company_name'),
            'badge' => 'FALSE',
            'filename' => $file_name,
        ];
        $this->applib->create_pdf($pdf);
    }

    public function paymentspdf(): void
    {
        $start_date = date('Y-m-d', $this->uri->segment(3));
        $end_date = date('Y-m-d', $this->uri->segment(4));
        $data['payments'] = Payment::by_range($start_date, $end_date);
        $data['range'] = [$start_date, $end_date];
        $data['page'] = lang('reports');
        $html = $this->load->view('pdf/payments', $data, true);
        $file_name = lang('payments').'_'.$start_date.'To'.$end_date.'.pdf';

        $pdf = [
            'html' => $html,
            'title' => lang('payments_report'),
            'author' => config_item('company_name'),
            'creator' => config_item('company_name'),
            'badge' => 'FALSE',
            'filename' => $file_name,
        ];
        $this->applib->create_pdf($pdf);
    }

    public function _filter_by()
    {
        $filter = $_GET['view'] ?? '';

        return $filter;
    }
}

// End of file invoices.php
