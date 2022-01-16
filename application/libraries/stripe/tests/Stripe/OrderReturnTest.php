<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class OrderReturnTest extends TestCase
{
    public const TEST_RESOURCE_ID = 'orret_123';

    public function testIsListable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/order_returns'
        );
        $resources = OrderReturn::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\OrderReturn', $resources->data[0]);
    }

    public function testIsRetrievable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/order_returns/'.self::TEST_RESOURCE_ID
        );
        $resource = OrderReturn::retrieve(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\OrderReturn', $resource);
    }
}
