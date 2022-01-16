<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Proxy\V1\Service\Session;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains beta products that are subject to change. Use them with caution.
 */
class InteractionContext extends InstanceContext
{
    /**
     * Initialize the InteractionContext.
     *
     * @param Version $version    Version that contains the resource
     * @param string  $serviceSid The SID of the parent Service of the resource to
     *                            fetch
     * @param string  $sessionSid he SID of the parent Session of the resource to
     *                            fetch
     * @param string  $sid        The unique string that identifies the resource
     */
    public function __construct(Version $version, $serviceSid, $sessionSid, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['serviceSid' => $serviceSid, 'sessionSid' => $sessionSid, 'sid' => $sid];

        $this->uri = '/Services/'.\rawurlencode($serviceSid).'/Sessions/'.\rawurlencode($sessionSid).'/Interactions/'.\rawurlencode($sid).'';
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

        return '[Twilio.Proxy.V1.InteractionContext '.\implode(' ', $context).']';
    }

    /**
     * Fetch the InteractionInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return InteractionInstance Fetched InteractionInstance
     */
    public function fetch(): InteractionInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);

        return new InteractionInstance(
            $this->version,
            $payload,
            $this->solution['serviceSid'],
            $this->solution['sessionSid'],
            $this->solution['sid']
        );
    }

    /**
     * Delete the InteractionInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return bool True if delete succeeds, false otherwise
     */
    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }
}
