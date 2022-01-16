<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Supersim\V1\NetworkAccessProfile;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains beta products that are subject to change. Use them with caution.
 */
class NetworkAccessProfileNetworkContext extends InstanceContext
{
    /**
     * Initialize the NetworkAccessProfileNetworkContext.
     *
     * @param Version $version                 Version that contains the resource
     * @param string  $networkAccessProfileSid The unique string that identifies the
     *                                         Network Access Profile resource
     * @param string  $sid                     The SID of the resource to fetch
     */
    public function __construct(Version $version, $networkAccessProfileSid, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['networkAccessProfileSid' => $networkAccessProfileSid, 'sid' => $sid];

        $this->uri = '/NetworkAccessProfiles/'.\rawurlencode($networkAccessProfileSid).'/Networks/'.\rawurlencode($sid).'';
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

        return '[Twilio.Supersim.V1.NetworkAccessProfileNetworkContext '.\implode(' ', $context).']';
    }

    /**
     * Delete the NetworkAccessProfileNetworkInstance.
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
     * Fetch the NetworkAccessProfileNetworkInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return NetworkAccessProfileNetworkInstance Fetched
     *                                             NetworkAccessProfileNetworkInstance
     */
    public function fetch(): NetworkAccessProfileNetworkInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);

        return new NetworkAccessProfileNetworkInstance(
            $this->version,
            $payload,
            $this->solution['networkAccessProfileSid'],
            $this->solution['sid']
        );
    }
}
