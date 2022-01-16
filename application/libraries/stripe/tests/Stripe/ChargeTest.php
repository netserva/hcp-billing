<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class ChargeTest extends TestCase
{
    public const TEST_RESOURCE_ID = 'ch_123';

    public function testIsListable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/charges'
        );
        $resources = Charge::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\Charge', $resources->data[0]);
    }

    public function testIsRetrievable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/charges/'.self::TEST_RESOURCE_ID
        );
        $resource = Charge::retrieve(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\Charge', $resource);
    }

    public function testIsCreatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/charges'
        );
        $resource = Charge::create([
            'amount' => 100,
            'currency' => 'usd',
            'source' => 'tok_123',
        ]);
        $this->assertInstanceOf('Stripe\\Charge', $resource);
    }

    public function testIsSaveable(): void
    {
        $resource = Charge::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/v1/charges/'.$resource->id
        );
        $resource->save();
        $this->assertInstanceOf('Stripe\\Charge', $resource);
    }

    public function testIsUpdatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/charges/'.self::TEST_RESOURCE_ID
        );
        $resource = Charge::update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        $this->assertInstanceOf('Stripe\\Charge', $resource);
    }

    public function testCanRefund(): void
    {
        $charge = Charge::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/charges/'.$charge->id.'/refund'
        );
        $resource = $charge->refund();
        $this->assertInstanceOf('Stripe\\Charge', $resource);
        $this->assertSame($resource, $charge);
    }

    public function testCanCapture(): void
    {
        $charge = Charge::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/charges/'.$charge->id.'/capture'
        );
        $resource = $charge->capture();
        $this->assertInstanceOf('Stripe\\Charge', $resource);
        $this->assertSame($resource, $charge);
    }

    public function testCanUpdateDispute(): void
    {
        $charge = Charge::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/charges/'.$charge->id.'/dispute'
        );
        $resource = $charge->updateDispute();
        $this->assertInstanceOf('Stripe\\Dispute', $resource);
    }

    public function testCanCloseDispute(): void
    {
        $charge = Charge::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/charges/'.$charge->id.'/dispute/close'
        );
        $resource = $charge->closeDispute();
        $this->assertInstanceOf('Stripe\\Charge', $resource);
        $this->assertSame($resource, $charge);
    }

    public function testCanMarkAsFraudulent(): void
    {
        $charge = Charge::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/charges/'.$charge->id,
            ['fraud_details' => ['user_report' => 'fraudulent']]
        );
        $resource = $charge->markAsFraudulent();
        $this->assertInstanceOf('Stripe\\Charge', $resource);
        $this->assertSame($resource, $charge);
    }

    public function testCanMarkAsSafe(): void
    {
        $charge = Charge::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/charges/'.$charge->id,
            ['fraud_details' => ['user_report' => 'safe']]
        );
        $resource = $charge->markAsSafe();
        $this->assertInstanceOf('Stripe\\Charge', $resource);
        $this->assertSame($resource, $charge);
    }
}
