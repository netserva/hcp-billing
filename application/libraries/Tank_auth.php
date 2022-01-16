<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once 'phpass-0.1/PasswordHash.php';

define('STATUS_ACTIVATED', '1');
define('STATUS_NOT_ACTIVATED', '0');

/**
 * Tank_auth.
 *
 * Authentication library for Code Igniter.
 *
 * @author		Ilya Konyukhov (http://konyukhov.com/soft/)
 *
 * @version		1.0.9
 * @based on	DX Auth by Dexcell (http://dexcell.shinsengumiteam.com/dx_auth)
 *
 * @license		MIT License Copyright (c) 2008 Erick Hartanto
 */
class Tank_auth
{
    private $error = [];

    public function __construct()
    {
        $this->ci = &get_instance();

        $this->ci->config->load('tank_auth', true);

        $this->ci->load->library('session');
        $this->ci->load->database();
        $this->ci->load->model('tank_auth/users');

        // Try to autologin
        $this->autologin();
    }

    /**
     * Login user on the site. Return TRUE if login is successful
     * (user exists and activated, password is correct), otherwise FALSE.
     *
     * @param	string	(username or email or both depending on settings in config file)
     * @param	string
     * @param	bool
     * @param mixed $login
     * @param mixed $password
     * @param mixed $remember
     * @param mixed $login_by_username
     * @param mixed $login_by_email
     *
     * @return bool
     */
    public function login($login, $password, $remember, $login_by_username, $login_by_email)
    {
        if ((strlen($login) > 0) and (strlen($password) > 0)) {
            // Which function to use to login (based on config)
            if ($login_by_username and $login_by_email) {
                $get_user_func = 'get_user_by_login';
            } elseif ($login_by_username) {
                $get_user_func = 'get_user_by_username';
            } else {
                $get_user_func = 'get_user_by_email';
            }

            if (!is_null($user = $this->ci->users->{$get_user_func}($login))) {	// login ok
                // Does password match hash in database?
                $hasher = new PasswordHash(
                    $this->ci->config->item('phpass_hash_strength', 'tank_auth'),
                    $this->ci->config->item('phpass_hash_portable', 'tank_auth')
                );
                if ($hasher->CheckPassword($password, $user->password)) {		// password ok
                    if (1 == $user->banned) {									// fail - banned
                        $this->error = ['banned' => $user->ban_reason];
                    } else {
                        $this->ci->session->set_userdata([
                            'user_id' => $user->id,
                            'username' => $user->username,
                            'role_id' => $user->role_id,
                            'status' => (1 == $user->activated) ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED,
                            'admin' => (1 == $user->role_id || 3 == $user->role_id) ? [$user->id, $user->username, $user->role_id] : null,
                        ]);

                        if (0 == $user->activated) {							// fail - not activated
                            $this->error = ['not_activated' => ''];
                        } else {												// success
                            if ($remember) {
                                $this->create_autologin($user->id);
                            }

                            $this->clear_login_attempts($login);

                            $this->ci->users->update_login_info(
                                $user->id,
                                $this->ci->config->item('login_record_ip', 'tank_auth'),
                                $this->ci->config->item('login_record_time', 'tank_auth')
                            );

                            return true;
                        }
                    }
                } else {														// fail - wrong password
                    $this->increase_login_attempt($login);
                    $this->error = ['password' => 'auth_incorrect_password'];
                }
            } else {															// fail - wrong login
                $this->increase_login_attempt($login);
                $this->error = ['login' => 'auth_incorrect_login'];
            }
        }

        return false;
    }

    /**
     * Logout user from the site.
     */
    public function logout(): void
    {
        if ('TRUE' == config_item('stop_timer_logout')) {
            App::stop_running_timer();
        }
        $this->delete_autologin();

        // See http://codeigniter.com/forums/viewreply/662369/ as the reason for the next line
        $this->ci->session->set_userdata(['user_id' => '', 'username' => '', 'status' => '']);

        $this->ci->session->sess_destroy();
        // session_start();
        // $this->ci->session->sess_create();
    }

    /**
     * Check if user logged in. Also test if user is activated or not.
     *
     * @param	bool
     * @param mixed $activated
     *
     * @return bool
     */
    public function is_logged_in($activated = true)
    {
        return $this->ci->session->userdata('status') === ($activated ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED);
    }

    /**
     * Get user_id.
     *
     * @return string
     */
    public function get_user_id()
    {
        return $this->ci->session->userdata('user_id');
    }

    /**
     * Get role_id.
     *
     * @return string
     */
    public function get_role_id()
    {
        return $this->ci->session->userdata('role_id');
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function get_username()
    {
        return $this->ci->session->userdata('username');
    }

    /**
     * Get role name using id.
     *
     * @param mixed $r
     *
     * @return string
     */
    public function user_role($r)
    {
        if ($this->is_logged_in()) {
            return $this->ci->db->select('role')->where('r_id', $r)->get('roles')->row()->role;
        }

        return false;
    }

    /**
     * Create new user on the site and return some data about it:
     * user_id, username, password, email, new_email_key (if any).
     *
     * @param	string
     * @param	string
     * @param	string
     * @param	bool
     * @param mixed $username
     * @param mixed $email
     * @param mixed $password
     * @param mixed $fullname
     * @param mixed $company
     * @param mixed $role
     * @param mixed $phone
     * @param mixed $email_activation
     * @param mixed $company_name
     * @param mixed $individual
     * @param mixed $address
     * @param mixed $city
     * @param mixed $state
     * @param mixed $zip
     * @param mixed $country
     * @param mixed $code
     *
     * @return array
     */
    public function create_user(
        $username,
        $email,
        $password,
        $fullname,
        $company,
        $role,
        $phone,
        $email_activation,
        $company_name,
        $individual,
        $address = '',
        $city = '',
        $state = '',
        $zip = '',
        $country = '',
        $code = 0
    )
    {
        if ((strlen($username) > 0) and !$this->ci->users->is_username_available($username)) {
            $this->error = ['username' => 'auth_username_in_use'];
        } elseif (!$this->ci->users->is_email_available($email)) {
            $this->error = ['email' => 'auth_email_in_use'];
        } else {
            // Hash password using phpass
            $hasher = new PasswordHash(
                $this->ci->config->item('phpass_hash_strength', 'tank_auth'),
                $this->ci->config->item('phpass_hash_portable', 'tank_auth')
            );
            $hashed_password = $hasher->HashPassword($password);

            $data = [
                'username' => $username,
                'password' => $hashed_password,
                'email' => $email,
                'role_id' => $role,
                'last_ip' => $this->ci->input->ip_address(),
            ];

            $company_id = $this->_create_company(
                $company_name,
                $email,
                $individual,
                $phone,
                $address,
                $city,
                $state,
                $zip,
                $country
            );

            $profile = [
                'company' => $company_id,
                'fullname' => $fullname,
                'phone' => $phone,
                'avatar' => 'default_avatar.jpg',
                'language' => config_item('default_language') ? config_item('default_language') : 'english',
                'locale' => config_item('locale') ? config_item('locale') : 'en_US',
            ];

            if ($email_activation) {
                $data['new_email_key'] = md5(random_int(0, getrandmax()).microtime());
            }
            if (!is_null($res = $this->ci->users->create_user($data, $profile, !$email_activation, $company))) {
                $data['user_id'] = $res['user_id'];

                $co = $this->ci->db->where('co_id', $company_id)->get('companies')->result();
                $com = $co[0];
                if (0 == intval($com->primary_contact)) {
                    $this->ci->db->where('co_id', $company_id)->update('companies', ['primary_contact' => $res['user_id']]);
                }

                $data['password'] = $password;
                unset($data['last_ip']);

                return $data;
            }
        }

        return null;
    }

    /**
     * Check if company available.
     *
     * @param string
     * @param string
     * @param mixed $company
     * @param mixed $email
     *
     * @return int
     */
    public function is_company_available($company, $email)
    {
        return @$this->ci->db->select('co_id')
            ->where('company_name', $company)->or_where('company_email', $email)
            ->get('companies')->row()->co_id;
    }

    /**
     * Create new user on the site and return some data about it:
     * user_id, username, password, email, new_email_key (if any).
     *
     * @param	string
     * @param	string
     * @param	string
     * @param	bool
     * @param mixed $username
     * @param mixed $email
     * @param mixed $password
     * @param mixed $fullname
     * @param mixed $company
     * @param mixed $role
     * @param mixed $phone
     * @param mixed $email_activation
     *
     * @return array
     */
    public function admin_create_user($username, $email, $password, $fullname, $company, $role, $phone, $email_activation)
    {
        if ((strlen($username) > 0) and !$this->ci->users->is_username_available($username)) {
            $this->error = ['username' => 'auth_username_in_use'];
        } elseif (!$this->ci->users->is_email_available($email)) {
            $this->error = ['email' => 'auth_email_in_use'];
        } else {
            // Hash password using phpass
            $hasher = new PasswordHash(
                $this->ci->config->item('phpass_hash_strength', 'tank_auth'),
                $this->ci->config->item('phpass_hash_portable', 'tank_auth')
            );
            $hashed_password = $hasher->HashPassword($password);

            $data = [
                'username' => $username,
                'password' => $hashed_password,
                'email' => $email,
                'role_id' => (1 == $role && 1 != $company) ? 2 : $role,
                'last_ip' => $this->ci->input->ip_address(),
            ];

            $profile = [
                'company' => $company,
                'fullname' => $fullname,
                'phone' => $phone,
                'avatar' => 'default_avatar.jpg',
                'language' => config_item('default_language') ? config_item('default_language') : 'english',
                'locale' => config_item('locale') ? config_item('locale') : 'en_US',
            ];

            if ($email_activation) {
                $data['new_email_key'] = md5(random_int(0, getrandmax()).microtime());
            }
            if (!is_null($res = $this->ci->users->create_user($data, $profile, !$email_activation, $company))) {
                $data['user_id'] = $res['user_id'];

                $co = $this->ci->db->where('co_id', $company)->get('companies')->result();
                $com = $co[0];
                if (0 == intval($com->primary_contact)) {
                    $this->ci->db->where('co_id', $company)->update('companies', ['primary_contact' => $res['user_id']]);
                }

                $data['password'] = $password;
                unset($data['last_ip']);

                return $data;
            }
        }

        return null;
    }

    public function _create_company(
        $company_name,
        $company_email,
        $individual,
        $phone,
        $address,
        $city,
        $state,
        $zip,
        $country
    )
    {
        $this->ci->load->library('applib');
        $lang = ($this->ci->config->item('default_language')) ?
                $this->ci->config->item('default_language') : 'english';
        $currency = ($this->ci->config->item('default_currency')) ?
                $this->ci->config->item('default_currency') : 'USD';
        $data = [
            'company_ref' => $this->ci->applib->generate_string(),
            'company_name' => $company_name,
            'company_email' => $company_email,
            'language' => $lang,
            'currency' => $currency,
            'individual' => $individual,
            'company_address' => $address,
            'company_phone' => $phone,
            'city' => $city,
            'state' => $state,
            'zip' => $zip,
            'country' => $country,
        ];

        $this->ci->db->insert('companies', $data);

        return $this->ci->db->insert_id();
    }

    /**
     * Check if username available for registering.
     * Can be called for instant form validation.
     *
     * @param	string
     * @param mixed $username
     *
     * @return bool
     */
    public function is_username_available($username)
    {
        return (strlen($username) > 0) and $this->ci->users->is_username_available($username);
    }

    /**
     * Check if email available for registering.
     * Can be called for instant form validation.
     *
     * @param	string
     * @param mixed $email
     *
     * @return bool
     */
    public function is_email_available($email)
    {
        return (strlen($email) > 0) and $this->ci->users->is_email_available($email);
    }

    /**
     * Change email for activation and return some data about user:
     * user_id, username, email, new_email_key.
     * Can be called for not activated users only.
     *
     * @param	string
     * @param mixed $email
     *
     * @return array
     */
    public function change_email($email)
    {
        $user_id = $this->ci->session->userdata('user_id');

        if (!is_null($user = $this->ci->users->get_user_by_id($user_id, false))) {
            $data = [
                'user_id' => $user_id,
                'username' => $user->username,
                'email' => $email,
            ];
            if (strtolower($user->email) == strtolower($email)) {		// leave activation key as is
                $data['new_email_key'] = $user->new_email_key;

                return $data;
            }
            if ($this->ci->users->is_email_available($email)) {
                $data['new_email_key'] = md5(random_int(0, getrandmax()).microtime());
                $this->ci->users->set_new_email($user_id, $email, $data['new_email_key'], false);

                return $data;
            }
            $this->error = ['email' => 'auth_email_in_use'];
        }

        return null;
    }

    /**
     * Activate user using given key.
     *
     * @param	string
     * @param	string
     * @param	bool
     * @param mixed $user_id
     * @param mixed $activation_key
     * @param mixed $activate_by_email
     *
     * @return bool
     */
    public function activate_user($user_id, $activation_key, $activate_by_email = true)
    {
        $this->ci->users->purge_na($this->ci->config->item('email_activation_expire', 'tank_auth'));

        if ((strlen($user_id) > 0) and (strlen($activation_key) > 0)) {
            return $this->ci->users->activate_user($user_id, $activation_key, $activate_by_email);
        }

        return false;
    }

    /**
     * Set new password key for user and return some data about user:
     * user_id, username, email, new_pass_key.
     * The password key can be used to verify user when resetting his/her password.
     *
     * @param	string
     * @param mixed $login
     *
     * @return array
     */
    public function forgot_password($login)
    {
        if (strlen($login) > 0) {
            if (!is_null($user = $this->ci->users->get_user_by_login($login))) {
                $data = [
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'new_pass_key' => md5(random_int(0, getrandmax()).microtime()),
                ];

                $this->ci->users->set_password_key($user->id, $data['new_pass_key']);

                return $data;
            }
            $this->error = ['login' => 'auth_incorrect_email_or_username'];
        }

        return null;
    }

    /**
     * Check if given password key is valid and user is authenticated.
     *
     * @param	string
     * @param	string
     * @param mixed $user_id
     * @param mixed $new_pass_key
     *
     * @return bool
     */
    public function can_reset_password($user_id, $new_pass_key)
    {
        if ((strlen($user_id) > 0) and (strlen($new_pass_key) > 0)) {
            return $this->ci->users->can_reset_password(
                $user_id,
                $new_pass_key,
                $this->ci->config->item('forgot_password_expire', 'tank_auth')
            );
        }

        return false;
    }

    /**
     * Replace user password (forgotten) with a new one (set by user)
     * and return some data about it: user_id, username, new_password, email.
     *
     * @param	string
     * @param	string
     * @param mixed $user_id
     * @param mixed $new_pass_key
     * @param mixed $new_password
     *
     * @return bool
     */
    public function reset_password($user_id, $new_pass_key, $new_password)
    {
        if ((strlen($user_id) > 0) and (strlen($new_pass_key) > 0) and (strlen($new_password) > 0)) {
            if (!is_null($user = $this->ci->users->get_user_by_id($user_id, true))) {
                // Hash password using phpass
                $hasher = new PasswordHash(
                    $this->ci->config->item('phpass_hash_strength', 'tank_auth'),
                    $this->ci->config->item('phpass_hash_portable', 'tank_auth')
                );
                $hashed_password = $hasher->HashPassword($new_password);

                if ($this->ci->users->reset_password(
                    $user_id,
                    $hashed_password,
                    $new_pass_key,
                    $this->ci->config->item('forgot_password_expire', 'tank_auth')
                )) {	// success
                    // Clear all user's autologins
                    $this->ci->load->model('tank_auth/user_autologin');
                    $this->ci->user_autologin->clear($user->id);

                    return [
                        'user_id' => $user_id,
                        'username' => $user->username,
                        'email' => $user->email,
                        'new_password' => $new_password,
                    ];
                }
            }
        }

        return null;
    }

    /**
     * Change user password (only when user is logged in).
     *
     * @param	string
     * @param	string
     * @param mixed $old_pass
     * @param mixed $new_pass
     *
     * @return bool
     */
    public function change_password($old_pass, $new_pass)
    {
        $user_id = $this->ci->session->userdata('user_id');

        if (!is_null($user = $this->ci->users->get_user_by_id($user_id, true))) {
            // Check if old password correct
            $hasher = new PasswordHash(
                $this->ci->config->item('phpass_hash_strength', 'tank_auth'),
                $this->ci->config->item('phpass_hash_portable', 'tank_auth')
            );
            if ($hasher->CheckPassword($old_pass, $user->password)) {			// success
                // Hash new password using phpass
                $hashed_password = $hasher->HashPassword($new_pass);

                // Replace old password with new one
                $this->ci->users->change_password($user_id, $hashed_password);

                return true;
            }  															// fail
            $this->error = ['old_password' => 'auth_incorrect_password'];
        }

        return false;
    }

    /**
     * Set new password.
     *
     * @param   string
     * @param   string
     * @param mixed $user_id
     * @param mixed $new_pass
     *
     * @return bool
     */
    public function set_new_password($user_id, $new_pass)
    {
        if (!is_null($user = $this->ci->users->get_user_by_id($user_id, true))) {
                // Hash password using phpass
            $hasher = new PasswordHash(
                $this->ci->config->item('phpass_hash_strength', 'tank_auth'),
                $this->ci->config->item('phpass_hash_portable', 'tank_auth')
            );

            // Hash new password using phpass
            $hashed_password = $hasher->HashPassword($new_pass);

            // Replace old password with new one
            $this->ci->users->change_password($user_id, $hashed_password);

            return true;
        }

        return false;
    }

    /**
     * Change user email (only when user is logged in) and return some data about user:
     * user_id, username, new_email, new_email_key.
     * The new email cannot be used for login or notification before it is activated.
     *
     * @param	string
     * @param	string
     * @param mixed $new_email
     * @param mixed $password
     *
     * @return array
     */
    public function set_new_email($new_email, $password)
    {
        $user_id = $this->ci->session->userdata('user_id');

        if (!is_null($user = $this->ci->users->get_user_by_id($user_id, true))) {
            // Check if password correct
            $hasher = new PasswordHash(
                $this->ci->config->item('phpass_hash_strength', 'tank_auth'),
                $this->ci->config->item('phpass_hash_portable', 'tank_auth')
            );
            if ($hasher->CheckPassword($password, $user->password)) {			// success
                $data = [
                    'user_id' => $user_id,
                    'username' => $user->username,
                    'new_email' => $new_email,
                ];

                if ($user->email == $new_email) {
                    $this->error = ['email' => 'auth_current_email'];
                } elseif ($user->new_email == $new_email) {		// leave email key as is
                    $data['new_email_key'] = $user->new_email_key;

                    return $data;
                } elseif ($this->ci->users->is_email_available($new_email)) {
                    $data['new_email_key'] = md5(random_int(0, getrandmax()).microtime());
                    $this->ci->users->set_new_email($user_id, $new_email, $data['new_email_key'], true);

                    return $data;
                } else {
                    $this->error = ['email' => 'auth_email_in_use'];
                }
            } else {															// fail
                $this->error = ['password' => 'auth_incorrect_password'];
            }
        }

        return null;
    }

    /**
     * Activate new email, if email activation key is valid.
     *
     * @param	string
     * @param	string
     * @param mixed $user_id
     * @param mixed $new_email_key
     *
     * @return bool
     */
    public function activate_new_email($user_id, $new_email_key)
    {
        if ((strlen($user_id) > 0) and (strlen($new_email_key) > 0)) {
            return $this->ci->users->activate_new_email(
                $user_id,
                $new_email_key
            );
        }

        return false;
    }

    /**
     * Delete user from the site (only when user is logged in).
     *
     * @param	string
     * @param mixed $password
     *
     * @return bool
     */
    public function delete_user($password)
    {
        $user_id = $this->ci->session->userdata('user_id');

        if (!is_null($user = $this->ci->users->get_user_by_id($user_id, true))) {
            // Check if password correct
            $hasher = new PasswordHash(
                $this->ci->config->item('phpass_hash_strength', 'tank_auth'),
                $this->ci->config->item('phpass_hash_portable', 'tank_auth')
            );
            if ($hasher->CheckPassword($password, $user->password)) {			// success
                $this->ci->users->delete_user($user_id);
                $this->logout();

                return true;
            }  															// fail
            $this->error = ['password' => 'auth_incorrect_password'];
        }

        return false;
    }

    /**
     * Get error message.
     * Can be invoked after any failed operation such as login or register.
     *
     * @return string
     */
    public function get_error_message()
    {
        return $this->error;
    }

    /**
     * Save data for user's autologin.
     *
     * @param	int
     * @param mixed $user_id
     *
     * @return bool
     */
    public function create_remote_login($user_id)
    {
        $key = substr(md5(uniqid(random_int(0, getrandmax()).time())), 0, 16);
        $this->ci->load->model('tank_auth/remote_login');
        $this->ci->remote_login->purge($user_id);
        $expiration = date('Y-m-d H:m:i', time() + 3600 * config_item('remote_login_expires'));

        if ($this->ci->remote_login->set($user_id, md5($key), $expiration)) {
            return md5($key);
        }

        return false;
    }

    /**
     * Login user automatically if he/she provides correct autologin verification.
     *
     * @param mixed $key
     */
    public function remote_login($key = false)
    {
        if (!$this->is_logged_in() and !$this->is_logged_in(false)) {			// not logged in (as any user)
            if ($key) {
                $this->ci->load->model('tank_auth/remote_login');
                if (!is_null($user = $this->ci->remote_login->get($key))) {
                    if (strtotime($user->expires) < time()) {
                        return false;
                    }

                    // Login user
                    $this->ci->session->set_userdata([
                        'user_id' => $user->id,
                        'username' => $user->username,
                        'role_id' => $user->role_id,
                        'status' => STATUS_ACTIVATED,
                    ]);

                    $this->ci->users->update_login_info(
                        $user->id,
                        $this->ci->config->item('login_record_ip', 'tank_auth'),
                        $this->ci->config->item('login_record_time', 'tank_auth')
                    );

                    return true;
                }
            }
        } else {
            return true;
        }

        return false;
    }

    /**
     * Check if login attempts exceeded max login attempts (specified in config).
     *
     * @param	string
     * @param mixed $login
     *
     * @return bool
     */
    public function is_max_login_attempts_exceeded($login)
    {
        if ($this->ci->config->item('login_count_attempts', 'tank_auth')) {
            $this->ci->load->model('tank_auth/login_attempts');

            return $this->ci->login_attempts->get_attempts_num($this->ci->input->ip_address(), $login)
                    >= $this->ci->config->item('login_max_attempts', 'tank_auth');
        }

        return false;
    }

    /**
     * Save data for user's autologin.
     *
     * @param	int
     * @param mixed $user_id
     *
     * @return bool
     */
    private function create_autologin($user_id)
    {
        $this->ci->load->helper('cookie');
        $key = substr(md5(uniqid(random_int(0, getrandmax()).get_cookie($this->ci->config->item('sess_cookie_name')))), 0, 16);

        $this->ci->load->model('tank_auth/user_autologin');
        $this->ci->user_autologin->purge($user_id);

        if ($this->ci->user_autologin->set($user_id, md5($key))) {
            set_cookie([
                'name' => $this->ci->config->item('autologin_cookie_name', 'tank_auth'),
                'value' => serialize(['user_id' => $user_id, 'key' => $key]),
                'expire' => $this->ci->config->item('autologin_cookie_life', 'tank_auth'),
            ]);

            return true;
        }

        return false;
    }

    /**
     * Clear user's autologin data.
     */
    private function delete_autologin(): void
    {
        $this->ci->load->helper('cookie');
        if ($cookie = get_cookie($this->ci->config->item('autologin_cookie_name', 'tank_auth'), true)) {
            $data = unserialize($cookie);

            $this->ci->load->model('tank_auth/user_autologin');
            $this->ci->user_autologin->delete($data['user_id'], md5($data['key']));

            delete_cookie($this->ci->config->item('autologin_cookie_name', 'tank_auth'));
        }
    }

    /**
     * Login user automatically if he/she provides correct autologin verification.
     */
    private function autologin()
    {
        if (!$this->is_logged_in() and !$this->is_logged_in(false)) {			// not logged in (as any user)
            $this->ci->load->helper('cookie');
            if ($cookie = get_cookie($this->ci->config->item('autologin_cookie_name', 'tank_auth'), true)) {
                $data = unserialize($cookie);

                if (isset($data['key']) and isset($data['user_id'])) {
                    $this->ci->load->model('tank_auth/user_autologin');
                    if (!is_null($user = $this->ci->user_autologin->get($data['user_id'], md5($data['key'])))) {
                        // Login user
                        $this->ci->session->set_userdata([
                            'user_id' => $user->id,
                            'username' => $user->username,
                            'role_id' => $user->role_id,
                            'status' => STATUS_ACTIVATED,
                        ]);

                        // Renew users cookie to prevent it from expiring
                        set_cookie([
                            'name' => $this->ci->config->item('autologin_cookie_name', 'tank_auth'),
                            'value' => $cookie,
                            'expire' => $this->ci->config->item('autologin_cookie_life', 'tank_auth'),
                        ]);

                        $this->ci->users->update_login_info(
                            $user->id,
                            $this->ci->config->item('login_record_ip', 'tank_auth'),
                            $this->ci->config->item('login_record_time', 'tank_auth')
                        );

                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Increase number of attempts for given IP-address and login
     * (if attempts to login is being counted).
     *
     * @param	string
     * @param mixed $login
     */
    private function increase_login_attempt($login): void
    {
        if ($this->ci->config->item('login_count_attempts', 'tank_auth')) {
            if (!$this->is_max_login_attempts_exceeded($login)) {
                $this->ci->load->model('tank_auth/login_attempts');
                $this->ci->login_attempts->increase_attempt($this->ci->input->ip_address(), $login);
            }
        }
    }

    /**
     * Clear all attempt records for given IP-address and login
     * (if attempts to login is being counted).
     *
     * @param	string
     * @param mixed $login
     */
    private function clear_login_attempts($login): void
    {
        if ($this->ci->config->item('login_count_attempts', 'tank_auth')) {
            $this->ci->load->model('tank_auth/login_attempts');
            $this->ci->login_attempts->clear_attempts(
                $this->ci->input->ip_address(),
                $login,
                $this->ci->config->item('login_attempt_expire', 'tank_auth')
            );
        }
    }
}

// End of file Tank_auth.php
// Location: ./application/libraries/Tank_auth.php
