<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\FlexApi\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Version;

class ChannelContext extends InstanceContext
{
    /**
     * Initialize the ChannelContext.
     *
     * @param Version $version Version that contains the resource
     * @param string  $sid     The SID that identifies the Flex chat channel resource to
     *                         fetch
     */
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['sid' => $sid];

        $this->uri = '/Channels/'.\rawurlencode($sid).'';
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

        return '[Twilio.FlexApi.V1.ChannelContext '.\implode(' ', $context).']';
    }

    /**
     * Fetch the ChannelInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return ChannelInstance Fetched ChannelInstance
     */
    public function fetch(): ChannelInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);

        return new ChannelInstance($this->version, $payload, $this->solution['sid']);
    }

    /**
     * Delete the ChannelInstance.
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
