<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Bulkexports\V1\Export;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Version;

class DayContext extends InstanceContext
{
    /**
     * Initialize the DayContext.
     *
     * @param Version $version      Version that contains the resource
     * @param string  $resourceType The type of communication – Messages, Calls,
     *                              Conferences, and Participants
     * @param string  $day          The date of the data in the file
     */
    public function __construct(Version $version, $resourceType, $day)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['resourceType' => $resourceType, 'day' => $day];

        $this->uri = '/Exports/'.\rawurlencode($resourceType).'/Days/'.\rawurlencode($day).'';
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

        return '[Twilio.Bulkexports.V1.DayContext '.\implode(' ', $context).']';
    }

    /**
     * Fetch the DayInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return DayInstance Fetched DayInstance
     */
    public function fetch(): DayInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);

        return new DayInstance(
            $this->version,
            $payload,
            $this->solution['resourceType'],
            $this->solution['day']
        );
    }
}
