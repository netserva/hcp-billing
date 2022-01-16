<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Voice\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Voice\V1\ConnectionPolicy\ConnectionPolicyTargetList;
use Twilio\Values;
use Twilio\Version;

/**
 * @property ConnectionPolicyTargetList $targets
 *
 * @method \Twilio\Rest\Voice\V1\ConnectionPolicy\ConnectionPolicyTargetContext targets(string $sid)
 */
class ConnectionPolicyContext extends InstanceContext
{
    protected $_targets;

    /**
     * Initialize the ConnectionPolicyContext.
     *
     * @param Version $version Version that contains the resource
     * @param string  $sid     The unique string that identifies the resource
     */
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['sid' => $sid];

        $this->uri = '/ConnectionPolicies/'.\rawurlencode($sid).'';
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

        return '[Twilio.Voice.V1.ConnectionPolicyContext '.\implode(' ', $context).']';
    }

    /**
     * Fetch the ConnectionPolicyInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return ConnectionPolicyInstance Fetched ConnectionPolicyInstance
     */
    public function fetch(): ConnectionPolicyInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);

        return new ConnectionPolicyInstance($this->version, $payload, $this->solution['sid']);
    }

    /**
     * Update the ConnectionPolicyInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return ConnectionPolicyInstance Updated ConnectionPolicyInstance
     */
    public function update(array $options = []): ConnectionPolicyInstance
    {
        $options = new Values($options);

        $data = Values::of(['FriendlyName' => $options['friendlyName']]);

        $payload = $this->version->update('POST', $this->uri, [], $data);

        return new ConnectionPolicyInstance($this->version, $payload, $this->solution['sid']);
    }

    /**
     * Delete the ConnectionPolicyInstance.
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
     * Access the targets.
     */
    protected function getTargets(): ConnectionPolicyTargetList
    {
        if (!$this->_targets) {
            $this->_targets = new ConnectionPolicyTargetList($this->version, $this->solution['sid']);
        }

        return $this->_targets;
    }
}
