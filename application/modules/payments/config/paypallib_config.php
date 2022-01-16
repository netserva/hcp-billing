<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

// ------------------------------------------------------------------------
// Ppal (Paypal IPN Class)
// ------------------------------------------------------------------------

// If (and where) to log ipn to file
$config['paypal_lib_ipn_log_file'] = BASEPATH.'logs/paypal_ipn.log';
$config['paypal_lib_ipn_log'] = true;

// Where are the buttons located at
$config['paypal_lib_button_path'] = 'resource/paypal/buttons';
