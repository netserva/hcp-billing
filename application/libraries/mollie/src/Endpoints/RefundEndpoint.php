<?php

declare(strict_types=1);

namespace Mollie\Api\Endpoints;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Resources\Refund;
use Mollie\Api\Resources\RefundCollection;

class RefundEndpoint extends \Mollie\Api\Endpoints\CollectionEndpointAbstract
{
    protected $resourcePath = 'refunds';

    /**
     * Retrieves a collection of Refunds from Mollie.
     *
     * @param string $from  the first refund ID you want to include in your list
     * @param int    $limit
     *
     * @throws ApiException
     *
     * @return RefundCollection
     */
    public function page($from = null, $limit = null, array $parameters = [])
    {
        return $this->rest_list($from, $limit, $parameters);
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
