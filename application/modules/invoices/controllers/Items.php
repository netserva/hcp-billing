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
        User::logged_in();

        $this->load->library(['form_validation']);
        $this->load->model(['Invoice', 'App', 'Client']);

        $this->applib->set_locale();
    }

    public function add(): void
    {
        if ($this->input->post()) {
            $invoice_id = $this->input->post('invoice_id', true);
            $this->form_validation->set_rules('invoice_id', 'Invoice ID', 'required');
            $this->form_validation->set_rules('item_name', 'Item Name', 'required');
            $this->form_validation->set_rules('quantity', 'Quantity', 'required');
            $this->form_validation->set_rules('unit_cost', 'Unit Cost', 'required');

            if (false == $this->form_validation->run()) {
                $_POST = '';
                Applib::go_to('invoices/view/'.$invoice_id, 'error', lang('error_in_form'));
            } else {
                $item_name = $this->input->post('item_name', true);
                $sub_total = $this->input->post('unit_cost') * $this->input->post('quantity');
                $tax_rate = $this->input->post('item_tax_rate');

                if ('0.00' == $tax_rate) {
                    if ($row = $this->db->where('item_name', $item_name)->get('items_saved')->row()) {
                        $tax_rate = $row->item_tax_rate;
                    }
                }
                $item_tax_total = Applib::format_deci(($tax_rate / 100) * $sub_total);
                $total_cost = Applib::format_deci($sub_total + $item_tax_total);

                $data = [
                    'invoice_id' => $this->input->post('invoice_id', true),
                    'item_name' => $item_name,
                    'item_desc' => $this->input->post('item_desc', true),
                    'unit_cost' => $this->input->post('unit_cost', true),
                    'item_order' => $this->input->post('item_order', true),
                    'item_tax_rate' => $tax_rate,
                    'item_tax_total' => $item_tax_total,
                    'quantity' => $this->input->post('quantity', true),
                    'total_cost' => $total_cost,
                ];
                // unset($_POST['tax']);

                if (App::save_data('items', $data)) {
                    Applib::go_to('invoices/view/'.$invoice_id, 'success', lang('item_added_successfully'));
                }
            }
        }
    }

    public function edit(): void
    {
        if ($this->input->post()) {
            $item_id = $this->input->post('item_id', true);
            $invoice_id = Invoice::view_item($item_id)->invoice_id;

            $this->form_validation->set_rules('invoice_id', 'Invoice ID', 'required');
            $this->form_validation->set_rules('item_name', 'Item Name', 'required');
            $this->form_validation->set_rules('quantity', 'Quantity', 'required');
            $this->form_validation->set_rules('unit_cost', 'Unit Cost', 'required');

            if (false == $this->form_validation->run()) {
                $_POST = '';
                Applib::go_to('invoices/view/'.$invoice_id, 'error', lang('error_in_form'));
            } else {
                $sub_total = $this->input->post('unit_cost') * $this->input->post('quantity');
                $tax_rate = $this->input->post('item_tax_rate');
                $item_tax_total = Applib::format_deci(($tax_rate / 100) * $sub_total);

                $total_cost = Applib::format_deci($sub_total + $item_tax_total);

                $data = [
                    'invoice_id' => $this->input->post('invoice_id', true),
                    'item_name' => $this->input->post('item_name', true),
                    'item_desc' => $this->input->post('item_desc', true),
                    'unit_cost' => $this->input->post('unit_cost', true),
                    'item_tax_rate' => $tax_rate,
                    'item_tax_total' => $item_tax_total,
                    'quantity' => $this->input->post('quantity', true),
                    'total_cost' => $total_cost,
                ];

                if (App::update('items', ['item_id' => $item_id], $data)) {
                    Applib::go_to('invoices/view/'.$invoice_id, 'success', lang('item_added_successfully'));
                }
            }
        } else {
            $data['id'] = $this->uri->segment(4);
            $this->load->view('modal/edit_item', $data);
        }
    }

    public function insert(): void
    {
        if ($this->input->post()) {
            $invoice = $this->input->post('invoice', true);

            $this->form_validation->set_rules('item', 'Item Name', 'required');

            if (false == $this->form_validation->run()) {
                Applib::go_to('invoices/view/'.$invoice, 'error', lang('operation_failed'));
            } else {
                $item = $this->input->post('item', true);
                $saved_item = $this->db->where(['item_id' => $item])->get('items_saved')->row();

                $items = Invoice::has_items($invoice);

                $form_data = [
                    'invoice_id' => $invoice,
                    'item_name' => $saved_item->item_name,
                    'item_desc' => $saved_item->item_desc,
                    'unit_cost' => $saved_item->unit_cost,
                    'item_tax_rate' => $saved_item->item_tax_rate,
                    'item_tax_total' => $saved_item->item_tax_total,
                    'quantity' => $saved_item->quantity,
                    'total_cost' => $saved_item->total_cost,
                    'item_order' => count($items) + 1,
                ];
                if (App::save_data('items', $form_data)) {
                    Applib::go_to('invoices/view/'.$invoice, 'success', lang('item_added_successfully'));
                }
            }
        } else {
            $data['invoice'] = $this->uri->segment(4);
            $this->load->view('modal/quickadd', $data);
        }
    }

    public function delete(): void
    {
        if ($this->input->post()) {
            $item_id = $this->input->post('item', true);
            $invoice = $this->input->post('invoice', true);
            if (App::delete('items', ['item_id' => $item_id])) {
                Applib::go_to('invoices/view/'.$invoice, 'success', lang('item_deleted_successfully'));
            }
        } else {
            $data['item_id'] = $this->uri->segment(4);
            $data['invoice'] = $this->uri->segment(5);
            $this->load->view('modal/delete_item', $data);
        }
    }

    public function reorder(): void
    {
        if ($this->input->post()) {
            $items = $this->input->post('json', true);
            $items = json_decode($items);
            foreach ($items[0] as $ix => $item) {
                App::update('items', ['item_id' => $item->id], ['item_order' => $ix + 1]);
            }
        }
        $data['json'] = $items;
        $this->load->view('json', $data ?? null);
    }
}

// End of file invoices.php
