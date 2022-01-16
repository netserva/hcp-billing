<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class InvoiceTest extends TestCase
{
    public const TEST_RESOURCE_ID = 'in_123';

    public function testIsListable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/invoices'
        );
        $resources = Invoice::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\Invoice', $resources->data[0]);
    }

    public function testIsRetrievable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/invoices/'.self::TEST_RESOURCE_ID
        );
        $resource = Invoice::retrieve(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\Invoice', $resource);
    }

    public function testIsCreatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/invoices'
        );
        $resource = Invoice::create([
            'customer' => 'cus_123',
        ]);
        $this->assertInstanceOf('Stripe\\Invoice', $resource);
    }

    public function testIsSaveable(): void
    {
        $resource = Invoice::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/v1/invoices/'.self::TEST_RESOURCE_ID
        );
        $resource->save();
        $this->assertInstanceOf('Stripe\\Invoice', $resource);
    }

    public function testIsUpdatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/invoices/'.self::TEST_RESOURCE_ID
        );
        $resource = Invoice::update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        $this->assertInstanceOf('Stripe\\Invoice', $resource);
    }

    public function testCanRetrieveUpcoming(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/invoices/upcoming'
        );
        $resource = Invoice::upcoming(['customer' => 'cus_123']);
        $this->assertInstanceOf('Stripe\\Invoice', $resource);
    }

    public function testIsPayable(): void
    {
        $invoice = Invoice::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/invoices/'.$invoice->id.'/pay'
        );
        $resource = $invoice->pay();
        $this->assertInstanceOf('Stripe\\Invoice', $resource);
        $this->assertSame($resource, $invoice);
    }
}
