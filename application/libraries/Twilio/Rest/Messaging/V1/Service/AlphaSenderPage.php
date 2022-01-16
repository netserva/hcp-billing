<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Messaging\V1\Service;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains beta products that are subject to change. Use them with caution.
 */
class AlphaSenderPage extends Page
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
        return '[Twilio.Messaging.V1.AlphaSenderPage]';
    }

    /**
     * @param array $payload Payload response from the API
     *
     * @return AlphaSenderInstance \Twilio\Rest\Messaging\V1\Service\AlphaSenderInstance
     */
    public function buildInstance(array $payload): AlphaSenderInstance
    {
        return new AlphaSenderInstance($this->version, $payload, $this->solution['serviceSid']);
    }
}
