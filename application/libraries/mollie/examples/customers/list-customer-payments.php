<?php

declare(strict_types=1);

namespace _PhpScoper5ed105407e8f2;

// How to retrieve your customers' payments history.
try {
    /*
     * Initialize the Mollie API library with your API key.
     *
     * See: https://www.mollie.com/dashboard/developers/api-keys
     */
    require '../initialize.php';
    // Determine the url parts to these example files.
    $protocol = isset($_SERVER['HTTPS']) && 0 !== \strcasecmp('off', $_SERVER['HTTPS']) ? 'https' : 'http';
    $hostname = $_SERVER['HTTP_HOST'];
    $path = \dirname($_SERVER['REQUEST_URI'] ?? $_SERVER['PHP_SELF']);
    /*
     * Retrieve the last created customer for this example.
     * If no customers are created yet, run create-customer example.
     */
    $customer = $mollie->customers->page(null, 1)[0];
    // Get the all payments for this API key ordered by newest.
    $payments = $customer->payments();
    echo '<ul>';
    foreach ($payments as $payment) {
        echo '<li>';
        echo "<strong style='font-family: monospace'>".\htmlspecialchars($payment->id).'</strong><br />';
        echo \htmlspecialchars($payment->description).'<br />';
        echo \htmlspecialchars($payment->amount->currency).' '.\htmlspecialchars($payment->amount->value).'<br />';
        echo 'Status: '.\htmlspecialchars($payment->status).'<br />';
        if ($payment->hasRefunds()) {
            echo 'Payment has been (partially) refunded.<br />';
        }
        if ($payment->hasChargebacks()) {
            echo 'Payment has been charged back.<br />';
        }
        if ($payment->canBeRefunded() && 'EUR' === $payment->amountRemaining->currency && $payment->amountRemaining->value >= '2.00') {
            echo " (<a href=\"{$protocol}://{$hostname}{$path}/payments/refund-payment.php?payment_id=".\htmlspecialchars($payment->id).'">refund</a>)';
        }
        echo '</li>';
    }
    echo '</ul>';
} catch (\Mollie\Api\Exceptions\ApiException $e) {
    echo 'API call failed: '.\htmlspecialchars($e->getMessage());
}
