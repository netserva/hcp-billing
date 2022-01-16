<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Supersim\V1;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains beta products that are subject to change. Use them with caution.
 *
 * @property string    $accountSid
 * @property string    $sid
 * @property string    $uniqueName
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 * @property string    $url
 * @property bool      $dataEnabled
 * @property int       $dataLimit
 * @property string    $dataMetering
 * @property bool      $commandsEnabled
 * @property string    $commandsUrl
 * @property string    $commandsMethod
 * @property bool      $smsCommandsEnabled
 * @property string    $smsCommandsUrl
 * @property string    $smsCommandsMethod
 * @property string    $networkAccessProfileSid
 */
class FleetInstance extends InstanceResource
{
    /**
     * Initialize the FleetInstance.
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string  $sid     The SID that identifies the resource to fetch
     */
    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'sid' => Values::array_get($payload, 'sid'),
            'uniqueName' => Values::array_get($payload, 'unique_name'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'url' => Values::array_get($payload, 'url'),
            'dataEnabled' => Values::array_get($payload, 'data_enabled'),
            'dataLimit' => Values::array_get($payload, 'data_limit'),
            'dataMetering' => Values::array_get($payload, 'data_metering'),
            'commandsEnabled' => Values::array_get($payload, 'commands_enabled'),
            'commandsUrl' => Values::array_get($payload, 'commands_url'),
            'commandsMethod' => Values::array_get($payload, 'commands_method'),
            'smsCommandsEnabled' => Values::array_get($payload, 'sms_commands_enabled'),
            'smsCommandsUrl' => Values::array_get($payload, 'sms_commands_url'),
            'smsCommandsMethod' => Values::array_get($payload, 'sms_commands_method'),
            'networkAccessProfileSid' => Values::array_get($payload, 'network_access_profile_sid'),
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

        return '[Twilio.Supersim.V1.FleetInstance '.\implode(' ', $context).']';
    }

    /**
     * Fetch the FleetInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return FleetInstance Fetched FleetInstance
     */
    public function fetch(): FleetInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Update the FleetInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return FleetInstance Updated FleetInstance
     */
    public function update(array $options = []): FleetInstance
    {
        return $this->proxy()->update($options);
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context.
     *
     * @return FleetContext Context for this FleetInstance
     */
    protected function proxy(): FleetContext
    {
        if (!$this->context) {
            $this->context = new FleetContext($this->version, $this->solution['sid']);
        }

        return $this->context;
    }
}
