<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class User extends CI_Model
{
    private static $db;

    public function __construct()
    {
        parent::__construct();
        self::$db = &get_instance()->db;
    }

    // Get logged in user ID
    public static function get_id()
    {
        $ci = &get_instance();

        return $ci->tank_auth->get_user_id();
    }

    // Get logged in user ID
    public static function logged_in(): void
    {
        $ci = &get_instance();
        $logged_in = ($ci->tank_auth->is_logged_in()) ? true : false;
        //if(!$logged_in) redirect('login');
    }

    // Get login status
    public static function is_logged_in()
    {
        $ci = &get_instance();

        return ($ci->tank_auth->is_logged_in()) ? true : false;
    }

    // Get user information
    public static function view_user($id)
    {
        return self::$db->where('id', $id)->get('users')->row();
    }

    // Get user purchse status
    public static function purchased($id)
    {
        $user = self::$db->where('id', $id)->get('users')->row();
        if (!empty($user->code)) {
            return true;
        }

        return false;
    }

    public static function purchase_code($id)
    {
        $user = self::$db->where('id', $id)->get('users')->row();

        return $user->code;
    }

    /**
     * Check user if admin.
     */
    public static function is_admin()
    {
        $ci = &get_instance();

        return ('admin' == $ci->tank_auth->user_role($ci->tank_auth->get_role_id())) ? true : false;
    }

    /**
     * Check user if client.
     */
    public static function is_client()
    {
        $ci = &get_instance();

        return ('client' == $ci->tank_auth->user_role($ci->tank_auth->get_role_id())) ? true : false;
    }

    /**
     * User exists and is client.
     *
     * @param mixed $id
     */
    public static function client_exists($id)
    {
        $ci = &get_instance();

        return (self::$db->where(['role_id' => 2, 'id' => $id])->get('users')->num_rows() > 0) ? true : false;
    }

    /**
     * Check user if staff.
     */
    public static function is_staff()
    {
        $ci = &get_instance();

        return ('staff' == $ci->tank_auth->user_role($ci->tank_auth->get_role_id())) ? true : false;
    }

    /**
     * Get user login information.
     *
     * @param mixed $id
     *
     * @return User data array
     */
    public static function login_info($id)
    {
        return self::$db->where('id', $id)->get('users')->row();
    }

    /**
     * Get admins and staff.
     */
    public static function team()
    {
        return self::$db->where('role_id !=', 2)->get('users')->result();
    }

    // Get all users
    public static function all_users()
    {
        return self::$db->get('users')->result();
    }

    /**
     * Display username or full name if exists.
     *
     * @param mixed $user
     */
    public static function displayName($user = '')
    {
        if (!self::check_user_exist($user)) {
            return '[MISSING USER]';
        }

        return (null == self::profile_info($user)->fullname)
            ? self::login_info($user)->username
            : self::profile_info($user)->fullname;
    }

    // Get access permissions
    public static function perm_allowed($user, $perm)
    {
        $permission = self::$db->where(['status' => 'active'])->get('permissions')->result();
        // $json = self::profile_info($user)->allowed_modules;
        $allowed_modules = isset(self::profile_info($user)->allowed_modules) ? self::profile_info($user)->allowed_modules : '{"settings":"permissions"}';
        $allowed_modules = json_decode($allowed_modules, true);
        if (!array_key_exists($perm, $allowed_modules)) {
            return false;
        }

        foreach ($permission as $key => $p) {
            if (array_key_exists($p->name, $allowed_modules) && 'on' == $allowed_modules[$perm]) {
                return true;
            }

            return false;
        }

        return false;
    }

    /**
     * Get user role name e.g admin,staff etc.
     */
    public static function login_role_name()
    {
        $ci = &get_instance();

        return $ci->tank_auth->user_role($ci->tank_auth->get_role_id());
    }

    /**
     * Get user role name usind ID e.g admin,staff etc.
     *
     * @param mixed $user
     */
    public static function get_role($user)
    {
        $ci = &get_instance();
        if ($ci->tank_auth->is_logged_in()) {
            $id = self::login_info($user)->role_id;
        } else {
            $id = null;
        }

        return $ci->tank_auth->user_role($id);
    }

    // Get all admin list
    public static function admin_list()
    {
        return self::$db->where(['role_id' => 1, 'activated' => 1])->get('users')->result();
    }

    // Get all user list
    public static function user_list()
    {
        return self::$db->where(['role_id' => 2, 'activated' => 1])->get('users')->result();
    }

    // Get staff list
    public static function staff_list()
    {
        return self::$db->where(['role_id' => 3, 'activated' => 1])->get('users')->result();
    }

    // Get roles
    public static function get_roles()
    {
        return self::$db->get('roles')->result();
    }

    /**
     * Get user profile information.
     *
     * @param mixed $id
     */
    public static function profile_info($id)
    {
        return self::$db->where('user_id', $id)->get('account_details')->row();
    }

    public static function user_log($user)
    {
        return self::$db->where('user', $user)->order_by('activity_date', 'DESC')->get('activities')->result();
    }

    // Get user avatar URL
    public static function avatar_url($user = null)
    {
        if (!self::check_user_exist($user)) {
            return base_url().'resource/avatar/default_avatar.jpg';
        }

        if ('TRUE' == config_item('use_gravatar') && 'Y' == self::profile_info($user)->use_gravatar) {
            $user_email = self::login_info($user)->email;

            return Applib::get_gravatar($user_email);
        }

        return base_url().'resource/avatar/'.self::profile_info($user)->avatar;
    }

    public static function check_user_exist($user)
    {
        return self::$db->where('id', $user)->get('users')->num_rows();
    }

    // User can view invoice
    public static function can_view_invoice($user, $invoice)
    {
        $role = self::login_role_name();
        if ('admin' == $role) {
            return true;
        }
        if ('staff' == $role && self::perm_allowed($user, 'view_all_invoices')) {
            return true;
        }
        if (self::check_user_exist($user) > 0) {
            $client = Invoice::view_by_id($invoice)->client;
            $show_client = Invoice::view_by_id($invoice)->show_client;

            return ($client == self::profile_info($user)->company && 'Yes' == $show_client) ? true : false;
        }

        return false;
    }

    // Can pay Invoice
    public static function can_pay_invoice()
    {
        if ('admin' == self::login_role_name()) {
            return true;
        }
        if ('staff' == self::login_role_name() && self::perm_allowed(self::get_id(), 'pay_invoice_offline')) {
            return true;
        }

        return false;
    }

    // User can add invoice
    public static function can_add_invoice()
    {
        if ('admin' == self::login_role_name()) {
            return true;
        }
        if ('staff' == self::login_role_name() && self::perm_allowed(self::get_id(), 'add_invoices')) {
            return true;
        }

        return false;
    }

    // Check ticket permission
    public static function can_view_ticket($user, $ticket)
    {
        $info = Ticket::view_by_id($ticket);
        $user_dept = self::profile_info(self::get_id())->department;
        $dep = json_decode($user_dept, true);

        if (is_array($dep) && in_array($info->department, $dep) || (self::is_staff()
                && $user_dept == $info->department || $info->reporter == $user)) {
            return true;
        }

        if (self::is_admin() || $info->reporter == self::get_id()) {
            return true;
        }

        return false;
    }
}

// End of file model.php
