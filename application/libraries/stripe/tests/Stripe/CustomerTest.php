<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class CustomerTest extends TestCase
{
    public const TEST_RESOURCE_ID = 'cus_123';
    public const TEST_SOURCE_ID = 'ba_123';

    public function testIsListable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/customers'
        );
        $resources = Customer::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\Customer', $resources->data[0]);
    }

    public function testIsRetrievable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/customers/'.self::TEST_RESOURCE_ID
        );
        $resource = Customer::retrieve(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\Customer', $resource);
    }

    public function testIsCreatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/customers'
        );
        $resource = Customer::create();
        $this->assertInstanceOf('Stripe\\Customer', $resource);
    }

    public function testIsSaveable(): void
    {
        $resource = Customer::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/v1/customers/'.self::TEST_RESOURCE_ID
        );
        $resource->save();
        $this->assertInstanceOf('Stripe\\Customer', $resource);
    }

    public function testIsUpdatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/customers/'.self::TEST_RESOURCE_ID
        );
        $resource = Customer::update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        $this->assertInstanceOf('Stripe\\Customer', $resource);
    }

    public function testIsDeletable(): void
    {
        $resource = Customer::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'delete',
            '/v1/customers/'.self::TEST_RESOURCE_ID
        );
        $resource->delete();
        $this->assertInstanceOf('Stripe\\Customer', $resource);
    }

    public function testCanAddInvoiceItem(): void
    {
        $customer = Customer::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/invoiceitems',
            [
                'amount' => 100,
                'currency' => 'usd',
                'customer' => $customer->id,
            ]
        );
        $resource = $customer->addInvoiceItem([
            'amount' => 100,
            'currency' => 'usd',
        ]);
        $this->assertInstanceOf('Stripe\\InvoiceItem', $resource);
    }

    public function testCanListInvoices(): void
    {
        $customer = Customer::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'get',
            '/v1/invoices',
            ['customer' => $customer->id]
        );
        $resources = $customer->invoices();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\Invoice', $resources->data[0]);
    }

    public function testCanListInvoiceItems(): void
    {
        $customer = Customer::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'get',
            '/v1/invoiceitems',
            ['customer' => $customer->id]
        );
        $resources = $customer->invoiceItems();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\InvoiceItem', $resources->data[0]);
    }

    public function testCanListCharges(): void
    {
        $customer = Customer::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'get',
            '/v1/charges',
            ['customer' => $customer->id]
        );
        $resources = $customer->charges();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\Charge', $resources->data[0]);
    }

    public function testCanUpdateSubscription(): void
    {
        $customer = Customer::retrieve(self::TEST_RESOURCE_ID);
        $this->stubRequest(
            'post',
            '/v1/customers/'.$customer->id.'/subscription',
            ['plan' => 'plan'],
            null,
            false,
            [
                'object' => 'subscription',
                'id' => 'sub_foo',
            ]
        );
        $resource = $customer->updateSubscription(['plan' => 'plan']);
        $this->assertInstanceOf('Stripe\\Subscription', $resource);
        $this->assertSame('sub_foo', $customer->subscription->id);
    }

    public function testCanCancelSubscription(): void
    {
        $customer = Customer::retrieve(self::TEST_RESOURCE_ID);
        $this->stubRequest(
            'delete',
            '/v1/customers/'.$customer->id.'/subscription',
            [],
            null,
            false,
            [
                'object' => 'subscription',
                'id' => 'sub_foo',
            ]
        );
        $resource = $customer->cancelSubscription();
        $this->assertInstanceOf('Stripe\\Subscription', $resource);
        $this->assertSame('sub_foo', $customer->subscription->id);
    }

    public function testCanDeleteDiscount(): void
    {
        $customer = Customer::retrieve(self::TEST_RESOURCE_ID);
        $this->stubRequest(
            'delete',
            '/v1/customers/'.$customer->id.'/discount'
        );
        $customer->deleteDiscount();
        $this->assertSame($customer->discount, null);
    }

    public function testCanCreateSource(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/customers/'.self::TEST_RESOURCE_ID.'/sources'
        );
        $resource = Customer::createSource(self::TEST_RESOURCE_ID, ['source' => 'btok_123']);
        $this->assertInstanceOf('Stripe\\BankAccount', $resource);
    }

    public function testCanRetrieveSource(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/customers/'.self::TEST_RESOURCE_ID.'/sources/'.self::TEST_SOURCE_ID
        );
        $resource = Customer::retrieveSource(self::TEST_RESOURCE_ID, self::TEST_SOURCE_ID);
        $this->assertInstanceOf('Stripe\\BankAccount', $resource);
    }

    public function testCanUpdateSource(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/customers/'.self::TEST_RESOURCE_ID.'/sources/'.self::TEST_SOURCE_ID
        );
        $resource = Customer::updateSource(self::TEST_RESOURCE_ID, self::TEST_SOURCE_ID, ['name' => 'name']);
        // stripe-mock returns a Card on this method and not a bank account
        $this->assertInstanceOf('Stripe\\Card', $resource);
    }

    public function testCanDeleteSource(): void
    {
        $this->expectsRequest(
            'delete',
            '/v1/customers/'.self::TEST_RESOURCE_ID.'/sources/'.self::TEST_SOURCE_ID
        );
        $resource = Customer::deleteSource(self::TEST_RESOURCE_ID, self::TEST_SOURCE_ID);
        $this->assertInstanceOf('Stripe\\BankAccount', $resource);
    }

    public function testCanListSources(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/customers/'.self::TEST_RESOURCE_ID.'/sources'
        );
        $resources = Customer::allSources(self::TEST_RESOURCE_ID);
        $this->assertTrue(is_array($resources->data));
    }
}
