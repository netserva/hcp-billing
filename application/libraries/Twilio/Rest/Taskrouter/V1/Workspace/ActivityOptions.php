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

abstract class ActivityOptions
{
    /**
     * @param string $friendlyName A string to describe the Activity resource
     *
     * @return UpdateActivityOptions Options builder
     */
    public static function update(string $friendlyName = Values::NONE): UpdateActivityOptions
    {
        return new UpdateActivityOptions($friendlyName);
    }

    /**
     * @param string $friendlyName The friendly_name of the Activity resources to
     *                             read
     * @param string $available    Whether to return activities that are available or
     *                             unavailable
     *
     * @return ReadActivityOptions Options builder
     */
    public static function read(string $friendlyName = Values::NONE, string $available = Values::NONE): ReadActivityOptions
    {
        return new ReadActivityOptions($friendlyName, $available);
    }

    /**
     * @param bool $available Whether the Worker should be eligible to receive a
     *                        Task when it occupies the Activity
     *
     * @return CreateActivityOptions Options builder
     */
    public static function create(bool $available = Values::NONE): CreateActivityOptions
    {
        return new CreateActivityOptions($available);
    }
}

class UpdateActivityOptions extends Options
{
    /**
     * @param string $friendlyName A string to describe the Activity resource
     */
    public function __construct(string $friendlyName = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $options = \http_build_query(Values::of($this->options), '', ' ');

        return '[Twilio.Taskrouter.V1.UpdateActivityOptions '.$options.']';
    }

    /**
     * A descriptive string that you create to describe the Activity resource. It can be up to 64 characters long. These names are used to calculate and expose statistics about Workers, and provide visibility into the state of each Worker. Examples of friendly names include: `on-call`, `break`, and `email`.
     *
     * @param string $friendlyName A string to describe the Activity resource
     *
     * @return $this Fluent Builder
     */
    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;

        return $this;
    }
}

class ReadActivityOptions extends Options
{
    /**
     * @param string $friendlyName The friendly_name of the Activity resources to
     *                             read
     * @param string $available    Whether to return activities that are available or
     *                             unavailable
     */
    public function __construct(string $friendlyName = Values::NONE, string $available = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['available'] = $available;
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $options = \http_build_query(Values::of($this->options), '', ' ');

        return '[Twilio.Taskrouter.V1.ReadActivityOptions '.$options.']';
    }

    /**
     * The `friendly_name` of the Activity resources to read.
     *
     * @param string $friendlyName The friendly_name of the Activity resources to
     *                             read
     *
     * @return $this Fluent Builder
     */
    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;

        return $this;
    }

    /**
     * Whether return only Activity resources that are available or unavailable. A value of `true` returns only available activities. Values of '1' or `yes` also indicate `true`. All other values represent `false` and return activities that are unavailable.
     *
     * @param string $available Whether to return activities that are available or
     *                          unavailable
     *
     * @return $this Fluent Builder
     */
    public function setAvailable(string $available): self
    {
        $this->options['available'] = $available;

        return $this;
    }
}

class CreateActivityOptions extends Options
{
    /**
     * @param bool $available Whether the Worker should be eligible to receive a
     *                        Task when it occupies the Activity
     */
    public function __construct(bool $available = Values::NONE)
    {
        $this->options['available'] = $available;
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $options = \http_build_query(Values::of($this->options), '', ' ');

        return '[Twilio.Taskrouter.V1.CreateActivityOptions '.$options.']';
    }

    /**
     * Whether the Worker should be eligible to receive a Task when it occupies the Activity. A value of `true`, `1`, or `yes` specifies the Activity is available. All other values specify that it is not. The value cannot be changed after the Activity is created.
     *
     * @param bool $available Whether the Worker should be eligible to receive a
     *                        Task when it occupies the Activity
     *
     * @return $this Fluent Builder
     */
    public function setAvailable(bool $available): self
    {
        $this->options['available'] = $available;

        return $this;
    }
}
