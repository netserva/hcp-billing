<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Fopdf extends Hosting_Billing
{
    public function __construct()
    {
        parent::__construct();
        User::logged_in();

        $this->load->helper('invoicer');
        $this->applib->set_locale();
    }

    public function invoice($invoice_id = null): void
    {
        $data['id'] = $invoice_id;
        $this->load->view('invoice_pdf', $data ?? null);
    }

    public function attach_invoice($invoice)
    {
        $data['id'] = $invoice['inv_id'];
        $data['attach'] = true;

        return $this->load->view('invoice_pdf', $data ?? null, true);
    }
}

// End of file fopdf.php
