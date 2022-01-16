<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Events\V1\Sink;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains beta products that are subject to change. Use them with caution.
 */
class SinkValidateList extends ListResource
{
    /**
     * Construct the SinkValidateList.
     *
     * @param Version $version Version that contains the resource
     * @param string  $sid     a string that uniquely identifies this Sink
     */
    public function __construct(Version $version, string $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['sid' => $sid];

        $this->uri = '/Sinks/'.\rawurlencode($sid).'/Validate';
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        return '[Twilio.Events.V1.SinkValidateList]';
    }

    /**
     * Create the SinkValidateInstance.
     *
     * @param string $testId a string that uniquely identifies the test event for a
     *                       Sink being validated
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return SinkValidateInstance Created SinkValidateInstance
     */
    public function create(string $testId): SinkValidateInstance
    {
        $data = Values::of(['TestId' => $testId]);

        $payload = $this->version->create('POST', $this->uri, [], $data);

        return new SinkValidateInstance($this->version, $payload, $this->solution['sid']);
    }
}
