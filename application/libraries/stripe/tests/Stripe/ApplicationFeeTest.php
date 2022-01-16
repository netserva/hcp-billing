<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class ApplicationFeeTest extends TestCase
{
    public const TEST_RESOURCE_ID = 'fee_123';
    public const TEST_FEEREFUND_ID = 'fr_123';

    public function testIsListable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/application_fees'
        );
        $resources = ApplicationFee::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\ApplicationFee', $resources->data[0]);
    }

    public function testIsRetrievable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/application_fees/'.self::TEST_RESOURCE_ID
        );
        $resource = ApplicationFee::retrieve(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\ApplicationFee', $resource);
    }

    public function testCanCreateRefund(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/application_fees/'.self::TEST_RESOURCE_ID.'/refunds'
        );
        $resource = ApplicationFee::createRefund(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\ApplicationFeeRefund', $resource);
    }

    public function testCanRetrieveRefund(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/application_fees/'.self::TEST_RESOURCE_ID.'/refunds/'.self::TEST_FEEREFUND_ID
        );
        $resource = ApplicationFee::retrieveRefund(self::TEST_RESOURCE_ID, self::TEST_FEEREFUND_ID);
        $this->assertInstanceOf('Stripe\\ApplicationFeeRefund', $resource);
    }

    public function testCanUpdateRefund(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/application_fees/'.self::TEST_RESOURCE_ID.'/refunds/'.self::TEST_FEEREFUND_ID
        );
        $resource = ApplicationFee::updateRefund(self::TEST_RESOURCE_ID, self::TEST_FEEREFUND_ID);
        $this->assertInstanceOf('Stripe\\ApplicationFeeRefund', $resource);
    }

    public function testCanListRefunds(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/application_fees/'.self::TEST_RESOURCE_ID.'/refunds'
        );
        $resources = ApplicationFee::allRefunds(self::TEST_RESOURCE_ID);
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\ApplicationFeeRefund', $resources->data[0]);
    }
}
