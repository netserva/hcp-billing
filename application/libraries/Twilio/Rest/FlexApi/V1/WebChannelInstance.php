<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\FlexApi\V1;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string    $accountSid
 * @property string    $flexFlowSid
 * @property string    $sid
 * @property string    $url
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 */
class WebChannelInstance extends InstanceResource
{
    /**
     * Initialize the WebChannelInstance.
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string  $sid     The SID of the WebChannel resource to fetch
     */
    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'flexFlowSid' => Values::array_get($payload, 'flex_flow_sid'),
            'sid' => Values::array_get($payload, 'sid'),
            'url' => Values::array_get($payload, 'url'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
        ];

        $this->solution = ['sid' => $sid ?: $this->properties['sid']];
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

        return '[Twilio.FlexApi.V1.WebChannelInstance '.\implode(' ', $context).']';
    }

    /**
     * Fetch the WebChannelInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return WebChannelInstance Fetched WebChannelInstance
     */
    public function fetch(): WebChannelInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Update the WebChannelInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return WebChannelInstance Updated WebChannelInstance
     */
    public function update(array $options = []): WebChannelInstance
    {
        return $this->proxy()->update($options);
    }

    /**
     * Delete the WebChannelInstance.
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
     * @return WebChannelContext Context for this WebChannelInstance
     */
    protected function proxy(): WebChannelContext
    {
        if (!$this->context) {
            $this->context = new WebChannelContext($this->version, $this->solution['sid']);
        }

        return $this->context;
    }
}
