<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Payments extends Hosting_Billing
{
    public function __construct()
    {
        parent::__construct();
        User::logged_in();

        $this->load->module('layouts');
        $this->load->library(['template', 'form_validation']);

        App::module_access('menu_payments');

        $this->applib->set_locale();
    }

    public function index(): void
    {
        $this->template->title(lang('payments'));
        $data['page'] = lang('payments');
        $data['datatables'] = true;
        $data['payments'] = $this->_payments_list();
        $this->template
            ->set_layout('users')
            ->build('payments', $data ?? null)
        ;
    }

    public function edit($transaction = null): void
    {
        if ($this->input->post()) {
            $id = $this->input->post('p_id', true);

            $this->form_validation->set_rules('payment_date', 'Payment Date', 'required');
            $this->form_validation->set_rules('amount', 'Amount', 'required');

            if (false == $this->form_validation->run()) {
                $_POST = '';
                Applib::go_to('payments/edit/'.$id, 'error', lang('error_in_form'));
            } else {
                $_POST['payment_date'] = Applib::date_formatter($_POST['payment_date']);

                $_POST['month_paid'] = date('m', strtotime($_POST['payment_date']));
                $_POST['year_paid'] = date('Y', strtotime($_POST['payment_date']));

                Payment::update_pay($id, $this->input->post());

                $payment = Payment::view_by_id($id);

                $data = [
                    'module' => 'invoices',
                    'module_field_id' => $payment->invoice,
                    'user' => User::get_id(),
                    'activity' => 'activity_edited_payment',
                    'icon' => 'fa-pencil',
                    'value1' => $payment->trans_id,
                    'value2' => $payment->currency.''.$payment->amount,
                ];
                App::Log($data);

                Applib::go_to('payments/edit/'.$id, 'success', lang('payment_edited_successfully'));
            }
        } else {
            $this->template->title(lang('payments'));
            $data['page'] = lang('edit_payment');
            $data['datepicker'] = true;
            $data['payments'] = $this->_payments_list();
            $data['id'] = $transaction;

            $this->template
                ->set_layout('users')
                ->build('edit_payment', $data ?? null)
            ;
        }
    }

    public function view($id = null): void
    {
        $this->template->title(lang('payments'));
        $data['page'] = lang('payment');
        $data['payments'] = $this->_payments_list();
        $data['id'] = $id;
        $this->template
            ->set_layout('users')
            ->build('view', $data ?? null)
        ;
    }

    public function pdf($payment_id = null): void
    {
        $data['page'] = lang('payments');
        $data['id'] = $payment_id;

        $html = $this->load->view('receipt_pdf', $data, true);

        $pdf = [
            'html' => $html,
            'title' => lang('receipt').' '.Payment::view_by_id($payment_id)->trans_id,
            'author' => config_item('company_name'),
            'creator' => config_item('company_name'),
            'filename' => lang('receipt').'-'.Payment::view_by_id($payment_id)->trans_id.'.pdf',
            'badge' => config_item('display_invoice_badge'),
        ];

        $this->applib->create_pdf($pdf);
    }

    public function delete($id = null): void
    {
        if ($this->input->post()) {
            $id = $this->input->post('id', true);
            $payment = Payment::view_by_id($id);

            Payment::delete($id); //delete transaction

            Invoice::update($payment->invoice, ['status' => 'Unpaid']);

            $data = [
                'module' => 'invoices',
                'module_field_id' => $payment->invoice,
                'user' => User::get_id(),
                'activity' => 'activity_delete_payment',
                'icon' => 'fa-times',
                'value1' => $payment->trans_id,
                'value2' => $payment->currency.''.$payment->amount,
            ];
            App::Log($data);

            Applib::go_to('payments', 'success', lang('payment_deleted_successfully'));
        } else {
            $data['id'] = $id;
            $this->load->view('modal/delete_payment', $data);
        }
    }

    public function refund(): void
    {
        if ($_POST) {
            $id = $this->input->post('id', true);
            $refund = Payment::view_by_id($id)->refunded;
            if ('Yes' == $refund) {
                Payment::update_pay($id, ['refunded' => 'No']);
            }
            if ('No' == $refund) {
                Payment::update_pay($id, ['refunded' => 'Yes']);
            }
            Applib::go_to('payments/view/'.$id, 'success', lang('payment_edited_successfully'));
        } else {
            $data['id'] = $this->uri->segment(3);
            $this->load->view('modal/refund', $data);
        }
    }

    public function _payments_list()
    {
        if (User::is_admin() || User::perm_allowed(User::get_id(), 'view_all_payments')) {
            return Payment::all();
        }

        return Payment::by_client(User::profile_info(User::get_id())->company);
    }
}

// End of file payments.php
