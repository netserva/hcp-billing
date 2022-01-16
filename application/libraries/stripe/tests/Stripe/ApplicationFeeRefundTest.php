<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class ApplicationFeeRefundTest extends TestCase
{
    public const TEST_RESOURCE_ID = 'fr_123';
    public const TEST_FEE_ID = 'fee_123';

    public function testIsSaveable(): void
    {
        $resource = ApplicationFee::retrieveRefund(self::TEST_FEE_ID, self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/v1/application_fees/'.$resource->fee.'/refunds/'.$resource->id
        );
        $resource->save();
        $this->assertInstanceOf('Stripe\\ApplicationFeeRefund', $resource);
    }
}
