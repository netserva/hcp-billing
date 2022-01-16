<?php

declare(strict_types=1);

namespace Mollie\Api\Endpoints;

use Mollie\Api\Resources\Order;
use Mollie\Api\Resources\Payment;

class OrderPaymentEndpoint extends \Mollie\Api\Endpoints\CollectionEndpointAbstract
{
    /**
     * @var string
     */
    public const RESOURCE_ID_PREFIX = 'tr_';
    protected $resourcePath = 'orders_payments';

    /**
     * Creates a payment in Mollie for a specific order.
     *
     * @param array $data an array containing details on the order payment
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return \Mollie\Api\Resources\BaseResource|\Mollie\Api\Resources\Payment
     */
    public function createFor(Order $order, array $data, array $filters = [])
    {
        return $this->createForId($order->id, $data, $filters);
    }

    /**
     * Creates a payment in Mollie for a specific order ID.
     *
     * @param string $orderId
     * @param array  $data    an array containing details on the order payment
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return \Mollie\Api\Resources\BaseResource|\Mollie\Api\Resources\Payment
     */
    public function createForId($orderId, array $data, array $filters = [])
    {
        $this->parentId = $orderId;

        return $this->rest_create($data, $filters);
    }

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one
     * type of object.
     *
     * @return \Mollie\Api\Resources\Payment
     */
    protected function getResourceObject()
    {
        return new \Mollie\Api\Resources\Payment($this->client);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API
     * endpoint uses one type of collection object.
     *
     * @param int       $count
     * @param \stdClass $_links
     *
     * @return \Mollie\Api\Resources\PaymentCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new \Mollie\Api\Resources\PaymentCollection($this->client, $count, $_links);
    }
}
