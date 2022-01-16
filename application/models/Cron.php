<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Cron extends CI_Model
{
    public function overdue_invoices()
    {
        $invoices = [];
        $this->db->join('companies', 'companies.co_id = invoices.client');
        $invoices = $this->db->where(['inv_deleted' => 'No', 'alert_overdue' => '0', 'due_date <' => date('Y-m-d'),
        ])->get('invoices')->result();

        foreach ($invoices as $key => &$invoice) {
            if ('fully_paid' == Invoice::payment_status($invoice->inv_id)) {
                unset($invoices[$key]);
            }
        }

        return $invoices;
    }

    public function get_renewals()
    {
        $days = config_item('invoices_due_before');
        $today = date('Y-m-d');
        $renewal = Cron::get_processing_date($today, $days);
        $cut_off = date('Y-m-d', strtotime('-10 days'));

        $list = [];
        $accounts = [];
        $this->db->join('companies', 'companies.co_id = orders.client_id');
        $this->db->join('items', 'items.item_id = orders.item');
        $this->db->join('item_pricing', 'orders.item_parent = item_pricing.item_id', 'LEFT');
        $this->db->select('orders.*, items.*, monthly_payments,	quarterly_payments,	semi_annually_payments,	annually_payments, biennially_payments, triennially_payments');
        $accounts = $this->db->where([
            'status_id' => 6,
            'renewal_date <=' => $renewal,
            'renewal_date >' => $cut_off,
            'processed <' => $cut_off,
        ])->get('orders')->result();

        foreach ($accounts as $account) {
            if ('domain' == $account->type || 'domain_only' == $account->type) {
                $list[] = $account;

                continue;
            }

            $renewal = $account->renewal;
            $payments = $renewal.'_payments';
            $max_payments = $account->{$payments};

            if ($renewal.'_payments' > 0 && $account->counter < $max_payments) {
                $account->payments = $max_payments;
                $list[] = $account;
            } else {
                $list[] = $account;
            }
        }

        return $list;
    }

    public function get_suspensions()
    {
        $accounts = [];

        if ('TRUE' == config_item('suspend_due')) {
            $today = date('Y-m-d');

            $this->db->join('invoices', 'orders.invoice_id = invoices.inv_id', 'INNER');
            $this->db->join('items_saved', 'orders.item_parent = items_saved.item_id', 'LEFT');
            $list = $this->db->where([
                'status_id' => 6,
                'due_date <' => $today,
                'status' => 'Unpaid',
                'inv_deleted' => 'No',
            ])->get('orders')->result();

            foreach ($list as $li) {
                $invoice_date_due = new DateTime($li->due_date);
                $invoice_date_due->add(new DateInterval('P'.config_item('suspend_after').'D'));
                $suspend_date = $invoice_date_due->format('Y-m-d');

                if (strtotime($today) > strtotime($suspend_date)) {
                    $accounts[] = $li;
                }
            }

            return $accounts;
        }

        return $accounts;
    }

    public function get_terminations()
    {
        $accounts = [];

        if ('TRUE' == config_item('terminate_due')) {
            $today = date('Y-m-d');

            $this->db->join('invoices', 'orders.invoice_id = invoices.inv_id', 'INNER');
            $this->db->join('items_saved', 'orders.item_parent = items_saved.item_id', 'LEFT');
            $list = $this->db->where([
                'status_id >' => 6,
                'due_date <' => $today,
                'status' => 'Unpaid',
                'inv_deleted' => 'No',
            ])->get('orders')->result();

            foreach ($list as $li) {
                $invoice_date_due = new DateTime($li->due_date);
                $invoice_date_due->add(new DateInterval('P'.config_item('terminate_after').'D'));
                $terminate_date = $invoice_date_due->format('Y-m-d');

                if (strtotime($today) > strtotime($terminate_date)) {
                    $accounts[] = $li;
                }
            }

            return $accounts;
        }

        return $accounts;
    }

    public static function get_processing_date($date, $days)
    {
        $renewal_date = new DateTime($date);
        $renewal_date->add(new DateInterval('P'.$days.'D'));

        return $renewal_date->format('Y-m-d');
    }

    public static function get_date_due($invoice_date_created)
    {
        $invoice_date_due = new DateTime($invoice_date_created);
        $invoice_date_due->add(new DateInterval('P'.config_item('invoices_due_after').'D'));

        return $invoice_date_due->format('Y-m-d');
    }
}

// End of file cron_model.php
