<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class PayoutTest extends TestCase
{
    public const TEST_RESOURCE_ID = 'po_123';

    public function testIsListable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/payouts'
        );
        $resources = Payout::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\Payout', $resources->data[0]);
    }

    public function testIsRetrievable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/payouts/'.self::TEST_RESOURCE_ID
        );
        $resource = Payout::retrieve(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\Payout', $resource);
    }

    public function testIsCreatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/payouts'
        );
        $resource = Payout::create([
            'amount' => 100,
            'currency' => 'usd',
        ]);
        $this->assertInstanceOf('Stripe\\Payout', $resource);
    }

    public function testIsSaveable(): void
    {
        $resource = Payout::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/v1/payouts/'.self::TEST_RESOURCE_ID
        );
        $resource->save();
        $this->assertInstanceOf('Stripe\\Payout', $resource);
    }

    public function testIsUpdatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/payouts/'.self::TEST_RESOURCE_ID
        );
        $resource = Payout::update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        $this->assertInstanceOf('Stripe\\Payout', $resource);
    }

    public function testIsCancelable(): void
    {
        $resource = Payout::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/payouts/'.$resource->id.'/cancel'
        );
        $resource->cancel();
        $this->assertInstanceOf('Stripe\\Payout', $resource);
    }
}
