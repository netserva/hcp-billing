<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Preview\Understand\Assistant;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains preview products that are subject to change. Use them with caution. If you currently do not have developer preview access, please contact help@twilio.com.
 */
class ModelBuildContext extends InstanceContext
{
    /**
     * Initialize the ModelBuildContext.
     *
     * @param Version $version      Version that contains the resource
     * @param string  $assistantSid The assistant_sid
     * @param string  $sid          The sid
     */
    public function __construct(Version $version, $assistantSid, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['assistantSid' => $assistantSid, 'sid' => $sid];

        $this->uri = '/Assistants/'.\rawurlencode($assistantSid).'/ModelBuilds/'.\rawurlencode($sid).'';
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

        return '[Twilio.Preview.Understand.ModelBuildContext '.\implode(' ', $context).']';
    }

    /**
     * Fetch the ModelBuildInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return ModelBuildInstance Fetched ModelBuildInstance
     */
    public function fetch(): ModelBuildInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);

        return new ModelBuildInstance(
            $this->version,
            $payload,
            $this->solution['assistantSid'],
            $this->solution['sid']
        );
    }

    /**
     * Update the ModelBuildInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return ModelBuildInstance Updated ModelBuildInstance
     */
    public function update(array $options = []): ModelBuildInstance
    {
        $options = new Values($options);

        $data = Values::of(['UniqueName' => $options['uniqueName']]);

        $payload = $this->version->update('POST', $this->uri, [], $data);

        return new ModelBuildInstance(
            $this->version,
            $payload,
            $this->solution['assistantSid'],
            $this->solution['sid']
        );
    }

    /**
     * Delete the ModelBuildInstance.
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
