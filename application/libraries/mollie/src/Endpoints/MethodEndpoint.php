<?php

declare(strict_types=1);

namespace Mollie\Api\Endpoints;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Resources\Method;
use Mollie\Api\Resources\MethodCollection;

class MethodEndpoint extends \Mollie\Api\Endpoints\CollectionEndpointAbstract
{
    protected $resourcePath = 'methods';

    /**
     * Retrieve all active methods. In test mode, this includes pending methods. The results are not paginated.
     *
     * @deprecated Use allActive() instead
     *
     * @throws ApiException
     *
     * @return \Mollie\Api\Resources\BaseCollection|\Mollie\Api\Resources\MethodCollection
     */
    public function all(array $parameters = [])
    {
        return $this->allActive($parameters);
    }

    /**
     * Retrieve all active methods for the organization. In test mode, this includes pending methods.
     * The results are not paginated.
     *
     * @throws ApiException
     *
     * @return \Mollie\Api\Resources\BaseCollection|\Mollie\Api\Resources\MethodCollection
     */
    public function allActive(array $parameters = [])
    {
        return parent::rest_list(null, null, $parameters);
    }

    /**
     * Retrieve all available methods for the organization, including activated and not yet activated methods. The
     * results are not paginated. Make sure to include the profileId parameter if using an OAuth Access Token.
     *
     * @param array $parameters query string parameters
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return \Mollie\Api\Resources\BaseCollection|\Mollie\Api\Resources\MethodCollection
     */
    public function allAvailable(array $parameters = [])
    {
        $url = 'methods/all'.$this->buildQueryString($parameters);
        $result = $this->client->performHttpCall('GET', $url);

        return \Mollie\Api\Resources\ResourceFactory::createBaseResourceCollection($this->client, \Mollie\Api\Resources\Method::class, $result->_embedded->methods, $result->_links);
    }

    /**
     * Retrieve a payment method from Mollie.
     *
     * Will throw a ApiException if the method id is invalid or the resource cannot be found.
     *
     * @param string $methodId
     *
     * @throws ApiException
     *
     * @return \Mollie\Api\Resources\BaseResource|\Mollie\Api\Resources\Method
     */
    public function get($methodId, array $parameters = [])
    {
        if (empty($methodId)) {
            throw new \Mollie\Api\Exceptions\ApiException('Method ID is empty.');
        }

        return parent::rest_read($methodId, $parameters);
    }

    /**
     * @return Method
     */
    protected function getResourceObject()
    {
        return new \Mollie\Api\Resources\Method($this->client);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API endpoint uses one type of collection object.
     *
     * @param int       $count
     * @param \stdClass $_links
     *
     * @return MethodCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new \Mollie\Api\Resources\MethodCollection($count, $_links);
    }
}
