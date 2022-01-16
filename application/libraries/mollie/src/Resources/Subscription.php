<?php

declare(strict_types=1);

namespace Mollie\Api\Resources;

class Subscription extends \Mollie\Api\Resources\BaseResource
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
     * @var string
     */
    public $customerId;
    /**
     * Either "live" or "test" depending on the customer's mode.
     *
     * @var string
     */
    public $mode;
    /**
     * UTC datetime the subscription created in ISO-8601 format.
     *
     * @var string
     */
    public $createdAt;
    /**
     * @var string
     */
    public $status;
    /**
     * @var \stdClass
     */
    public $amount;
    /**
     * @var null|int
     */
    public $times;
    /**
     * @var string
     */
    public $interval;
    /**
     * @var string
     */
    public $description;
    /**
     * @var null|string
     */
    public $method;
    /**
     * @var null|string
     */
    public $mandateId;
    /**
     * @var null|array
     */
    public $metadata;
    /**
     * UTC datetime the subscription canceled in ISO-8601 format.
     *
     * @var null|string
     */
    public $canceledAt;
    /**
     * Date the subscription started. For example: 2018-04-24.
     *
     * @var null|string
     */
    public $startDate;
    /**
     * Contains an optional 'webhookUrl'.
     *
     * @var null|\stdClass
     */
    public $webhookUrl;
    /**
     * @var \stdClass
     */
    public $_links;

    /**
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return BaseResource|Subscription
     */
    public function update()
    {
        if (!isset($this->_links->self->href)) {
            return $this;
        }
        $body = \json_encode(['amount' => $this->amount, 'times' => $this->times, 'startDate' => $this->startDate, 'webhookUrl' => $this->webhookUrl, 'description' => $this->description, 'mandateId' => $this->mandateId, 'metadata' => $this->metadata, 'interval' => $this->interval]);
        $result = $this->client->performHttpCallToFullUrl(\Mollie\Api\MollieApiClient::HTTP_PATCH, $this->_links->self->href, $body);

        return \Mollie\Api\Resources\ResourceFactory::createFromApiResult($result, new \Mollie\Api\Resources\Subscription($this->client));
    }

    /**
     * Returns whether the Subscription is active or not.
     *
     * @return bool
     */
    public function isActive()
    {
        return \Mollie\Api\Types\SubscriptionStatus::STATUS_ACTIVE === $this->status;
    }

    /**
     * Returns whether the Subscription is pending or not.
     *
     * @return bool
     */
    public function isPending()
    {
        return \Mollie\Api\Types\SubscriptionStatus::STATUS_PENDING === $this->status;
    }

    /**
     * Returns whether the Subscription is canceled or not.
     *
     * @return bool
     */
    public function isCanceled()
    {
        return \Mollie\Api\Types\SubscriptionStatus::STATUS_CANCELED === $this->status;
    }

    /**
     * Returns whether the Subscription is suspended or not.
     *
     * @return bool
     */
    public function isSuspended()
    {
        return \Mollie\Api\Types\SubscriptionStatus::STATUS_SUSPENDED === $this->status;
    }

    /**
     * Returns whether the Subscription is completed or not.
     *
     * @return bool
     */
    public function isCompleted()
    {
        return \Mollie\Api\Types\SubscriptionStatus::STATUS_COMPLETED === $this->status;
    }

    /**
     * Cancels this subscription.
     *
     * @return Subscription
     */
    public function cancel()
    {
        if (!isset($this->_links->self->href)) {
            return $this;
        }
        $body = null;
        if ($this->client->usesOAuth()) {
            $body = \json_encode(['testmode' => 'test' === $this->mode ? \true : \false]);
        }
        $result = $this->client->performHttpCallToFullUrl(\Mollie\Api\MollieApiClient::HTTP_DELETE, $this->_links->self->href, $body);

        return \Mollie\Api\Resources\ResourceFactory::createFromApiResult($result, new \Mollie\Api\Resources\Subscription($this->client));
    }

    public function payments()
    {
        if (!isset($this->_links->payments->href)) {
            return new \Mollie\Api\Resources\PaymentCollection($this->client, 0, null);
        }
        $result = $this->client->performHttpCallToFullUrl(\Mollie\Api\MollieApiClient::HTTP_GET, $this->_links->payments->href);

        return \Mollie\Api\Resources\ResourceFactory::createCursorResourceCollection($this->client, $result->_embedded->payments, \Mollie\Api\Resources\Payment::class, $result->_links);
    }
}
