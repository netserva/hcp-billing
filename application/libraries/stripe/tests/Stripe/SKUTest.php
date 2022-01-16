<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class SKUTest extends TestCase
{
    public const TEST_RESOURCE_ID = 'sku_123';

    public function testIsListable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/skus'
        );
        $resources = SKU::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\SKU', $resources->data[0]);
    }

    public function testIsRetrievable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/skus/'.self::TEST_RESOURCE_ID
        );
        $resource = SKU::retrieve(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\SKU', $resource);
    }

    public function testIsCreatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/skus'
        );
        $resource = SKU::create([
            'currency' => 'usd',
            'inventory' => [
                'type' => 'finite',
                'quantity' => 1,
            ],
            'price' => 100,
            'product' => 'prod_123',
        ]);
        $this->assertInstanceOf('Stripe\\SKU', $resource);
    }

    public function testIsSaveable(): void
    {
        $resource = SKU::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/v1/skus/'.self::TEST_RESOURCE_ID
        );
        $resource->save();
        $this->assertInstanceOf('Stripe\\SKU', $resource);
    }

    public function testIsUpdatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/skus/'.self::TEST_RESOURCE_ID
        );
        $resource = SKU::update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        $this->assertInstanceOf('Stripe\\SKU', $resource);
    }

    public function testIsDeletable(): void
    {
        $resource = SKU::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'delete',
            '/v1/skus/'.self::TEST_RESOURCE_ID
        );
        $resource->delete();
        $this->assertInstanceOf('Stripe\\SKU', $resource);
    }
}
