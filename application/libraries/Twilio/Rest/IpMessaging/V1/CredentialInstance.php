<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\IpMessaging\V1;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string    $sid
 * @property string    $accountSid
 * @property string    $friendlyName
 * @property string    $type
 * @property string    $sandbox
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 * @property string    $url
 */
class CredentialInstance extends InstanceResource
{
    /**
     * Initialize the CredentialInstance.
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string  $sid     The sid
     */
    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'sid' => Values::array_get($payload, 'sid'),
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'friendlyName' => Values::array_get($payload, 'friendly_name'),
            'type' => Values::array_get($payload, 'type'),
            'sandbox' => Values::array_get($payload, 'sandbox'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'url' => Values::array_get($payload, 'url'),
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

        return '[Twilio.IpMessaging.V1.CredentialInstance '.\implode(' ', $context).']';
    }

    /**
     * Fetch the CredentialInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return CredentialInstance Fetched CredentialInstance
     */
    public function fetch(): CredentialInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Update the CredentialInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return CredentialInstance Updated CredentialInstance
     */
    public function update(array $options = []): CredentialInstance
    {
        return $this->proxy()->update($options);
    }

    /**
     * Delete the CredentialInstance.
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
     * @return CredentialContext Context for this CredentialInstance
     */
    protected function proxy(): CredentialContext
    {
        if (!$this->context) {
            $this->context = new CredentialContext($this->version, $this->solution['sid']);
        }

        return $this->context;
    }
}
