<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Servers extends Hosting_Billing
{
    public function __construct()
    {
        parent::__construct();
        $this->load->module('layouts');
        $this->load->library(['template']);

        User::logged_in();
        $this->load->library('encryption');
        $this->encryption->initialize(
            [
                'cipher' => 'aes-256',
                'driver' => 'openssl',
                'mode' => 'ctr',
            ]
        );
    }

    public function index($id = null): void
    {
        if ($id) {
            $server = $this->db->where(['id' => $id])->get('servers')->row();
            $response = $this->check_connection($id);
            $data['response'] = $server->name.': '.$response;
        }
        $this->template->title(lang('servers'));
        $data['page'] = lang('servers');
        $data['datatables'] = true;
        $this->template
            ->set_layout('users')
            ->build('index', $data ?? null)
        ;
    }

    public function add_server(): void
    {
        if ($this->input->post()) {
            Applib::is_demo();

            $_POST['selected'] = ('on' == $this->input->post('selected')) ? 1 : 0;
            $_POST['use_ssl'] = ('on' == $this->input->post('use_ssl')) ? 'Yes' : 'No';
            if (App::save_data('servers', $this->input->post())) {
                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('server_added'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $data['servers'] = Plugin::servers();
            $this->load->view('modal/add_server', $data);
        }
    }

    public function edit_server($id = null): void
    {
        if ($this->input->post()) {
            Applib::is_demo();

            if ('on' == $this->input->post('selected')) {
                $this->db->set('selected', 0);
                $this->db->where('selected', 1);
                $this->db->update('servers');
            }
            $update = [
                'type' => $this->input->post('type'),
                'name' => $this->input->post('name'),
                'selected' => ('on' == $this->input->post('selected')) ? 1 : 0,
                'use_ssl' => ('on' == $this->input->post('use_ssl')) ? 'Yes' : 'No',
                'hostname' => $this->input->post('hostname'),
                'port' => $this->input->post('port'),
                'username' => $this->input->post('username'),
                'authkey' => $this->input->post('authkey'),
                'ns1' => $this->input->post('ns1'),
                'ns2' => $this->input->post('ns2'),
                'ns3' => $this->input->post('ns3'),
                'ns4' => $this->input->post('ns4'),
                'ns5' => $this->input->post('ns5'),
            ];

            $this->db->where('id', $id);
            if ($this->db->update('servers', $update)) {
                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('server_edited'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $data['data'] = $this->db->where(['id' => $id])->get('servers')->row();
            $this->load->view('modal/edit_server', $data);
        }
    }

    public function delete_server($id = null): void
    {
        if ($this->input->post()) {
            Applib::is_demo();
            $server_id = $this->input->post('id', true);
            App::delete('servers', ['id' => $server_id]);

            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('server_deleted'));
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data['id'] = $id;
            $this->load->view('modal/delete_server', $data);
        }
    }

    public function create_order($item, $co_id, $a, $id)
    {
        $items = [
            'invoice_id' => 0,
            'item_name' => $item->item_name,
            'item_desc' => '-',
            'unit_cost' => $item->unit_cost,
            'item_order' => 1,
            'item_tax_rate' => $item->item_tax_rate,
            'item_tax_total' => $item->item_tax_total,
            'quantity' => 1,
            'total_cost' => $item->total_cost,
        ];

        $item_id = App::save_data('items', $items);

        $time = strtotime($a['startdate']);
        $date = gmdate('Y-m-d', $time);

        $order = [
            'client_id' => $co_id,
            'invoice_id' => 0,
            'date' => date('Y-m-d H:i:s'),
            'nameservers' => '',
            'item' => $item_id,
            'domain' => $a['domain'],
            'item_parent' => $item->item_id,
            'type' => 'hosting',
            'process_id' => $time,
            'order_id' => $time,
            'fee' => 0,
            'processed' => $date,
            'username' => $a['user'],
            'password' => $a['pass'],
            'renewal_date' => $date,
            'status_id' => 6,
            'server' => $id,
            'renewal' => '',
        ];

        return App::save_data('orders', $order);
    }

    public function check_connection($id)
    {
        $server = $this->db->where(['id' => $id])->get('servers')->row();

        return modules::run($server->type.'/check_connection', $server);
    }

    public function import($id = null): void
    {
        $list = [];
        $server = $this->db->where(['id' => $id])->get('servers')->row();
        $count = 0;

        $list = modules::run($server->type.'/import', $server);

        $accounts = $this->db->where(['type' => 'hosting', 'status_id' => 6])
            ->join('companies', 'companies.co_id = orders.client_id')
            ->get('orders')->result();

        $clients = $this->db->where(['co_id >' => 1])->get('companies')->result();

        if ($this->input->post() && is_array($list)) {
            Applib::is_demo();
            foreach ($this->input->post() as $key => $domain) {
                foreach ($list as $k => $a) {
                    if ($a['domain'] == str_replace('_', '.', $key)) {
                        $item = $this->db->where('package_name', $a['plan'])->join('servers', 'servers.id = items_saved.server')->get('items_saved')->row();
                        $client = $this->db->where('company_email', $a['email'])->get('companies')->row();
                        if (is_object($client)) {
                            if (0 == $this->db->where('domain', $a['domain'])->where('type', 'hosting')->get('orders')->num_rows()) {
                                if ($this->create_order($item, $client->co_id, $a, $id)) {
                                    ++$count;
                                }
                            } else {
                                $this->db->where('domain', $a['domain'])
                                    ->where('client_id', $client->co_id)
                                    ->where('status_id', 6)
                                    ->update('orders', ['username' => $a['user']])
                                ;
                            }
                        } else {
                            if ('' != $a['email']) {
                                $username = explode('@', $a['email'])[0];
                                $email = $a['email'];
                                $password = $a['email'];
                            } else {
                                $username = $a['user'];
                                $email = $a['user'].'@'.$a['domain'];
                                $password = $a['email'];
                            }

                            $hasher = new PasswordHash(
                                $this->config->item('phpass_hash_strength', 'tank_auth'),
                                $this->config->item('phpass_hash_portable', 'tank_auth')
                            );
                            $hashed_password = $hasher->HashPassword($password);

                            if (!is_username_available($username)) {
                                $username = explode('.', $a['domain'], 2)[0];
                            }

                            $data = [
                                'username' => $username,
                                'password' => $hashed_password,
                                'email' => $email,
                                'role_id' => 2,
                            ];

                            $user_id = App::save_data('users', $data);

                            $client = [
                                'company_name' => ucfirst($a['domain']).' '.lang('account'),
                                'company_email' => $email,
                                'company_ref' => $this->applib->generate_string(),
                                'language' => config_item('default_language'),
                                'currency' => config_item('default_currency'),
                                'primary_contact' => $user_id,
                                'individual' => 0,
                                'company_address_two' => '',
                                'company_phone' => '',
                                'city' => '',
                                'state' => '',
                                'zip' => '',
                            ];

                            if ($co_id = App::save_data('companies', $client)) {
                                $profile = [
                                    'user_id' => $user_id,
                                    'company' => $co_id,
                                    'fullname' => ucfirst($a['domain']).' '.lang('account'),
                                    'phone' => '',
                                    'avatar' => 'default_avatar.jpg',
                                    'language' => config_item('default_language'),
                                    'locale' => config_item('locale') ? config_item('locale') : 'en_US',
                                ];

                                App::save_data('account_details', $profile);
                                if ($this->create_order($item, $co_id, $a, $id)) {
                                    ++$count;
                                }
                            }
                        }
                    }
                }
            }

            $this->session->set_flashdata('response_status', 'info');
            $this->session->set_flashdata('message', 'Created '.$count.' accounts');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            if (is_array($list)) {
                foreach ($list as $key => $a) {
                    foreach ($clients as $client) {
                        if ($a['email'] == $client->company_email) {
                            $list[$key]['client'] = $client->company_name;
                        }
                    }

                    $item = $this->db->where('package_name', $a['plan'])
                        ->join('servers', 'servers.id = items_saved.server')
                        ->where('reseller_package', 'No')
                        ->get('items_saved')->row();

                    if (isset($item->package_name)) {
                        $list[$key]['package'] = $item->item_name;
                        $list[$key]['server'] = $item->name;
                        $list[$key]['import'] = ($id == $item->server) ? 1 : 0;
                    }

                    foreach ($accounts as $acc) {
                        if ($a['domain'] == $acc->domain && $a['user'] == $acc->username) {
                            unset($list[$key]);
                        }
                    }
                }
            }
        }

        $data['data'] = $list;
        $data['id'] = $id;
        $this->template->title(lang('import_accounts'));
        $data['page'] = lang('import_accounts');
        $this->template
            ->set_layout('users')
            ->build('import', $data ?? null)
        ;
    }

    public function login($id)
    {
        Applib::is_demo();
        if (User::is_admin() || User::perm_allowed(User::get_id(), 'manage_accounts')) {
            $server = $this->db->where(['id' => $id])->get('servers')->row();

            return modules::run($server->type.'/admin_login', $server);
        }

        redirect(base_url());
    }
}

// End of file Servers.php
