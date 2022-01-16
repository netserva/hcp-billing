<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Taskrouter\V1\Workspace\Workflow;

use Twilio\ListResource;
use Twilio\Version;

class WorkflowStatisticsList extends ListResource
{
    /**
     * Construct the WorkflowStatisticsList.
     *
     * @param Version $version      Version that contains the resource
     * @param string  $workspaceSid The SID of the Workspace that contains the
     *                              Workflow
     * @param string  $workflowSid  Returns the list of Tasks that are being
     *                              controlled by the Workflow with the specified SID
     *                              value
     */
    public function __construct(Version $version, string $workspaceSid, string $workflowSid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['workspaceSid' => $workspaceSid, 'workflowSid' => $workflowSid];
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        return '[Twilio.Taskrouter.V1.WorkflowStatisticsList]';
    }

    /**
     * Constructs a WorkflowStatisticsContext.
     */
    public function getContext(): WorkflowStatisticsContext
    {
        return new WorkflowStatisticsContext(
            $this->version,
            $this->solution['workspaceSid'],
            $this->solution['workflowSid']
        );
    }
}
