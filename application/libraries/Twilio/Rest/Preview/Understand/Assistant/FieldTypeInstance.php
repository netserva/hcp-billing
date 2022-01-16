<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Preview\Understand\Assistant;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Preview\Understand\Assistant\FieldType\FieldValueList;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains preview products that are subject to change. Use them with caution. If you currently do not have developer preview access, please contact help@twilio.com.
 *
 * @property string    $accountSid
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 * @property string    $friendlyName
 * @property array     $links
 * @property string    $assistantSid
 * @property string    $sid
 * @property string    $uniqueName
 * @property string    $url
 */
class FieldTypeInstance extends InstanceResource
{
    protected $_fieldValues;

    /**
     * Initialize the FieldTypeInstance.
     *
     * @param Version $version      Version that contains the resource
     * @param mixed[] $payload      The response payload
     * @param string  $assistantSid the unique ID of the Assistant
     * @param string  $sid          The sid
     */
    public function __construct(Version $version, array $payload, string $assistantSid, string $sid = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'friendlyName' => Values::array_get($payload, 'friendly_name'),
            'links' => Values::array_get($payload, 'links'),
            'assistantSid' => Values::array_get($payload, 'assistant_sid'),
            'sid' => Values::array_get($payload, 'sid'),
            'uniqueName' => Values::array_get($payload, 'unique_name'),
            'url' => Values::array_get($payload, 'url'),
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

        return '[Twilio.Preview.Understand.FieldTypeInstance '.\implode(' ', $context).']';
    }

    /**
     * Fetch the FieldTypeInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return FieldTypeInstance Fetched FieldTypeInstance
     */
    public function fetch(): FieldTypeInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Update the FieldTypeInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return FieldTypeInstance Updated FieldTypeInstance
     */
    public function update(array $options = []): FieldTypeInstance
    {
        return $this->proxy()->update($options);
    }

    /**
     * Delete the FieldTypeInstance.
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
     * @return FieldTypeContext Context for this FieldTypeInstance
     */
    protected function proxy(): FieldTypeContext
    {
        if (!$this->context) {
            $this->context = new FieldTypeContext(
                $this->version,
                $this->solution['assistantSid'],
                $this->solution['sid']
            );
        }

        return $this->context;
    }

    /**
     * Access the fieldValues.
     */
    protected function getFieldValues(): FieldValueList
    {
        return $this->proxy()->fieldValues;
    }
}
