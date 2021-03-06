<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class RecipientTest extends TestCase
{
    public const TEST_RESOURCE_ID = 'rp_123';

    public function testIsListable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/recipients'
        );
        $resources = Recipient::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\Recipient', $resources->data[0]);
    }

    public function testIsRetrievable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/recipients/'.self::TEST_RESOURCE_ID
        );
        $resource = Recipient::retrieve(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\Recipient', $resource);
    }

    public function testIsCreatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/recipients'
        );
        $resource = Recipient::create([
            'name' => 'name',
            'type' => 'individual',
        ]);
        $this->assertInstanceOf('Stripe\\Recipient', $resource);
    }

    public function testIsSaveable(): void
    {
        $resource = Recipient::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/v1/recipients/'.self::TEST_RESOURCE_ID
        );
        $resource->save();
        $this->assertInstanceOf('Stripe\\Recipient', $resource);
    }

    public function testIsUpdatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/recipients/'.self::TEST_RESOURCE_ID
        );
        $resource = Recipient::update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        $this->assertInstanceOf('Stripe\\Recipient', $resource);
    }

    public function testIsDeletable(): void
    {
        $resource = Recipient::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'delete',
            '/v1/recipients/'.self::TEST_RESOURCE_ID
        );
        $resource->delete();
        $this->assertInstanceOf('Stripe\\Recipient', $resource);
    }

    public function testCanListTransfers(): void
    {
        $recipient = Recipient::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'get',
            '/v1/transfers',
            ['recipient' => $recipient->id]
        );
        $resources = $recipient->transfers();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\Transfer', $resources->data[0]);
    }
}
