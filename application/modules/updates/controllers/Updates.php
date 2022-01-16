<?php

declare(strict_types=1);

class Updates extends Hosting_Billing
{
    public function __construct()
    {
        parent::__construct();
        if (!User::is_admin() && !User::perm_allowed(User::get_id(), 'edit_settings')) {
            redirect('dashboard');
        }

        if (User::is_client()) {
            Applib::go_to('dashboard', 'error', lang('access_denied'));
        }

        $this->load->module('layouts');
        $this->load->library(['template']);
        $this->load->model('Update');
    }

    public function index(): void
    {
        $this->template->title('Updates '.config_item('company_name'));
        $data['page'] = 'Updates';
        $data['plugins'] = Plugin::active_plugins();
        $this->template
            ->set_layout('users')
            ->build('index', $data ?? null)
        ;
    }

    public function version($id): void
    {
        $this->template->title('Update '.config_item('company_name'));
        $data['page'] = 'Version Information';
        $data['version_notifications_array'] = Update::version($id);
        $data['version'] = $id;
        $this->template
            ->set_layout('users')
            ->build('version', $data ?? null)
        ;
    }

    public function install($id): void
    {
        $this->template->title('Update '.config_item('company_name'));
        $data['page'] = 'Update Information';
        $data['version_notifications_array'] = $this->process($id);
        $data['status'] = '';
        $this->template
            ->set_layout('users')
            ->build('update', $data ?? null)
        ;
    }

    public function process($id)
    {
        $response = Update::install($id);

        if ('notification_operation_ok' == $response['notification_case']) {
            $database = Update::database($id);

            if ('notification_operation_ok' == $database['notification_case']) {
                $sql = trim($database['notification_data']);
                if ('' != $sql) {
                    $sqls = explode(';', $sql);
                    array_pop($sqls);

                    $this->db->trans_start();
                    foreach ($sqls as $statement) {
                        $statment = trim($statement).';';
                        $this->db->query($statement);
                    }
                    $this->db->trans_complete();
                }
            }
        }

        return $response;
    }
}
