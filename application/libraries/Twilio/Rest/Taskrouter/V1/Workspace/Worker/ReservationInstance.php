<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Taskrouter\V1\Workspace\Worker;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string    $accountSid
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 * @property string    $reservationStatus
 * @property string    $sid
 * @property string    $taskSid
 * @property string    $workerName
 * @property string    $workerSid
 * @property string    $workspaceSid
 * @property string    $url
 * @property array     $links
 */
class ReservationInstance extends InstanceResource
{
    /**
     * Initialize the ReservationInstance.
     *
     * @param Version $version      Version that contains the resource
     * @param mixed[] $payload      The response payload
     * @param string  $workspaceSid the SID of the Workspace that this worker is
     *                              contained within
     * @param string  $workerSid    The SID of the reserved Worker resource
     * @param string  $sid          The SID of the WorkerReservation resource to fetch
     */
    public function __construct(Version $version, array $payload, string $workspaceSid, string $workerSid, string $sid = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'reservationStatus' => Values::array_get($payload, 'reservation_status'),
            'sid' => Values::array_get($payload, 'sid'),
            'taskSid' => Values::array_get($payload, 'task_sid'),
            'workerName' => Values::array_get($payload, 'worker_name'),
            'workerSid' => Values::array_get($payload, 'worker_sid'),
            'workspaceSid' => Values::array_get($payload, 'workspace_sid'),
            'url' => Values::array_get($payload, 'url'),
            'links' => Values::array_get($payload, 'links'),
        ];

        $this->solution = [
            'workspaceSid' => $workspaceSid,
            'workerSid' => $workerSid,
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

        return '[Twilio.Taskrouter.V1.ReservationInstance '.\implode(' ', $context).']';
    }

    /**
     * Fetch the ReservationInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return ReservationInstance Fetched ReservationInstance
     */
    public function fetch(): ReservationInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Update the ReservationInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return ReservationInstance Updated ReservationInstance
     */
    public function update(array $options = []): ReservationInstance
    {
        return $this->proxy()->update($options);
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context.
     *
     * @return ReservationContext Context for this ReservationInstance
     */
    protected function proxy(): ReservationContext
    {
        if (!$this->context) {
            $this->context = new ReservationContext(
                $this->version,
                $this->solution['workspaceSid'],
                $this->solution['workerSid'],
                $this->solution['sid']
            );
        }

        return $this->context;
    }
}
