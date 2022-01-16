<?php

declare(strict_types=1);
(defined('BASEPATH')) or exit('No direct script access allowed');

// load the MX_Loader class
require APPPATH.'third_party/MX/Loader.php';

class MY_Loader extends MX_Loader
{
    public function __construct()
    {
        $this->_ci_view_paths = [FCPATH.'themes/' => true] + $this->_ci_view_paths;
    }
}
