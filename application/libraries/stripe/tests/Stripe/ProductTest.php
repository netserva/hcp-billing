<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class ProductTest extends TestCase
{
    public const TEST_RESOURCE_ID = 'prod_123';

    public function testIsListable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/products'
        );
        $resources = Product::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\Product', $resources->data[0]);
    }

    public function testIsRetrievable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/products/'.self::TEST_RESOURCE_ID
        );
        $resource = Product::retrieve(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\Product', $resource);
    }

    public function testIsCreatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/products'
        );
        $resource = Product::create([
            'name' => 'name',
        ]);
        $this->assertInstanceOf('Stripe\\Product', $resource);
    }

    public function testIsSaveable(): void
    {
        $resource = Product::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/v1/products/'.self::TEST_RESOURCE_ID
        );
        $resource->save();
        $this->assertInstanceOf('Stripe\\Product', $resource);
    }

    public function testIsUpdatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/products/'.self::TEST_RESOURCE_ID
        );
        $resource = Product::update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        $this->assertInstanceOf('Stripe\\Product', $resource);
    }

    public function testIsDeletable(): void
    {
        $resource = Product::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'delete',
            '/v1/products/'.self::TEST_RESOURCE_ID
        );
        $resource->delete();
        $this->assertInstanceOf('Stripe\\Product', $resource);
    }
}
