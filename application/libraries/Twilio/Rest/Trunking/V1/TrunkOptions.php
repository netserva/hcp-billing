<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Trunking\V1;

use Twilio\Options;
use Twilio\Values;

abstract class TrunkOptions
{
    /**
     * @param string $friendlyName           A string to describe the resource
     * @param string $domainName             The unique address you reserve on Twilio to which
     *                                       you route your SIP traffic
     * @param string $disasterRecoveryUrl    The HTTP URL that we should call if an
     *                                       error occurs while sending SIP traffic
     *                                       towards your configured Origination URL
     * @param string $disasterRecoveryMethod The HTTP method we should use to call
     *                                       the disaster_recovery_url
     * @param string $transferMode           The call transfer settings for the trunk
     * @param bool   $secure                 Whether Secure Trunking is enabled for the trunk
     * @param bool   $cnamLookupEnabled      Whether Caller ID Name (CNAM) lookup should
     *                                       be enabled for the trunk
     *
     * @return CreateTrunkOptions Options builder
     */
    public static function create(string $friendlyName = Values::NONE, string $domainName = Values::NONE, string $disasterRecoveryUrl = Values::NONE, string $disasterRecoveryMethod = Values::NONE, string $transferMode = Values::NONE, bool $secure = Values::NONE, bool $cnamLookupEnabled = Values::NONE): CreateTrunkOptions
    {
        return new CreateTrunkOptions($friendlyName, $domainName, $disasterRecoveryUrl, $disasterRecoveryMethod, $transferMode, $secure, $cnamLookupEnabled);
    }

    /**
     * @param string $friendlyName           A string to describe the resource
     * @param string $domainName             The unique address you reserve on Twilio to which
     *                                       you route your SIP traffic
     * @param string $disasterRecoveryUrl    The HTTP URL that we should call if an
     *                                       error occurs while sending SIP traffic
     *                                       towards your configured Origination URL
     * @param string $disasterRecoveryMethod The HTTP method we should use to call
     *                                       the disaster_recovery_url
     * @param string $transferMode           The call transfer settings for the trunk
     * @param bool   $secure                 Whether Secure Trunking is enabled for the trunk
     * @param bool   $cnamLookupEnabled      Whether Caller ID Name (CNAM) lookup should
     *                                       be enabled for the trunk
     *
     * @return UpdateTrunkOptions Options builder
     */
    public static function update(string $friendlyName = Values::NONE, string $domainName = Values::NONE, string $disasterRecoveryUrl = Values::NONE, string $disasterRecoveryMethod = Values::NONE, string $transferMode = Values::NONE, bool $secure = Values::NONE, bool $cnamLookupEnabled = Values::NONE): UpdateTrunkOptions
    {
        return new UpdateTrunkOptions($friendlyName, $domainName, $disasterRecoveryUrl, $disasterRecoveryMethod, $transferMode, $secure, $cnamLookupEnabled);
    }
}

class CreateTrunkOptions extends Options
{
    /**
     * @param string $friendlyName           A string to describe the resource
     * @param string $domainName             The unique address you reserve on Twilio to which
     *                                       you route your SIP traffic
     * @param string $disasterRecoveryUrl    The HTTP URL that we should call if an
     *                                       error occurs while sending SIP traffic
     *                                       towards your configured Origination URL
     * @param string $disasterRecoveryMethod The HTTP method we should use to call
     *                                       the disaster_recovery_url
     * @param string $transferMode           The call transfer settings for the trunk
     * @param bool   $secure                 Whether Secure Trunking is enabled for the trunk
     * @param bool   $cnamLookupEnabled      Whether Caller ID Name (CNAM) lookup should
     *                                       be enabled for the trunk
     */
    public function __construct(string $friendlyName = Values::NONE, string $domainName = Values::NONE, string $disasterRecoveryUrl = Values::NONE, string $disasterRecoveryMethod = Values::NONE, string $transferMode = Values::NONE, bool $secure = Values::NONE, bool $cnamLookupEnabled = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['domainName'] = $domainName;
        $this->options['disasterRecoveryUrl'] = $disasterRecoveryUrl;
        $this->options['disasterRecoveryMethod'] = $disasterRecoveryMethod;
        $this->options['transferMode'] = $transferMode;
        $this->options['secure'] = $secure;
        $this->options['cnamLookupEnabled'] = $cnamLookupEnabled;
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $options = \http_build_query(Values::of($this->options), '', ' ');

        return '[Twilio.Trunking.V1.CreateTrunkOptions '.$options.']';
    }

    /**
     * A descriptive string that you create to describe the resource. It can be up to 64 characters long.
     *
     * @param string $friendlyName A string to describe the resource
     *
     * @return $this Fluent Builder
     */
    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;

        return $this;
    }

    /**
     * The unique address you reserve on Twilio to which you route your SIP traffic. Domain names can contain letters, digits, and `-` and must end with `pstn.twilio.com`. See [Termination Settings](https://www.twilio.com/docs/sip-trunking#termination) for more information.
     *
     * @param string $domainName The unique address you reserve on Twilio to which
     *                           you route your SIP traffic
     *
     * @return $this Fluent Builder
     */
    public function setDomainName(string $domainName): self
    {
        $this->options['domainName'] = $domainName;

        return $this;
    }

    /**
     * The URL we should call using the `disaster_recovery_method` if an error occurs while sending SIP traffic towards the configured Origination URL. We retrieve TwiML from the URL and execute the instructions like any other normal TwiML call. See [Disaster Recovery](https://www.twilio.com/docs/sip-trunking#disaster-recovery) for more information.
     *
     * @param string $disasterRecoveryUrl The HTTP URL that we should call if an
     *                                    error occurs while sending SIP traffic
     *                                    towards your configured Origination URL
     *
     * @return $this Fluent Builder
     */
    public function setDisasterRecoveryUrl(string $disasterRecoveryUrl): self
    {
        $this->options['disasterRecoveryUrl'] = $disasterRecoveryUrl;

        return $this;
    }

    /**
     * The HTTP method we should use to call the `disaster_recovery_url`. Can be: `GET` or `POST`.
     *
     * @param string $disasterRecoveryMethod The HTTP method we should use to call
     *                                       the disaster_recovery_url
     *
     * @return $this Fluent Builder
     */
    public function setDisasterRecoveryMethod(string $disasterRecoveryMethod): self
    {
        $this->options['disasterRecoveryMethod'] = $disasterRecoveryMethod;

        return $this;
    }

    /**
     * The call transfer settings for the trunk. Can be: `enable-all`, `sip-only` and `disable-all`. See [Transfer](https://www.twilio.com/docs/sip-trunking/call-transfer) for more information.
     *
     * @param string $transferMode The call transfer settings for the trunk
     *
     * @return $this Fluent Builder
     */
    public function setTransferMode(string $transferMode): self
    {
        $this->options['transferMode'] = $transferMode;

        return $this;
    }

    /**
     * Whether Secure Trunking is enabled for the trunk. If enabled, all calls going through the trunk will be secure using SRTP for media and TLS for signaling. If disabled, then RTP will be used for media. See [Secure Trunking](https://www.twilio.com/docs/sip-trunking#securetrunking) for more information.
     *
     * @param bool $secure Whether Secure Trunking is enabled for the trunk
     *
     * @return $this Fluent Builder
     */
    public function setSecure(bool $secure): self
    {
        $this->options['secure'] = $secure;

        return $this;
    }

    /**
     * Whether Caller ID Name (CNAM) lookup should be enabled for the trunk. If enabled, all inbound calls to the SIP Trunk from the United States and Canada automatically perform a CNAM Lookup and display Caller ID data on your phone. See [CNAM Lookups](https://www.twilio.com/docs/sip-trunking#CNAM) for more information.
     *
     * @param bool $cnamLookupEnabled Whether Caller ID Name (CNAM) lookup should
     *                                be enabled for the trunk
     *
     * @return $this Fluent Builder
     */
    public function setCnamLookupEnabled(bool $cnamLookupEnabled): self
    {
        $this->options['cnamLookupEnabled'] = $cnamLookupEnabled;

        return $this;
    }
}

class UpdateTrunkOptions extends Options
{
    /**
     * @param string $friendlyName           A string to describe the resource
     * @param string $domainName             The unique address you reserve on Twilio to which
     *                                       you route your SIP traffic
     * @param string $disasterRecoveryUrl    The HTTP URL that we should call if an
     *                                       error occurs while sending SIP traffic
     *                                       towards your configured Origination URL
     * @param string $disasterRecoveryMethod The HTTP method we should use to call
     *                                       the disaster_recovery_url
     * @param string $transferMode           The call transfer settings for the trunk
     * @param bool   $secure                 Whether Secure Trunking is enabled for the trunk
     * @param bool   $cnamLookupEnabled      Whether Caller ID Name (CNAM) lookup should
     *                                       be enabled for the trunk
     */
    public function __construct(string $friendlyName = Values::NONE, string $domainName = Values::NONE, string $disasterRecoveryUrl = Values::NONE, string $disasterRecoveryMethod = Values::NONE, string $transferMode = Values::NONE, bool $secure = Values::NONE, bool $cnamLookupEnabled = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['domainName'] = $domainName;
        $this->options['disasterRecoveryUrl'] = $disasterRecoveryUrl;
        $this->options['disasterRecoveryMethod'] = $disasterRecoveryMethod;
        $this->options['transferMode'] = $transferMode;
        $this->options['secure'] = $secure;
        $this->options['cnamLookupEnabled'] = $cnamLookupEnabled;
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $options = \http_build_query(Values::of($this->options), '', ' ');

        return '[Twilio.Trunking.V1.UpdateTrunkOptions '.$options.']';
    }

    /**
     * A descriptive string that you create to describe the resource. It can be up to 64 characters long.
     *
     * @param string $friendlyName A string to describe the resource
     *
     * @return $this Fluent Builder
     */
    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;

        return $this;
    }

    /**
     * The unique address you reserve on Twilio to which you route your SIP traffic. Domain names can contain letters, digits, and `-` and must end with `pstn.twilio.com`. See [Termination Settings](https://www.twilio.com/docs/sip-trunking#termination) for more information.
     *
     * @param string $domainName The unique address you reserve on Twilio to which
     *                           you route your SIP traffic
     *
     * @return $this Fluent Builder
     */
    public function setDomainName(string $domainName): self
    {
        $this->options['domainName'] = $domainName;

        return $this;
    }

    /**
     * The URL we should call using the `disaster_recovery_method` if an error occurs while sending SIP traffic towards the configured Origination URL. We retrieve TwiML from the URL and execute the instructions like any other normal TwiML call. See [Disaster Recovery](https://www.twilio.com/docs/sip-trunking#disaster-recovery) for more information.
     *
     * @param string $disasterRecoveryUrl The HTTP URL that we should call if an
     *                                    error occurs while sending SIP traffic
     *                                    towards your configured Origination URL
     *
     * @return $this Fluent Builder
     */
    public function setDisasterRecoveryUrl(string $disasterRecoveryUrl): self
    {
        $this->options['disasterRecoveryUrl'] = $disasterRecoveryUrl;

        return $this;
    }

    /**
     * The HTTP method we should use to call the `disaster_recovery_url`. Can be: `GET` or `POST`.
     *
     * @param string $disasterRecoveryMethod The HTTP method we should use to call
     *                                       the disaster_recovery_url
     *
     * @return $this Fluent Builder
     */
    public function setDisasterRecoveryMethod(string $disasterRecoveryMethod): self
    {
        $this->options['disasterRecoveryMethod'] = $disasterRecoveryMethod;

        return $this;
    }

    /**
     * The call transfer settings for the trunk. Can be: `enable-all`, `sip-only` and `disable-all`. See [Transfer](https://www.twilio.com/docs/sip-trunking/call-transfer) for more information.
     *
     * @param string $transferMode The call transfer settings for the trunk
     *
     * @return $this Fluent Builder
     */
    public function setTransferMode(string $transferMode): self
    {
        $this->options['transferMode'] = $transferMode;

        return $this;
    }

    /**
     * Whether Secure Trunking is enabled for the trunk. If enabled, all calls going through the trunk will be secure using SRTP for media and TLS for signaling. If disabled, then RTP will be used for media. See [Secure Trunking](https://www.twilio.com/docs/sip-trunking#securetrunking) for more information.
     *
     * @param bool $secure Whether Secure Trunking is enabled for the trunk
     *
     * @return $this Fluent Builder
     */
    public function setSecure(bool $secure): self
    {
        $this->options['secure'] = $secure;

        return $this;
    }

    /**
     * Whether Caller ID Name (CNAM) lookup should be enabled for the trunk. If enabled, all inbound calls to the SIP Trunk from the United States and Canada automatically perform a CNAM Lookup and display Caller ID data on your phone. See [CNAM Lookups](https://www.twilio.com/docs/sip-trunking#CNAM) for more information.
     *
     * @param bool $cnamLookupEnabled Whether Caller ID Name (CNAM) lookup should
     *                                be enabled for the trunk
     *
     * @return $this Fluent Builder
     */
    public function setCnamLookupEnabled(bool $cnamLookupEnabled): self
    {
        $this->options['cnamLookupEnabled'] = $cnamLookupEnabled;

        return $this;
    }
}
