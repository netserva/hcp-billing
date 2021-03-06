<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Numbers\V2\RegulatoryCompliance;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string $sid
 * @property string $friendlyName
 * @property string $isoCountry
 * @property string $numberType
 * @property string $endUserType
 * @property array  $requirements
 * @property string $url
 */
class RegulationInstance extends InstanceResource
{
    /**
     * Initialize the RegulationInstance.
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string  $sid     The unique string that identifies the Regulation resource
     */
    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'sid' => Values::array_get($payload, 'sid'),
            'friendlyName' => Values::array_get($payload, 'friendly_name'),
            'isoCountry' => Values::array_get($payload, 'iso_country'),
            'numberType' => Values::array_get($payload, 'number_type'),
            'endUserType' => Values::array_get($payload, 'end_user_type'),
            'requirements' => Values::array_get($payload, 'requirements'),
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

        return '[Twilio.Numbers.V2.RegulationInstance '.\implode(' ', $context).']';
    }

    /**
     * Fetch the RegulationInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return RegulationInstance Fetched RegulationInstance
     */
    public function fetch(): RegulationInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context.
     *
     * @return RegulationContext Context for this RegulationInstance
     */
    protected function proxy(): RegulationContext
    {
        if (!$this->context) {
            $this->context = new RegulationContext($this->version, $this->solution['sid']);
        }

        return $this->context;
    }
}
