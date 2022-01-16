<?php

declare(strict_types=1);

namespace Mollie\Api\Endpoints;

use Mollie\Api\Resources\Payment;
use Mollie\Api\Resources\Refund;
use Mollie\Api\Resources\RefundCollection;

class PaymentRefundEndpoint extends \Mollie\Api\Endpoints\CollectionEndpointAbstract
{
    protected $resourcePath = 'payments_refunds';

    /**
     * @param string $refundId
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return Refund
     */
    public function getFor(Payment $payment, $refundId, array $parameters = [])
    {
        return $this->getForId($payment->id, $refundId, $parameters);
    }

    /**
     * @param string $paymentId
     * @param string $refundId
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return \Mollie\Api\Resources\BaseResource|\Mollie\Api\Resources\Refund
     */
    public function getForId($paymentId, $refundId, array $parameters = [])
    {
        $this->parentId = $paymentId;

        return parent::rest_read($refundId, $parameters);
    }

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one type of object.
     *
     * @return Refund
     */
    protected function getResourceObject()
    {
        return new \Mollie\Api\Resources\Refund($this->client);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API endpoint uses one type of collection object.
     *
     * @param int       $count
     * @param \stdClass $_links
     *
     * @return RefundCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new \Mollie\Api\Resources\RefundCollection($this->client, $count, $_links);
    }
}
