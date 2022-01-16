<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Api\V2010\Account\Recording\AddOnResult;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class PayloadPage extends Page
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
        return '[Twilio.Api.V2010.PayloadPage]';
    }

    /**
     * @param array $payload Payload response from the API
     *
     * @return PayloadInstance \Twilio\Rest\Api\V2010\Account\Recording\AddOnResult\PayloadInstance
     */
    public function buildInstance(array $payload): PayloadInstance
    {
        return new PayloadInstance(
            $this->version,
            $payload,
            $this->solution['accountSid'],
            $this->solution['referenceSid'],
            $this->solution['addOnResultSid']
        );
    }
}
