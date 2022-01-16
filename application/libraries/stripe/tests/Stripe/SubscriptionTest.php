<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class SubscriptionTest extends TestCase
{
    public const TEST_RESOURCE_ID = 'sub_123';

    public function testIsListable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/subscriptions'
        );
        $resources = Subscription::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\Subscription', $resources->data[0]);
    }

    public function testIsRetrievable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/subscriptions/'.self::TEST_RESOURCE_ID
        );
        $resource = Subscription::retrieve(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\Subscription', $resource);
    }

    public function testIsCreatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/subscriptions'
        );
        $resource = Subscription::create([
            'customer' => 'cus_123',
            'plan' => 'plan',
        ]);
        $this->assertInstanceOf('Stripe\\Subscription', $resource);
    }

    public function testIsSaveable(): void
    {
        $resource = Subscription::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/v1/subscriptions/'.$resource->id
        );
        $resource->save();
        $this->assertInstanceOf('Stripe\\Subscription', $resource);
    }

    public function testIsUpdatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/subscriptions/'.self::TEST_RESOURCE_ID
        );
        $resource = Subscription::update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        $this->assertInstanceOf('Stripe\\Subscription', $resource);
    }

    public function testIsCancelable(): void
    {
        $resource = Subscription::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'delete',
            '/v1/subscriptions/'.$resource->id
        );
        $resource->cancel();
        $this->assertInstanceOf('Stripe\\Subscription', $resource);
    }

    public function testCanDeleteDiscount(): void
    {
        $resource = Subscription::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'delete',
            '/v1/subscriptions/'.$resource->id.'/discount'
        );
        $resource->deleteDiscount();
        $this->assertInstanceOf('Stripe\\Subscription', $resource);
    }
}
