<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class TransferTest extends TestCase
{
    public const TEST_RESOURCE_ID = 'tr_123';
    public const TEST_REVERSAL_ID = 'trr_123';

    public function testIsListable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/transfers'
        );
        $resources = Transfer::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\Transfer', $resources->data[0]);
    }

    public function testIsRetrievable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/transfers/'.self::TEST_RESOURCE_ID
        );
        $resource = Transfer::retrieve(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\Transfer', $resource);
    }

    public function testIsCreatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/transfers'
        );
        $resource = Transfer::create([
            'amount' => 100,
            'currency' => 'usd',
            'destination' => 'acct_123',
        ]);
        $this->assertInstanceOf('Stripe\\Transfer', $resource);
    }

    public function testIsSaveable(): void
    {
        $resource = Transfer::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/v1/transfers/'.$resource->id
        );
        $resource->save();
        $this->assertInstanceOf('Stripe\\Transfer', $resource);
    }

    public function testIsUpdatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/transfers/'.self::TEST_RESOURCE_ID
        );
        $resource = Transfer::update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        $this->assertInstanceOf('Stripe\\Transfer', $resource);
    }

    public function testIsReversable(): void
    {
        $resource = Transfer::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/transfers/'.$resource->id.'/reversals'
        );
        $resource->reverse();
        $this->assertInstanceOf('Stripe\\Transfer', $resource);
    }

    public function testIsCancelable(): void
    {
        $transfer = Transfer::retrieve(self::TEST_RESOURCE_ID);

        // stripe-mock does not support this anymore so we stub it
        $this->stubRequest(
            'post',
            '/v1/transfers/'.$transfer->id.'/cancel'
        );
        $resource = $transfer->cancel();
        $this->assertInstanceOf('Stripe\\Transfer', $resource);
        $this->assertSame($resource, $transfer);
    }

    public function testCanCreateReversal(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/transfers/'.self::TEST_RESOURCE_ID.'/reversals'
        );
        $resource = Transfer::createReversal(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\TransferReversal', $resource);
    }

    public function testCanRetrieveReversal(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/transfers/'.self::TEST_RESOURCE_ID.'/reversals/'.self::TEST_REVERSAL_ID
        );
        $resource = Transfer::retrieveReversal(self::TEST_RESOURCE_ID, self::TEST_REVERSAL_ID);
        $this->assertInstanceOf('Stripe\\TransferReversal', $resource);
    }

    public function testCanUpdateReversal(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/transfers/'.self::TEST_RESOURCE_ID.'/reversals/'.self::TEST_REVERSAL_ID
        );
        $resource = Transfer::updateReversal(
            self::TEST_RESOURCE_ID,
            self::TEST_REVERSAL_ID,
            [
                'metadata' => ['key' => 'value'],
            ]
        );
        $this->assertInstanceOf('Stripe\\TransferReversal', $resource);
    }

    public function testCanListReversal(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/transfers/'.self::TEST_RESOURCE_ID.'/reversals'
        );
        $resources = Transfer::allReversals(self::TEST_RESOURCE_ID);
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\TransferReversal', $resources->data[0]);
    }
}
