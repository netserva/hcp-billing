<?php

declare(strict_types=1);

namespace Mollie\Api\Resources;

class Organization extends \Mollie\Api\Resources\BaseResource
{
    /**
     * Id of the payment method.
     *
     * @var string
     */
    public $id;
    /**
     * The name of the organization.
     *
     * @var string
     */
    public $name;
    /**
     * The email address of the organization.
     *
     * @var string
     */
    public $email;
    /**
     * The preferred locale of the merchant which has been set in Mollie Dashboard.
     *
     * @var string
     */
    public $locale;
    /**
     * The address of the organization.
     *
     * @var \stdClass
     */
    public $address;
    /**
     * The registration number of the organization at the (local) chamber of
     * commerce.
     *
     * @var string
     */
    public $registrationNumber;
    /**
     * The VAT number of the organization, if based in the European Union. The VAT
     * number has been checked with the VIES by Mollie.
     *
     * @var string
     */
    public $vatNumber;
    /**
     * @var \stdClass
     */
    public $_links;
}
