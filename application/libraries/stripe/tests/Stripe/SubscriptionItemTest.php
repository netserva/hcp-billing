<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class SubscriptionItemTest extends TestCase
{
    public const TEST_RESOURCE_ID = 'si_123';

    public function testIsListable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/subscription_items'
        );
        $resources = SubscriptionItem::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\SubscriptionItem', $resources->data[0]);
    }

    public function testIsRetrievable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/subscription_items/'.self::TEST_RESOURCE_ID
        );
        $resource = SubscriptionItem::retrieve(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\SubscriptionItem', $resource);
    }

    public function testIsCreatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/subscription_items'
        );
        $resource = SubscriptionItem::create([
            'plan' => 'plan',
            'subscription' => 'sub_123',
        ]);
        $this->assertInstanceOf('Stripe\\SubscriptionItem', $resource);
    }

    public function testIsSaveable(): void
    {
        $resource = SubscriptionItem::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/v1/subscription_items/'.$resource->id
        );
        $resource->save();
        $this->assertInstanceOf('Stripe\\SubscriptionItem', $resource);
    }

    public function testIsUpdatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/subscription_items/'.self::TEST_RESOURCE_ID
        );
        $resource = SubscriptionItem::update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        $this->assertInstanceOf('Stripe\\SubscriptionItem', $resource);
    }

    public function testIsDeletable(): void
    {
        $resource = SubscriptionItem::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'delete',
            '/v1/subscription_items/'.$resource->id
        );
        $resource->delete();
        $this->assertInstanceOf('Stripe\\SubscriptionItem', $resource);
    }
}
