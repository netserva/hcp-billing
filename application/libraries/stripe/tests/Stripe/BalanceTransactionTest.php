<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class BalanceTransactionTest extends TestCase
{
    public const TEST_RESOURCE_ID = 'txn_123';

    public function testIsListable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/balance/history'
        );
        $resources = BalanceTransaction::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\BalanceTransaction', $resources->data[0]);
    }

    public function testIsRetrievable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/balance/history/'.self::TEST_RESOURCE_ID
        );
        $resource = BalanceTransaction::retrieve(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\BalanceTransaction', $resource);
    }
}
