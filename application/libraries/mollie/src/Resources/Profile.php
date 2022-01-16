<?php

declare(strict_types=1);

namespace Mollie\Api\Resources;

use Mollie\Api\Exceptions\ApiException;

class Profile extends \Mollie\Api\Resources\BaseResource
{
    /**
     * @var string
     */
    public $resource;
    /**
     * @var string
     */
    public $id;
    /**
     * Test or live mode.
     *
     * @var string
     */
    public $mode;
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $website;
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $phone;
    /**
     * See https://docs.mollie.com/reference/v2/profiles-api/get-profile.
     *
     * @var int
     */
    public $categoryCode;
    /**
     * @var string
     */
    public $status;
    /**
     * @var \stdClass
     */
    public $review;
    /**
     * UTC datetime the profile was created in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     *
     * @var string
     */
    public $createdAt;
    /**
     * @var \stdClass
     */
    public $_links;

    /**
     * @return bool
     */
    public function isUnverified()
    {
        return \Mollie\Api\Types\ProfileStatus::STATUS_UNVERIFIED == $this->status;
    }

    /**
     * @return bool
     */
    public function isVerified()
    {
        return \Mollie\Api\Types\ProfileStatus::STATUS_VERIFIED == $this->status;
    }

    /**
     * @return bool
     */
    public function isBlocked()
    {
        return \Mollie\Api\Types\ProfileStatus::STATUS_BLOCKED == $this->status;
    }

    /**
     * @throws ApiException
     *
     * @return Profile
     */
    public function update()
    {
        if (!isset($this->_links->self->href)) {
            return $this;
        }
        $body = \json_encode(['name' => $this->name, 'website' => $this->website, 'email' => $this->email, 'phone' => $this->phone, 'categoryCode' => $this->categoryCode, 'mode' => $this->mode]);
        $result = $this->client->performHttpCallToFullUrl(\Mollie\Api\MollieApiClient::HTTP_PATCH, $this->_links->self->href, $body);

        return \Mollie\Api\Resources\ResourceFactory::createFromApiResult($result, new \Mollie\Api\Resources\Profile($this->client));
    }

    /**
     * Retrieves all chargebacks associated with this profile.
     *
     * @throws ApiException
     *
     * @return ChargebackCollection
     */
    public function chargebacks()
    {
        if (!isset($this->_links->chargebacks->href)) {
            return new \Mollie\Api\Resources\ChargebackCollection($this->client, 0, null);
        }
        $result = $this->client->performHttpCallToFullUrl(\Mollie\Api\MollieApiClient::HTTP_GET, $this->_links->chargebacks->href);

        return \Mollie\Api\Resources\ResourceFactory::createCursorResourceCollection($this->client, $result->_embedded->chargebacks, \Mollie\Api\Resources\Chargeback::class, $result->_links);
    }

    /**
     * Retrieves all methods activated on this profile.
     *
     * @throws ApiException
     *
     * @return MethodCollection
     */
    public function methods()
    {
        if (!isset($this->_links->methods->href)) {
            return new \Mollie\Api\Resources\MethodCollection(0, null);
        }
        $result = $this->client->performHttpCallToFullUrl(\Mollie\Api\MollieApiClient::HTTP_GET, $this->_links->methods->href);

        return \Mollie\Api\Resources\ResourceFactory::createCursorResourceCollection($this->client, $result->_embedded->methods, \Mollie\Api\Resources\Method::class, $result->_links);
    }

    /**
     * Enable a payment method for this profile.
     *
     * @param string $methodId
     *
     * @throws ApiException
     *
     * @return Method
     */
    public function enableMethod($methodId, array $data = [])
    {
        return $this->client->profileMethods->createFor($this, $methodId, $data);
    }

    /**
     * Disable a payment method for this profile.
     *
     * @param string $methodId
     *
     * @throws ApiException
     *
     * @return Method
     */
    public function disableMethod($methodId, array $data = [])
    {
        return $this->client->profileMethods->deleteFor($this, $methodId, $data);
    }

    /**
     * Retrieves all payments associated with this profile.
     *
     * @throws ApiException
     *
     * @return PaymentCollection
     */
    public function payments()
    {
        if (!isset($this->_links->payments->href)) {
            return new \Mollie\Api\Resources\PaymentCollection($this->client, 0, null);
        }
        $result = $this->client->performHttpCallToFullUrl(\Mollie\Api\MollieApiClient::HTTP_GET, $this->_links->payments->href);

        return \Mollie\Api\Resources\ResourceFactory::createCursorResourceCollection($this->client, $result->_embedded->methods, \Mollie\Api\Resources\Method::class, $result->_links);
    }

    /**
     * Retrieves all refunds associated with this profile.
     *
     * @throws ApiException
     *
     * @return RefundCollection
     */
    public function refunds()
    {
        if (!isset($this->_links->refunds->href)) {
            return new \Mollie\Api\Resources\RefundCollection($this->client, 0, null);
        }
        $result = $this->client->performHttpCallToFullUrl(\Mollie\Api\MollieApiClient::HTTP_GET, $this->_links->refunds->href);

        return \Mollie\Api\Resources\ResourceFactory::createCursorResourceCollection($this->client, $result->_embedded->refunds, \Mollie\Api\Resources\Refund::class, $result->_links);
    }
}
