<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Video\V1\Room;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Video\V1\Room\Participant\PublishedTrackList;
use Twilio\Rest\Video\V1\Room\Participant\SubscribedTrackList;
use Twilio\Rest\Video\V1\Room\Participant\SubscribeRulesList;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string    $sid
 * @property string    $roomSid
 * @property string    $accountSid
 * @property string    $status
 * @property string    $identity
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 * @property \DateTime $startTime
 * @property \DateTime $endTime
 * @property int       $duration
 * @property string    $url
 * @property array     $links
 */
class ParticipantInstance extends InstanceResource
{
    protected $_publishedTracks;
    protected $_subscribedTracks;
    protected $_subscribeRules;

    /**
     * Initialize the ParticipantInstance.
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string  $roomSid The SID of the participant's room
     * @param string  $sid     The SID that identifies the resource to fetch
     */
    public function __construct(Version $version, array $payload, string $roomSid, string $sid = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'sid' => Values::array_get($payload, 'sid'),
            'roomSid' => Values::array_get($payload, 'room_sid'),
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'status' => Values::array_get($payload, 'status'),
            'identity' => Values::array_get($payload, 'identity'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'startTime' => Deserialize::dateTime(Values::array_get($payload, 'start_time')),
            'endTime' => Deserialize::dateTime(Values::array_get($payload, 'end_time')),
            'duration' => Values::array_get($payload, 'duration'),
            'url' => Values::array_get($payload, 'url'),
            'links' => Values::array_get($payload, 'links'),
        ];

        $this->solution = ['roomSid' => $roomSid, 'sid' => $sid ?: $this->properties['sid']];
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

        return '[Twilio.Video.V1.ParticipantInstance '.\implode(' ', $context).']';
    }

    /**
     * Fetch the ParticipantInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return ParticipantInstance Fetched ParticipantInstance
     */
    public function fetch(): ParticipantInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Update the ParticipantInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return ParticipantInstance Updated ParticipantInstance
     */
    public function update(array $options = []): ParticipantInstance
    {
        return $this->proxy()->update($options);
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context.
     *
     * @return ParticipantContext Context for this ParticipantInstance
     */
    protected function proxy(): ParticipantContext
    {
        if (!$this->context) {
            $this->context = new ParticipantContext(
                $this->version,
                $this->solution['roomSid'],
                $this->solution['sid']
            );
        }

        return $this->context;
    }

    /**
     * Access the publishedTracks.
     */
    protected function getPublishedTracks(): PublishedTrackList
    {
        return $this->proxy()->publishedTracks;
    }

    /**
     * Access the subscribedTracks.
     */
    protected function getSubscribedTracks(): SubscribedTrackList
    {
        return $this->proxy()->subscribedTracks;
    }

    /**
     * Access the subscribeRules.
     */
    protected function getSubscribeRules(): SubscribeRulesList
    {
        return $this->proxy()->subscribeRules;
    }
}
