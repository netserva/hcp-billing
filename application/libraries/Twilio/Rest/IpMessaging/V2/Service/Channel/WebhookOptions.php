<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\IpMessaging\V2\Service\Channel;

use Twilio\Options;
use Twilio\Values;

abstract class WebhookOptions
{
    /**
     * @param string   $configurationUrl        The configuration.url
     * @param string   $configurationMethod     The configuration.method
     * @param string[] $configurationFilters    The configuration.filters
     * @param string[] $configurationTriggers   The configuration.triggers
     * @param string   $configurationFlowSid    The configuration.flow_sid
     * @param int      $configurationRetryCount The configuration.retry_count
     *
     * @return CreateWebhookOptions Options builder
     */
    public static function create(string $configurationUrl = Values::NONE, string $configurationMethod = Values::NONE, array $configurationFilters = Values::ARRAY_NONE, array $configurationTriggers = Values::ARRAY_NONE, string $configurationFlowSid = Values::NONE, int $configurationRetryCount = Values::NONE): CreateWebhookOptions
    {
        return new CreateWebhookOptions($configurationUrl, $configurationMethod, $configurationFilters, $configurationTriggers, $configurationFlowSid, $configurationRetryCount);
    }

    /**
     * @param string   $configurationUrl        The configuration.url
     * @param string   $configurationMethod     The configuration.method
     * @param string[] $configurationFilters    The configuration.filters
     * @param string[] $configurationTriggers   The configuration.triggers
     * @param string   $configurationFlowSid    The configuration.flow_sid
     * @param int      $configurationRetryCount The configuration.retry_count
     *
     * @return UpdateWebhookOptions Options builder
     */
    public static function update(string $configurationUrl = Values::NONE, string $configurationMethod = Values::NONE, array $configurationFilters = Values::ARRAY_NONE, array $configurationTriggers = Values::ARRAY_NONE, string $configurationFlowSid = Values::NONE, int $configurationRetryCount = Values::NONE): UpdateWebhookOptions
    {
        return new UpdateWebhookOptions($configurationUrl, $configurationMethod, $configurationFilters, $configurationTriggers, $configurationFlowSid, $configurationRetryCount);
    }
}

class CreateWebhookOptions extends Options
{
    /**
     * @param string   $configurationUrl        The configuration.url
     * @param string   $configurationMethod     The configuration.method
     * @param string[] $configurationFilters    The configuration.filters
     * @param string[] $configurationTriggers   The configuration.triggers
     * @param string   $configurationFlowSid    The configuration.flow_sid
     * @param int      $configurationRetryCount The configuration.retry_count
     */
    public function __construct(string $configurationUrl = Values::NONE, string $configurationMethod = Values::NONE, array $configurationFilters = Values::ARRAY_NONE, array $configurationTriggers = Values::ARRAY_NONE, string $configurationFlowSid = Values::NONE, int $configurationRetryCount = Values::NONE)
    {
        $this->options['configurationUrl'] = $configurationUrl;
        $this->options['configurationMethod'] = $configurationMethod;
        $this->options['configurationFilters'] = $configurationFilters;
        $this->options['configurationTriggers'] = $configurationTriggers;
        $this->options['configurationFlowSid'] = $configurationFlowSid;
        $this->options['configurationRetryCount'] = $configurationRetryCount;
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $options = \http_build_query(Values::of($this->options), '', ' ');

        return '[Twilio.IpMessaging.V2.CreateWebhookOptions '.$options.']';
    }

    /**
     * The configuration.url.
     *
     * @param string $configurationUrl The configuration.url
     *
     * @return $this Fluent Builder
     */
    public function setConfigurationUrl(string $configurationUrl): self
    {
        $this->options['configurationUrl'] = $configurationUrl;

        return $this;
    }

    /**
     * The configuration.method.
     *
     * @param string $configurationMethod The configuration.method
     *
     * @return $this Fluent Builder
     */
    public function setConfigurationMethod(string $configurationMethod): self
    {
        $this->options['configurationMethod'] = $configurationMethod;

        return $this;
    }

    /**
     * The configuration.filters.
     *
     * @param string[] $configurationFilters The configuration.filters
     *
     * @return $this Fluent Builder
     */
    public function setConfigurationFilters(array $configurationFilters): self
    {
        $this->options['configurationFilters'] = $configurationFilters;

        return $this;
    }

    /**
     * The configuration.triggers.
     *
     * @param string[] $configurationTriggers The configuration.triggers
     *
     * @return $this Fluent Builder
     */
    public function setConfigurationTriggers(array $configurationTriggers): self
    {
        $this->options['configurationTriggers'] = $configurationTriggers;

        return $this;
    }

    /**
     * The configuration.flow_sid.
     *
     * @param string $configurationFlowSid The configuration.flow_sid
     *
     * @return $this Fluent Builder
     */
    public function setConfigurationFlowSid(string $configurationFlowSid): self
    {
        $this->options['configurationFlowSid'] = $configurationFlowSid;

        return $this;
    }

    /**
     * The configuration.retry_count.
     *
     * @param int $configurationRetryCount The configuration.retry_count
     *
     * @return $this Fluent Builder
     */
    public function setConfigurationRetryCount(int $configurationRetryCount): self
    {
        $this->options['configurationRetryCount'] = $configurationRetryCount;

        return $this;
    }
}

class UpdateWebhookOptions extends Options
{
    /**
     * @param string   $configurationUrl        The configuration.url
     * @param string   $configurationMethod     The configuration.method
     * @param string[] $configurationFilters    The configuration.filters
     * @param string[] $configurationTriggers   The configuration.triggers
     * @param string   $configurationFlowSid    The configuration.flow_sid
     * @param int      $configurationRetryCount The configuration.retry_count
     */
    public function __construct(string $configurationUrl = Values::NONE, string $configurationMethod = Values::NONE, array $configurationFilters = Values::ARRAY_NONE, array $configurationTriggers = Values::ARRAY_NONE, string $configurationFlowSid = Values::NONE, int $configurationRetryCount = Values::NONE)
    {
        $this->options['configurationUrl'] = $configurationUrl;
        $this->options['configurationMethod'] = $configurationMethod;
        $this->options['configurationFilters'] = $configurationFilters;
        $this->options['configurationTriggers'] = $configurationTriggers;
        $this->options['configurationFlowSid'] = $configurationFlowSid;
        $this->options['configurationRetryCount'] = $configurationRetryCount;
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $options = \http_build_query(Values::of($this->options), '', ' ');

        return '[Twilio.IpMessaging.V2.UpdateWebhookOptions '.$options.']';
    }

    /**
     * The configuration.url.
     *
     * @param string $configurationUrl The configuration.url
     *
     * @return $this Fluent Builder
     */
    public function setConfigurationUrl(string $configurationUrl): self
    {
        $this->options['configurationUrl'] = $configurationUrl;

        return $this;
    }

    /**
     * The configuration.method.
     *
     * @param string $configurationMethod The configuration.method
     *
     * @return $this Fluent Builder
     */
    public function setConfigurationMethod(string $configurationMethod): self
    {
        $this->options['configurationMethod'] = $configurationMethod;

        return $this;
    }

    /**
     * The configuration.filters.
     *
     * @param string[] $configurationFilters The configuration.filters
     *
     * @return $this Fluent Builder
     */
    public function setConfigurationFilters(array $configurationFilters): self
    {
        $this->options['configurationFilters'] = $configurationFilters;

        return $this;
    }

    /**
     * The configuration.triggers.
     *
     * @param string[] $configurationTriggers The configuration.triggers
     *
     * @return $this Fluent Builder
     */
    public function setConfigurationTriggers(array $configurationTriggers): self
    {
        $this->options['configurationTriggers'] = $configurationTriggers;

        return $this;
    }

    /**
     * The configuration.flow_sid.
     *
     * @param string $configurationFlowSid The configuration.flow_sid
     *
     * @return $this Fluent Builder
     */
    public function setConfigurationFlowSid(string $configurationFlowSid): self
    {
        $this->options['configurationFlowSid'] = $configurationFlowSid;

        return $this;
    }

    /**
     * The configuration.retry_count.
     *
     * @param int $configurationRetryCount The configuration.retry_count
     *
     * @return $this Fluent Builder
     */
    public function setConfigurationRetryCount(int $configurationRetryCount): self
    {
        $this->options['configurationRetryCount'] = $configurationRetryCount;

        return $this;
    }
}
