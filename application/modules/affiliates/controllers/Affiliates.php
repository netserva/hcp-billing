<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Affiliates extends Hosting_Billing
{
    public function __construct()
    {
        parent::__construct();
        User::logged_in();

        $this->load->module('layouts');
        $this->load->model('Affiliate');
        $this->load->library(['template', 'form_validation']);
    }

    public function index(): void
    {
        $this->template->title(lang('affiliates'));
        $data['page'] = lang('affiliates');
        $data['datatables'] = true;
        $this->template->set_layout('users')
            ->build((User::is_admin() || User::is_staff()) ? 'admin' : 'client', $data ?? null)
        ;
    }

    public function withdraw(): void
    {
        $data = [];
        $this->load->view('modal/withdraw', $data);
    }

    public function view_signups($id): void
    {
        $data = ['id' => $id];
        $this->load->view('modal/view_signups', $data);
    }

    public function payout_history($id): void
    {
        $data = ['id' => $id];
        $this->load->view('modal/payout_history', $data);
    }

    public function pay_withdrawal($id = null): void
    {
        if ($this->input->post()) {
            $client_id = $this->input->post('id');
            $data = [
                'payment_date' => date('Y-m-d'),
                'notes' => $this->input->post('notes'),
            ];

            $this->db->where('withdrawal_id', $this->input->post('withdrawal_id'));
            $this->db->update('affiliates', $data);
            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('payment_recorded'));
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data = ['id' => $id];
            $this->load->view('modal/pay_withdrawal', $data);
        }
    }

    public function change_balance($id = null): void
    {
        if ($this->input->post()) {
            $affiliate_id = $this->input->post('id');
            $affiliate = $this->db->where('affiliate_id', $affiliate_id)->get('companies')->row();
            $balance = $affiliate->affiliate_balance + $this->input->post('amount');

            $aff_data = [
                'affiliate_balance' => $balance,
            ];
            $this->db->where('affiliate_id', $affiliate_id);
            $this->db->update('companies', $aff_data);
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data = ['id' => $id];
            $this->load->view('modal/change_balance', $data);
        }
    }

    public function submit_withdrawal(): void
    {
        $user = User::get_id();
        $user_company = User::profile_info($user)->company;
        $company = Client::view_by_id($user_company);

        if ($company->affiliate_balance < $this->input->post('amount')) {
            $this->session->set_flashdata('response_status', 'warning');
            $this->session->set_flashdata('message', lang('invalid_withdrawal_amount'));
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $client_id = User::profile_info(User::get_id())->company;
            $data = [
                'request_date' => date('Y-m-d'),
                'client_id' => $client_id,
                'amount' => $this->input->post('amount'),
                'payment_details' => $this->input->post('payment_details'),
            ];

            if (App::save_data('hd_affiliates', $data)) {
                $affiliate = $this->db->where('affiliate_id', $client_id)->get('companies')->row();
                $balance = $affiliate->affiliate_balance - $this->input->post('amount');

                $aff_data = [
                    'affiliate_balance' => $balance,
                ];
                $this->db->where('affiliate_id', $client_id);
                $this->db->update('companies', $aff_data);

                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('withdrawal_request_submitted'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function activate(): void
    {
        Client::update($this->input->post('co_id'), ['affiliate' => 1, 'affiliate_balance' => config_item('affiliates_bonus'), 'affiliate_id' => $this->input->post('co_id')]);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function config(): void
    {
        if ($this->input->post()) {
            foreach ($this->input->post() as $key => $value) {
                $data = ('on' == $value) ? ['value' => 'TRUE'] : ['value' => $value];
                $this->db->where('config_key', $key)->update('config', $data);
            }

            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('settings_saved'));
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}
