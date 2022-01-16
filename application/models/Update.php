<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Update extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        require_once FCPATH.'/core/core_config.php';

        require_once FCPATH.'/core/core_updates.php';
    }

    public static function get_versions()
    {
        return ausGetAllVersions();
    }

    public static function version($id)
    {
        return ausGetVersion($id);
    }

    public static function install($id)
    {
        return ausDownloadFile('version_upgrade_file', $id);
    }

    public static function database($id)
    {
        return ausFetchQuery('upgrade', $id);
    }

    public static function update_database()
    {
        return ausFetchQuery();
    }

    private static function _p($msg): void
    {
        $ci = &get_instance();
        $ci->session->set_flashdata('response_status', 'error');
        $ci->session->set_flashdata('message', $msg);
        redirect('updates');
    }
}

// End of file update_model.php
