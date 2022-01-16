<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Settings extends Hosting_Billing
{
    public function __construct()
    {
        parent::__construct();
        User::logged_in();
        if (!User::is_admin() && !User::perm_allowed(User::get_id(), 'edit_settings')) {
            redirect('dashboard');
        }

        $this->invoice_logo_height = 0;
        $this->invoice_logo_width = 0;
        $this->load->library(['form_validation']);

        $this->auth_key = config_item('api_key'); // Set our API KEY

        $this->load->module('layouts');
        $this->load->library('template');
        $this->template->title(lang('settings').' - '.config_item('company_name'));

        $this->load->model(['Setting']);

        $this->general_setting = '?settings=general';
        $this->domain_setting = '?settings=domain';
        $this->invoice_setting = '?settings=invoice';
        $this->system_setting = '?settings=system';
        $this->theme_setting = '?settings=theme';
        $this->language_files = [
            'hd_lang.php' => './application/',
            'tank_auth_lang.php' => './application/',
            'calendar_lang.php' => './system/',
            'date_lang.php' => './system/',
            'db_lang.php' => './system/',
            'email_lang.php' => './system/',
            'form_validation_lang.php' => './system/',
            'ftp_lang.php' => './system/',
            'imglib_lang.php' => './system/',
            'migration_lang.php' => './system/',
            'number_lang.php' => './system/',
            'profiler_lang.php' => './system/',
            'unit_test_lang.php' => './system/',
            'upload_lang.php' => './system/',
        ];

        $this->applib->set_locale();
    }

    public function index(): void
    {
        $settings = $this->input->get('settings', true) ? $this->input->get('settings', true) : 'general';
        $data['page'] = lang('settings');
        $data['form'] = true;
        $data['editor'] = true;
        $data['fuelux'] = true;
        $data['datatables'] = true;
        $data['nouislider'] = true;
        $data['translations'] = $this->applib->translations();
        $data['available'] = $this->available_translations();
        $data['languages'] = App::languages();
        $data['load_setting'] = $settings;
        $data['locale_name'] = App::get_locale()->name;

        if ('system' == $settings) {
            $data['countries'] = App::countries();
            $data['locales'] = App::locales();
            $data['currencies'] = App::currencies();
            $data['timezones'] = Setting::timezones();
        }
        if ('menu' == $settings) {
            $data['iconpicker'] = true;
            $data['sortable'] = true;
            $data['admin'] = $this->db->where('hook', 'main_menu_admin')->where('parent', '')->where('access', 1)->order_by('order', 'ASC')->get('hooks')->result();
            $data['client'] = $this->db->where('hook', 'main_menu_client')->where('parent', '')->where('access', 2)->order_by('order', 'ASC')->get('hooks')->result();
            $data['staff'] = $this->db->where('hook', 'main_menu_staff')->where('parent', '')->where('access', 3)->order_by('order', 'ASC')->get('hooks')->result();
        }
        if ('crons' == $settings) {
            $data['crons'] = $this->db->where('hook', 'cron_job_admin')->where('access', 1)->order_by('name', 'ASC')->get('hooks')->result();
        }
        if ('general' == $settings) {
            $data['countries'] = App::countries();
        }

        if ('domain' == $settings) {
            $data['countries'] = App::countries();
        }

        if ('sms_templates' == $settings) {
            $data['templates'] = $this->db->get('sms_templates')->result();
        }

        if ('theme' == $settings) {
            $data['iconpicker'] = true;
        }

        if ('translations' == $settings) {
            $action = $this->uri->segment(3);
            $data['translation_stats'] = $this->Setting->translation_stats($this->language_files);
            if ('view' == $action) {
                $data['language'] = $this->uri->segment(4);
                $data['language_files'] = $this->language_files;
            }
            if ('edit' == $action) {
                $language = $this->uri->segment(4);
                $file = $this->uri->segment(5);
                $path = $this->language_files[$file.'_lang.php'];
                $data['language'] = $language;
                $data['english'] = $this->lang->load($file, 'english', true, true, $path);
                if ('english' == $language) {
                    $data['translation'] = $data['english'];
                } else {
                    $data['translation'] = $this->lang->load($file, $language, true, true);
                }
                $data['language_file'] = $file;
            }
        }

        $this->template
            ->set_layout('users')
            ->build('settings', $data ?? null)
        ;
    }

    public function vE(): void
    {
        Settings::_vP();
    }

    public function templates(): void
    {
        if ($_POST) {
            Applib::is_demo();
            $group = $this->input->post('email_group', true);
            $data = ['subject' => $this->input->post('subject'),
                'template_body' => $this->input->post('email_template'),
            ];
            Setting::update_template($group, $data);

            $return_url = $_POST['return_url'];

            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('settings_updated_successfully'));
            redirect($return_url);
        } else {
            $this->index();
        }
    }

    public function _sms_templates(): void
    {
        if ($_POST) {
            Applib::is_demo();
            $template = $this->input->post('template', true);
            $this->db->where('type', $template)->update('sms_templates', ['body' => $this->input->post('sms_template')]);
            $return_url = $_POST['return_url'];

            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('settings_updated_successfully'));
            redirect($return_url);
        } else {
            $this->index();
        }
    }

    public function customize(): void
    {
        $this->load->helper('file');
        if ($_POST) {
            $data = $_POST['css-area'];
            if (write_file('./resource/css/style.css', $data)) {
                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('settings_updated_successfully'));
                redirect('settings/?settings=customize');
            } else {
                $this->session->set_flashdata('response_status', 'error');
                $this->session->set_flashdata('message', lang('operation_failed'));
                redirect('settings/?settings=customize');
            }
        } else {
            $this->index();
        }
    }

    public function add_currency(): void
    {
        if ($_POST) {
            if ('0' == $this->db->where('code', $this->input->post('code'))->get('currencies')->num_rows()) {
                App::save_data('currencies', $this->input->post());
                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('currency_added_successfully'));
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->session->set_flashdata('response_status', 'error');
                $this->session->set_flashdata('message', lang('currency_code_exists'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $this->load->view('modal_add_currency', $data ?? null);
        }
    }

    public function xrates(): void
    {
        if ($_POST) {
            $this->db->where('config_key', 'xrates_app_id')->update('config', ['value' => $this->input->post('xrates_app_id')]);
            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('currency_updated_successfully'));
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function edit_currency($code = null): void
    {
        if ($_POST) {
            $prev_code = $this->input->post('oldcode');
            unset($_POST['oldcode']);
            $this->db->where('code', $prev_code)->update('currencies', $this->input->post());
            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('currency_updated_successfully'));
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data['code'] = $code;
            $this->load->view('modal_edit_currency', $data ?? null);
        }
    }

    public function add_category(): void
    {
        if ($_POST) {
            Applib::is_demo();

            if ('0' == $this->db->where('cat_name', $this->input->post('cat_name'))->get('categories')->num_rows()) {
                if ($category_id = App::save_data('categories', $this->input->post())) {
                    $this->add_block($category_id);
                }

                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('category_added_successfully'));
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->session->set_flashdata('response_status', 'error');
                $this->session->set_flashdata('message', lang('category_exists'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $this->load->view('modal_add_category', $data ?? null);
        }
    }

    public function edit_category($id = null): void
    {
        if ($_POST) {
            Applib::is_demo();

            $id = $this->input->post('id');

            switch ($this->input->post('delete_cat')) {
                case 'on':
                    $this->db->where('id', $id)->delete('categories');
                    App::delete('blocks_modules', ['param' => 'items_'.$id, 'module' => 'Items']);
                    App::delete('blocks_modules', ['param' => 'faq_'.$id, 'module' => 'FAQ']);

                    $block = $this->db->where('id', 'items_'.$id)->where('module', 'Items')->get('blocks')->row();
                    if ($block) {
                        App::delete('blocks', ['id' => 'items_'.$id, 'module' => 'Items']);
                        App::delete('blocks_pages', ['block_id' => $block->block_id]);
                    }

                    $block = $this->db->where('id', 'items_'.$id)->where('module', 'Items')->get('blocks')->row();
                    if ($block) {
                        App::delete('blocks', ['id' => 'faq_'.$id, 'module' => 'FAQ']);
                        App::delete('blocks_pages', ['block_id' => $block->block_id]);
                    }

                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', lang('operation_successful'));

                    break;

                default:
                    unset($_POST['delete_cat']);
                    $this->db->where('id', $id)->update('categories', $this->input->post());

                    if ('0' == $this->db->where('param', 'items_'.$id)->where('module', 'Items')->get('blocks_modules')->num_rows()
                        && '0' == $this->db->where('param', 'faq_'.$id)->where('module', 'FAQ')->get('blocks_modules')->num_rows()) {
                        $this->add_block($id);
                    } else {
                        $data = [
                            'name' => $this->input->post('cat_name'),
                        ];

                        App::update('blocks_modules', ['param' => 'items_'.$id, 'module' => 'Items'], $data);
                        App::update('blocks_modules', ['param' => 'faq_'.$id, 'module' => 'FAQ'], $data);
                    }
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', lang('category_updated_successfully'));

                    break;
            }
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data['cat'] = $id;
            $this->load->view('modal_edit_category', $data ?? null);
        }
    }

    public function add_block($category_id): void
    {
        $category = $this->db->where('id', $category_id)->get('categories')->row();
        $list = [8, 9, 10];
        if (in_array($category->parent, $list)) {
            $data = [
                'name' => $this->input->post('cat_name'),
                'param' => 'items_'.$category_id,
                'type' => 'Module',
                'module' => 'Items',
            ];

            App::save_data('blocks_modules', $data);
        }

        if (6 == $category->parent) {
            $data = [
                'name' => $this->input->post('cat_name'),
                'param' => 'faq_'.$category_id,
                'type' => 'Module',
                'module' => 'FAQ',
            ];

            App::save_data('blocks_modules', $data);
        }
    }

    public function _vP(): void
    {
        Applib::pData();
        $data = ['value' => 'TRUE'];
        Applib::update('config', ['config_key' => 'valid_license'], $data);
        Applib::make_flashdata(
            [
                'response_status' => 'success',
                'message' => 'Software validated successfully', ]
        );
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function departments(): void
    {
        if ($_POST) {
            $settings = $_POST['settings'];
            unset($_POST['settings']);
            App::save_data('departments', $this->input->post());

            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('department_added_successfully'));
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->index();
        }
    }

    public function add_custom_field(): void
    {
        if ($_POST) {
            if (isset($_POST['targetdept'])) {
                // select department and redirect to creating field
                Applib::go_to('settings/?settings=fields&dept='.$_POST['targetdept'], 'success', 'Department selected');
            } else {
                $_POST['uniqid'] = $this->_GenerateUniqueFieldValue();
                App::save_data('fields', $this->input->post());

                Applib::go_to('settings/?settings=fields&dept='.$_POST['deptid'], 'success', 'Custom field added');
                // Insert to database additional fields
            }
        }
    }

    public function edit_custom_field($field = null): void
    {
        if ($_POST) {
            if (isset($_POST['delete_field']) and 'on' == $_POST['delete_field']) {
                $this->db->where('id', $_POST['id'])->delete('fields');
                Applib::go_to($_SERVER['HTTP_REFERER'], 'success', lang('custom_field_deleted'));
            } else {
                $this->db->where('id', $_POST['id'])->update('fields', $this->input->post());
                Applib::go_to($_SERVER['HTTP_REFERER'], 'success', lang('custom_field_updated'));
            }
        } else {
            $data['field_info'] = $this->db->where(['id' => $field])->get('fields')->result();
            $this->load->view('fields/modal_edit_field', $data ?? null);
        }
    }

    public function edit_dept($deptid = null): void
    {
        if ($_POST) {
            if (isset($_POST['delete_dept']) and 'on' == $_POST['delete_dept']) {
                $this->db->where('deptid', $_POST['deptid'])->delete('departments');
                Applib::go_to($_SERVER['HTTP_REFERER'], 'success', lang('department_deleted'));
            } else {
                $this->db->where('deptid', $_POST['deptid'])->update('departments', $this->input->post());
                Applib::go_to($_SERVER['HTTP_REFERER'], 'success', lang('department_updated'));
            }
        } else {
            $data['deptid'] = $deptid;
            $data['dept_info'] = $this->db->where(['deptid' => $deptid])->get('departments')->result();
            $this->load->view('modal_edit_department', $data ?? null);
        }
    }

    public function translations()
    {
        $action = $this->uri->segment(3);

        if ($_POST) {
            if ('save' == $action) {
                $jpost = [];
                $jsondata = json_decode(html_entity_decode($_POST['json']));
                foreach ($jsondata as $jdata) {
                    $jpost[$jdata->name] = $jdata->value;
                }
                $jpost['_path'] = $this->language_files[$jpost['_file'].'_lang.php'];
                $data['json'] = $this->Setting->save_translation($jpost);
                $this->load->view('json', $data ?? null);

                return;
            }
            if ('active' == $action) {
                $language = $this->uri->segment(4);

                return $this->db->where('name', $language)->update('languages', $this->input->post());
            }
        } else {
            if ('add' == $action) {
                $language = $this->uri->segment(4);
                $this->Setting->add_translation($language, $this->language_files);
                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('translation_added_successfully'));
                redirect($_SERVER['HTTP_REFERER']);
            }
            if ('backup' == $action) {
                $language = $this->uri->segment(4);

                return $this->Setting->backup_translation($language, $this->language_files);
            }
            if ('restore' == $action) {
                $language = $this->uri->segment(4);

                return $this->Setting->restore_translation($language, $this->language_files);
            }

            $this->index();
        }
    }

    public function available_translations()
    {
        $available = [];
        $ex = App::languages();
        foreach ($ex as $e) {
            $existing[] = $e->name;
        }
        $ln = $this->db->group_by('language')->get('locales')->result();
        foreach ($ln as $l) {
            if (!in_array($l->language, $existing)) {
                $available[] = $l;
            }
        }

        return $available;
    }

    public function update(): void
    {
        if ($_POST) {
            Applib::is_demo();

            switch ($_POST['settings']) {
                case 'general':
                    $this->_update_general_settings($this->general_setting);

                    break;

                case 'search':
                    $this->_search_settings();

                    break;

                case 'sms':
                    $this->_sms_settings();

                    break;

                case 'sms_templates':
                    $this->_sms_templates();

                    break;

                case 'email':
                    $this->_update_email_settings();

                    break;

                case 'payments':
                    $this->_update_payment_settings();

                    break;

                case 'registrars':
                    $this->_update_registrar_settings();

                    break;

                case 'domain':
                    $this->_update_domain_settings();

                    break;

                case 'system':
                    $this->_update_system_settings('system');

                    break;

                case 'theme':
                    if (file_exists($_FILES['iconfile']['tmp_name']) || is_uploaded_file($_FILES['iconfile']['tmp_name'])) {
                        $this->upload_favicon($this->input->post());
                    }
                    if (file_exists($_FILES['appleicon']['tmp_name']) || is_uploaded_file($_FILES['appleicon']['tmp_name'])) {
                        $this->upload_appleicon($this->input->post());
                    }
                    if (file_exists($_FILES['logofile']['tmp_name']) || is_uploaded_file($_FILES['logofile']['tmp_name'])) {
                        $this->upload_logo($this->input->post());
                    }
                    if (file_exists($_FILES['loginbg']['tmp_name']) || is_uploaded_file($_FILES['loginbg']['tmp_name'])) {
                        $this->upload_login_bg($this->input->post());
                    }
                    $this->_update_theme_settings('theme');

                    break;

                case 'crons':
                    $this->_update_cron_settings();

                    break;

                case 'invoice':
                    if (file_exists($_FILES['invoicelogo']['tmp_name']) || is_uploaded_file($_FILES['invoicelogo']['tmp_name'])) {
                        $this->upload_invoice_logo($this->input->post());
                    }
                    $this->_update_invoice_settings('invoice');

                    break;
            }
        } else {
            $this->index();
        }
    }

    public function _update_general_settings($setting): void
    {
        Applib::is_demo();

        $this->form_validation->set_rules('company_name', 'Company Name', 'required');
        $this->form_validation->set_rules('company_address', 'Company Address', 'required');
        if (false == $this->form_validation->run()) {
            $this->session->set_flashdata('response_status', 'error');
            $this->session->set_flashdata('message', lang('settings_update_failed'));
            redirect('settings/'.$this->general_setting);
        } else {
            foreach ($_POST as $key => $value) {
                $data = ['value' => $value];
                $this->db->where('config_key', $key)->update('config', $data);
                $exists = $this->db->where('config_key', $key)->get('config');
                if (0 == $exists->num_rows()) {
                    $this->db->insert('config', ['config_key' => $key, 'value' => $value]);
                }
            }
            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('settings_updated_successfully'));
            redirect('settings/'.$this->general_setting);
        }
    }

    public function _search_settings(): void
    {
        Applib::is_demo();

        foreach ($_POST as $key => $value) {
            if ('on' == strtolower($value)) {
                $value = 'TRUE';
            } elseif ('off' == strtolower($value)) {
                $value = 'FALSE';
            }

            $data = ['value' => $value];
            $this->db->where('config_key', $key)->update('config', $data);
            $exists = $this->db->where('config_key', $key)->get('config');
            if (0 == $exists->num_rows()) {
                $this->db->insert('config', ['config_key' => $key, 'value' => $value]);
            }
        }
        $this->session->set_flashdata('response_status', 'success');
        $this->session->set_flashdata('message', lang('settings_updated_successfully'));
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function _update_cron_settings(): void
    {
        Applib::is_demo();

        $this->form_validation->set_rules('cron_key', 'Cron Key', 'required');
        if (false == $this->form_validation->run()) {
            $this->session->set_flashdata('response_status', 'error');
            $this->session->set_flashdata('message', lang('settings_update_failed'));
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->load->library('encryption');
            $this->encryption->initialize(
                [
                    'cipher' => 'aes-256',
                    'driver' => 'openssl',
                    'mode' => 'ctr',
                ]
            );
            $_POST['mail_password'] = $this->encryption->encrypt($this->input->post('mail_password'));

            foreach ($_POST as $key => $value) {
                if ('on' == strtolower($value)) {
                    $value = 'TRUE';
                } elseif ('off' == strtolower($value)) {
                    $value = 'FALSE';
                }
                $data = ['value' => $value];

                $this->db->where('config_key', $key)->update('config', $data);
            }
            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('settings_updated_successfully'));
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function _update_system_settings($setting): void
    {
        Applib::is_demo();

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span><br>');
        $this->form_validation->set_rules('file_max_size', 'File Max Size', 'required');
        if (false == $this->form_validation->run()) {
            $this->session->set_flashdata('response_status', 'error');
            $this->session->set_flashdata('message', lang('settings_update_failed'));
            $this->session->set_flashdata('form_error', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            foreach ($_POST as $key => $value) {
                if ('on' == strtolower($value)) {
                    $value = 'TRUE';
                } elseif ('off' == strtolower($value)) {
                    $value = 'FALSE';
                }
                $data = ['value' => $value];
                $this->db->where('config_key', $key)->update('config', $data);
            }

            //Set date format for date picker
            switch ($_POST['date_format']) {
                case '%d-%m-%Y': $picker = 'dd-mm-yyyy'; $phptime = 'd-m-Y';

break;

                case '%m-%d-%Y': $picker = 'mm-dd-yyyy'; $phptime = 'm-d-Y';

break;

                case '%Y-%m-%d': $picker = 'yyyy-mm-dd'; $phptime = 'Y-m-d';

break;

                case '%d.%m.%Y': $picker = 'dd.mm.yyyy'; $phptime = 'd.m.Y';

break;

                case '%m.%d.%Y': $picker = 'mm.dd.yyyy'; $phptime = 'm.d.Y';

break;

                case '%Y.%m.%d': $picker = 'yyyy.mm.dd'; $phptime = 'Y.m.d';

break;
            }
            $this->db->where('config_key', 'date_picker_format')->update('config', ['value' => $picker]);
            $this->db->where('config_key', 'date_php_format')->update('config', ['value' => $phptime]);

            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('settings_updated_successfully'));
            redirect('settings/'.$this->system_setting);
        }
    }

    public function _update_theme_settings($setting): void
    {
        Applib::is_demo();
        foreach ($_POST as $key => $value) {
            if ('on' == strtolower($value)) {
                $value = 'TRUE';
            } elseif ('off' == strtolower($value)) {
                $value = 'FALSE';
            }
            $this->db->where('config_key', $key)->update('config', ['value' => $value]);
        }
        $this->session->set_flashdata('response_status', 'success');
        $this->session->set_flashdata('message', lang('settings_updated_successfully'));
        redirect('settings/'.$this->theme_setting);
    }

    public function _update_invoice_settings($setting): void
    {
        Applib::is_demo();

        $this->form_validation->set_rules('invoice_color', 'Invoice Color', 'required');
        if (false == $this->form_validation->run()) {
            $this->session->set_flashdata('response_status', 'error');
            $this->session->set_flashdata('message', lang('settings_update_failed'));
            redirect('settings/'.$this->invoice_setting);
        } else {
            foreach ($_POST as $key => $value) {
                if ('on' == strtolower($value)) {
                    $value = 'TRUE';
                } elseif ('off' == strtolower($value)) {
                    $value = 'FALSE';
                }
                if ('invoice_logo_height' == $key && $this->invoice_logo_height > 0) {
                    $value = $this->invoice_logo_height;
                }
                if ('invoice_logo_width' == $key && $this->invoice_logo_width > 0) {
                    $value = $this->invoice_logo_width;
                }
                $data = ['value' => $value];
                $this->db->where('config_key', $key)->update('config', $data);
            }
            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('settings_updated_successfully'));
            redirect('settings/'.$this->invoice_setting);
        }
    }

    public function _update_email_settings(): void
    {
        Applib::is_demo();

        $this->load->library('form_validation');
        $this->load->library('encryption');
        $this->encryption->initialize(
            [
                'cipher' => 'aes-256',
                'driver' => 'openssl',
                'mode' => 'ctr',
            ]
        );
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span><br>');
        $this->form_validation->set_rules('settings', 'Settings', 'required');
        if (false == $this->form_validation->run()) {
            $this->session->set_flashdata('response_status', 'error');
            $this->session->set_flashdata('form_error', validation_errors());
            $this->session->set_flashdata('message', lang('settings_update_failed'));
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            foreach ($_POST as $key => $value) {
                if ('on' == strtolower($value)) {
                    $value = 'TRUE';
                } elseif ('off' == strtolower($value)) {
                    $value = 'FALSE';
                }

                $data = ['value' => $value];
                App::update('config', ['config_key' => $key], $data);
            }
            if (isset($_POST['smtp_pass'])) {
                $raw_smtp_pass = $this->input->post('smtp_pass');
                $smtp_pass = $this->encryption->encrypt($raw_smtp_pass);
                $data = ['value' => $smtp_pass];
                App::update('config', ['config_key' => 'smtp_pass'], $data);
            }

            if (isset($_POST['mail_password'])) {
                $raw_mail_pass = $this->input->post('mail_password');
                $mail_pass = $this->encryption->encrypt($raw_mail_pass);
                $data = ['value' => $mail_pass];
                App::update('config', ['config_key' => 'mail_password'], $data);
            }

            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('settings_updated_successfully'));
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function _sms_settings(): void
    {
        Applib::is_demo();

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span><br>');
        $this->form_validation->set_rules('settings', 'Settings', 'required');
        if (false == $this->form_validation->run()) {
            $this->session->set_flashdata('response_status', 'error');
            $this->session->set_flashdata('form_error', validation_errors());
            $this->session->set_flashdata('message', lang('settings_update_failed'));
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            foreach ($_POST as $key => $value) {
                if ('on' == strtolower($value)) {
                    $value = 'TRUE';
                } elseif ('off' == strtolower($value)) {
                    $value = 'FALSE';
                }

                $data = ['value' => $value];
                App::update('config', ['config_key' => $key], $data);
            }

            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('settings_updated_successfully'));
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function send_test(): void
    {
        if ($this->input->post()) {
            $phone = trim($this->input->post('phone'));
            $message = $this->input->post('message');

            $result = send_sms($phone, $message);

            $this->session->set_flashdata('response_status', 'info');
            $this->session->set_flashdata('message', $result);
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->load->view('modal_send_sms', []);
        }
    }

    public function _update_payment_settings(): void
    {
        if ($this->input->post()) {
            Applib::is_demo();

            foreach ($_POST as $key => $value) {
                if ('on' == strtolower($value)) {
                    $value = 'TRUE';
                } elseif ('off' == strtolower($value)) {
                    $value = 'FALSE';
                }

                $data = ['value' => $value];
                $this->db->where('config_key', $key)->update('config', $data);
            }

            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('settings_updated_successfully'));
            redirect('settings/?settings=payments');
        } else {
            $this->session->set_flashdata('response_status', 'error');
            $this->session->set_flashdata('message', lang('settings_update_failed'));
            redirect('settings/?settings=payments');
        }
    }

    public function _update_domain_settings(): void
    {
        if ($this->input->post()) {
            Applib::is_demo();

            foreach ($_POST as $key => $value) {
                if ('on' == strtolower($value)) {
                    $value = 'TRUE';
                } elseif ('off' == strtolower($value)) {
                    $value = 'FALSE';
                }

                $data = ['value' => $value];
                $this->db->where('config_key', $key)->update('config', $data);
            }

            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('settings_updated_successfully'));
            redirect('settings/?settings=domain');
        } else {
            $this->session->set_flashdata('response_status', 'error');
            $this->session->set_flashdata('message', lang('settings_update_failed'));
            redirect('settings/?settings=domain');
        }
    }

    public function _update_registrar_settings(): void
    {
        if ($this->input->post()) {
            Applib::is_demo();

            foreach ($_POST as $key => $value) {
                if ('on' == strtolower($value)) {
                    $value = 'TRUE';
                } elseif ('off' == strtolower($value)) {
                    $value = 'FALSE';
                }

                $data = ['value' => $value];
                $this->db->where('config_key', $key)->update('config', $data);
            }

            $this->session->set_flashdata('response_status', 'success');
            $this->session->set_flashdata('message', lang('settings_updated_successfully'));
            redirect('registrars');
        } else {
            $this->session->set_flashdata('response_status', 'error');
            $this->session->set_flashdata('message', lang('settings_update_failed'));
            redirect('registrars');
        }
    }

    public function update_email_templates(): void
    {
        if ($this->input->post()) {
            Applib::is_demo();

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span><br>');
            $this->form_validation->set_rules('email_invoice_message', 'Invoice Message', 'required');
            $this->form_validation->set_rules('reminder_message', 'Reminder Message', 'required');
            if (false == $this->form_validation->run()) {
                $this->session->set_flashdata('response_status', 'error');
                $this->session->set_flashdata('message', lang('settings_update_failed'));
                $_POST = '';
                $this->update('email');
            } else {
                foreach ($_POST as $key => $value) {
                    $data = ['value' => $value];
                    $this->db->where('config_key', $key)->update('config', $data);
                }

                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('settings_updated_successfully'));
                redirect('settings/update/email');
            }
        } else {
            $this->session->set_flashdata('response_status', 'error');
            $this->session->set_flashdata('message', lang('settings_update_failed'));
            redirect('settings/update/email');
        }
    }

    public function upload_favicon($files)
    {
        Applib::is_demo();

        if ($files) {
            $config['upload_path'] = './resource/images/';
            $config['allowed_types'] = 'jpg|jpeg|png|ico';
            $config['max_width'] = '300';
            $config['max_height'] = '300';
            $config['overwrite'] = true;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('iconfile')) {
                $data = $this->upload->data();
                $file_name = $data['file_name'];
                $data = ['value' => $file_name];
                $this->db->where('config_key', 'site_favicon')->update('config', $data);

                return true;
            }
            $this->session->set_flashdata('response_status', 'error');
            $this->session->set_flashdata('message', lang('logo_upload_error'));
            redirect('settings/'.$this->theme_setting);
        } else {
            return false;
        }
    }

    public function upload_appleicon($files)
    {
        Applib::is_demo();

        if ($files) {
            $config['upload_path'] = './resource/images/';
            $config['allowed_types'] = 'jpg|jpeg|png|ico';
            $config['overwrite'] = true;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('appleicon')) {
                $data = $this->upload->data();
                $file_name = $data['file_name'];
                $data = ['value' => $file_name];
                $this->db->where('config_key', 'site_appleicon')->update('config', $data);

                return true;
            }
            $this->session->set_flashdata('response_status', 'error');
            $this->session->set_flashdata('message', lang('logo_upload_error'));
            redirect('settings/'.$this->theme_setting);
        } else {
            return false;
        }
    }

    public function upload_logo($files)
    {
        Applib::is_demo();

        if ($files) {
            $config['upload_path'] = './resource/images/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['remove_spaces'] = true;

            $config['overwrite'] = true;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('logofile')) {
                $filedata = $this->upload->data();
                $file_name = $filedata['file_name'];
                $data = ['value' => $file_name];
                $this->db->where('config_key', 'company_logo')->update('config', $data);
                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('file_uploaded_successfully'));
                redirect('settings/'.$this->theme_setting);

                return true;
            }
            $this->session->set_flashdata('response_status', 'error');
            $this->session->set_flashdata('message', lang('logo_upload_error'));
            redirect('settings/'.$this->theme_setting);
        } else {
            return false;
        }
    }

    public function upload_login_bg($files)
    {
        Applib::is_demo();

        if ($files) {
            $config['upload_path'] = './resource/images/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_width'] = '0';
            $config['max_height'] = '0';
            $config['remove_spaces'] = true;
            $config['overwrite'] = true;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('loginbg')) {
                $filedata = $this->upload->data();
                $file_name = $filedata['file_name'];
                $data = ['value' => $file_name];
                $this->db->where('config_key', 'login_bg')->update('config', $data);
                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', lang('file_uploaded_successfully'));
                redirect('settings/'.$this->theme_setting);

                return true;
            }
            $this->session->set_flashdata('response_status', 'error');
            $this->session->set_flashdata('message', lang('logo_upload_error'));
            redirect('settings/'.$this->theme_setting);
        } else {
            return false;
        }
    }

    public function upload_invoice_logo($files)
    {
        Applib::is_demo();

        if ($files) {
            $config['upload_path'] = './resource/images/logos/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_width'] = '800';
            $config['max_height'] = '300';
            $config['remove_spaces'] = true;
            $config['overwrite'] = true;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('invoicelogo')) {
                $filedata = $this->upload->data();
                $file_name = $filedata['file_name'];
                $size = getimagesize('./resource/images/logos/'.$file_name);
                $ratio = $size[1] / $size[0];
                $height = 60;
                if ($size[1] < $height) {
                    $height = $size[1];
                }
                $width = intval($height / $ratio);
                $this->invoice_logo_height = $height;
                $this->invoice_logo_width = $width;
                $this->db->where('config_key', 'invoice_logo')->update('config', ['value' => $file_name]);

                return true;
            }
            $this->session->set_flashdata('response_status', 'error');
            $this->session->set_flashdata('message', lang('logo_upload_error'));
            redirect('settings/'.$this->invoice_setting);
        } else {
            return false;
        }
    }

    public function _GenerateUniqueFieldValue()
    {
        $uniqid = uniqid('f');
        // Id should start with an character other than digit

        $this->db->where('uniqid', $uniqid)->get('fields');

        if ($this->db->affected_rows() > 0) {
            $this->GetUniqueFieldValue();
        // Recursion
        } else {
            return $uniqid;
        }
    }

    public function database(): void
    {
        Applib::is_demo();
        $this->load->helper('file');
        $this->load->dbutil();
        $prefs = [
            'format' => 'zip',             // gzip, zip, txt
            'filename' => 'database-full-backup_'.date('Y-m-d').'.zip',
            'add_drop' => true,              // Whether to add DROP TABLE statements to backup file
            'add_insert' => true,              // Whether to add INSERT data to backup file
            'newline' => "\n",               // Newline character used in backup file
        ];
        $backup = &$this->dbutil->backup($prefs);

        if (!write_file('./resource/backup/database-full-backup_'.date('Y-m-d').'.zip', $backup)) {
            $this->session->set_flashdata('response_status', 'error');
            $this->session->set_flashdata('message', 'The resource/backup folder is not writable.');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->helper('download');
        force_download('database-full-backup_'.date('Y-m-d').'.zip', $backup);
    }

    public function skin()
    {
        $skin = $this->input->post('skin');

        return $this->db->where('config_key', 'top_bar_color')->update('config', ['value' => $skin]);
    }

    public function hook($action, $item)
    {
        switch ($action) {
            case 'visible':
                $role = $this->input->post('access');
                $visible = $this->input->post('visible');

                return $this->db->where('module', $item)->where('access', $role)->update('hooks', ['visible' => $visible]);

            case 'enabled':
                $role = $this->input->post('access');
                $enabled = $this->input->post('enabled');

                return $this->db->where('module', $item)->where('access', $role)->update('hooks', ['enabled' => $enabled]);

            case 'icon':
                $role = $this->input->post('access');
                $icon = $this->input->post('icon');

                return $this->db->where('module', $item)->where('access', $role)->update('hooks', ['icon' => $icon]);

            case 'reorder':
                $items = $this->input->post('json', true);
                $items = json_decode($items);
                foreach ($items[0] as $i => $mod) {
                    $this->db->where('module', $mod->module)->where('access', $mod->access)->update('hooks', ['order' => $i + 1]);
                }

                return true;
        }

        return false;
    }
}

// End of file settings.php
