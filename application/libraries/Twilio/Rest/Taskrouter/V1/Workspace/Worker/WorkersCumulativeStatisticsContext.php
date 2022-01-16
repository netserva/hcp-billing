<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Taskrouter\V1\Workspace\Worker;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;

class WorkersCumulativeStatisticsContext extends InstanceContext
{
    /**
     * Initialize the WorkersCumulativeStatisticsContext.
     *
     * @param Version $version      Version that contains the resource
     * @param string  $workspaceSid The SID of the Workspace with the resource to
     *                              fetch
     */
    public function __construct(Version $version, $workspaceSid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['workspaceSid' => $workspaceSid];

        $this->uri = '/Workspaces/'.\rawurlencode($workspaceSid).'/Workers/CumulativeStatistics';
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

        return '[Twilio.Taskrouter.V1.WorkersCumulativeStatisticsContext '.\implode(' ', $context).']';
    }

    /**
     * Fetch the WorkersCumulativeStatisticsInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return WorkersCumulativeStatisticsInstance Fetched
     *                                             WorkersCumulativeStatisticsInstance
     */
    public function fetch(array $options = []): WorkersCumulativeStatisticsInstance
    {
        $options = new Values($options);

        $params = Values::of([
            'EndDate' => Serialize::iso8601DateTime($options['endDate']),
            'Minutes' => $options['minutes'],
            'StartDate' => Serialize::iso8601DateTime($options['startDate']),
            'TaskChannel' => $options['taskChannel'],
        ]);

        $payload = $this->version->fetch('GET', $this->uri, $params);

        return new WorkersCumulativeStatisticsInstance(
            $this->version,
            $payload,
            $this->solution['workspaceSid']
        );
    }
}
