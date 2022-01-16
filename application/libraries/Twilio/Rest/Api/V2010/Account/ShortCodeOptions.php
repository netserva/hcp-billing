<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Options;
use Twilio\Values;

abstract class ShortCodeOptions
{
    /**
     * @param string $friendlyName      A string to describe this resource
     * @param string $apiVersion        The API version to use to start a new TwiML session
     * @param string $smsUrl            URL Twilio will request when receiving an SMS
     * @param string $smsMethod         HTTP method to use when requesting the sms url
     * @param string $smsFallbackUrl    URL Twilio will request if an error occurs in
     *                                  executing TwiML
     * @param string $smsFallbackMethod HTTP method Twilio will use with
     *                                  sms_fallback_url
     *
     * @return UpdateShortCodeOptions Options builder
     */
    public static function update(string $friendlyName = Values::NONE, string $apiVersion = Values::NONE, string $smsUrl = Values::NONE, string $smsMethod = Values::NONE, string $smsFallbackUrl = Values::NONE, string $smsFallbackMethod = Values::NONE): UpdateShortCodeOptions
    {
        return new UpdateShortCodeOptions($friendlyName, $apiVersion, $smsUrl, $smsMethod, $smsFallbackUrl, $smsFallbackMethod);
    }

    /**
     * @param string $friendlyName The string that identifies the ShortCode
     *                             resources to read
     * @param string $shortCode    Filter by ShortCode
     *
     * @return ReadShortCodeOptions Options builder
     */
    public static function read(string $friendlyName = Values::NONE, string $shortCode = Values::NONE): ReadShortCodeOptions
    {
        return new ReadShortCodeOptions($friendlyName, $shortCode);
    }
}

class UpdateShortCodeOptions extends Options
{
    /**
     * @param string $friendlyName      A string to describe this resource
     * @param string $apiVersion        The API version to use to start a new TwiML session
     * @param string $smsUrl            URL Twilio will request when receiving an SMS
     * @param string $smsMethod         HTTP method to use when requesting the sms url
     * @param string $smsFallbackUrl    URL Twilio will request if an error occurs in
     *                                  executing TwiML
     * @param string $smsFallbackMethod HTTP method Twilio will use with
     *                                  sms_fallback_url
     */
    public function __construct(string $friendlyName = Values::NONE, string $apiVersion = Values::NONE, string $smsUrl = Values::NONE, string $smsMethod = Values::NONE, string $smsFallbackUrl = Values::NONE, string $smsFallbackMethod = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['apiVersion'] = $apiVersion;
        $this->options['smsUrl'] = $smsUrl;
        $this->options['smsMethod'] = $smsMethod;
        $this->options['smsFallbackUrl'] = $smsFallbackUrl;
        $this->options['smsFallbackMethod'] = $smsFallbackMethod;
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $options = \http_build_query(Values::of($this->options), '', ' ');

        return '[Twilio.Api.V2010.UpdateShortCodeOptions '.$options.']';
    }

    /**
     * A descriptive string that you created to describe this resource. It can be up to 64 characters long. By default, the `FriendlyName` is the short code.
     *
     * @param string $friendlyName A string to describe this resource
     *
     * @return $this Fluent Builder
     */
    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;

        return $this;
    }

    /**
     * The API version to use to start a new TwiML session. Can be: `2010-04-01` or `2008-08-01`.
     *
     * @param string $apiVersion The API version to use to start a new TwiML session
     *
     * @return $this Fluent Builder
     */
    public function setApiVersion(string $apiVersion): self
    {
        $this->options['apiVersion'] = $apiVersion;

        return $this;
    }

    /**
     * The URL we should call when receiving an incoming SMS message to this short code.
     *
     * @param string $smsUrl URL Twilio will request when receiving an SMS
     *
     * @return $this Fluent Builder
     */
    public function setSmsUrl(string $smsUrl): self
    {
        $this->options['smsUrl'] = $smsUrl;

        return $this;
    }

    /**
     * The HTTP method we should use when calling the `sms_url`. Can be: `GET` or `POST`.
     *
     * @param string $smsMethod HTTP method to use when requesting the sms url
     *
     * @return $this Fluent Builder
     */
    public function setSmsMethod(string $smsMethod): self
    {
        $this->options['smsMethod'] = $smsMethod;

        return $this;
    }

    /**
     * The URL that we should call if an error occurs while retrieving or executing the TwiML from `sms_url`.
     *
     * @param string $smsFallbackUrl URL Twilio will request if an error occurs in
     *                               executing TwiML
     *
     * @return $this Fluent Builder
     */
    public function setSmsFallbackUrl(string $smsFallbackUrl): self
    {
        $this->options['smsFallbackUrl'] = $smsFallbackUrl;

        return $this;
    }

    /**
     * The HTTP method that we should use to call the `sms_fallback_url`. Can be: `GET` or `POST`.
     *
     * @param string $smsFallbackMethod HTTP method Twilio will use with
     *                                  sms_fallback_url
     *
     * @return $this Fluent Builder
     */
    public function setSmsFallbackMethod(string $smsFallbackMethod): self
    {
        $this->options['smsFallbackMethod'] = $smsFallbackMethod;

        return $this;
    }
}

class ReadShortCodeOptions extends Options
{
    /**
     * @param string $friendlyName The string that identifies the ShortCode
     *                             resources to read
     * @param string $shortCode    Filter by ShortCode
     */
    public function __construct(string $friendlyName = Values::NONE, string $shortCode = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['shortCode'] = $shortCode;
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $options = \http_build_query(Values::of($this->options), '', ' ');

        return '[Twilio.Api.V2010.ReadShortCodeOptions '.$options.']';
    }

    /**
     * The string that identifies the ShortCode resources to read.
     *
     * @param string $friendlyName The string that identifies the ShortCode
     *                             resources to read
     *
     * @return $this Fluent Builder
     */
    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;

        return $this;
    }

    /**
     * Only show the ShortCode resources that match this pattern. You can specify partial numbers and use '*' as a wildcard for any digit.
     *
     * @param string $shortCode Filter by ShortCode
     *
     * @return $this Fluent Builder
     */
    public function setShortCode(string $shortCode): self
    {
        $this->options['shortCode'] = $shortCode;

        return $this;
    }
}
