<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Conversations\V1;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class ParticipantConversationPage extends Page
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
        return '[Twilio.Conversations.V1.ParticipantConversationPage]';
    }

    /**
     * @param array $payload Payload response from the API
     *
     * @return ParticipantConversationInstance \Twilio\Rest\Conversations\V1\ParticipantConversationInstance
     */
    public function buildInstance(array $payload): ParticipantConversationInstance
    {
        return new ParticipantConversationInstance($this->version, $payload);
    }
}
