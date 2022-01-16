<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\IpMessaging\V2\Service;

use Twilio\Options;
use Twilio\Values;

abstract class UserOptions
{
    /**
     * @param string $roleSid               The role_sid
     * @param string $attributes            The attributes
     * @param string $friendlyName          The friendly_name
     * @param string $xTwilioWebhookEnabled The X-Twilio-Webhook-Enabled HTTP
     *                                      request header
     *
     * @return CreateUserOptions Options builder
     */
    public static function create(string $roleSid = Values::NONE, string $attributes = Values::NONE, string $friendlyName = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE): CreateUserOptions
    {
        return new CreateUserOptions($roleSid, $attributes, $friendlyName, $xTwilioWebhookEnabled);
    }

    /**
     * @param string $roleSid               The role_sid
     * @param string $attributes            The attributes
     * @param string $friendlyName          The friendly_name
     * @param string $xTwilioWebhookEnabled The X-Twilio-Webhook-Enabled HTTP
     *                                      request header
     *
     * @return UpdateUserOptions Options builder
     */
    public static function update(string $roleSid = Values::NONE, string $attributes = Values::NONE, string $friendlyName = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE): UpdateUserOptions
    {
        return new UpdateUserOptions($roleSid, $attributes, $friendlyName, $xTwilioWebhookEnabled);
    }
}

class CreateUserOptions extends Options
{
    /**
     * @param string $roleSid               The role_sid
     * @param string $attributes            The attributes
     * @param string $friendlyName          The friendly_name
     * @param string $xTwilioWebhookEnabled The X-Twilio-Webhook-Enabled HTTP
     *                                      request header
     */
    public function __construct(string $roleSid = Values::NONE, string $attributes = Values::NONE, string $friendlyName = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE)
    {
        $this->options['roleSid'] = $roleSid;
        $this->options['attributes'] = $attributes;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $options = \http_build_query(Values::of($this->options), '', ' ');

        return '[Twilio.IpMessaging.V2.CreateUserOptions '.$options.']';
    }

    /**
     * The role_sid.
     *
     * @param string $roleSid The role_sid
     *
     * @return $this Fluent Builder
     */
    public function setRoleSid(string $roleSid): self
    {
        $this->options['roleSid'] = $roleSid;

        return $this;
    }

    /**
     * The attributes.
     *
     * @param string $attributes The attributes
     *
     * @return $this Fluent Builder
     */
    public function setAttributes(string $attributes): self
    {
        $this->options['attributes'] = $attributes;

        return $this;
    }

    /**
     * The friendly_name.
     *
     * @param string $friendlyName The friendly_name
     *
     * @return $this Fluent Builder
     */
    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;

        return $this;
    }

    /**
     * The X-Twilio-Webhook-Enabled HTTP request header.
     *
     * @param string $xTwilioWebhookEnabled The X-Twilio-Webhook-Enabled HTTP
     *                                      request header
     *
     * @return $this Fluent Builder
     */
    public function setXTwilioWebhookEnabled(string $xTwilioWebhookEnabled): self
    {
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;

        return $this;
    }
}

class UpdateUserOptions extends Options
{
    /**
     * @param string $roleSid               The role_sid
     * @param string $attributes            The attributes
     * @param string $friendlyName          The friendly_name
     * @param string $xTwilioWebhookEnabled The X-Twilio-Webhook-Enabled HTTP
     *                                      request header
     */
    public function __construct(string $roleSid = Values::NONE, string $attributes = Values::NONE, string $friendlyName = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE)
    {
        $this->options['roleSid'] = $roleSid;
        $this->options['attributes'] = $attributes;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $options = \http_build_query(Values::of($this->options), '', ' ');

        return '[Twilio.IpMessaging.V2.UpdateUserOptions '.$options.']';
    }

    /**
     * The role_sid.
     *
     * @param string $roleSid The role_sid
     *
     * @return $this Fluent Builder
     */
    public function setRoleSid(string $roleSid): self
    {
        $this->options['roleSid'] = $roleSid;

        return $this;
    }

    /**
     * The attributes.
     *
     * @param string $attributes The attributes
     *
     * @return $this Fluent Builder
     */
    public function setAttributes(string $attributes): self
    {
        $this->options['attributes'] = $attributes;

        return $this;
    }

    /**
     * The friendly_name.
     *
     * @param string $friendlyName The friendly_name
     *
     * @return $this Fluent Builder
     */
    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;

        return $this;
    }

    /**
     * The X-Twilio-Webhook-Enabled HTTP request header.
     *
     * @param string $xTwilioWebhookEnabled The X-Twilio-Webhook-Enabled HTTP
     *                                      request header
     *
     * @return $this Fluent Builder
     */
    public function setXTwilioWebhookEnabled(string $xTwilioWebhookEnabled): self
    {
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;

        return $this;
    }
}
