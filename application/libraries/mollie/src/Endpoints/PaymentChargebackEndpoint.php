<?php

declare(strict_types=1);

namespace Mollie\Api\Endpoints;

use Mollie\Api\Resources\Chargeback;
use Mollie\Api\Resources\ChargebackCollection;
use Mollie\Api\Resources\Payment;

class PaymentChargebackEndpoint extends \Mollie\Api\Endpoints\CollectionEndpointAbstract
{
    protected $resourcePath = 'payments_chargebacks';

    /**
     * @param string $chargebackId
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return Chargeback
     */
    public function getFor(Payment $payment, $chargebackId, array $parameters = [])
    {
        return $this->getForId($payment->id, $chargebackId, $parameters);
    }

    /**
     * @param string $paymentId
     * @param string $chargebackId
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return Chargeback
     */
    public function getForId($paymentId, $chargebackId, array $parameters = [])
    {
        $this->parentId = $paymentId;

        return parent::rest_read($chargebackId, $parameters);
    }

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one type of object.
     *
     * @return Chargeback
     */
    protected function getResourceObject()
    {
        return new \Mollie\Api\Resources\Chargeback($this->client);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API endpoint uses one type of collection object.
     *
     * @param int       $count
     * @param \stdClass $_links
     *
     * @return ChargebackCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new \Mollie\Api\Resources\ChargebackCollection($this->client, $count, $_links);
    }
}
