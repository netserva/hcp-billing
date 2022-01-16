<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\IpMessaging\V2\Service;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\IpMessaging\V2\Service\User\UserBindingList;
use Twilio\Rest\IpMessaging\V2\Service\User\UserChannelList;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string    $sid
 * @property string    $accountSid
 * @property string    $serviceSid
 * @property string    $attributes
 * @property string    $friendlyName
 * @property string    $roleSid
 * @property string    $identity
 * @property bool      $isOnline
 * @property bool      $isNotifiable
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 * @property int       $joinedChannelsCount
 * @property array     $links
 * @property string    $url
 */
class UserInstance extends InstanceResource
{
    protected $_userChannels;
    protected $_userBindings;

    /**
     * Initialize the UserInstance.
     *
     * @param Version $version    Version that contains the resource
     * @param mixed[] $payload    The response payload
     * @param string  $serviceSid The service_sid
     * @param string  $sid        The sid
     */
    public function __construct(Version $version, array $payload, string $serviceSid, string $sid = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'sid' => Values::array_get($payload, 'sid'),
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'serviceSid' => Values::array_get($payload, 'service_sid'),
            'attributes' => Values::array_get($payload, 'attributes'),
            'friendlyName' => Values::array_get($payload, 'friendly_name'),
            'roleSid' => Values::array_get($payload, 'role_sid'),
            'identity' => Values::array_get($payload, 'identity'),
            'isOnline' => Values::array_get($payload, 'is_online'),
            'isNotifiable' => Values::array_get($payload, 'is_notifiable'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'joinedChannelsCount' => Values::array_get($payload, 'joined_channels_count'),
            'links' => Values::array_get($payload, 'links'),
            'url' => Values::array_get($payload, 'url'),
        ];

        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid ?: $this->properties['sid']];
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

        return '[Twilio.IpMessaging.V2.UserInstance '.\implode(' ', $context).']';
    }

    /**
     * Fetch the UserInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return UserInstance Fetched UserInstance
     */
    public function fetch(): UserInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Delete the UserInstance.
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
     * Update the UserInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return UserInstance Updated UserInstance
     */
    public function update(array $options = []): UserInstance
    {
        return $this->proxy()->update($options);
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context.
     *
     * @return UserContext Context for this UserInstance
     */
    protected function proxy(): UserContext
    {
        if (!$this->context) {
            $this->context = new UserContext(
                $this->version,
                $this->solution['serviceSid'],
                $this->solution['sid']
            );
        }

        return $this->context;
    }

    /**
     * Access the userChannels.
     */
    protected function getUserChannels(): UserChannelList
    {
        return $this->proxy()->userChannels;
    }

    /**
     * Access the userBindings.
     */
    protected function getUserBindings(): UserBindingList
    {
        return $this->proxy()->userBindings;
    }
}
