<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Studio\V1\Flow\Execution\ExecutionStep;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Version;

class ExecutionStepContextContext extends InstanceContext
{
    /**
     * Initialize the ExecutionStepContextContext.
     *
     * @param Version $version      Version that contains the resource
     * @param string  $flowSid      The SID of the Flow
     * @param string  $executionSid The SID of the Execution
     * @param string  $stepSid      Step SID
     */
    public function __construct(Version $version, $flowSid, $executionSid, $stepSid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['flowSid' => $flowSid, 'executionSid' => $executionSid, 'stepSid' => $stepSid];

        $this->uri = '/Flows/'.\rawurlencode($flowSid).'/Executions/'.\rawurlencode($executionSid).'/Steps/'.\rawurlencode($stepSid).'/Context';
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

        return '[Twilio.Studio.V1.ExecutionStepContextContext '.\implode(' ', $context).']';
    }

    /**
     * Fetch the ExecutionStepContextInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return ExecutionStepContextInstance Fetched ExecutionStepContextInstance
     */
    public function fetch(): ExecutionStepContextInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);

        return new ExecutionStepContextInstance(
            $this->version,
            $payload,
            $this->solution['flowSid'],
            $this->solution['executionSid'],
            $this->solution['stepSid']
        );
    }
}
