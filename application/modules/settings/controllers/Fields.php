<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Fields extends Hosting_Billing
{
    public function __construct()
    {
        parent::__construct();
        $this->load->module('layouts');
        $this->load->library('template');
        $this->template->title(lang('settings').' - '.config_item('company_name'));
        $this->load->model(['Setting']);
        $this->applib->set_locale();

        User::logged_in();
        if (!User::is_admin()) {
            redirect('');
        }
    }

    public function index(): void
    {
        $data['page'] = lang('settings');
        $data['formbuilder'] = true;
        $data['load_setting'] = 'fields';
        $this->template
            ->set_layout('users')
            ->build('fields/custom.php', $data ?? null)
        ;
    }

    public function module(): void
    {
        $data['page'] = lang('settings');
        $data['formbuilder'] = true;
        $data['load_setting'] = 'fields';
        if ($_POST) {
            if (isset($_POST['module'])) {
                $data['module'] = $this->input->post('module');
                $data['department'] = ($this->input->post('department')) ? $this->input->post('department') : null;
            }
        } else {
            $module = $_GET['mod'] ?? '';
            if ('' != $module) {
                $data['module'] = $module;
            }
        }
        $data['fields'] = $this->db->order_by('order', 'DESC')->where('module', $data['module'])->get('fields')->result();
        $this->template
            ->set_layout('users')
            ->build('fields/custom.php', $data ?? null)
        ;
    }

    public function saveform(): void
    {
        $this->load->helper(['inflector']);
        $module = $_POST['module'];
        $fields = json_decode($_POST['formcontent'], true);
        $this->db->where('module', $module)->delete('fields');
        $order = 1;
        foreach ($fields['fields'] as $key => $f) {
            $id_exist = 0;
            if (isset($f->uniqid)) {
                $this->db->where('uniqid', $f['uniqid'])->get('fields');
                $id_exist = $this->db->affected_rows();
            }
            $uniqid = (0 == $id_exist) ? Applib::generate_unique_value() : $f['uniqid'];
            $data = [
                'label' => $f['label'],
                'module' => $module,
                'deptid' => $_POST['deptid'],
                'name' => underscore(clean($f['label'])),
                'uniqid' => $uniqid,
                'type' => $f['field_type'],
                'required' => $f['required'],
                'field_options' => json_encode($f['field_options']),
                'cid' => $f['cid'],
                'order' => $order++,
            ];
            (0 == $id_exist) ? $this->db->insert('fields', $data) : $this->db->where('uniqid', $f['uniqid'])->update('fields', $data);
        }
        redirect('settings/fields/module?mod='.$module);
    }
}
