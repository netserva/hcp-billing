<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Layouts extends MX_Controller
{
    public function index(): void
    {
        $this->load->library('template');
    }
}

//end
