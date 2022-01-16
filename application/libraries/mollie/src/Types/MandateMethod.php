<?php

declare(strict_types=1);

namespace Mollie\Api\Types;

class MandateMethod
{
    public const DIRECTDEBIT = 'directdebit';
    public const CREDITCARD = 'creditcard';

    public static function getForFirstPaymentMethod($firstPaymentMethod)
    {
        if (\in_array($firstPaymentMethod, [\Mollie\Api\Types\PaymentMethod::APPLEPAY, \Mollie\Api\Types\PaymentMethod::CREDITCARD])) {
            return static::CREDITCARD;
        }

        return static::DIRECTDEBIT;
    }
}
