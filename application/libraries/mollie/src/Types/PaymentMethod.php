<?php

declare(strict_types=1);

namespace Mollie\Api\Types;

class PaymentMethod
{
    /**
     * @see https://www.mollie.com/en/payments/applepay
     */
    public const APPLEPAY = 'applepay';
    /**
     * @see https://www.mollie.com/en/payments/bancontact
     */
    public const BANCONTACT = 'bancontact';
    /**
     * @see https://www.mollie.com/en/payments/bank-transfer
     */
    public const BANKTRANSFER = 'banktransfer';
    /**
     * @see https://www.mollie.com/en/payments/belfius
     */
    public const BELFIUS = 'belfius';
    /**
     * @deprecated 2019-05-01
     */
    public const BITCOIN = 'bitcoin';
    /**
     * @see https://www.mollie.com/en/payments/credit-card
     */
    public const CREDITCARD = 'creditcard';
    /**
     * @see https://www.mollie.com/en/payments/direct-debit
     */
    public const DIRECTDEBIT = 'directdebit';
    /**
     * @see https://www.mollie.com/en/payments/eps
     */
    public const EPS = 'eps';
    /**
     * @see https://www.mollie.com/en/payments/gift-cards
     */
    public const GIFTCARD = 'giftcard';
    /**
     * @see https://www.mollie.com/en/payments/giropay
     */
    public const GIROPAY = 'giropay';
    /**
     * @see https://www.mollie.com/en/payments/ideal
     */
    public const IDEAL = 'ideal';
    /**
     * @see https://www.mollie.com/en/payments/ing-homepay
     */
    public const INGHOMEPAY = 'inghomepay';
    /**
     * @see https://www.mollie.com/en/payments/kbc-cbc
     */
    public const KBC = 'kbc';
    /**
     * @see https://www.mollie.com/en/payments/klarna-pay-later
     */
    public const KLARNA_PAY_LATER = 'klarnapaylater';
    /**
     * @see https://www.mollie.com/en/payments/klarna-slice-it
     */
    public const KLARNA_SLICE_IT = 'klarnasliceit';
    /**
     * @see https://www.mollie.com/en/payments/mybank
     */
    public const MYBANK = 'mybank';
    /**
     * @see https://www.mollie.com/en/payments/paypal
     */
    public const PAYPAL = 'paypal';
    /**
     * @see https://www.mollie.com/en/payments/paysafecard
     */
    public const PAYSAFECARD = 'paysafecard';
    /**
     * @see https://www.mollie.com/en/payments/przelewy24
     */
    public const PRZELEWY24 = 'przelewy24';
    /**
     * @deprecated
     * @see https://www.mollie.com/en/payments/gift-cards
     */
    public const PODIUMCADEAUKAART = 'podiumcadeaukaart';
    /**
     * @see https://www.mollie.com/en/payments/sofort
     */
    public const SOFORT = 'sofort';
}
