<?php

declare(strict_types=1);

namespace Mollie\Api\Endpoints;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Resources\Payment;
use Mollie\Api\Resources\PaymentCollection;
use Mollie\Api\Resources\Refund;

class PaymentEndpoint extends \Mollie\Api\Endpoints\CollectionEndpointAbstract
{
    /**
     * @var string
     */
    public const RESOURCE_ID_PREFIX = 'tr_';
    protected $resourcePath = 'payments';

    /**
     * Creates a payment in Mollie.
     *
     * @param array $data an array containing details on the payment
     *
     * @throws ApiException
     *
     * @return Payment
     */
    public function create(array $data = [], array $filters = [])
    {
        return $this->rest_create($data, $filters);
    }

    /**
     * Retrieve a single payment from Mollie.
     *
     * Will throw a ApiException if the payment id is invalid or the resource cannot be found.
     *
     * @param string $paymentId
     *
     * @throws ApiException
     *
     * @return Payment
     */
    public function get($paymentId, array $parameters = [])
    {
        if (empty($paymentId) || !\str_starts_with($paymentId, self::RESOURCE_ID_PREFIX)) {
            throw new \Mollie\Api\Exceptions\ApiException("Invalid payment ID: '{$paymentId}'. A payment ID should start with '".self::RESOURCE_ID_PREFIX."'.");
        }

        return parent::rest_read($paymentId, $parameters);
    }

    /**
     * Deletes the given Payment.
     *
     * Will throw a ApiException if the payment id is invalid or the resource cannot be found.
     * Returns with HTTP status No Content (204) if successful.
     *
     * @param string $paymentId
     *
     * @throws ApiException
     *
     * @return Payment
     */
    public function delete($paymentId, array $data = [])
    {
        return $this->rest_delete($paymentId, $data);
    }

    /**
     * Cancel the given Payment. This is just an alias of the 'delete' method.
     *
     * Will throw a ApiException if the payment id is invalid or the resource cannot be found.
     * Returns with HTTP status No Content (204) if successful.
     *
     * @param string $paymentId
     *
     * @throws ApiException
     *
     * @return Payment
     */
    public function cancel($paymentId, array $data = [])
    {
        return $this->rest_delete($paymentId, $data);
    }

    /**
     * Retrieves a collection of Payments from Mollie.
     *
     * @param string $from  the first payment ID you want to include in your list
     * @param int    $limit
     *
     * @throws ApiException
     *
     * @return PaymentCollection
     */
    public function page($from = null, $limit = null, array $parameters = [])
    {
        return $this->rest_list($from, $limit, $parameters);
    }

    /**
     * Issue a refund for the given payment.
     *
     * The $data parameter may either be an array of endpoint parameters, a float value to
     * initiate a partial refund, or empty to do a full refund.
     *
     * @param null|array|float $data
     *
     * @throws ApiException
     *
     * @return Refund
     */
    public function refund(Payment $payment, $data = [])
    {
        $resource = "{$this->getResourcePath()}/".\urlencode($payment->id).'/refunds';
        $body = null;
        if (\count($data) > 0) {
            $body = \json_encode($data);
        }
        $result = $this->client->performHttpCall(self::REST_CREATE, $resource, $body);

        return \Mollie\Api\Resources\ResourceFactory::createFromApiResult($result, new \Mollie\Api\Resources\Refund($this->client));
    }

    /**
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
