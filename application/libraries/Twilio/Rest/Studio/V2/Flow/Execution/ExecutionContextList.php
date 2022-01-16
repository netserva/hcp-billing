<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Studio\V2\Flow\Execution;

use Twilio\ListResource;
use Twilio\Version;

class ExecutionContextList extends ListResource
{
    /**
     * Construct the ExecutionContextList.
     *
     * @param Version $version      Version that contains the resource
     * @param string  $flowSid      The SID of the Flow
     * @param string  $executionSid The SID of the Execution
     */
    public function __construct(Version $version, string $flowSid, string $executionSid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['flowSid' => $flowSid, 'executionSid' => $executionSid];
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        return '[Twilio.Studio.V2.ExecutionContextList]';
    }

    /**
     * Constructs a ExecutionContextContext.
     */
    public function getContext(): ExecutionContextContext
    {
        return new ExecutionContextContext(
            $this->version,
            $this->solution['flowSid'],
            $this->solution['executionSid']
        );
    }
}
