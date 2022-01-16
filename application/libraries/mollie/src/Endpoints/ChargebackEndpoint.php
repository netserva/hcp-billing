<?php

declare(strict_types=1);

namespace Mollie\Api\Endpoints;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Resources\Chargeback;
use Mollie\Api\Resources\ChargebackCollection;

class ChargebackEndpoint extends \Mollie\Api\Endpoints\CollectionEndpointAbstract
{
    protected $resourcePath = 'chargebacks';

    /**
     * Retrieves a collection of Chargebacks from Mollie.
     *
     * @param string $from  the first chargeback ID you want to include in your list
     * @param int    $limit
     *
     * @throws ApiException
     *
     * @return ChargebackCollection
     */
    public function page($from = null, $limit = null, array $parameters = [])
    {
        return $this->rest_list($from, $limit, $parameters);
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
