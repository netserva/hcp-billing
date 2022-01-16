<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Items extends Hosting_Billing
{
    public function __construct()
    {
        parent::__construct();
        $this->load->module('layouts');
        $this->load->library(['form_validation', 'settings', 'template']);
        $this->load->helper('form');
        $this->filter_by = $this->_filter_by();
        $this->applib->set_locale();
    }

    public function index(): void
    {
        $this->list_items();
        $this->can_access();
    }

    public function can_access(): void
    {
        if (!User::is_admin() && !User::is_staff()) {
            redirect('clients');
        }
    }

    public function list_items(): void
    {
        $this->can_access();
        $this->template->title(lang('item_lookups').' - '.config_item('company_name'));
        $data['page'] = lang('items');
        $data['datatables'] = true;
        $data['form'] = true;
        $array = $this->filter_by($this->filter_by);
        $data['invoice_items'] = Item::list_items($array);
        $this->template
            ->set_layout('users')
            ->build('items', $data ?? null)
        ;
    }

    public function categories(): void
    {
        if (User::is_client()) {
            Applib::go_to('clients', 'error', lang('access_denied'));
        }
        $this->template->title(lang('categories').' - '.config_item('company_name'));
        $data['page'] = lang('categories');
        $this->template
            ->set_layout('users')
            ->build('categories', $data ?? null)
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
            case 'domains':
            return ['hd_categories.parent' => 8, 'deleted' => 'No'];

            break;

            case 'hosting':
            return ['hd_categories.parent' => 9, 'deleted' => 'No'];

            break;

            case 'service':
            return ['hd_categories.parent' => 10, 'deleted' => 'No'];

            break;

            default:
            return ['deleted' => 'No'];

            break;
        }
    }

    public function add_hosting(): void
    {
        $this->add_item('hosting');
    }

    public function add_domain(): void
    {
        $this->add_item('domain');
    }

    public function add_service(): void
    {
        $this->add_item('service');
    }

    public function add_addon(): void
    {
        $this->add_item('addon');
    }

    public function add_item($item = null): void
    {
        App::module_access('menu_items');
        if ($this->input->post()) {
            Applib::is_demo();

            if ($this->input->post('unit_cost')) {
                $sub_total = $this->input->post('unit_cost') * $this->input->post('quantity');
            } else {
                $sub_total = 0;
            }

            $item_tax_rate = $this->input->post('item_tax_rate');
            $item_tax_total = Applib::format_deci(($item_tax_rate / 100) * $sub_total);

            $data = [
                'item_tax_rate' => $item_tax_rate,
                'item_tax_total' => $item_tax_total,
                'quantity' => $this->input->post('quantity'),
                'total_cost' => Applib::format_deci($sub_total + $item_tax_total),
                'item_name' => $this->input->post('item_name'),
                'display' => ('on' == $this->input->post('display')) ? 'Yes' : 'No',
                'item_features' => $this->input->post('item_features', false),
                'unit_cost' => $this->input->post('unit_cost'),
                'order_by' => $this->input->post('order_by'),
            ];

            if ('addon' == $item) {
                $data['apply_to'] = serialize($this->input->post('apply_to'));
                $data['item_desc'] = $this->input->post('item_desc', true);
                $data['create_account'] = 'No';
                $data['addon'] = 1;
                $category = 5;
            } else {
                $category = $this->input->post('category');
            }

            if ($this->input->post('server')) {
                $data['server'] = $this->input->post('server');
            }

            if ($this->input->post('max_years')) {
                $data['max_years'] = $this->input->post('max_years');
            }
            if ($this->input->post('setup_fee')) {
                $data['setup_fee'] = $this->input->post('setup_fee');
            }
            if ($this->input->post('require_domain')) {
                $data['require_domain'] = ('on' == $this->input->post('require_domain')) ? 'Yes' : 'No';
            }
            if ($this->input->post('allow_upgrade')) {
                $data['allow_upgrade'] = ('on' == $this->input->post('allow_upgrade')) ? 'Yes' : 'No';
            }
            if ($this->input->post('price_change')) {
                $data['price_change'] = ('on' == $this->input->post('price_change')) ? 'Yes' : 'No';
            }
            if ($this->input->post('reseller_package')) {
                $data['reseller_package'] = ('on' == $this->input->post('reseller_package')) ? 'Yes' : 'No';
            }
            if ($this->input->post('default_registrar')) {
                $data['default_registrar'] = $this->input->post('default_registrar');
            }
            if ($this->input->post('create_account')) {
                $data['create_account'] = ('on' == $this->input->post('create_account')) ? 'Yes' : 'No';
            }

            if ('hosting' == $item) {
                $data['create_account'] = 'Yes';
            }

            if ($this->db->insert('items_saved', $data)) {
                $id = $this->db->insert_id();

                $pricing = [
                    'item_id' => $id,
                    'category' => $category,
                    'monthly' => $this->input->post('monthly'),
                    'quarterly' => $this->input->post('quarterly'),
                    'semi_annually' => $this->input->post('semi_annually'),
                    'annually' => $this->input->post('annually'),
                    'biennially' => $this->input->post('biennially'),
                    'triennially' => $this->input->post('triennially'),
                    'registration' => $this->input->post('registration'),
                    'transfer' => $this->input->post('transfer'),
                    'renewal' => $this->input->post('renewal'),
                ];

                if ($this->input->post('monthly_payments')) {
                    $pricing['monthly_payments'] = $this->input->post('monthly_payments');
                }
                if ($this->input->post('quarterly_payments')) {
                    $pricing['quarterly_payments'] = $this->input->post('quarterly_payments');
                }
                if ($this->input->post('semi_annually_payments')) {
                    $pricing['semi_annually_payments'] = $this->input->post('semi_annually_payments');
                }
                if ($this->input->post('annually_payments')) {
                    $pricing['annually_payments'] = $this->input->post('annually_payments');
                }
                if ($this->input->post('biennially_payments')) {
                    $pricing['biennially_payments'] = $this->input->post('biennially_payments');
                }
                if ($this->input->post('triennially_payments')) {
                    $pricing['triennially_payments'] = $this->input->post('triennially_payments');
                }

                $this->db->insert('item_pricing', $pricing);
            }

            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('item_added_successfully'));
            redirect($this->input->post('r_url'));
        } else {
            $data['form'] = true;
            $data['categories'] = App::get_by_where('categories', ['parent >' => '7']);
            $data['rates'] = App::get_by_where('tax_rates', []);
            $data['servers'] = $this->db->get('servers')->result();
            $this->load->view('modal/add_'.$item, $data);
        }
    }

    public function edit_hosting($id = null): void
    {
        $this->edit_item($id, 'hosting');
    }

    public function edit_domain($id = null): void
    {
        $this->edit_item($id, 'domain');
    }

    public function edit_service($id = null): void
    {
        $this->edit_item($id, 'service');
    }

    public function edit_addon($id = null): void
    {
        $this->edit_item($id, 'addon');
    }

    public function edit_item($id = null, $item = null): void
    {
        App::module_access('menu_items');
        if ($this->input->post()) {
            Applib::is_demo();

            if ($this->input->post('unit_cost')) {
                $sub_total = $this->input->post('unit_cost') * $this->input->post('quantity');
            } else {
                $sub_total = 0;
            }

            $item_tax_rate = $this->input->post('item_tax_rate');
            $item_tax_total = Applib::format_deci(($item_tax_rate / 100) * $sub_total);

            $data = [
                'item_tax_rate' => $item_tax_rate,
                'item_tax_total' => $item_tax_total,
                'quantity' => $this->input->post('quantity'),
                'total_cost' => Applib::format_deci($sub_total + $item_tax_total),
                'item_name' => $this->input->post('item_name'),
                'default_registrar' => $this->input->post('default_registrar'),
                'display' => ('on' == $this->input->post('display')) ? 'Yes' : 'No',
                'item_features' => $this->input->post('item_features', false),
                'unit_cost' => $this->input->post('unit_cost'),
                'order_by' => $this->input->post('order_by'),
            ];

            if ($this->input->post('max_years')) {
                $data['max_years'] = $this->input->post('max_years');
            }
            if ($this->input->post('setup_fee')) {
                $data['setup_fee'] = $this->input->post('setup_fee');
            }
            if ($this->input->post('require_domain')) {
                $data['require_domain'] = ('on' == $this->input->post('require_domain')) ? 'Yes' : 'No';
            }
            if ($this->input->post('allow_upgrade')) {
                $data['allow_upgrade'] = ('on' == $this->input->post('allow_upgrade')) ? 'Yes' : 'No';
            }
            if ($this->input->post('price_change')) {
                $data['price_change'] = ('on' == $this->input->post('price_change')) ? 'Yes' : 'No';
            }
            if ($this->input->post('reseller_package')) {
                $data['reseller_package'] = ('on' == $this->input->post('reseller_package')) ? 'Yes' : 'No';
            }
            if ($this->input->post('default_registrar')) {
                $data['default_registrar'] = $this->input->post('default_registrar');
            }
            if ($this->input->post('create_account')) {
                $data['create_account'] = ('on' == $this->input->post('create_account')) ? 'Yes' : 'No';
            }

            if ('addon' == $item) {
                $data['apply_to'] = serialize($this->input->post('apply_to'));
                $data['item_desc'] = $this->input->post('item_desc', true);
                $data['create_account'] = 'No';
                $data['addon'] = 1;
                $category = 5;
            } else {
                $category = $this->input->post('category');
            }

            $this->db->where('item_id', $this->input->post('item_id'));
            if ($this->db->update('items_saved', $data)) {
                $pricing = [
                    'category' => $category,
                    'monthly' => $this->input->post('monthly'),
                    'quarterly' => $this->input->post('quarterly'),
                    'semi_annually' => $this->input->post('semi_annually'),
                    'annually' => $this->input->post('annually'),
                    'biennially' => $this->input->post('biennially'),
                    'triennially' => $this->input->post('triennially'),
                    'registration' => $this->input->post('registration'),
                    'transfer' => $this->input->post('transfer'),
                    'renewal' => $this->input->post('renewal'),
                ];

                if ($this->input->post('monthly_payments')) {
                    $pricing['monthly_payments'] = $this->input->post('monthly_payments');
                }
                if ($this->input->post('quarterly_payments')) {
                    $pricing['quarterly_payments'] = $this->input->post('quarterly_payments');
                }
                if ($this->input->post('semi_annually_payments')) {
                    $pricing['semi_annually_payments'] = $this->input->post('semi_annually_payments');
                }
                if ($this->input->post('annually_payments')) {
                    $pricing['annually_payments'] = $this->input->post('annually_payments');
                }
                if ($this->input->post('biennially_payments')) {
                    $pricing['biennially_payments'] = $this->input->post('biennially_payments');
                }
                if ($this->input->post('triennially_payments')) {
                    $pricing['triennially_payments'] = $this->input->post('triennially_payments');
                }

                $this->db->where('item_id', $this->input->post('item_id'));
                $this->db->update('item_pricing', $pricing);
            }

            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('operation_successful'));
            redirect($this->input->post('r_url'));
        } else {
            $data['categories'] = App::get_by_where('categories', ['parent >' => '7']);
            $data['rates'] = App::get_by_where('tax_rates', []);
            $data['id'] = $id;
            $this->load->view('modal/edit_'.$item, $data);
        }
    }

    public function package($id = null): void
    {
        App::module_access('menu_items');
        if ($this->input->post()) {
            Applib::is_demo();
            $data['package_config'] = serialize($this->input->post());
            $data['server'] = $this->input->post('server_id');
            $data['package_name'] = $this->input->post('package');
            $this->db->where('item_id', $this->input->post('item_id'));

            if ($this->db->update('items_saved', $data)) {
                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('operation_successful'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $this->can_access();
            $this->template->title(lang('items').' - '.config_item('company_name'));
            $data['page'] = Item::view_item($id)->item_name;
            $data['servers'] = $this->db->get('servers')->result();
            $data['id'] = $id;
            $this->template
                ->set_layout('users')
                ->build('package', $data ?? null)
            ;
        }
    }

    public function delete_hosting($id = null): void
    {
        $this->delete_item($id, 'hosting');
    }

    public function delete_domain($id = null): void
    {
        $this->delete_item($id, 'domains');
    }

    public function delete_service($id = null): void
    {
        $this->delete_item($id, 'service');
    }

    public function delete_addon($id = null): void
    {
        $this->delete_item($id, 'addon');
    }

    public function delete_item($id = null, $item = null): void
    {
        App::module_access('menu_items');
        if ($this->input->post()) {
            Applib::is_demo();
            $item_id = $this->input->post('item', true);
            App::delete('items_saved', ['item_id' => $item_id]);
            App::delete('item_pricing', ['item_id' => $item_id]);

            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('item_deleted_successfully'));
            redirect('addon' == $item ? 'addons' : $this->input->post('r_url'));
        } else {
            $data['item_id'] = $id;
            $data['item'] = $item;
            $this->load->view('modal/delete_item', $data);
        }
    }

    public function item_links($id = null): void
    {
        $data['id'] = $id;
        $this->load->view('modal/item_links', $data);
    }

    public function affiliates($id = null): void
    {
        if ($this->input->post()) {
            $data['commission'] = $this->input->post('commission');
            $data['commission_payout'] = $this->input->post('commission_payout');
            $data['commission_amount'] = $this->input->post('commission_amount');
            $this->db->where('item_id', $this->input->post('item_id'));

            if ($this->db->update('items_saved', $data)) {
                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('operation_successful'));
                redirect($this->input->post('r_url'));
            }
        } else {
            $data['id'] = $id;
            $this->load->view('modal/item_affiliates', $data);
        }
    }

    public function items_block($id): void
    {
        $category = $this->db->where('id', $id)->where('parent >', '7')->get('categories')->row();
        $items = [];

        if (8 == $category->parent) {
            $items = Item::get_domains($id);
            $view = 'domains_block';
        }

        if (9 == $category->parent) {
            $items = Item::get_hosting($id);
            $view = 'hosting_block';
        }

        if (10 == $category->parent) {
            $items = Item::get_services($id);
            $view = 'services_block';
        }

        $data['items'] = $items;
        $data['style'] = $category->pricing_table;
        $this->load->view(config_item('active_theme').'/views/blocks/'.$view, $data);
    }
}

// End of file items.php
