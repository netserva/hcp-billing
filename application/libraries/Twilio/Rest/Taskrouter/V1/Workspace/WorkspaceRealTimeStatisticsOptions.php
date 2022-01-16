<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Options;
use Twilio\Values;

abstract class WorkspaceRealTimeStatisticsOptions
{
    /**
     * @param string $taskChannel Only calculate real-time statistics on this
     *                            TaskChannel
     *
     * @return FetchWorkspaceRealTimeStatisticsOptions Options builder
     */
    public static function fetch(string $taskChannel = Values::NONE): FetchWorkspaceRealTimeStatisticsOptions
    {
        return new FetchWorkspaceRealTimeStatisticsOptions($taskChannel);
    }
}

class FetchWorkspaceRealTimeStatisticsOptions extends Options
{
    /**
     * @param string $taskChannel Only calculate real-time statistics on this
     *                            TaskChannel
     */
    public function __construct(string $taskChannel = Values::NONE)
    {
        $this->options['taskChannel'] = $taskChannel;
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $options = \http_build_query(Values::of($this->options), '', ' ');

        return '[Twilio.Taskrouter.V1.FetchWorkspaceRealTimeStatisticsOptions '.$options.']';
    }

    /**
     * Only calculate real-time statistics on this TaskChannel. Can be the TaskChannel's SID or its `unique_name`, such as `voice`, `sms`, or `default`.
     *
     * @param string $taskChannel Only calculate real-time statistics on this
     *                            TaskChannel
     *
     * @return $this Fluent Builder
     */
    public function setTaskChannel(string $taskChannel): self
    {
        $this->options['taskChannel'] = $taskChannel;

        return $this;
    }
}
