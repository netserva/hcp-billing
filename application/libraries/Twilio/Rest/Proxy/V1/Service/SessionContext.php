<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Proxy\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Proxy\V1\Service\Session\InteractionList;
use Twilio\Rest\Proxy\V1\Service\Session\ParticipantList;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains beta products that are subject to change. Use them with caution.
 *
 * @property InteractionList $interactions
 * @property ParticipantList $participants
 *
 * @method \Twilio\Rest\Proxy\V1\Service\Session\InteractionContext interactions(string $sid)
 * @method \Twilio\Rest\Proxy\V1\Service\Session\ParticipantContext participants(string $sid)
 */
class SessionContext extends InstanceContext
{
    protected $_interactions;
    protected $_participants;

    /**
     * Initialize the SessionContext.
     *
     * @param Version $version    Version that contains the resource
     * @param string  $serviceSid The SID of the Service to fetch the resource from
     * @param string  $sid        The unique string that identifies the resource
     */
    public function __construct(Version $version, $serviceSid, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid];

        $this->uri = '/Services/'.\rawurlencode($serviceSid).'/Sessions/'.\rawurlencode($sid).'';
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

        return '[Twilio.Proxy.V1.SessionContext '.\implode(' ', $context).']';
    }

    /**
     * Fetch the SessionInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return SessionInstance Fetched SessionInstance
     */
    public function fetch(): SessionInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);

        return new SessionInstance(
            $this->version,
            $payload,
            $this->solution['serviceSid'],
            $this->solution['sid']
        );
    }

    /**
     * Delete the SessionInstance.
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
     * Update the SessionInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return SessionInstance Updated SessionInstance
     */
    public function update(array $options = []): SessionInstance
    {
        $options = new Values($options);

        $data = Values::of([
            'DateExpiry' => Serialize::iso8601DateTime($options['dateExpiry']),
            'Ttl' => $options['ttl'],
            'Status' => $options['status'],
            'FailOnParticipantConflict' => Serialize::booleanToString($options['failOnParticipantConflict']),
        ]);

        $payload = $this->version->update('POST', $this->uri, [], $data);

        return new SessionInstance(
            $this->version,
            $payload,
            $this->solution['serviceSid'],
            $this->solution['sid']
        );
    }

    /**
     * Access the interactions.
     */
    protected function getInteractions(): InteractionList
    {
        if (!$this->_interactions) {
            $this->_interactions = new InteractionList(
                $this->version,
                $this->solution['serviceSid'],
                $this->solution['sid']
            );
        }

        return $this->_interactions;
    }

    /**
     * Access the participants.
     */
    protected function getParticipants(): ParticipantList
    {
        if (!$this->_participants) {
            $this->_participants = new ParticipantList(
                $this->version,
                $this->solution['serviceSid'],
                $this->solution['sid']
            );
        }

        return $this->_participants;
    }
}
