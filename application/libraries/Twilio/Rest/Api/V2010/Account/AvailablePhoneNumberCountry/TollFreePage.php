<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountry;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class TollFreePage extends Page
{
    /**
     * @param Version  $version  Version that contains the resource
     * @param Response $response Response from the API
     * @param array    $solution The context solution
     */
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);

        // Path Solution
        $this->solution = $solution;
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        return '[Twilio.Api.V2010.TollFreePage]';
    }

    /**
     * @param array $payload Payload response from the API
     *
     * @return TollFreeInstance \Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountry\TollFreeInstance
     */
    public function buildInstance(array $payload): TollFreeInstance
    {
        return new TollFreeInstance(
            $this->version,
            $payload,
            $this->solution['accountSid'],
            $this->solution['countryCode']
        );
    }
}
