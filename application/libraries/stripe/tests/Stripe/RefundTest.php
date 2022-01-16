<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class RefundTest extends TestCase
{
    public const TEST_RESOURCE_ID = 're_123';

    public function testIsListable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/refunds'
        );
        $resources = Refund::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\Refund', $resources->data[0]);
    }

    public function testIsRetrievable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/refunds/'.self::TEST_RESOURCE_ID
        );
        $resource = Refund::retrieve(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\Refund', $resource);
    }

    public function testIsCreatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/refunds'
        );
        $resource = Refund::create([
            'charge' => 'ch_123',
        ]);
        $this->assertInstanceOf('Stripe\\Refund', $resource);
    }

    public function testIsSaveable(): void
    {
        $resource = Refund::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/v1/refunds/'.self::TEST_RESOURCE_ID
        );
        $resource->save();
        $this->assertInstanceOf('Stripe\\Refund', $resource);
    }

    public function testIsUpdatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/refunds/'.self::TEST_RESOURCE_ID
        );
        $resource = Refund::update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        $this->assertInstanceOf('Stripe\\Refund', $resource);
    }
}
