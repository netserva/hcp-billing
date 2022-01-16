<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\IpMessaging\V2\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\IpMessaging\V2\Service\User\UserBindingList;
use Twilio\Rest\IpMessaging\V2\Service\User\UserChannelList;
use Twilio\Values;
use Twilio\Version;

/**
 * @property UserChannelList $userChannels
 * @property UserBindingList $userBindings
 *
 * @method \Twilio\Rest\IpMessaging\V2\Service\User\UserChannelContext userChannels(string $channelSid)
 * @method \Twilio\Rest\IpMessaging\V2\Service\User\UserBindingContext userBindings(string $sid)
 */
class UserContext extends InstanceContext
{
    protected $_userChannels;
    protected $_userBindings;

    /**
     * Initialize the UserContext.
     *
     * @param Version $version    Version that contains the resource
     * @param string  $serviceSid The service_sid
     * @param string  $sid        The sid
     */
    public function __construct(Version $version, $serviceSid, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid];

        $this->uri = '/Services/'.\rawurlencode($serviceSid).'/Users/'.\rawurlencode($sid).'';
    }

    /**
     * Magic getter to lazy load subresources.
     *
     * @param string $name Subresource to return
     *
     * @throws TwilioException For unknown subresources
     *
     * @return ListResource The requested subresource
     */
    public function __get(string $name): ListResource
    {
        if (\property_exists($this, '_'.$name)) {
            $method = 'get'.\ucfirst($name);

            return $this->{$method}();
        }

        throw new TwilioException('Unknown subresource '.$name);
    }

    /**
     * Magic caller to get resource contexts.
     *
     * @param string $name      Resource to return
     * @param array  $arguments Context parameters
     *
     * @throws TwilioException For unknown resource
     *
     * @return InstanceContext The requested resource context
     */
    public function __call(string $name, array $arguments): InstanceContext
    {
        $property = $this->{$name};
        if (\method_exists($property, 'getContext')) {
            return \call_user_func_array([$property, 'getContext'], $arguments);
        }

        throw new TwilioException('Resource does not have a context');
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

        return '[Twilio.IpMessaging.V2.UserContext '.\implode(' ', $context).']';
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
        $payload = $this->version->fetch('GET', $this->uri);

        return new UserInstance(
            $this->version,
            $payload,
            $this->solution['serviceSid'],
            $this->solution['sid']
        );
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
        return $this->version->delete('DELETE', $this->uri);
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
        $options = new Values($options);

        $data = Values::of([
            'RoleSid' => $options['roleSid'],
            'Attributes' => $options['attributes'],
            'FriendlyName' => $options['friendlyName'],
        ]);
        $headers = Values::of(['X-Twilio-Webhook-Enabled' => $options['xTwilioWebhookEnabled']]);

        $payload = $this->version->update('POST', $this->uri, [], $data, $headers);

        return new UserInstance(
            $this->version,
            $payload,
            $this->solution['serviceSid'],
            $this->solution['sid']
        );
    }

    /**
     * Access the userChannels.
     */
    protected function getUserChannels(): UserChannelList
    {
        if (!$this->_userChannels) {
            $this->_userChannels = new UserChannelList(
                $this->version,
                $this->solution['serviceSid'],
                $this->solution['sid']
            );
        }

        return $this->_userChannels;
    }

    /**
     * Access the userBindings.
     */
    protected function getUserBindings(): UserBindingList
    {
        if (!$this->_userBindings) {
            $this->_userBindings = new UserBindingList(
                $this->version,
                $this->solution['serviceSid'],
                $this->solution['sid']
            );
        }

        return $this->_userBindings;
    }
}
