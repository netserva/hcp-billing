<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Autopilot\V1\Assistant;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains preview products that are subject to change. Use them with caution. If you currently do not have developer preview access, please contact help@twilio.com.
 */
class QueryContext extends InstanceContext
{
    /**
     * Initialize the QueryContext.
     *
     * @param Version $version      Version that contains the resource
     * @param string  $assistantSid The SID of the Assistant that is the parent of
     *                              the resource to fetch
     * @param string  $sid          The unique string that identifies the resource
     */
    public function __construct(Version $version, $assistantSid, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['assistantSid' => $assistantSid, 'sid' => $sid];

        $this->uri = '/Assistants/'.\rawurlencode($assistantSid).'/Queries/'.\rawurlencode($sid).'';
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

        return '[Twilio.Autopilot.V1.QueryContext '.\implode(' ', $context).']';
    }

    /**
     * Fetch the QueryInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return QueryInstance Fetched QueryInstance
     */
    public function fetch(): QueryInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);

        return new QueryInstance(
            $this->version,
            $payload,
            $this->solution['assistantSid'],
            $this->solution['sid']
        );
    }

    /**
     * Update the QueryInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return QueryInstance Updated QueryInstance
     */
    public function update(array $options = []): QueryInstance
    {
        $options = new Values($options);

        $data = Values::of(['SampleSid' => $options['sampleSid'], 'Status' => $options['status']]);

        $payload = $this->version->update('POST', $this->uri, [], $data);

        return new QueryInstance(
            $this->version,
            $payload,
            $this->solution['assistantSid'],
            $this->solution['sid']
        );
    }

    /**
     * Delete the QueryInstance.
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
