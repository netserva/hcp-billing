<?php

declare(strict_types=1);

namespace Mollie\Api\Endpoints;

use Mollie\Api\Resources\Customer;
use Mollie\Api\Resources\Payment;
use Mollie\Api\Resources\PaymentCollection;

class CustomerPaymentsEndpoint extends \Mollie\Api\Endpoints\CollectionEndpointAbstract
{
    protected $resourcePath = 'customers_payments';

    /**
     * Create a subscription for a Customer.
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return Payment
     */
    public function createFor(Customer $customer, array $options = [], array $filters = [])
    {
        return $this->createForId($customer->id, $options, $filters);
    }

    /**
     * Create a subscription for a Customer ID.
     *
     * @param string $customerId
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return \Mollie\Api\Resources\BaseResource|\Mollie\Api\Resources\Payment
     */
    public function createForId($customerId, array $options = [], array $filters = [])
    {
        $this->parentId = $customerId;

        return parent::rest_create($options, $filters);
    }

    /**
     * @param string $from  the first resource ID you want to include in your list
     * @param int    $limit
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return PaymentCollection
     */
    public function listFor(Customer $customer, $from = null, $limit = null, array $parameters = [])
    {
        return $this->listForId($customer->id, $from, $limit, $parameters);
    }

    /**
     * @param string $customerId
     * @param string $from       the first resource ID you want to include in your list
     * @param int    $limit
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return \Mollie\Api\Resources\BaseCollection|\Mollie\Api\Resources\PaymentCollection
     */
    public function listForId($customerId, $from = null, $limit = null, array $parameters = [])
    {
        $this->parentId = $customerId;

        return parent::rest_list($from, $limit, $parameters);
    }

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one type of object.
     *
     * @return Payment
     */
    protected function getResourceObject()
    {
        return new \Mollie\Api\Resources\Payment($this->client);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API endpoint uses one type of collection object.
     *
     * @param int       $count
     * @param \stdClass $_links
     *
     * @return PaymentCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new \Mollie\Api\Resources\PaymentCollection($this->client, $count, $_links);
    }
}
