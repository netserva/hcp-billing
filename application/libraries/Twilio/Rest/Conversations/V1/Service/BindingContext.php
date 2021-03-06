<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Conversations\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Version;

class BindingContext extends InstanceContext
{
    /**
     * Initialize the BindingContext.
     *
     * @param Version $version        Version that contains the resource
     * @param string  $chatServiceSid the SID of the Conversation Service that the
     *                                resource is associated with
     * @param string  $sid            a 34 character string that uniquely identifies this
     *                                resource
     */
    public function __construct(Version $version, $chatServiceSid, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['chatServiceSid' => $chatServiceSid, 'sid' => $sid];

        $this->uri = '/Services/'.\rawurlencode($chatServiceSid).'/Bindings/'.\rawurlencode($sid).'';
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

        return '[Twilio.Conversations.V1.BindingContext '.\implode(' ', $context).']';
    }

    /**
     * Delete the BindingInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return bool True if delete succeeds, false otherwise
     */
    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    /**
     * Fetch the BindingInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return BindingInstance Fetched BindingInstance
     */
    public function fetch(): BindingInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);

        return new BindingInstance(
            $this->version,
            $payload,
            $this->solution['chatServiceSid'],
            $this->solution['sid']
        );
    }
}
