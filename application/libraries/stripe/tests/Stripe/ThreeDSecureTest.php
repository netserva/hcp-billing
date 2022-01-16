<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class ThreeDSecureTest extends TestCase
{
    public const TEST_RESOURCE_ID = 'tdsrc_123';

    public function testIsRetrievable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/3d_secure/'.self::TEST_RESOURCE_ID
        );
        $resource = ThreeDSecure::retrieve(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\ThreeDSecure', $resource);
    }

    public function testIsCreatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/3d_secure'
        );
        $resource = ThreeDSecure::create([
            'amount' => 100,
            'currency' => 'usd',
            'return_url' => 'url',
        ]);
        $this->assertInstanceOf('Stripe\\ThreeDSecure', $resource);
    }
}
