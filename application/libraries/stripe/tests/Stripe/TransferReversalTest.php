<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class TransferReversalTest extends TestCase
{
    public const TEST_RESOURCE_ID = 'trr_123';
    public const TEST_TRANSFER_ID = 'tr_123';

    public function testIsSaveable(): void
    {
        $resource = Transfer::retrieveReversal(self::TEST_TRANSFER_ID, self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/v1/transfers/'.$resource->transfer.'/reversals/'.$resource->id
        );
        $resource->save();
        $this->assertInstanceOf('Stripe\\TransferReversal', $resource);
    }
}
