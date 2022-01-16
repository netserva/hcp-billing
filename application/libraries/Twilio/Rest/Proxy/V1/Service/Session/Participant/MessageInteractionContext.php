<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Proxy\V1\Service\Session\Participant;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains beta products that are subject to change. Use them with caution.
 */
class MessageInteractionContext extends InstanceContext
{
    /**
     * Initialize the MessageInteractionContext.
     *
     * @param Version $version        Version that contains the resource
     * @param string  $serviceSid     The SID of the Service to fetch the resource from
     * @param string  $sessionSid     The SID of the parent Session
     * @param string  $participantSid The SID of the Participant resource
     * @param string  $sid            The unique string that identifies the resource
     */
    public function __construct(Version $version, $serviceSid, $sessionSid, $participantSid, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            'serviceSid' => $serviceSid,
            'sessionSid' => $sessionSid,
            'participantSid' => $participantSid,
            'sid' => $sid,
        ];

        $this->uri = '/Services/'.\rawurlencode($serviceSid).'/Sessions/'.\rawurlencode($sessionSid).'/Participants/'.\rawurlencode($participantSid).'/MessageInteractions/'.\rawurlencode($sid).'';
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "{$key}={$value}";
        }

        return '[Twilio.Proxy.V1.MessageInteractionContext '.\implode(' ', $context).']';
    }

    /**
     * Fetch the MessageInteractionInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return MessageInteractionInstance Fetched MessageInteractionInstance
     */
    public function fetch(): MessageInteractionInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);

        return new MessageInteractionInstance(
            $this->version,
            $payload,
            $this->solution['serviceSid'],
            $this->solution['sessionSid'],
            $this->solution['participantSid'],
            $this->solution['sid']
        );
    }
}
