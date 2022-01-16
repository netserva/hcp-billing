<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Payment extends CI_Model
{
    private static $db;

    public function __construct()
    {
        parent::__construct();
        self::$db = &get_instance()->db;
    }

    public static function recent_paid()
    {
        return self::$db->order_by('created_date', 'desc')->where('inv_deleted', 'No')->get('payments', 15)->result();
    }

    // Get payment method name using ID
    public static function method_name_by_id($id = null)
    {
        return self::$db->where('method_id', $id)->get('payment_methods')->row()->method_name;
    }

    // Get all payments
    public static function all()
    {
        return self::$db->order_by('created_date', 'desc')->where('inv_deleted', 'No')->get('payments')->result();
    }

    // Get payments by client ID
    public static function by_client($client = null)
    {
        if ($client > 0) {
            return self::$db->order_by('created_date', 'desc')->where(['paid_by' => $client, 'inv_deleted' => 'No'])->get('payments')->result();
        }

        return [];
    }

    // Get payment information
    public static function view_by_id($id = null)
    {
        return self::$db->where(['p_id' => $id])->get('payments')->row();
    }

    // Get client payments
    public static function client_payments($company = null)
    {
        return self::$db->where('paid_by', $company)->get('payments')->result();
    }

    // Save payment to database
    public static function save_pay($data)
    {
        self::$db->insert('payments', $data);

        return self::$db->insert_id();
    }

    // Update payments table
    public static function update_pay($id, $data)
    {
        return self::$db->where('p_id', $id)->update('payments', $data);
    }

    // Delete payment from payments table
    public static function delete($id)
    {
        return self::$db->where('p_id', $id)->delete('payments');
    }

    // Get Invoice payments
    public static function by_invoice($id)
    {
        return self::$db->where('invoice', $id)->get('payments')->result();
    }

    public static function by_range($start, $end)
    {
        $sql = "SELECT * FROM hd_payments WHERE payment_date BETWEEN '{$start}' AND '{$end}' AND refunded = 'No'";

        return self::$db->query($sql)->result();
    }
}

/* End of file model.php */ // Get recently paid invoices
