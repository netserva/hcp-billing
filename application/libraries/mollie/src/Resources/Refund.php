<?php

declare(strict_types=1);

namespace Mollie\Api\Resources;

class Refund extends \Mollie\Api\Resources\BaseResource
{
    /**
     * @var string
     */
    public $resource;
    /**
     * Id of the payment method.
     *
     * @var string
     */
    public $id;
    /**
     * The $amount that was refunded.
     *
     * @var \stdClass
     */
    public $amount;
    /**
     * UTC datetime the payment was created in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     *
     * @var string
     */
    public $createdAt;
    /**
     * The refund's description, if available.
     *
     * @var null|string
     */
    public $description;
    /**
     * The payment id that was refunded.
     *
     * @var string
     */
    public $paymentId;
    /**
     * The order id that was refunded.
     *
     * @var null|string
     */
    public $orderId;
    /**
     * The order lines contain the actual things the customer ordered.
     * The lines will show the quantity, discountAmount, vatAmount and totalAmount
     * refunded.
     *
     * @var null|array|object[]
     */
    public $lines;
    /**
     * The settlement amount.
     *
     * @var \stdClass
     */
    public $settlementAmount;
    /**
     * The refund status.
     *
     * @var string
     */
    public $status;
    /**
     * @var \stdClass
     */
    public $_links;

    /**
     * Is this refund queued?
     *
     * @return bool
     */
    public function isQueued()
    {
        return \Mollie\Api\Types\RefundStatus::STATUS_QUEUED === $this->status;
    }

    /**
     * Is this refund pending?
     *
     * @return bool
     */
    public function isPending()
    {
        return \Mollie\Api\Types\RefundStatus::STATUS_PENDING === $this->status;
    }

    /**
     * Is this refund processing?
     *
     * @return bool
     */
    public function isProcessing()
    {
        return \Mollie\Api\Types\RefundStatus::STATUS_PROCESSING === $this->status;
    }

    /**
     * Is this refund transferred to consumer?
     *
     * @return bool
     */
    public function isTransferred()
    {
        return \Mollie\Api\Types\RefundStatus::STATUS_REFUNDED === $this->status;
    }

    /**
     * Cancel the refund.
     * Returns null if successful.
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function cancel()
    {
        $this->client->performHttpCallToFullUrl(\Mollie\Api\MollieApiClient::HTTP_DELETE, $this->_links->self->href);

        return null;
    }
}
