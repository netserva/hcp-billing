<?php

declare(strict_types=1);

namespace Mollie\Api\Resources;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Types\SequenceType;

class Payment extends \Mollie\Api\Resources\BaseResource
{
    /**
     * @var string
     */
    public $resource;
    /**
     * Id of the payment (on the Mollie platform).
     *
     * @var string
     */
    public $id;
    /**
     * Mode of the payment, either "live" or "test" depending on the API Key that was
     * used.
     *
     * @var string
     */
    public $mode;
    /**
     * Amount object containing the value and currency.
     *
     * @var \stdClass
     */
    public $amount;
    /**
     * The amount that has been settled containing the value and currency.
     *
     * @var \stdClass
     */
    public $settlementAmount;
    /**
     * The amount of the payment that has been refunded to the consumer, in EURO with
     * 2 decimals. This field will be null if the payment can not be refunded.
     *
     * @var null|\stdClass
     */
    public $amountRefunded;
    /**
     * The amount of a refunded payment that can still be refunded, in EURO with 2
     * decimals. This field will be null if the payment can not be refunded.
     *
     * For some payment methods this amount can be higher than the payment amount.
     * This is possible to reimburse the costs for a return shipment to your customer
     * for example.
     *
     * @var null|\stdClass
     */
    public $amountRemaining;
    /**
     * Description of the payment that is shown to the customer during the payment,
     * and possibly on the bank or credit card statement.
     *
     * @var string
     */
    public $description;
    /**
     * If method is empty/null, the customer can pick his/her preferred payment
     * method.
     *
     * @see Method
     *
     * @var null|string
     */
    public $method;
    /**
     * The status of the payment.
     *
     * @var string
     */
    public $status = \Mollie\Api\Types\PaymentStatus::STATUS_OPEN;
    /**
     * UTC datetime the payment was created in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     *
     * @var null|string
     */
    public $createdAt;
    /**
     * UTC datetime the payment was paid in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     *
     * @var null|string
     */
    public $paidAt;
    /**
     * UTC datetime the payment was canceled in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     *
     * @var null|string
     */
    public $canceledAt;
    /**
     * UTC datetime the payment expired in ISO-8601 format.
     *
     * @var null|string
     */
    public $expiresAt;
    /**
     * UTC datetime the payment failed in ISO-8601 format.
     *
     * @var null|string
     */
    public $failedAt;
    /**
     * The profile ID this payment belongs to.
     *
     * @example pfl_xH2kP6Nc6X
     *
     * @var string
     */
    public $profileId;
    /**
     * Either "first", "recurring", or "oneoff" for regular payments.
     *
     * @var null|string
     */
    public $sequenceType;
    /**
     * Redirect URL set on this payment.
     *
     * @var string
     */
    public $redirectUrl;
    /**
     * Webhook URL set on this payment.
     *
     * @var null|string
     */
    public $webhookUrl;
    /**
     * The mandate ID this payment is performed with.
     *
     * @example mdt_pXm1g3ND
     *
     * @var null|string
     */
    public $mandateId;
    /**
     * The subscription ID this payment belongs to.
     *
     * @example sub_rVKGtNd6s3
     *
     * @var null|string
     */
    public $subscriptionId;
    /**
     * The order ID this payment belongs to.
     *
     * @example ord_pbjz8x
     *
     * @var null|string
     */
    public $orderId;
    /**
     * The settlement ID this payment belongs to.
     *
     * @example stl_jDk30akdN
     *
     * @var null|string
     */
    public $settlementId;
    /**
     * The locale used for this payment.
     *
     * @var null|string
     */
    public $locale;
    /**
     * During creation of the payment you can set custom metadata that is stored with
     * the payment, and given back whenever you retrieve that payment.
     *
     * @var null|mixed|\stdClass
     */
    public $metadata;
    /**
     * Details of a successfully paid payment are set here. For example, the iDEAL
     * payment method will set $details->consumerName and $details->consumerAccount.
     *
     * @var \stdClass
     */
    public $details;
    /**
     * Used to restrict the payment methods available to your customer to those from a single country.
     *
     * @var string|null;
     */
    public $restrictPaymentMethodsToCountry;
    /**
     * @var \stdClass
     */
    public $_links;
    /**
     * @var \stdClass[]
     */
    public $_embedded;
    /**
     * Whether or not this payment can be canceled.
     *
     * @var null|bool
     */
    public $isCancelable;
    /**
     * The total amount that is already captured for this payment. Only available
     * when this payment supports captures.
     *
     * @var null|\stdClass
     */
    public $amountCaptured;
    /**
     * The application fee, if the payment was created with one. Contains amount
     * (the value and currency) and description.
     *
     * @var null|\stdClass
     */
    public $applicationFeeAmount;
    /**
     * The date and time the payment became authorized, in ISO 8601 format. This
     * parameter is omitted if the payment is not authorized (yet).
     *
     * @example "2013-12-25T10:30:54+00:00"
     *
     * @var null|string
     */
    public $authorizedAt;
    /**
     * The date and time the payment was expired, in ISO 8601 format. This
     * parameter is omitted if the payment did not expire (yet).
     *
     * @example "2013-12-25T10:30:54+00:00"
     *
     * @var null|string
     */
    public $expiredAt;
    /**
     * If a customer was specified upon payment creation, the customer’s token will
     * be available here as well.
     *
     * @example cst_XPn78q9CfT
     *
     * @var null|string
     */
    public $customerId;
    /**
     * This optional field contains your customer’s ISO 3166-1 alpha-2 country code,
     * detected by us during checkout. For example: BE. This field is omitted if the
     * country code was not detected.
     *
     * @var null|string
     */
    public $countryCode;

    /**
     * Is this payment canceled?
     *
     * @return bool
     */
    public function isCanceled()
    {
        return \Mollie\Api\Types\PaymentStatus::STATUS_CANCELED === $this->status;
    }

    /**
     * Is this payment expired?
     *
     * @return bool
     */
    public function isExpired()
    {
        return \Mollie\Api\Types\PaymentStatus::STATUS_EXPIRED === $this->status;
    }

    /**
     * Is this payment still open / ongoing?
     *
     * @return bool
     */
    public function isOpen()
    {
        return \Mollie\Api\Types\PaymentStatus::STATUS_OPEN === $this->status;
    }

    /**
     * Is this payment pending?
     *
     * @return bool
     */
    public function isPending()
    {
        return \Mollie\Api\Types\PaymentStatus::STATUS_PENDING === $this->status;
    }

    /**
     * Is this payment authorized?
     *
     * @return bool
     */
    public function isAuthorized()
    {
        return \Mollie\Api\Types\PaymentStatus::STATUS_AUTHORIZED === $this->status;
    }

    /**
     * Is this payment paid for?
     *
     * @return bool
     */
    public function isPaid()
    {
        return !empty($this->paidAt);
    }

    /**
     * Does the payment have refunds.
     *
     * @return bool
     */
    public function hasRefunds()
    {
        return !empty($this->_links->refunds);
    }

    /**
     * Does this payment has chargebacks.
     *
     * @return bool
     */
    public function hasChargebacks()
    {
        return !empty($this->_links->chargebacks);
    }

    /**
     * Is this payment failing?
     *
     * @return bool
     */
    public function isFailed()
    {
        return \Mollie\Api\Types\PaymentStatus::STATUS_FAILED === $this->status;
    }

    /**
     * Check whether 'sequenceType' is set to 'first'. If a 'first' payment has been
     * completed successfully, the consumer's account may be charged automatically
     * using recurring payments.
     *
     * @return bool
     */
    public function hasSequenceTypeFirst()
    {
        return \Mollie\Api\Types\SequenceType::SEQUENCETYPE_FIRST === $this->sequenceType;
    }

    /**
     * Check whether 'sequenceType' is set to 'recurring'. This type of payment is
     * processed without involving
     * the consumer.
     *
     * @return bool
     */
    public function hasSequenceTypeRecurring()
    {
        return \Mollie\Api\Types\SequenceType::SEQUENCETYPE_RECURRING === $this->sequenceType;
    }

    /**
     * Get the checkout URL where the customer can complete the payment.
     *
     * @return null|string
     */
    public function getCheckoutUrl()
    {
        if (empty($this->_links->checkout)) {
            return null;
        }

        return $this->_links->checkout->href;
    }

    /**
     * @return bool
     */
    public function canBeRefunded()
    {
        return null !== $this->amountRemaining;
    }

    /**
     * @return bool
     */
    public function canBePartiallyRefunded()
    {
        return $this->canBeRefunded();
    }

    /**
     * Get the amount that is already refunded.
     *
     * @return float
     */
    public function getAmountRefunded()
    {
        if ($this->amountRefunded) {
            return (float) $this->amountRefunded->value;
        }

        return 0.0;
    }

    /**
     * Get the remaining amount that can be refunded. For some payment methods this
     * amount can be higher than the payment amount. This is possible to reimburse
     * the costs for a return shipment to your customer for example.
     *
     * @return float
     */
    public function getAmountRemaining()
    {
        if ($this->amountRemaining) {
            return (float) $this->amountRemaining->value;
        }

        return 0.0;
    }

    /**
     * Retrieves all refunds associated with this payment.
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

    /**
     * @param string $refundId
     *
     * @return Refund
     */
    public function getRefund($refundId, array $parameters = [])
    {
        return $this->client->paymentRefunds->getFor($this, $refundId, $this->withPresetOptions($parameters));
    }

    /**
     * Retrieves all captures associated with this payment.
     *
     * @throws ApiException
     *
     * @return CaptureCollection
     */
    public function captures()
    {
        if (!isset($this->_links->captures->href)) {
            return new \Mollie\Api\Resources\CaptureCollection($this->client, 0, null);
        }
        $result = $this->client->performHttpCallToFullUrl(\Mollie\Api\MollieApiClient::HTTP_GET, $this->_links->captures->href);

        return \Mollie\Api\Resources\ResourceFactory::createCursorResourceCollection($this->client, $result->_embedded->captures, \Mollie\Api\Resources\Capture::class, $result->_links);
    }

    /**
     * @param string $captureId
     *
     * @return Capture
     */
    public function getCapture($captureId, array $parameters = [])
    {
        return $this->client->paymentCaptures->getFor($this, $captureId, $this->withPresetOptions($parameters));
    }

    /**
     * Retrieves all chargebacks associated with this payment.
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
     * Retrieves a specific chargeback for this payment.
     *
     * @param string $chargebackId
     *
     * @return Chargeback
     */
    public function getChargeback($chargebackId, array $parameters = [])
    {
        return $this->client->paymentChargebacks->getFor($this, $chargebackId, $this->withPresetOptions($parameters));
    }

    /**
     * Issue a refund for this payment.
     *
     * @param array $data
     *
     * @throws ApiException
     *
     * @return BaseResource
     */
    public function refund($data)
    {
        $resource = 'payments/'.\urlencode($this->id).'/refunds';
        $data = $this->withPresetOptions($data);
        $body = null;
        if (\count($data) > 0) {
            $body = \json_encode($data);
        }
        $result = $this->client->performHttpCall(\Mollie\Api\MollieApiClient::HTTP_POST, $resource, $body);

        return \Mollie\Api\Resources\ResourceFactory::createFromApiResult($result, new \Mollie\Api\Resources\Refund($this->client));
    }

    public function update()
    {
        if (!isset($this->_links->self->href)) {
            return $this;
        }
        $body = \json_encode(['description' => $this->description, 'redirectUrl' => $this->redirectUrl, 'webhookUrl' => $this->webhookUrl, 'metadata' => $this->metadata, 'restrictPaymentMethodsToCountry' => $this->restrictPaymentMethodsToCountry]);
        $result = $this->client->performHttpCallToFullUrl(\Mollie\Api\MollieApiClient::HTTP_PATCH, $this->_links->self->href, $body);

        return \Mollie\Api\Resources\ResourceFactory::createFromApiResult($result, new \Mollie\Api\Resources\Payment($this->client));
    }

    /**
     * The total amount that is already captured for this payment. Only available
     * when this payment supports captures.
     *
     * @return float
     */
    public function getAmountCaptured()
    {
        if ($this->amountCaptured) {
            return (float) $this->amountCaptured->value;
        }

        return 0.0;
    }

    /**
     * The amount that has been settled.
     *
     * @return float
     */
    public function getSettlementAmount()
    {
        if ($this->settlementAmount) {
            return (float) $this->settlementAmount->value;
        }

        return 0.0;
    }

    /**
     * The total amount that is already captured for this payment. Only available
     * when this payment supports captures.
     *
     * @return float
     */
    public function getApplicationFeeAmount()
    {
        if ($this->applicationFeeAmount) {
            return (float) $this->applicationFeeAmount->value;
        }

        return 0.0;
    }

    /**
     * When accessed by oAuth we want to pass the testmode by default.
     *
     * @return array
     */
    private function getPresetOptions()
    {
        $options = [];
        if ($this->client->usesOAuth()) {
            $options['testmode'] = 'test' === $this->mode ? \true : \false;
        }

        return $options;
    }

    /**
     * Apply the preset options.
     *
     * @return array
     */
    private function withPresetOptions(array $options)
    {
        return \array_merge($this->getPresetOptions(), $options);
    }
}
