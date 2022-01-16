<?php

declare(strict_types=1);

namespace Stripe;

/**
 * Class OrderItem.
 *
 * @property string $object
 * @property int    $amount
 * @property string $currency
 * @property string $description
 * @property string $parent
 * @property int    $quantity
 * @property string $type
 */
class OrderItem extends StripeObject
{
    public const OBJECT_NAME = 'order_item';
}
