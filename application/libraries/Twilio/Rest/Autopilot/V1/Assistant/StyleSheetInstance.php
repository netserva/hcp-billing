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
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains preview products that are subject to change. Use them with caution. If you currently do not have developer preview access, please contact help@twilio.com.
 *
 * @property string $accountSid
 * @property string $assistantSid
 * @property string $url
 * @property array  $data
 */
class StyleSheetInstance extends InstanceResource
{
    /**
     * Initialize the StyleSheetInstance.
     *
     * @param Version $version      Version that contains the resource
     * @param mixed[] $payload      The response payload
     * @param string  $assistantSid The SID of the Assistant that is the parent of
     *                              the resource
     */
    public function __construct(Version $version, array $payload, string $assistantSid)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'assistantSid' => Values::array_get($payload, 'assistant_sid'),
            'url' => Values::array_get($payload, 'url'),
            'data' => Values::array_get($payload, 'data'),
        ];

        $this->solution = ['assistantSid' => $assistantSid];
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

        return '[Twilio.Autopilot.V1.StyleSheetInstance '.\implode(' ', $context).']';
    }

    /**
     * Fetch the StyleSheetInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return StyleSheetInstance Fetched StyleSheetInstance
     */
    public function fetch(): StyleSheetInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Update the StyleSheetInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return StyleSheetInstance Updated StyleSheetInstance
     */
    public function update(array $options = []): StyleSheetInstance
    {
        return $this->proxy()->update($options);
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context.
     *
     * @return StyleSheetContext Context for this StyleSheetInstance
     */
    protected function proxy(): StyleSheetContext
    {
        if (!$this->context) {
            $this->context = new StyleSheetContext($this->version, $this->solution['assistantSid']);
        }

        return $this->context;
    }
}
