<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Chat\V1;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Chat\V1\Service\ChannelList;
use Twilio\Rest\Chat\V1\Service\RoleList;
use Twilio\Rest\Chat\V1\Service\UserList;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string    $sid
 * @property string    $accountSid
 * @property string    $friendlyName
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 * @property string    $defaultServiceRoleSid
 * @property string    $defaultChannelRoleSid
 * @property string    $defaultChannelCreatorRoleSid
 * @property bool      $readStatusEnabled
 * @property bool      $reachabilityEnabled
 * @property int       $typingIndicatorTimeout
 * @property int       $consumptionReportInterval
 * @property array     $limits
 * @property array     $webhooks
 * @property string    $preWebhookUrl
 * @property string    $postWebhookUrl
 * @property string    $webhookMethod
 * @property string[]  $webhookFilters
 * @property array     $notifications
 * @property string    $url
 * @property array     $links
 */
class ServiceInstance extends InstanceResource
{
    protected $_channels;
    protected $_roles;
    protected $_users;

    /**
     * Initialize the ServiceInstance.
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string  $sid     The unique string that identifies the resource
     */
    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'sid' => Values::array_get($payload, 'sid'),
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'friendlyName' => Values::array_get($payload, 'friendly_name'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'defaultServiceRoleSid' => Values::array_get($payload, 'default_service_role_sid'),
            'defaultChannelRoleSid' => Values::array_get($payload, 'default_channel_role_sid'),
            'defaultChannelCreatorRoleSid' => Values::array_get($payload, 'default_channel_creator_role_sid'),
            'readStatusEnabled' => Values::array_get($payload, 'read_status_enabled'),
            'reachabilityEnabled' => Values::array_get($payload, 'reachability_enabled'),
            'typingIndicatorTimeout' => Values::array_get($payload, 'typing_indicator_timeout'),
            'consumptionReportInterval' => Values::array_get($payload, 'consumption_report_interval'),
            'limits' => Values::array_get($payload, 'limits'),
            'webhooks' => Values::array_get($payload, 'webhooks'),
            'preWebhookUrl' => Values::array_get($payload, 'pre_webhook_url'),
            'postWebhookUrl' => Values::array_get($payload, 'post_webhook_url'),
            'webhookMethod' => Values::array_get($payload, 'webhook_method'),
            'webhookFilters' => Values::array_get($payload, 'webhook_filters'),
            'notifications' => Values::array_get($payload, 'notifications'),
            'url' => Values::array_get($payload, 'url'),
            'links' => Values::array_get($payload, 'links'),
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

        return '[Twilio.Chat.V1.ServiceInstance '.\implode(' ', $context).']';
    }

    /**
     * Fetch the ServiceInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return ServiceInstance Fetched ServiceInstance
     */
    public function fetch(): ServiceInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Delete the ServiceInstance.
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
     * Update the ServiceInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return ServiceInstance Updated ServiceInstance
     */
    public function update(array $options = []): ServiceInstance
    {
        return $this->proxy()->update($options);
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context.
     *
     * @return ServiceContext Context for this ServiceInstance
     */
    protected function proxy(): ServiceContext
    {
        if (!$this->context) {
            $this->context = new ServiceContext($this->version, $this->solution['sid']);
        }

        return $this->context;
    }

    /**
     * Access the channels.
     */
    protected function getChannels(): ChannelList
    {
        return $this->proxy()->channels;
    }

    /**
     * Access the roles.
     */
    protected function getRoles(): RoleList
    {
        return $this->proxy()->roles;
    }

    /**
     * Access the users.
     */
    protected function getUsers(): UserList
    {
        return $this->proxy()->users;
    }
}
