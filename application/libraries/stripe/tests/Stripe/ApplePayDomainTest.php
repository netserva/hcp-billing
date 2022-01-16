<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class ApplePayDomainTest extends TestCase
{
    public const TEST_RESOURCE_ID = 'apwc_123';

    public function testIsListable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/apple_pay/domains'
        );
        $resources = ApplePayDomain::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\ApplePayDomain', $resources->data[0]);
    }

    public function testIsRetrievable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/apple_pay/domains/'.self::TEST_RESOURCE_ID
        );
        $resource = ApplePayDomain::retrieve(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\ApplePayDomain', $resource);
    }

    public function testIsCreatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/apple_pay/domains'
        );
        $resource = ApplePayDomain::create([
            'domain_name' => 'domain',
        ]);
        $this->assertInstanceOf('Stripe\\ApplePayDomain', $resource);
    }

    public function testIsDeletable(): void
    {
        $resource = ApplePayDomain::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'delete',
            '/v1/apple_pay/domains/'.self::TEST_RESOURCE_ID
        );
        $resource->delete();
        $this->assertInstanceOf('Stripe\\ApplePayDomain', $resource);
    }
}
