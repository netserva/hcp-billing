<?php

declare(strict_types=1);

namespace Mollie\Api\Endpoints;

use Mollie\Api\Resources\Customer;
use Mollie\Api\Resources\Mandate;
use Mollie\Api\Resources\MandateCollection;

class MandateEndpoint extends \Mollie\Api\Endpoints\CollectionEndpointAbstract
{
    protected $resourcePath = 'customers_mandates';

    /**
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return \Mollie\Api\Resources\Mandate
     */
    public function createFor(Customer $customer, array $options = [], array $filters = [])
    {
        return $this->createForId($customer->id, $options, $filters);
    }

    /**
     * @param string $customerId
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return \Mollie\Api\Resources\BaseResource|\Mollie\Api\Resources\Mandate
     */
    public function createForId($customerId, array $options = [], array $filters = [])
    {
        $this->parentId = $customerId;

        return parent::rest_create($options, $filters);
    }

    /**
     * @param string $mandateId
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return \Mollie\Api\Resources\BaseResource|\Mollie\Api\Resources\Mandate
     */
    public function getFor(Customer $customer, $mandateId, array $parameters = [])
    {
        return $this->getForId($customer->id, $mandateId, $parameters);
    }

    /**
     * @param string $customerId
     * @param string $mandateId
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return \Mollie\Api\Resources\BaseResource
     */
    public function getForId($customerId, $mandateId, array $parameters = [])
    {
        $this->parentId = $customerId;

        return parent::rest_read($mandateId, $parameters);
    }

    /**
     * @param string $from  the first resource ID you want to include in your list
     * @param int    $limit
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return \Mollie\Api\Resources\BaseCollection|\Mollie\Api\Resources\MandateCollection
     */
    public function listFor(Customer $customer, $from = null, $limit = null, array $parameters = [])
    {
        return $this->listForId($customer->id, $from, $limit, $parameters);
    }

    /**
     * @param string $customerId
     * @param null   $from
     * @param null   $limit
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return \Mollie\Api\Resources\BaseCollection|\Mollie\Api\Resources\MandateCollection
     */
    public function listForId($customerId, $from = null, $limit = null, array $parameters = [])
    {
        $this->parentId = $customerId;

        return parent::rest_list($from, $limit, $parameters);
    }

    /**
     * @param string $mandateId
     * @param array  $data
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function revokeFor(Customer $customer, $mandateId, $data = [])
    {
        return $this->revokeForId($customer->id, $mandateId, $data);
    }

    /**
     * @param string $customerId
     * @param string $mandateId
     * @param array  $data
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function revokeForId($customerId, $mandateId, $data = [])
    {
        $this->parentId = $customerId;

        return parent::rest_delete($mandateId, $data);
    }

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one type of object.
     *
     * @return Mandate
     */
    protected function getResourceObject()
    {
        return new \Mollie\Api\Resources\Mandate($this->client);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API endpoint uses one type of collection object.
     *
     * @param int       $count
     * @param \stdClass $_links
     *
     * @return MandateCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new \Mollie\Api\Resources\MandateCollection($this->client, $count, $_links);
    }
}
