<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Orders extends Hosting_Billing
{
    private $server;

    public function __construct()
    {
        parent::__construct();
        User::logged_in();

        $this->load->module('layouts');
        $this->load->library('template');
        $this->filter_by = $this->_filter_by();
        $server = $this->db->where(['selected' => 1])->get('servers')->row();

        if ($server) {
            $this->server = $server->id;
        }

        $lang = config_item('default_language');
        if (isset($_COOKIE['fo_lang'])) {
            $lang = $_COOKIE['fo_lang'];
        }
        if ($this->session->userdata('lang')) {
            $lang = $this->session->userdata('lang');
        }
        $this->lang->load('hd', $lang);
    }

    public function index(): void
    {
        App::module_access('menu_orders');
        $this->template->title(lang('orders').' - '.config_item('company_name'));
        $data['page'] = lang('orders');
        $data['datatables'] = true;
        $data['form'] = true;
        $array = $this->filter_by($this->filter_by);
        $data['orders'] = Order::list_orders($array);
        $this->template
            ->set_layout('users')
            ->build('orders', $data ?? null)
        ;
    }

    public function _filter_by()
    {
        $filter = $_GET['view'] ?? '';

        return $filter;
    }

    public function filter_by($filter_by)
    {
        switch ($filter_by) {
            case 'unpaid':
            return ['hd_invoices.status' => 'Unpaid', 'status_id <>' => 8, 'status_id <>' => 2];

            break;

            case 'paid':
            return ['hd_invoices.status' => 'Paid', 'status_id <>' => 8, 'status_id <>' => 2];

            break;

            default:
            return ['status_id <>' => 8, 'status_id <>' => 2];

            break;
        }
    }

    public function activate($id = null): void
    {
        $domain_servers = [];

        App::module_access('menu_orders');
        if ($this->input->post()) {
            $result = '';
            if ($this->input->post('hosting')) {
                $client = Client::view_by_id($this->input->post('client_id'));
                $accounts = $this->input->post('username');
                $domain = $this->input->post('hosting_domain');
                $passwords = $this->input->post('password');
                $hosting = $this->input->post('hosting');
                $service = $this->input->post('service');
                $servers = $this->input->post('server');
                $user = User::view_user($client->primary_contact);
                $profile = User::profile_info($client->primary_contact);

                $this->db->set('inv_deleted', 'No');
                $this->db->where('inv_id', $this->input->post('inv_id'));
                $this->db->update('invoices');

                foreach ($accounts as $key => $account) {
                    $item = $this->input->post('item_id');

                    $domain_servers[] = [$domain[$key] => $servers[$key]];

                    $update = [
                        'status_id' => 6,
                        'username' => $accounts[$key],
                        'password' => $passwords[$key],
                        'server' => $servers[$key],
                    ];

                    $this->db->where('id', $hosting[$key]);
                    if ($this->db->update('orders', $update)) {
                        $result .= $service[$key].' for '.$domain[$key].' activated.<br>';
                    }

                    $username = $accounts[$key];

                    if ($username && 'on' == $username.'_send_details') {
                        Order::send_account_details($hosting[$key]);
                    }

                    $acc = Order::get_order($hosting[$key]);

                    if ('TRUE' != config_item('demo_mode')) {
                        if ('on' == $this->input->post($acc->username.'_controlpanel')) {
                            $package = $this->db->where(['item_id' => $acc->item_parent])->get('items_saved')->row();
                            $server = $this->db->where(['id' => $servers[$key]])->get('servers')->row();

                            $details = (object) [
                                'user' => $user,
                                'profile' => $profile,
                                'client' => $client,
                                'account' => $acc,
                                'package' => $package,
                                'server' => $server,
                            ];

                            $result .= modules::run($server->type.'/create_account', $details);
                        }
                    }
                }
            }

            if ($this->input->post('domain')) {
                $domains = $this->input->post('domain');

                foreach ($domains as $key => $account) {
                    $acc = Order::get_order($domains[$key]);

                    $update = [
                        'status_id' => 6,
                        'authcode' => $this->input->post('authcode')[$key],
                        'registrar' => $this->input->post('registrar')[$key],
                    ];

                    $this->db->where('id', $domains[$key]);

                    if ($this->db->update('orders', $update)) {
                        $domain = explode('.', $acc->domain, 2);

                        if ('on' == $this->input->post($domain[0].'_activate')) {
                            if ('' != $this->input->post('registrar')[$key]) {
                                $registrar = $this->input->post('registrar')[$key];

                                $action = '/register_domain';

                                $nameservers = Order::get_nameservers($domains[$key], $domain_servers);

                                if ('' != $nameservers) {
                                    $nameservers = explode(',', $nameservers);
                                } else {
                                    $nameservers = [];
                                    if ('' != config_item('nameserver_one')) {
                                        $nameservers[] = config_item('nameserver_one');
                                    }
                                    if ('' != config_item('nameserver_two')) {
                                        $nameservers[] = config_item('nameserver_two');
                                    }
                                    if ('' != config_item('nameserver_three')) {
                                        $nameservers[] = config_item('nameserver_three');
                                    }
                                    if ('' != config_item('nameserver_four')) {
                                        $nameservers[] = config_item('nameserver_four');
                                    }
                                    if ('' != config_item('nameserver_five')) {
                                        $nameservers[] = config_item('nameserver_five');
                                    }
                                }

                                if ($acc->item_name == lang('domain_renewal')) {
                                    $action = '/renew_domain';
                                }

                                if ($acc->item_name == lang('domain_transfer')) {
                                    $action = '/transfer_domain';
                                }

                                $result .= modules::run($registrar.$action, $domains[$key], $nameservers);
                            }

                            $data = [
                                'user' => User::get_id(),
                                'module' => 'accounts',
                                'module_field_id' => $domains[$key],
                                'activity' => $result,
                                'icon' => 'fa-usd',
                                'value1' => $acc->domain,
                                'value2' => '',
                            ];
                            App::Log($data);

                            $result .= '<p>'.$acc->domain.' activated! </p>';
                        }
                    }
                }
            }

            $this->session->set_flashdata('response_status', 'warning');
            $this->session->set_flashdata('message', $result);
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data['order'] = $this->get_order($id);
            $data['servers'] = $this->db->get('servers')->result();
            $this->load->view('modal/activate', $data);
        }
    }

    public function cancel($id = null): void
    {
        App::module_access('menu_orders');
        if ($this->input->post()) {
            if ('on' == $this->input->post('credit_account')) {
                Invoice::credit_client($this->input->post('invoice_id'));
            }

            $result = '';
            if ($this->input->post('hosting')) {
                $accounts = $this->input->post('username');
                $hosting = $this->input->post('hosting');
                $service = $this->input->post('service');
                $domain = $this->input->post('account');

                $this->db->set('inv_deleted', 'Yes');
                $this->db->where('inv_id', $this->input->post('invoice_id'));
                $this->db->update('invoices');

                foreach ($accounts as $key => $a) {
                    $this->db->set('status_id', 7);
                    $this->db->where('id', $hosting[$key]);
                    if ($this->db->update('orders')) {
                        $result .= $service[$key].' for '.$domain[$key].' cancelled.<br>';
                    }

                    if ('TRUE' != config_item('demo_mode')) {
                        $account = Order::get_order($hosting[$key]);

                        if ('on' == $this->input->post($account->username.'_delete_controlpanel')) {
                            $server = Order::get_server($account->server);
                            $client = Client::view_by_id($account->client_id);
                            $user = User::view_user($client->primary_contact);
                            $details = (object) ['account' => $account, 'server' => $server, 'package' => $package, 'client' => $client, 'user' => $user];
                            $result .= modules::run($server->type.'/terminate_account', $details);
                        }
                    }
                }
            }

            if ($this->input->post('domain')) {
                $domains = $this->input->post('domain');
                $domain = $this->input->post('domain_name');

                foreach ($domains as $key => $account) {
                    $this->db->set('status_id', 7);
                    $this->db->where('id', $domains[$key]);
                    if ($this->db->update('orders')) {
                        $result .= 'Domain: '.$domain[$key].' cancelled!<br>';
                    }
                }
            }

            $this->session->set_flashdata('response_status', 'warning');
            $this->session->set_flashdata('message', $result);
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data['order'] = $this->get_order($id);
            $data['servers'] = $this->db->get('servers')->result();
            $this->load->view('modal/cancel', $data);
        }
    }

    public function delete($id = null): void
    {
        App::module_access('menu_orders');
        if ($this->input->post()) {
            if ('on' == $this->input->post('credit_account')) {
                Invoice::credit_client($this->input->post('invoice_id'));
            }

            $result = '';
            if ($this->input->post('hosting')) {
                $accounts = $this->input->post('username');
                $hosting = $this->input->post('hosting');
                $service = $this->input->post('service');
                $domain = $this->input->post('account');

                foreach ($accounts as $key => $a) {
                    $this->db->where('id', $hosting[$key]);
                    if ($this->db->delete('orders')) {
                        $result .= $service[$key].' for '.$domain[$key].' deleted.<br>';
                    }

                    if ('TRUE' != config_item('demo_mode')) {
                        $account = Order::get_order($hosting[$key]);

                        if ('on' == $this->input->post($account->username.'_delete_controlpanel')) {
                            $server = Order::get_server($account->server);
                            $client = Client::view_by_id($account->client_id);
                            $user = User::view_user($client->primary_contact);
                            $details = (object) ['account' => $account, 'server' => $server, 'package' => $package, 'client' => $client, 'user' => $user];
                            $result .= modules::run($server->type.'/terminate_account', $details);
                        }
                    }
                }
            }

            if ($this->input->post('domain')) {
                $domains = $this->input->post('domain');
                $domain = $this->input->post('domain_name');

                foreach ($domains as $key => $account) {
                    $this->db->where('id', $domains[$key]);
                    if ($this->db->delete('orders')) {
                        $result .= 'Domain: '.$domain[$key].' deleted!<br>';
                    }
                }
            }

            $invoice = $this->input->post('invoice_id');
            Invoice::delete($invoice);

            $this->session->set_flashdata('response_status', 'warning');
            $this->session->set_flashdata('message', $result);
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data['order'] = $this->get_order($id);
            $data['servers'] = $this->db->get('servers')->result();
            $this->load->view('modal/delete', $data);
        }
    }

    public function select_client(): void
    {
        if ($this->input->post()) {
            $this->session->set_userdata(['co_id' => $this->input->post('co_id')]);
            redirect('orders/add_order');
        } else {
            $this->template->title(lang('orders').' - '.config_item('company_name'));
            $data['page'] = lang('new_order');
            $data['form'] = true;
            $this->template
                ->set_layout('users')
                ->build('select_client', $data ?? null)
            ;
        }
    }

    public function get_order($id)
    {
        $this->db->select('*');
        $this->db->from('orders');
        $this->db->join('items', 'orders.item = items.item_id', 'LEFT');
        $this->db->where('order_id', $id);

        return $this->db->get()->result();
    }

    public function add_order(): void
    {
        if ($this->input->post()) {
            $this->session->set_flashdata('response_status', 'warning');
            $this->session->set_flashdata('message', $result);
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->template->title(lang('orders').' - '.config_item('company_name'));
            $data['page'] = lang('orders');
            $data['datepicker'] = true;
            $data['form'] = true;
            $this->template
                ->set_layout('users')
                ->build(config_item('active_theme').'/views/pages/add_order', $data ?? null)
            ;
        }
    }

    public static function process($id)
    {
        $ci = &get_instance();
        $item = $ci->db->where('invoice_id', $id)->get('items')->result();
        if ($item[0]->item_name == lang('add_funds')) {
            $payment = Payment::by_invoice($id);
            $amount = $payment[0]->amount;

            $client = Client::view_by_id(Invoice::view_by_id($id)->client);
            $credit = $client->transaction_value;
            $bal = $credit + $amount;

            $balance = [
                'transaction_value' => Applib::format_deci($bal),
            ];

            $ci->db->where('co_id', $client->co_id)->update('companies', $balance);

            return true;
        }

        $ci->db->select('*');
        $ci->db->from('orders');
        $ci->db->join('items_saved', 'orders.item_parent = items_saved.item_id', 'LEFT');
        $ci->db->join('invoices', 'orders.invoice_id = invoices.inv_id', 'inner');
        $ci->db->where('inv_id', $id);
        $accounts = $ci->db->get()->result();

        foreach ($accounts as $acc) {
            $referral = $ci->db->where('order_id', $acc->id)->get('referrals')->row();
            if (is_object($referral)) {
                $affiliate = $ci->db->where('affiliate_id', $referral->affiliate_id)->get('companies')->row();
                $balance = $affiliate->affiliate_balance + $referral->commission;

                $aff_data = [
                    'affiliate_balance' => $balance,
                ];
                $ci->db->where('affiliate_id', $referral->affiliate_id);
                $ci->db->update('companies', $aff_data);
            }
        }

        if ('TRUE' == config_item('automatic_activation')
            && $ci->db->where('invoice_id', $id)->where('status_id', 5)->get('orders')->num_rows() > 0) {
            if (1 == count($accounts) && $accounts[0]->o_id > 0) {
                $order = $accounts[0];
                $o_id = $accounts[0]->o_id;

                $domain = $ci->db->select('*')->from('orders')->where('id', $o_id)->get()->row();
                $package = $ci->db->where(['item_id' => $order->item_parent])->get('items_saved')->row();

                if ('annually' == $order->renewal) {
                    $process_id = $domain->process_id;
                } else {
                    $process_id = time();
                }

                $update = [
                    'status_id' => 6,
                    'order_id' => $domain->order_id,
                    'process_id' => $process_id,
                    'o_id' => 0,
                ];

                $ci->db->where('o_id', $o_id);
                if ($ci->db->update('orders', $update)) {
                    $result = 'Order updated. <br>';

                    $activity = [
                        'user' => User::get_id(),
                        'module' => 'accounts',
                        'module_field_id' => $order->id,
                        'activity' => 'activity_activate_upgrade',
                        'icon' => 'fa-plus',
                        'value1' => $order->invoice_id,
                    ];

                    App::Log($activity);

                    $update_item = [
                        'item_name' => $order->item_name,
                    ];

                    $ci->db->where('item_id', $order->item);
                    if ($ci->db->update('items', $update_item)) {
                        App::delete('orders', ['id' => $o_id]);
                        if (null != $order->server && 'TRUE' != config_item('demo_mode')) {
                            $client = Client::view_by_id($order->client_id);
                            $user = User::view_user($client->primary_contact);
                            $profile = User::profile_info($client->primary_contact);
                            $server = Order::get_server($order->server);

                            $details = (object) [
                                'user' => $user,
                                'profile' => $profile,
                                'client' => $client,
                                'account' => $order,
                                'package' => $package,
                                'server' => $server,
                            ];

                            $result = modules::run($server->type.'/change_package', $details);

                            $activity = [
                                'user' => User::get_id(),
                                'module' => 'accounts',
                                'module_field_id' => $order->id,
                                'activity' => $result,
                                'icon' => 'fa-plus',
                                'value1' => $order->invoice_id,
                            ];

                            App::Log($activity);
                        }
                    }
                }
            } else {
                foreach ($accounts as $account) {
                    $client = Client::view_by_id($account->client_id);
                    $user = User::view_user($client->primary_contact);
                    $profile = User::profile_info($client->primary_contact);

                    if ('hosting' == $account->type) {
                        $update = [
                            'status_id' => 6,
                            'server' => (null != $account->server && $account->server > 0 && '' != $account->server) ? $account->server : $ci->server,
                        ];

                        $ci->db->where('id', $account->id);
                        if ($ci->db->update('orders', $update)) {
                            $data = [
                                'user' => $account->client_id,
                                'module' => 'accounts',
                                'module_field_id' => $account->id,
                                'activity' => 'activity_account_activated',
                                'icon' => 'fa-usd',
                                'value1' => $account->reference_no,
                                'value2' => $account->inv_id,
                            ];
                            App::Log($data);
                        }

                        Order::send_account_details($account->id);

                        $server = $ci->db->where('id', $account->server)->get('servers')->row();

                        if (!$server && !empty($ci->server)) {
                            $server = $ci->db->where('id', $ci->server)->get('servers')->row();
                        }

                        if ($server && 'TRUE' != config_item('demo_mode')) {
                            $package = $ci->db->where(['item_id' => $account->item_parent])->get('items_saved')->row();

                            $details = (object) [
                                'user' => $user,
                                'profile' => $profile,
                                'client' => $client,
                                'account' => $account,
                                'package' => $package,
                                'server' => $server,
                            ];

                            modules::run($server->type.'/create_account', $details);

                            $data = [
                                'user' => $account->client_id,
                                'module' => 'accounts',
                                'module_field_id' => $account->id,
                                'activity' => 'activity_cpanel_creation',
                                'icon' => 'fa-usd',
                                'value1' => $result,
                                'value2' => $account->inv_id,
                            ];
                        }

                        App::Log($data);
                    }

                    if ('domain' == $account->type || 'domain_only' == $account->type) {
                        $registrar = '';

                        if (empty($account->registrar)) {
                            $item = $ci->db->where('item_id', $account->item_parent)->get('items_saved')->row();
                            $item->default_registrar;

                            $ci->db->set('status_id', 6);
                            $ci->db->set('registrar', $registrar);
                            $ci->db->where('id', $account->id);
                            $ci->db->update('orders');
                        } else {
                            $registrar = $account->registrar;
                        }

                        if (!empty($registrar)) {
                            $process = $account->domain.' activated!';

                            if (Plugin::get_plugin($registrar)) {
                                $action = '/register_domain';

                                $nameservers = Order::get_nameservers($account->id);

                                if ('' != $nameservers) {
                                    $nameservers = explode(',', $nameservers);
                                } else {
                                    $nameservers = [];
                                    if ('' != config_item('nameserver_one')) {
                                        $nameservers[] = config_item('nameserver_one');
                                    }
                                    if ('' != config_item('nameserver_two')) {
                                        $nameservers[] = config_item('nameserver_two');
                                    }
                                    if ('' != config_item('nameserver_three')) {
                                        $nameservers[] = config_item('nameserver_three');
                                    }
                                    if ('' != config_item('nameserver_four')) {
                                        $nameservers[] = config_item('nameserver_four');
                                    }
                                    if ('' != config_item('nameserver_five')) {
                                        $nameservers[] = config_item('nameserver_five');
                                    }
                                }

                                if ($account->item_name == lang('domain_renewal')) {
                                    $action = '/renew_domain';
                                }
                                if ($account->item_name == lang('domain_transfer')) {
                                    $action = '/transfer_domain';
                                }
                                $process .= modules::run($registrar.$action, $account->id, $nameservers);
                            }

                            $data = [
                                'user' => $account->client_id,
                                'module' => 'accounts',
                                'module_field_id' => $account->id,
                                'activity' => $process,
                                'icon' => 'fa-usd',
                                'value1' => $account->domain,
                                'value2' => '',
                            ];
                            App::Log($data); // Log activity
                        }
                    }
                }
            }
        } else {
            $ci->db->join('items', 'items.item_id = orders.item');
            $account = $ci->db->where(['status_id' => 9, 'items.invoice_id' => $id])->get('orders')->row();
            if (isset($account)) {
                $ci->db->where('id', $account->id);
                if ($ci->db->update('orders', ['status_id' => 6])) {
                    if ('TRUE' == config_item('automatic_email_on_recur')) {
                        send_email($id, 'service_unsuspended', $account);
                    }

                    if ('TRUE' == config_item('sms_gateway')
                        && 'TRUE' == config_item('sms_service_unsuspended')) {
                        send_message($id, 'service_unsuspended');
                    }
                }
            }
        }
    }

    private function process_upgrade($o_id): void
    {
        $order = $this->db->select('*')->from('orders')->join('items_saved', 'orders.item_parent = items_saved.item_id', 'inner')->where('o_id', $o_id)->get()->row();
        $domain = $this->db->select('*')->from('orders')->where('id', $o_id)->get()->row();
        $package = $this->db->where(['item_id' => $order->item_parent])->get('items_saved')->row();

        if ('annually' == $order->renewal) {
            $process_id = $domain->process_id;
        } else {
            $process_id = time();
        }

        $update = [
            'status_id' => 6,
            'order_id' => $domain->order_id,
            'process_id' => $process_id,
            'o_id' => 0,
        ];

        $this->db->where('o_id', $o_id);
        if ($this->db->update('orders', $update)) {
            $result = 'Order updated. <br>';

            $activity = [
                'user' => User::get_id(),
                'module' => 'accounts',
                'module_field_id' => $order,
                'activity' => 'activity_activate_upgrade',
                'icon' => 'fa-plus',
                'value1' => $order->invoice_id,
            ];

            App::Log($activity);

            $update_item = [
                'item_name' => $order->item_name,
            ];

            $this->db->where('item_id', $order->item);
            $this->db->update('items', $update_item);

            $this->db->where('id', $o_id);
            $this->db->delete('orders');

            if (null != $order->server && 'TRUE' != config_item('demo_mode')) {
                $client = Client::view_by_id($order->client_id);
                $user = User::view_user($client->primary_contact);
                $profile = User::profile_info($client->primary_contact);
                $server = Order::get_server($order->server);

                $details = (object) [
                    'user' => $user,
                    'profile' => $profile,
                    'client' => $client,
                    'account' => $account,
                    'package' => $package,
                    'server' => $server,
                ];

                $details = ['server' => $server, 'account' => $order];
                $result = modules::run($server->type.'/change_package', $details);

                $activity = [
                    'user' => User::get_id(),
                    'module' => 'accounts',
                    'module_field_id' => $order,
                    'activity' => $result,
                    'icon' => 'fa-plus',
                    'value1' => $order->invoice_id,
                ];

                App::Log($activity);
            }

            $this->session->set_flashdata('response_status', 'warning');
            $this->session->set_flashdata('message', $result);

            $from = $_SERVER['HTTP_REFERER'];
            $segments = explode('/', $from);

            if ('invoices' == $segments[3]) {
                redirect('accounts');
            } else {
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}

// End of file orders.php
