<?php

declare(strict_types=1);

namespace Mollie\Api\Endpoints;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Resources\Settlement;
use Mollie\Api\Resources\SettlementCollection;

class SettlementsEndpoint extends \Mollie\Api\Endpoints\CollectionEndpointAbstract
{
    protected $resourcePath = 'settlements';

    /**
     * Retrieve a single settlement from Mollie.
     *
     * Will throw a ApiException if the settlement id is invalid or the resource cannot be found.
     *
     * @param string $settlementId
     *
     * @throws ApiException
     *
     * @return Settlement
     */
    public function get($settlementId, array $parameters = [])
    {
        return parent::rest_read($settlementId, $parameters);
    }

    /**
     * Retrieve the details of the current settlement that has not yet been paid out.
     *
     * @throws ApiException
     *
     * @return Settlement
     */
    public function next()
    {
        return parent::rest_read('next', []);
    }

    /**
     * Retrieve the details of the open balance of the organization.
     *
     * @throws ApiException
     *
     * @return Settlement
     */
    public function open()
    {
        return parent::rest_read('open', []);
    }

    /**
     * Retrieves a collection of Settlements from Mollie.
     *
     * @param string $from  the first settlement ID you want to include in your list
     * @param int    $limit
     *
     * @throws ApiException
     *
     * @return SettlementCollection
     */
    public function page($from = null, $limit = null, array $parameters = [])
    {
        return $this->rest_list($from, $limit, $parameters);
    }

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Mollie\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new \Mollie\Api\Resources\Settlement($this->client);
    }

    /**
     * Get the collection object that is used by this API. Every API uses one type of collection object.
     *
     * @param int       $count
     * @param \stdClass $_links
     *
     * @return \Mollie\Api\Resources\BaseCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new \Mollie\Api\Resources\SettlementCollection($this->client, $count, $_links);
    }
}
