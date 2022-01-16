<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

class WorkspaceRealTimeStatisticsContext extends InstanceContext
{
    /**
     * Initialize the WorkspaceRealTimeStatisticsContext.
     *
     * @param Version $version      Version that contains the resource
     * @param string  $workspaceSid The SID of the Workspace to fetch
     */
    public function __construct(Version $version, $workspaceSid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['workspaceSid' => $workspaceSid];

        $this->uri = '/Workspaces/'.\rawurlencode($workspaceSid).'/RealTimeStatistics';
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

        return '[Twilio.Taskrouter.V1.WorkspaceRealTimeStatisticsContext '.\implode(' ', $context).']';
    }

    /**
     * Fetch the WorkspaceRealTimeStatisticsInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return WorkspaceRealTimeStatisticsInstance Fetched
     *                                             WorkspaceRealTimeStatisticsInstance
     */
    public function fetch(array $options = []): WorkspaceRealTimeStatisticsInstance
    {
        $options = new Values($options);

        $params = Values::of(['TaskChannel' => $options['taskChannel']]);

        $payload = $this->version->fetch('GET', $this->uri, $params);

        return new WorkspaceRealTimeStatisticsInstance(
            $this->version,
            $payload,
            $this->solution['workspaceSid']
        );
    }
}
