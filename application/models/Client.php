<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Client extends CI_Model
{
    private static $db;

    public function __construct()
    {
        parent::__construct();
        self::$db = &get_instance()->db;
    }

    /**
     * Insert records to companies table and return INSERT ID.
     *
     * @param mixed $data
     */
    public static function save($data = [])
    {
        self::$db->insert('companies', $data);

        return self::$db->insert_id();
    }

    /**
     * Update client information.
     *
     * @param mixed $company
     * @param mixed $data
     */
    public static function update($company, $data = [])
    {
        self::$db->where('co_id', $company)->update('companies', $data);

        return self::$db->affected_rows();
    }

    // Get all clients
    public static function get_all_clients()
    {
        return self::$db->where(['co_id >' => 1])->order_by('company_name', 'ASC')->get('companies')->result();
    }

    public static function due_amount($company)
    {
        $due = 0;
        $cur = self::view_by_id($company)->currency;
        $invoices = self::$db->where(['client' => $company, 'status !=' => 'Cancelled', 'status !=' => 'Deleted'])->get('invoices')->result();
        foreach ($invoices as $key => $invoice) {
            if ($invoice->currency != $cur) {
                $due += Applib::convert_currency($cur, Invoice::get_invoice_due_amount($invoice->inv_id));
            } else {
                $due += Invoice::get_invoice_due_amount($invoice->inv_id);
            }
        }

        return $due;
    }

    public static function client_due_amount($company)
    {
        $due = 0;
        $cur = self::view_by_id($company)->currency;
        $invoices = self::$db->where(['client' => $company, 'status !=' => 'Cancelled', 'status !=' => 'Deleted'])->get('invoices')->result();
        foreach ($invoices as $key => $invoice) {
            if ($invoice->currency != $cur) {
                $due += Applib::client_currency($cur, Invoice::get_invoice_due_amount($invoice->inv_id));
            } else {
                $due += Invoice::get_invoice_due_amount($invoice->inv_id);
            }
        }

        return $due;
    }

    // Get all client files
    public static function has_files($id)
    {
        return self::$db->where('client_id', $id)->get('files')->result();
    }

    public static function get_client_contacts($company)
    {
        self::$db->join('companies', 'companies.co_id = account_details.company');
        self::$db->join('users', 'users.id = account_details.user_id');

        return self::$db->where('company', $company)->get('account_details')->result();
    }

    public static function payable($company)
    {
        $total = 0;
        $invoices = Invoice::get_client_invoices($company);
        foreach ($invoices as $key => $inv) {
            if ($inv->currency != config_item('default_currency')) {
                $total += Applib::convert_currency($inv->currency, Invoice::payable($inv->inv_id));
            } else {
                $total += Invoice::payable($inv->inv_id);
            }
        }

        return $total;
    }

    public static function client_payable($company)
    {
        $total = 0;
        $cur = self::view_by_id($company)->currency;
        $invoices = Invoice::get_client_invoices($company);
        foreach ($invoices as $key => $inv) {
            if ($inv->currency != $cur) {
                $total += Applib::client_currency($cur, Invoice::payable($inv->inv_id));
            } else {
                $total += Invoice::payable($inv->inv_id);
            }
        }

        return $total;
    }

    public static function view_by_id($company)
    {
        return self::$db->where('co_id', $company)->get('companies')->row();
    }

    public static function get_by_user($uid)
    {
        return self::$db->where('primary_contact', $uid)->get('companies')->row();
    }

    public static function custom_fields($client)
    {
        return self::$db->where(['module' => 'clients', 'client_id' => $client])->get('formmeta')->result();
    }

    // Get client currency
    public static function client_currency($company = false)
    {
        if (!$company) {
            return false;
        }
        $dcurrency = self::$db->where('code', config_item('default_currency'))->get('currencies')->result();
        $client = self::$db->where('co_id', $company)->get('companies')->result();
        if (0 == count($client)) {
            return $dcurrency[0];
        }
        $currency = self::$db->where('code', $client[0]->currency)->get('currencies')->result();
        if (count($currency) > 0) {
            return $currency[0];
        }
        $dcurrency = self::$db->where('code', config_item('default_currency'))->get('currencies')->result();
        if (count($dcurrency) > 0) {
            return $dcurrency[0];
        }
    }

    // Get client language
    public static function client_language($id = false)
    {
        if (!$id) {
            return false;
        }
        $language = self::$db->where('name', self::view_by_id($id)->language)->get('languages')->result();

        return $language[0];
    }

    // Amount paid by client
    public static function amount_paid($company)
    {
        $total = 0;
        if ($company > 0) {
            $payments = self::$db->where(['paid_by' => $company, 'refunded' => 'No'])->get('payments')->result();
            foreach ($payments as $key => $pay) {
                if ($pay->currency != config_item('default_currency')) {
                    $total += Applib::convert_currency($pay->currency, $pay->amount);
                } else {
                    $total += $pay->amount;
                }
            }
        }

        return $total;
    }

    // Amount paid by client in their currency
    public static function client_amount_paid($company)
    {
        $total = 0;
        if ($company > 0) {
            $cur = self::view_by_id($company)->currency;
            $payments = self::$db->where(['paid_by' => $company, 'refunded' => 'No'])->get('payments')->result();
            foreach ($payments as $key => $pay) {
                if ($pay->currency != $cur) {
                    $total += Applib::client_currency($cur, $pay->amount);
                } else {
                    $total += $pay->amount;
                }
            }
        }

        return $total;
    }

    // Get Client Currency
    public static function get_currency_code($company = false)
    {
        if (!$company) {
            return false;
        }
        $dcurrency = self::$db->where('code', config_item('default_currency'))->get('currencies')->result();
        $client = self::$db->where('co_id', $company)->get('companies')->result();
        if (0 == count($client)) {
            return $dcurrency[0];
        }
        $currency = self::$db->where('code', $client[0]->currency)->get('currencies')->result();
        if (count($currency) > 0) {
            return $currency[0];
        }
        $dcurrency = self::$db->where('code', config_item('default_currency'))->get('currencies')->result();
        if (count($dcurrency) > 0) {
            return $dcurrency[0];
        }
    }

    public static function month_amount($year, $month, $client)
    {
        $total = 0;
        $query = "SELECT * FROM hd_payments WHERE paid_by = '{$client}' AND MONTH(payment_date) = '{$month}' AND refunded = 'No' AND YEAR(payment_date) = '{$year}'";
        $payments = self::$db->query($query)->result();
        foreach ($payments as $p) {
            $amount = $p->amount;
            if ($p->currency != config_item('default_currency')) {
                $amount = Applib::convert_currency($p->currency, $amount);
            }
            $total += $amount;
        }

        return round($total, config_item('currency_decimals'));
    }

    // Deletes Client from the database
    public static function delete($company): void
    {
        $company_invoices = Invoice::get_client_invoices($company);
        $company_contacts = self::get_client_contacts($company);

        if (count($company_invoices)) {
            foreach ($company_invoices as $invoice) {
                //delete invoice items
                self::$db->where('invoice_id', $invoice->inv_id)->delete('items');
            }
        }

        //delete invoices
        self::$db->where('client', $company)->delete('invoices');

        // delete client payments
        self::$db->where('paid_by', $company)->delete('payments');
        //clear client activities
        self::$db->where(['module' => 'Clients', 'module_field_id' => $company])->delete('activities');
        //delete company
        self::$db->where('co_id', $company)->delete('companies');

        if (count($company_contacts)) {
            foreach ($company_contacts as $contact) {
                //set contacts to blank
                self::$db->set('company', '-')->where('company', $company)->update('account_details');
            }
        }
    }

    public static function recent_activities($user, $limit = 10)
    {
        return self::$db->where('user', $user)->order_by('activity_date', 'DESC')->get('activities', $limit)->result();
    }
}

// End of file model.php
