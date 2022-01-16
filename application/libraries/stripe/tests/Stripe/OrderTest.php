<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class OrderTest extends TestCase
{
    public const TEST_RESOURCE_ID = 'or_123';

    public function testIsListable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/orders'
        );
        $resources = Order::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\Order', $resources->data[0]);
    }

    public function testIsRetrievable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/orders/'.self::TEST_RESOURCE_ID
        );
        $resource = Order::retrieve(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\Order', $resource);
    }

    public function testIsCreatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/orders'
        );
        $resource = Order::create([
            'currency' => 'usd',
        ]);
        $this->assertInstanceOf('Stripe\\Order', $resource);
    }

    public function testIsSaveable(): void
    {
        $resource = Order::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/v1/orders/'.self::TEST_RESOURCE_ID
        );
        $resource->save();
        $this->assertInstanceOf('Stripe\\Order', $resource);
    }

    public function testIsUpdatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/orders/'.self::TEST_RESOURCE_ID
        );
        $resource = Order::update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        $this->assertInstanceOf('Stripe\\Order', $resource);
    }

    public function testIsPayable(): void
    {
        $resource = Order::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/orders/'.self::TEST_RESOURCE_ID.'/pay'
        );
        $resource->pay();
        $this->assertInstanceOf('Stripe\\Order', $resource);
    }

    public function testIsReturnable(): void
    {
        $order = Order::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/orders/'.self::TEST_RESOURCE_ID.'/returns'
        );
        $resource = $order->returnOrder();
        $this->assertInstanceOf('Stripe\\OrderReturn', $resource);
    }
}
