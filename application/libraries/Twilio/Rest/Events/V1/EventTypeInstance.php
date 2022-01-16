<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Events\V1;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains beta products that are subject to change. Use them with caution.
 *
 * @property string    $type
 * @property string    $schemaId
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 * @property string    $description
 * @property string    $url
 * @property array     $links
 */
class EventTypeInstance extends InstanceResource
{
    /**
     * Initialize the EventTypeInstance.
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string  $type    a string that uniquely identifies this Event Type
     */
    public function __construct(Version $version, array $payload, string $type = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'type' => Values::array_get($payload, 'type'),
            'schemaId' => Values::array_get($payload, 'schema_id'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'description' => Values::array_get($payload, 'description'),
            'url' => Values::array_get($payload, 'url'),
            'links' => Values::array_get($payload, 'links'),
        ];

        $this->solution = ['type' => $type ?: $this->properties['type']];
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

        return '[Twilio.Events.V1.EventTypeInstance '.\implode(' ', $context).']';
    }

    /**
     * Fetch the EventTypeInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return EventTypeInstance Fetched EventTypeInstance
     */
    public function fetch(): EventTypeInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context.
     *
     * @return EventTypeContext Context for this EventTypeInstance
     */
    protected function proxy(): EventTypeContext
    {
        if (!$this->context) {
            $this->context = new EventTypeContext($this->version, $this->solution['type']);
        }

        return $this->context;
    }
}
