<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Preview\DeployedDevices\Fleet;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains preview products that are subject to change. Use them with caution. If you currently do not have developer preview access, please contact help@twilio.com.
 *
 * @property string    $sid
 * @property string    $url
 * @property string    $uniqueName
 * @property string    $friendlyName
 * @property string    $fleetSid
 * @property bool      $enabled
 * @property string    $accountSid
 * @property string    $identity
 * @property string    $deploymentSid
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 * @property \DateTime $dateAuthenticated
 */
class DeviceInstance extends InstanceResource
{
    /**
     * Initialize the DeviceInstance.
     *
     * @param Version $version  Version that contains the resource
     * @param mixed[] $payload  The response payload
     * @param string  $fleetSid the unique identifier of the Fleet
     * @param string  $sid      a string that uniquely identifies the Device
     */
    public function __construct(Version $version, array $payload, string $fleetSid, string $sid = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'sid' => Values::array_get($payload, 'sid'),
            'url' => Values::array_get($payload, 'url'),
            'uniqueName' => Values::array_get($payload, 'unique_name'),
            'friendlyName' => Values::array_get($payload, 'friendly_name'),
            'fleetSid' => Values::array_get($payload, 'fleet_sid'),
            'enabled' => Values::array_get($payload, 'enabled'),
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'identity' => Values::array_get($payload, 'identity'),
            'deploymentSid' => Values::array_get($payload, 'deployment_sid'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'dateAuthenticated' => Deserialize::dateTime(Values::array_get($payload, 'date_authenticated')),
        ];

        $this->solution = ['fleetSid' => $fleetSid, 'sid' => $sid ?: $this->properties['sid']];
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

        return '[Twilio.Preview.DeployedDevices.DeviceInstance '.\implode(' ', $context).']';
    }

    /**
     * Fetch the DeviceInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return DeviceInstance Fetched DeviceInstance
     */
    public function fetch(): DeviceInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Delete the DeviceInstance.
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
     * Update the DeviceInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return DeviceInstance Updated DeviceInstance
     */
    public function update(array $options = []): DeviceInstance
    {
        return $this->proxy()->update($options);
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context.
     *
     * @return DeviceContext Context for this DeviceInstance
     */
    protected function proxy(): DeviceContext
    {
        if (!$this->context) {
            $this->context = new DeviceContext(
                $this->version,
                $this->solution['fleetSid'],
                $this->solution['sid']
            );
        }

        return $this->context;
    }
}
