<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Autopilot\V1\Assistant;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains preview products that are subject to change. Use them with caution. If you currently do not have developer preview access, please contact help@twilio.com.
 *
 * @property string    $accountSid
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 * @property string    $assistantSid
 * @property string    $sid
 * @property string    $status
 * @property string    $uniqueName
 * @property string    $url
 * @property int       $buildDuration
 * @property int       $errorCode
 */
class ModelBuildInstance extends InstanceResource
{
    /**
     * Initialize the ModelBuildInstance.
     *
     * @param Version $version      Version that contains the resource
     * @param mixed[] $payload      The response payload
     * @param string  $assistantSid The SID of the Assistant that is the parent of
     *                              the resource
     * @param string  $sid          The unique string that identifies the resource
     */
    public function __construct(Version $version, array $payload, string $assistantSid, string $sid = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'assistantSid' => Values::array_get($payload, 'assistant_sid'),
            'sid' => Values::array_get($payload, 'sid'),
            'status' => Values::array_get($payload, 'status'),
            'uniqueName' => Values::array_get($payload, 'unique_name'),
            'url' => Values::array_get($payload, 'url'),
            'buildDuration' => Values::array_get($payload, 'build_duration'),
            'errorCode' => Values::array_get($payload, 'error_code'),
        ];

        $this->solution = ['assistantSid' => $assistantSid, 'sid' => $sid ?: $this->properties['sid']];
    }

    /**
     * Magic getter to access properties.
     *
     * @param string $name Property to access
     *
     * @throws TwilioException For unknown properties
     *
     * @return mixed The requested property
     */
    public function __get(string $name)
    {
        if (\array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        if (\property_exists($this, '_'.$name)) {
            $method = 'get'.\ucfirst($name);

            return $this->{$method}();
        }

        throw new TwilioException('Unknown property: '.$name);
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

        return '[Twilio.Autopilot.V1.ModelBuildInstance '.\implode(' ', $context).']';
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
        return $this->proxy()->fetch();
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
        return $this->proxy()->update($options);
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
        return $this->proxy()->delete();
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context.
     *
     * @return ModelBuildContext Context for this ModelBuildInstance
     */
    protected function proxy(): ModelBuildContext
    {
        if (!$this->context) {
            $this->context = new ModelBuildContext(
                $this->version,
                $this->solution['assistantSid'],
                $this->solution['sid']
            );
        }

        return $this->context;
    }
}
