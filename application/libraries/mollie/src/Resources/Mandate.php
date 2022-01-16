<?php

declare(strict_types=1);

namespace Mollie\Api\Resources;

class Mandate extends \Mollie\Api\Resources\BaseResource
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
    public $status;
    /**
     * @var string
     */
    public $mode;
    /**
     * @var string
     */
    public $method;
    /**
     * @var null|\stdClass
     */
    public $details;
    /**
     * @var string
     */
    public $customerId;
    /**
     * @var string
     */
    public $createdAt;
    /**
     * @var string
     */
    public $mandateReference;
    /**
     * Date of signature, for example: 2018-05-07.
     *
     * @var string
     */
    public $signatureDate;
    /**
     * @var \stdClass
     */
    public $_links;

    /**
     * @return bool
     */
    public function isValid()
    {
        return \Mollie\Api\Types\MandateStatus::STATUS_VALID === $this->status;
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return \Mollie\Api\Types\MandateStatus::STATUS_PENDING === $this->status;
    }

    /**
     * @return bool
     */
    public function isInvalid()
    {
        return \Mollie\Api\Types\MandateStatus::STATUS_INVALID === $this->status;
    }

    /**
     * Revoke the mandate.
     */
    public function revoke()
    {
        if (!isset($this->_links->self->href)) {
            return $this;
        }
        $body = null;
        if ($this->client->usesOAuth()) {
            $body = \json_encode(['testmode' => 'test' === $this->mode ? \true : \false]);
        }

        return $this->client->performHttpCallToFullUrl(\Mollie\Api\MollieApiClient::HTTP_DELETE, $this->_links->self->href, $body);
    }
}
