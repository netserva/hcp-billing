<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class SourceTest extends TestCase
{
    public const TEST_RESOURCE_ID = 'src_123';

    public function testIsRetrievable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/sources/'.self::TEST_RESOURCE_ID
        );
        $resource = Source::retrieve(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\Source', $resource);
    }

    public function testIsCreatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/sources'
        );
        $resource = Source::create([
            'type' => 'card',
        ]);
        $this->assertInstanceOf('Stripe\\Source', $resource);
    }

    public function testIsSaveable(): void
    {
        $resource = Source::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/v1/sources/'.self::TEST_RESOURCE_ID
        );
        $resource->save();
        $this->assertInstanceOf('Stripe\\Source', $resource);
    }

    public function testIsUpdatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/sources/'.self::TEST_RESOURCE_ID
        );
        $resource = Source::update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        $this->assertInstanceOf('Stripe\\Source', $resource);
    }

    public function testCanSaveCardExpiryDate(): void
    {
        $response = [
            'id' => 'src_foo',
            'object' => 'source',
            'card' => [
                'exp_month' => 8,
                'exp_year' => 2019,
            ],
        ];
        $source = Source::constructFrom(
            $response,
            new Util\RequestOptions()
        );

        $response['card']['exp_month'] = 12;
        $response['card']['exp_year'] = 2022;
        $this->stubRequest(
            'POST',
            '/v1/sources/src_foo',
            [
                'card' => [
                    'exp_month' => 12,
                    'exp_year' => 2022,
                ],
            ],
            null,
            false,
            $response
        );

        $source->card->exp_month = 12;
        $source->card->exp_year = 2022;
        $source->save();

        $this->assertSame(12, $source->card->exp_month);
        $this->assertSame(2022, $source->card->exp_year);
    }

    public function testIsDetachableWhenAttached(): void
    {
        $resource = Source::retrieve(self::TEST_RESOURCE_ID);
        $resource->customer = 'cus_123';
        $this->expectsRequest(
            'delete',
            '/v1/customers/cus_123/sources/'.self::TEST_RESOURCE_ID
        );
        $resource->delete();
        $this->assertInstanceOf('Stripe\\Source', $resource);
    }

    /**
     * @expectedException \Stripe\Error\Api
     */
    public function testIsNotDetachableWhenUnattached(): void
    {
        $resource = Source::retrieve(self::TEST_RESOURCE_ID);
        $resource->detach();
    }

    public function testCanListSourceTransactions(): void
    {
        $source = Source::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'get',
            '/v1/sources/'.$source->id.'/source_transactions'
        );
        $resources = $source->sourceTransactions();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\SourceTransaction', $resources->data[0]);
    }

    public function testCanVerify(): void
    {
        $resource = Source::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/sources/'.self::TEST_RESOURCE_ID.'/verify'
        );
        $resource->verify(['values' => [32, 45]]);
        $this->assertInstanceOf('Stripe\\Source', $resource);
    }
}
