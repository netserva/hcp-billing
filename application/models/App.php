<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class App extends CI_Model
{
    private static $db;

    public function __construct()
    {
        parent::__construct();
        self::$db = &get_instance()->db;
    }

    //Count orders
    public static function order_counter($table, $where = [])
    {
        return self::$db->where($where)->group_by('order_id')->get($table)->num_rows();
    }

    // Get all countries
    public static function countries()
    {
        return self::$db->get('countries')->result();
    }

    // Get country code
    public static function country_code($country_name)
    {
        $country = self::$db->where('value', $country_name)->get('countries')->row();
        $code = explode('/', $country->code);

        return trim($code[0]);
    }

    // Get country dialing code
    public static function dialing_code($country_name)
    {
        $country = self::$db->where('value', $country_name)->get('countries')->row();

        return preg_replace('/[^0-9]/', '', $country->phone);
    }

    // Get state code
    public static function state_code($state)
    {
        $state = self::$db->where('state', $state)->get('states')->row();

        return $state->code ?? 'AE';
    }

    // Get all currencies
    public static function currencies($code = false)
    {
        if (!$code) {
            return self::$db->order_by('name', 'ASC')->get('currencies')->result();
        }
        $c = self::$db->where('code', $code)->get('currencies')->result();
        if (is_array($c) && count($c) > 0) {
            return $c[0];
        }
        $c = self::$db->where('code', config_item('default_currency'))->get('currencies')->result();
        if (is_array($c) && count($c) > 0) {
            return $c[0];
        }

        return false;
    }

    // Get languages
    public static function languages($lang = false)
    {
        if (!$lang) {
            return self::$db->order_by('name', 'ASC')->get('languages')->result();
        }
        $l = self::$db->where('name', $lang)->get('languages')->result();
        if (count($l > 0)) {
            return $l[0];
        }
        $l = self::$db->where('name', config_item('default_language'))->get('languages')->result();
        if (count($l > 0)) {
            return $l[0];
        }

        return false;
    }

    /**
     * Counts num of records in TABLE.
     *
     * @param mixed $table
     * @param mixed $where
     */
    public static function counter($table, $where = [])
    {
        return self::$db->where($where)->get($table)->num_rows();
    }

    // Get activities
    public static function get_activity($limit = null)
    {
        return self::$db->order_by('activity_date', 'desc')->get('activities', $limit)->result();
    }

    // Access denied redirection
    public static function access_denied($module): void
    {
        $ci = &get_instance();
        $ci->session->set_flashdata('response_status', 'error');
        $ci->session->set_flashdata('message', lang('access_denied'));
        redirect($_SERVER['HTTP_REFERER']);
    }

    // Get email template body
    public static function email_template($group = null, $column = null)
    {
        return self::$db->where('email_group', $group)->get('email_templates')->row()->{$column};
    }

    // Get sms template
    public static function sms_template($template = null)
    {
        return self::$db->where('type', $template)->get('sms_templates')->row()->body;
    }

    // Get number of days
    public static function num_days($frequency)
    {
        switch ($frequency) {
            case '7D':
                return 7;

            break;

            case '1M':
                return 31;

            break;

            case '3M':
                return 90;

            break;

            case '6M':
                return 182;

            break;

            case '1Y':
                return 365;

            break;
        }
    }

    /**
     * Insert data to logs table.
     *
     * @param mixed $data
     */
    public static function Log($data = [])
    {
        return self::$db->insert('activities', $data);
    }

    // Get category name using ID
    public static function get_category_by_id($category)
    {
        $cat = self::$db->where('id', $category)->get('categories');

        return ($cat->num_rows() > 0) ? $cat->row()->cat_name : 'Uncategorized';
    }

    // Get payment method name using ID
    public static function get_method_by_id($method)
    {
        return self::$db->where('method_id', $method)->get('payment_methods')->row()->method_name;
    }

    // Get department name
    public static function get_dept_by_id($id)
    {
        $dept = self::$db->where('deptid', $id)->get('departments')->row();

        return $dept->deptname ?? '';
    }

    // Get a list of payment methods
    public static function list_payment_methods()
    {
        return self::$db->get('payment_methods')->result();
    }

    public static function get_by_where($table, $array = null, $order_by = [])
    {
        if (count($order_by) > 0) {
            self::$db->order_by($order_by['column'], $order_by['order']);
        }

        return self::$db->where($array)->get($table)->result();
    }

    public static function field_meta_value($key, $client)
    {
        $r = self::$db->where(['meta_key' => $key, 'client_id' => $client])->get('formmeta');

        return ($r->num_rows() > 0) ? $r->row()->meta_value : null;
    }

    // Check if module disabled
    public static function module_access($module): void
    {
        $result = self::$db->where(['module' => $module,
            'hook' => 'main_menu_'.User::get_role(User::get_id()), ])
            ->get('hooks')->row();
        if (null == $result || '0' == $result->visible) {
            redirect();
        } else {
            return;
        }
    }

    // Save any data
    public static function save_data($table, $data)
    {
        if ('payments' == $table) {
        }
        self::$db->insert($table, $data);

        return self::$db->insert_id();
    }

    /**
     * Update records in $table matching $match.
     *
     * @param mixed $table
     * @param mixed $match
     * @param mixed $data
     *
     * @return Affected rows int
     */
    public static function update($table, $match = [], $data = [])
    {
        self::$db->where($match)->update($table, $data);

        return self::$db->affected_rows();
    }

    /**
     * Deletes data matching $where in $table.
     *
     * @param mixed $table
     * @param mixed $where
     *
     * @return bool
     */
    public static function delete($table, $where = [])
    {
        return self::$db->delete($table, $where);
    }

    // Get locale
    public static function get_locale()
    {
        return self::$db->where('locale', config_item('locale'))->get('locales')->row();
    }

    // Get locales
    public static function locales()
    {
        return self::$db->order_by('name')->get('locales')->result();
    }
}

// End of file model.php
