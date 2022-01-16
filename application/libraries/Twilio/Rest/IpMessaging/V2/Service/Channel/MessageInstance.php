<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\IpMessaging\V2\Service\Channel;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string    $sid
 * @property string    $accountSid
 * @property string    $attributes
 * @property string    $serviceSid
 * @property string    $to
 * @property string    $channelSid
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 * @property string    $lastUpdatedBy
 * @property bool      $wasEdited
 * @property string    $from
 * @property string    $body
 * @property int       $index
 * @property string    $type
 * @property array     $media
 * @property string    $url
 */
class MessageInstance extends InstanceResource
{
    /**
     * Initialize the MessageInstance.
     *
     * @param Version $version    Version that contains the resource
     * @param mixed[] $payload    The response payload
     * @param string  $serviceSid The service_sid
     * @param string  $channelSid The channel_sid
     * @param string  $sid        The sid
     */
    public function __construct(Version $version, array $payload, string $serviceSid, string $channelSid, string $sid = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'sid' => Values::array_get($payload, 'sid'),
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'attributes' => Values::array_get($payload, 'attributes'),
            'serviceSid' => Values::array_get($payload, 'service_sid'),
            'to' => Values::array_get($payload, 'to'),
            'channelSid' => Values::array_get($payload, 'channel_sid'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'lastUpdatedBy' => Values::array_get($payload, 'last_updated_by'),
            'wasEdited' => Values::array_get($payload, 'was_edited'),
            'from' => Values::array_get($payload, 'from'),
            'body' => Values::array_get($payload, 'body'),
            'index' => Values::array_get($payload, 'index'),
            'type' => Values::array_get($payload, 'type'),
            'media' => Values::array_get($payload, 'media'),
            'url' => Values::array_get($payload, 'url'),
        ];

        $this->solution = [
            'serviceSid' => $serviceSid,
            'channelSid' => $channelSid,
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

        return '[Twilio.IpMessaging.V2.MessageInstance '.\implode(' ', $context).']';
    }

    /**
     * Fetch the MessageInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return MessageInstance Fetched MessageInstance
     */
    public function fetch(): MessageInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Delete the MessageInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return bool True if delete succeeds, false otherwise
     */
    public function delete(array $options = []): bool
    {
        return $this->proxy()->delete($options);
    }

    /**
     * Update the MessageInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return MessageInstance Updated MessageInstance
     */
    public function update(array $options = []): MessageInstance
    {
        return $this->proxy()->update($options);
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context.
     *
     * @return MessageContext Context for this MessageInstance
     */
    protected function proxy(): MessageContext
    {
        if (!$this->context) {
            $this->context = new MessageContext(
                $this->version,
                $this->solution['serviceSid'],
                $this->solution['channelSid'],
                $this->solution['sid']
            );
        }

        return $this->context;
    }
}
