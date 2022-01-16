<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber\AssignedAddOn\AssignedAddOnExtensionList;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains beta products that are subject to change. Use them with caution.
 *
 * @property string    $sid
 * @property string    $accountSid
 * @property string    $resourceSid
 * @property string    $friendlyName
 * @property string    $description
 * @property array     $configuration
 * @property string    $uniqueName
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 * @property string    $uri
 * @property array     $subresourceUris
 */
class AssignedAddOnInstance extends InstanceResource
{
    protected $_extensions;

    /**
     * Initialize the AssignedAddOnInstance.
     *
     * @param Version $version     Version that contains the resource
     * @param mixed[] $payload     The response payload
     * @param string  $accountSid  The SID of the Account that created the resource
     * @param string  $resourceSid The SID of the Phone Number that installed this
     *                             Add-on
     * @param string  $sid         The unique string that identifies the resource
     */
    public function __construct(Version $version, array $payload, string $accountSid, string $resourceSid, string $sid = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'sid' => Values::array_get($payload, 'sid'),
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'resourceSid' => Values::array_get($payload, 'resource_sid'),
            'friendlyName' => Values::array_get($payload, 'friendly_name'),
            'description' => Values::array_get($payload, 'description'),
            'configuration' => Values::array_get($payload, 'configuration'),
            'uniqueName' => Values::array_get($payload, 'unique_name'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'uri' => Values::array_get($payload, 'uri'),
            'subresourceUris' => Values::array_get($payload, 'subresource_uris'),
        ];

        $this->solution = [
            'accountSid' => $accountSid,
            'resourceSid' => $resourceSid,
            'sid' => $sid ?: $this->properties['sid'],
        ];
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

        return '[Twilio.Api.V2010.AssignedAddOnInstance '.\implode(' ', $context).']';
    }

    /**
     * Fetch the AssignedAddOnInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return AssignedAddOnInstance Fetched AssignedAddOnInstance
     */
    public function fetch(): AssignedAddOnInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Delete the AssignedAddOnInstance.
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
     * @return AssignedAddOnContext Context for this AssignedAddOnInstance
     */
    protected function proxy(): AssignedAddOnContext
    {
        if (!$this->context) {
            $this->context = new AssignedAddOnContext(
                $this->version,
                $this->solution['accountSid'],
                $this->solution['resourceSid'],
                $this->solution['sid']
            );
        }

        return $this->context;
    }

    /**
     * Access the extensions.
     */
    protected function getExtensions(): AssignedAddOnExtensionList
    {
        return $this->proxy()->extensions;
    }
}
