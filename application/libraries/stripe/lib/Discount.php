<?php

declare(strict_types=1);

namespace Stripe;

/**
 * Class Discount.
 *
 * @property string $object
 * @property Coupon $coupon
 * @property string $customer
 * @property int    $end
 * @property int    $start
 * @property string $subscription
 */
class Discount extends StripeObject
{
    public const OBJECT_NAME = 'discount';
}
