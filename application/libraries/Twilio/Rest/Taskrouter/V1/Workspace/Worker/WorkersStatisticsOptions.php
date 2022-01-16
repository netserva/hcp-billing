<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Taskrouter\V1\Workspace\Worker;

use Twilio\Options;
use Twilio\Values;

abstract class WorkersStatisticsOptions
{
    /**
     * @param int       $minutes       Only calculate statistics since this many minutes in the
     *                                 past
     * @param \DateTime $startDate     Only calculate statistics from on or after this
     *                                 date
     * @param \DateTime $endDate       Only calculate statistics from this date and time
     *                                 and earlier
     * @param string    $taskQueueSid  The SID of the TaskQueue for which to fetch
     *                                 Worker statistics
     * @param string    $taskQueueName The friendly_name of the TaskQueue for which to
     *                                 fetch Worker statistics
     * @param string    $friendlyName  Only include Workers with `friendly_name` values
     *                                 that match this parameter
     * @param string    $taskChannel   Only calculate statistics on this TaskChannel
     *
     * @return FetchWorkersStatisticsOptions Options builder
     */
    public static function fetch(int $minutes = Values::NONE, \DateTime $startDate = Values::NONE, \DateTime $endDate = Values::NONE, string $taskQueueSid = Values::NONE, string $taskQueueName = Values::NONE, string $friendlyName = Values::NONE, string $taskChannel = Values::NONE): FetchWorkersStatisticsOptions
    {
        return new FetchWorkersStatisticsOptions($minutes, $startDate, $endDate, $taskQueueSid, $taskQueueName, $friendlyName, $taskChannel);
    }
}

class FetchWorkersStatisticsOptions extends Options
{
    /**
     * @param int       $minutes       Only calculate statistics since this many minutes in the
     *                                 past
     * @param \DateTime $startDate     Only calculate statistics from on or after this
     *                                 date
     * @param \DateTime $endDate       Only calculate statistics from this date and time
     *                                 and earlier
     * @param string    $taskQueueSid  The SID of the TaskQueue for which to fetch
     *                                 Worker statistics
     * @param string    $taskQueueName The friendly_name of the TaskQueue for which to
     *                                 fetch Worker statistics
     * @param string    $friendlyName  Only include Workers with `friendly_name` values
     *                                 that match this parameter
     * @param string    $taskChannel   Only calculate statistics on this TaskChannel
     */
    public function __construct(int $minutes = Values::NONE, \DateTime $startDate = Values::NONE, \DateTime $endDate = Values::NONE, string $taskQueueSid = Values::NONE, string $taskQueueName = Values::NONE, string $friendlyName = Values::NONE, string $taskChannel = Values::NONE)
    {
        $this->options['minutes'] = $minutes;
        $this->options['startDate'] = $startDate;
        $this->options['endDate'] = $endDate;
        $this->options['taskQueueSid'] = $taskQueueSid;
        $this->options['taskQueueName'] = $taskQueueName;
        $this->options['friendlyName'] = $friendlyName;
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

        return '[Twilio.Taskrouter.V1.FetchWorkersStatisticsOptions '.$options.']';
    }

    /**
     * Only calculate statistics since this many minutes in the past. The default 15 minutes. This is helpful for displaying statistics for the last 15 minutes, 240 minutes (4 hours), and 480 minutes (8 hours) to see trends.
     *
     * @param int $minutes Only calculate statistics since this many minutes in the
     *                     past
     *
     * @return $this Fluent Builder
     */
    public function setMinutes(int $minutes): self
    {
        $this->options['minutes'] = $minutes;

        return $this;
    }

    /**
     * Only calculate statistics from this date and time and later, specified in [ISO 8601](https://en.wikipedia.org/wiki/ISO_8601) format.
     *
     * @param \DateTime $startDate Only calculate statistics from on or after this
     *                             date
     *
     * @return $this Fluent Builder
     */
    public function setStartDate(\DateTime $startDate): self
    {
        $this->options['startDate'] = $startDate;

        return $this;
    }

    /**
     * Only calculate statistics from this date and time and earlier, specified in GMT as an [ISO 8601](https://en.wikipedia.org/wiki/ISO_8601) date-time.
     *
     * @param \DateTime $endDate Only calculate statistics from this date and time
     *                           and earlier
     *
     * @return $this Fluent Builder
     */
    public function setEndDate(\DateTime $endDate): self
    {
        $this->options['endDate'] = $endDate;

        return $this;
    }

    /**
     * The SID of the TaskQueue for which to fetch Worker statistics.
     *
     * @param string $taskQueueSid The SID of the TaskQueue for which to fetch
     *                             Worker statistics
     *
     * @return $this Fluent Builder
     */
    public function setTaskQueueSid(string $taskQueueSid): self
    {
        $this->options['taskQueueSid'] = $taskQueueSid;

        return $this;
    }

    /**
     * The `friendly_name` of the TaskQueue for which to fetch Worker statistics.
     *
     * @param string $taskQueueName The friendly_name of the TaskQueue for which to
     *                              fetch Worker statistics
     *
     * @return $this Fluent Builder
     */
    public function setTaskQueueName(string $taskQueueName): self
    {
        $this->options['taskQueueName'] = $taskQueueName;

        return $this;
    }

    /**
     * Only include Workers with `friendly_name` values that match this parameter.
     *
     * @param string $friendlyName Only include Workers with `friendly_name` values
     *                             that match this parameter
     *
     * @return $this Fluent Builder
     */
    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;

        return $this;
    }

    /**
     * Only calculate statistics on this TaskChannel. Can be the TaskChannel's SID or its `unique_name`, such as `voice`, `sms`, or `default`.
     *
     * @param string $taskChannel Only calculate statistics on this TaskChannel
     *
     * @return $this Fluent Builder
     */
    public function setTaskChannel(string $taskChannel): self
    {
        $this->options['taskChannel'] = $taskChannel;

        return $this;
    }
}
