<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Preview\Wireless;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains preview products that are subject to change. Use them with caution. If you currently do not have developer preview access, please contact help@twilio.com.
 */
class CommandContext extends InstanceContext
{
    /**
     * Initialize the CommandContext.
     *
     * @param Version $version Version that contains the resource
     * @param string  $sid     The sid
     */
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['sid' => $sid];

        $this->uri = '/Commands/'.\rawurlencode($sid).'';
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

        return '[Twilio.Preview.Wireless.CommandContext '.\implode(' ', $context).']';
    }

    /**
     * Fetch the CommandInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return CommandInstance Fetched CommandInstance
     */
    public function fetch(): CommandInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);

        return new CommandInstance($this->version, $payload, $this->solution['sid']);
    }
}
