<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class CountrySpecTest extends TestCase
{
    public const TEST_RESOURCE_ID = 'US';

    public function testIsListable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/country_specs'
        );
        $resources = CountrySpec::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\CountrySpec', $resources->data[0]);
    }

    public function testIsRetrievable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/country_specs/'.self::TEST_RESOURCE_ID
        );
        $resource = CountrySpec::retrieve(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\CountrySpec', $resource);
    }
}
