<?php

declare(strict_types=1);

namespace Mollie\Api\Endpoints;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Resources\Invoice;
use Mollie\Api\Resources\InvoiceCollection;

class InvoiceEndpoint extends \Mollie\Api\Endpoints\CollectionEndpointAbstract
{
    protected $resourcePath = 'invoices';

    /**
     * Retrieve an Invoice from Mollie.
     *
     * Will throw a ApiException if the invoice id is invalid or the resource cannot be found.
     *
     * @param string $invoiceId
     *
     * @throws ApiException
     *
     * @return Invoice
     */
    public function get($invoiceId, array $parameters = [])
    {
        return $this->rest_read($invoiceId, $parameters);
    }

    /**
     * Retrieves a collection of Invoices from Mollie.
     *
     * @param string $from  the first invoice ID you want to include in your list
     * @param int    $limit
     *
     * @throws ApiException
     *
     * @return InvoiceCollection
     */
    public function page($from = null, $limit = null, array $parameters = [])
    {
        return $this->rest_list($from, $limit, $parameters);
    }

    /**
     * This is a wrapper method for page.
     *
     * @param null|array $parameters
     *
     * @return \Mollie\Api\Resources\BaseCollection
     */
    public function all(array $parameters = [])
    {
        return $this->page(null, null, $parameters);
    }

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Mollie\Api\Resources\BaseResource
     */
    protected function getResourceObject()
    {
        return new \Mollie\Api\Resources\Invoice($this->client);
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
        return new \Mollie\Api\Resources\InvoiceCollection($this->client, $count, $_links);
    }
}
