<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\IpMessaging\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;

class RoleContext extends InstanceContext
{
    /**
     * Initialize the RoleContext.
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

        $this->uri = '/Services/'.\rawurlencode($serviceSid).'/Roles/'.\rawurlencode($sid).'';
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

        return '[Twilio.IpMessaging.V1.RoleContext '.\implode(' ', $context).']';
    }

    /**
     * Fetch the RoleInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return RoleInstance Fetched RoleInstance
     */
    public function fetch(): RoleInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);

        return new RoleInstance(
            $this->version,
            $payload,
            $this->solution['serviceSid'],
            $this->solution['sid']
        );
    }

    /**
     * Delete the RoleInstance.
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
     * Update the RoleInstance.
     *
     * @param string[] $permission The permission
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return RoleInstance Updated RoleInstance
     */
    public function update(array $permission): RoleInstance
    {
        $data = Values::of(['Permission' => Serialize::map($permission, fn ($e) => $e)]);

        $payload = $this->version->update('POST', $this->uri, [], $data);

        return new RoleInstance(
            $this->version,
            $payload,
            $this->solution['serviceSid'],
            $this->solution['sid']
        );
    }
}
