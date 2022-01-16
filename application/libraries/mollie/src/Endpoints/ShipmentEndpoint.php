<?php

declare(strict_types=1);

namespace Mollie\Api\Endpoints;

use Mollie\Api\Resources\Order;
use Mollie\Api\Resources\Shipment;
use Mollie\Api\Resources\ShipmentCollection;

class ShipmentEndpoint extends \Mollie\Api\Endpoints\CollectionEndpointAbstract
{
    /**
     * @var string
     */
    public const RESOURCE_ID_PREFIX = 'shp_';
    protected $resourcePath = 'orders_shipments';

    /**
     * Create a shipment for some order lines. You can provide an empty array for the
     * "lines" option to include all unshipped lines for this order.
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return Shipment
     */
    public function createFor(Order $order, array $options = [], array $filters = [])
    {
        return $this->createForId($order->id, $options, $filters);
    }

    /**
     * Create a shipment for some order lines. You can provide an empty array for the
     * "lines" option to include all unshipped lines for this order.
     *
     * @param string $orderId
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return Shipment
     */
    public function createForId($orderId, array $options = [], array $filters = [])
    {
        $this->parentId = $orderId;

        return parent::rest_create($options, $filters);
    }

    /**
     * Retrieve a single shipment and the order lines shipped by a shipment’s ID.
     *
     * @param string $shipmentId
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return Shipment
     */
    public function getFor(Order $order, $shipmentId, array $parameters = [])
    {
        return $this->getForId($order->id, $shipmentId, $parameters);
    }

    /**
     * Retrieve a single shipment and the order lines shipped by a shipment’s ID.
     *
     * @param string $orderId
     * @param string $shipmentId
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return \Mollie\Api\Resources\BaseResource|\Mollie\Api\Resources\Shipment
     */
    public function getForId($orderId, $shipmentId, array $parameters = [])
    {
        $this->parentId = $orderId;

        return parent::rest_read($shipmentId, $parameters);
    }

    /**
     * Return all shipments for the Order provided.
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return ShipmentCollection
     */
    public function listFor(Order $order, array $parameters = [])
    {
        return $this->listForId($order->id, $parameters);
    }

    /**
     * Return all shipments for the provided Order id.
     *
     * @param string $orderId
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return \Mollie\Api\Resources\BaseCollection|\Mollie\Api\Resources\ShipmentCollection
     */
    public function listForId($orderId, array $parameters = [])
    {
        $this->parentId = $orderId;

        return parent::rest_list(null, null, $parameters);
    }

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one type of object.
     *
     * @return Shipment
     */
    protected function getResourceObject()
    {
        return new \Mollie\Api\Resources\Shipment($this->client);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API
     * endpoint uses one type of collection object.
     *
     * @param int       $count
     * @param \stdClass $_links
     *
     * @return ShipmentCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new \Mollie\Api\Resources\ShipmentCollection($count, $_links);
    }
}
