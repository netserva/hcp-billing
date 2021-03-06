<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Video\V1\Room\Participant;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;

class SubscribeRulesList extends ListResource
{
    /**
     * Construct the SubscribeRulesList.
     *
     * @param Version $version        Version that contains the resource
     * @param string  $roomSid        The SID of the Room resource for the Subscribe Rules
     * @param string  $participantSid The SID of the Participant resource for the
     *                                Subscribe Rules
     */
    public function __construct(Version $version, string $roomSid, string $participantSid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['roomSid' => $roomSid, 'participantSid' => $participantSid];

        $this->uri = '/Rooms/'.\rawurlencode($roomSid).'/Participants/'.\rawurlencode($participantSid).'/SubscribeRules';
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        return '[Twilio.Video.V1.SubscribeRulesList]';
    }

    /**
     * Fetch the SubscribeRulesInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return SubscribeRulesInstance Fetched SubscribeRulesInstance
     */
    public function fetch(): SubscribeRulesInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);

        return new SubscribeRulesInstance(
            $this->version,
            $payload,
            $this->solution['roomSid'],
            $this->solution['participantSid']
        );
    }

    /**
     * Update the SubscribeRulesInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return SubscribeRulesInstance Updated SubscribeRulesInstance
     */
    public function update(array $options = []): SubscribeRulesInstance
    {
        $options = new Values($options);

        $data = Values::of(['Rules' => Serialize::jsonObject($options['rules'])]);

        $payload = $this->version->update('POST', $this->uri, [], $data);

        return new SubscribeRulesInstance(
            $this->version,
            $payload,
            $this->solution['roomSid'],
            $this->solution['participantSid']
        );
    }
}
