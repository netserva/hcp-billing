<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class BalanceTest extends TestCase
{
    public function testIsRetrievable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/balance'
        );
        $resource = Balance::retrieve();
        $this->assertInstanceOf('Stripe\\Balance', $resource);
    }
}
