<?php

declare(strict_types=1);

namespace Mollie\Api\Endpoints;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Resources\Order;
use Mollie\Api\Resources\OrderLine;
use Mollie\Api\Resources\OrderLineCollection;

class OrderLineEndpoint extends \Mollie\Api\Endpoints\CollectionEndpointAbstract
{
    /**
     * @var string
     */
    public const RESOURCE_ID_PREFIX = 'odl_';
    protected $resourcePath = 'orders_lines';

    /**
     * Cancel lines for the provided order.
     * The data array must contain a lines array.
     * You can pass an empty lines array if you want to cancel all eligible lines.
     * Returns null if successful.
     *
     * @throws ApiException
     */
    public function cancelFor(Order $order, array $data)
    {
        return $this->cancelForId($order->id, $data);
    }

    /**
     * Cancel lines for the provided order id.
     * The data array must contain a lines array.
     * You can pass an empty lines array if you want to cancel all eligible lines.
     * Returns null if successful.
     *
     * @param string $orderId
     *
     * @throws ApiException
     */
    public function cancelForId($orderId, array $data)
    {
        if (!isset($data['lines']) || !\is_array($data['lines'])) {
            throw new \Mollie\Api\Exceptions\ApiException('A lines array is required.');
        }
        $this->parentId = $orderId;
        $this->client->performHttpCall(self::REST_DELETE, "{$this->getResourcePath()}", $this->parseRequestBody($data));

        return null;
    }

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one
     * type of object.
     *
     * @return OrderLine
     */
    protected function getResourceObject()
    {
        return new \Mollie\Api\Resources\OrderLine($this->client);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API
     * endpoint uses one type of collection object.
     *
     * @param int       $count
     * @param \stdClass $_links
     *
     * @return OrderLineCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new \Mollie\Api\Resources\OrderLineCollection($count, $_links);
    }
}
