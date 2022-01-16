<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Verify\V2;

use Twilio\Options;
use Twilio\Values;

abstract class ServiceOptions
{
    /**
     * @param int    $codeLength               The length of the verification code to generate
     * @param bool   $lookupEnabled            Whether to perform a lookup with each verification
     * @param bool   $skipSmsToLandlines       Whether to skip sending SMS verifications to
     *                                         landlines
     * @param bool   $dtmfInputRequired        Whether to ask the user to press a number
     *                                         before delivering the verify code in a phone
     *                                         call
     * @param string $ttsName                  The name of an alternative text-to-speech service to
     *                                         use in phone calls
     * @param bool   $psd2Enabled              Whether to pass PSD2 transaction parameters when
     *                                         starting a verification
     * @param bool   $doNotShareWarningEnabled whether to add a security warning at
     *                                         the end of an SMS
     * @param bool   $customCodeEnabled        whether to allow sending verifications with a
     *                                         custom code
     * @param bool   $pushIncludeDate          Optional. Include the date in the Challenge's
     *                                         reponse. Default: true
     * @param string $pushApnCredentialSid     Optional. Set APN Credential for this
     *                                         service.
     * @param string $pushFcmCredentialSid     Optional. Set FCM Credential for this
     *                                         service.
     * @param string $totpIssuer               Optional. Set TOTP Issuer for this service.
     * @param int    $totpTimeStep             Optional. How often, in seconds, are TOTP codes
     *                                         generated
     * @param int    $totpCodeLength           Optional. Number of digits for generated TOTP
     *                                         codes
     * @param int    $totpSkew                 Optional. The number of past and future time-steps
     *                                         valid at a given time
     *
     * @return CreateServiceOptions Options builder
     */
    public static function create(int $codeLength = Values::NONE, bool $lookupEnabled = Values::NONE, bool $skipSmsToLandlines = Values::NONE, bool $dtmfInputRequired = Values::NONE, string $ttsName = Values::NONE, bool $psd2Enabled = Values::NONE, bool $doNotShareWarningEnabled = Values::NONE, bool $customCodeEnabled = Values::NONE, bool $pushIncludeDate = Values::NONE, string $pushApnCredentialSid = Values::NONE, string $pushFcmCredentialSid = Values::NONE, string $totpIssuer = Values::NONE, int $totpTimeStep = Values::NONE, int $totpCodeLength = Values::NONE, int $totpSkew = Values::NONE): CreateServiceOptions
    {
        return new CreateServiceOptions($codeLength, $lookupEnabled, $skipSmsToLandlines, $dtmfInputRequired, $ttsName, $psd2Enabled, $doNotShareWarningEnabled, $customCodeEnabled, $pushIncludeDate, $pushApnCredentialSid, $pushFcmCredentialSid, $totpIssuer, $totpTimeStep, $totpCodeLength, $totpSkew);
    }

    /**
     * @param string $friendlyName             A string to describe the verification service
     * @param int    $codeLength               The length of the verification code to generate
     * @param bool   $lookupEnabled            Whether to perform a lookup with each verification
     * @param bool   $skipSmsToLandlines       Whether to skip sending SMS verifications to
     *                                         landlines
     * @param bool   $dtmfInputRequired        Whether to ask the user to press a number
     *                                         before delivering the verify code in a phone
     *                                         call
     * @param string $ttsName                  The name of an alternative text-to-speech service to
     *                                         use in phone calls
     * @param bool   $psd2Enabled              Whether to pass PSD2 transaction parameters when
     *                                         starting a verification
     * @param bool   $doNotShareWarningEnabled whether to add a privacy warning at
     *                                         the end of an SMS
     * @param bool   $customCodeEnabled        whether to allow sending verifications with a
     *                                         custom code
     * @param bool   $pushIncludeDate          Optional. Include the date in the Challenge's
     *                                         reponse. Default: true
     * @param string $pushApnCredentialSid     Optional. Set APN Credential for this
     *                                         service.
     * @param string $pushFcmCredentialSid     Optional. Set FCM Credential for this
     *                                         service.
     * @param string $totpIssuer               Optional. Set TOTP Issuer for this service.
     * @param int    $totpTimeStep             Optional. How often, in seconds, are TOTP codes
     *                                         generated
     * @param int    $totpCodeLength           Optional. Number of digits for generated TOTP
     *                                         codes
     * @param int    $totpSkew                 Optional. The number of past and future time-steps
     *                                         valid at a given time
     *
     * @return UpdateServiceOptions Options builder
     */
    public static function update(string $friendlyName = Values::NONE, int $codeLength = Values::NONE, bool $lookupEnabled = Values::NONE, bool $skipSmsToLandlines = Values::NONE, bool $dtmfInputRequired = Values::NONE, string $ttsName = Values::NONE, bool $psd2Enabled = Values::NONE, bool $doNotShareWarningEnabled = Values::NONE, bool $customCodeEnabled = Values::NONE, bool $pushIncludeDate = Values::NONE, string $pushApnCredentialSid = Values::NONE, string $pushFcmCredentialSid = Values::NONE, string $totpIssuer = Values::NONE, int $totpTimeStep = Values::NONE, int $totpCodeLength = Values::NONE, int $totpSkew = Values::NONE): UpdateServiceOptions
    {
        return new UpdateServiceOptions($friendlyName, $codeLength, $lookupEnabled, $skipSmsToLandlines, $dtmfInputRequired, $ttsName, $psd2Enabled, $doNotShareWarningEnabled, $customCodeEnabled, $pushIncludeDate, $pushApnCredentialSid, $pushFcmCredentialSid, $totpIssuer, $totpTimeStep, $totpCodeLength, $totpSkew);
    }
}

class CreateServiceOptions extends Options
{
    /**
     * @param int    $codeLength               The length of the verification code to generate
     * @param bool   $lookupEnabled            Whether to perform a lookup with each verification
     * @param bool   $skipSmsToLandlines       Whether to skip sending SMS verifications to
     *                                         landlines
     * @param bool   $dtmfInputRequired        Whether to ask the user to press a number
     *                                         before delivering the verify code in a phone
     *                                         call
     * @param string $ttsName                  The name of an alternative text-to-speech service to
     *                                         use in phone calls
     * @param bool   $psd2Enabled              Whether to pass PSD2 transaction parameters when
     *                                         starting a verification
     * @param bool   $doNotShareWarningEnabled whether to add a security warning at
     *                                         the end of an SMS
     * @param bool   $customCodeEnabled        whether to allow sending verifications with a
     *                                         custom code
     * @param bool   $pushIncludeDate          Optional. Include the date in the Challenge's
     *                                         reponse. Default: true
     * @param string $pushApnCredentialSid     Optional. Set APN Credential for this
     *                                         service.
     * @param string $pushFcmCredentialSid     Optional. Set FCM Credential for this
     *                                         service.
     * @param string $totpIssuer               Optional. Set TOTP Issuer for this service.
     * @param int    $totpTimeStep             Optional. How often, in seconds, are TOTP codes
     *                                         generated
     * @param int    $totpCodeLength           Optional. Number of digits for generated TOTP
     *                                         codes
     * @param int    $totpSkew                 Optional. The number of past and future time-steps
     *                                         valid at a given time
     */
    public function __construct(int $codeLength = Values::NONE, bool $lookupEnabled = Values::NONE, bool $skipSmsToLandlines = Values::NONE, bool $dtmfInputRequired = Values::NONE, string $ttsName = Values::NONE, bool $psd2Enabled = Values::NONE, bool $doNotShareWarningEnabled = Values::NONE, bool $customCodeEnabled = Values::NONE, bool $pushIncludeDate = Values::NONE, string $pushApnCredentialSid = Values::NONE, string $pushFcmCredentialSid = Values::NONE, string $totpIssuer = Values::NONE, int $totpTimeStep = Values::NONE, int $totpCodeLength = Values::NONE, int $totpSkew = Values::NONE)
    {
        $this->options['codeLength'] = $codeLength;
        $this->options['lookupEnabled'] = $lookupEnabled;
        $this->options['skipSmsToLandlines'] = $skipSmsToLandlines;
        $this->options['dtmfInputRequired'] = $dtmfInputRequired;
        $this->options['ttsName'] = $ttsName;
        $this->options['psd2Enabled'] = $psd2Enabled;
        $this->options['doNotShareWarningEnabled'] = $doNotShareWarningEnabled;
        $this->options['customCodeEnabled'] = $customCodeEnabled;
        $this->options['pushIncludeDate'] = $pushIncludeDate;
        $this->options['pushApnCredentialSid'] = $pushApnCredentialSid;
        $this->options['pushFcmCredentialSid'] = $pushFcmCredentialSid;
        $this->options['totpIssuer'] = $totpIssuer;
        $this->options['totpTimeStep'] = $totpTimeStep;
        $this->options['totpCodeLength'] = $totpCodeLength;
        $this->options['totpSkew'] = $totpSkew;
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $options = \http_build_query(Values::of($this->options), '', ' ');

        return '[Twilio.Verify.V2.CreateServiceOptions '.$options.']';
    }

    /**
     * The length of the verification code to generate. Must be an integer value between 4 and 10, inclusive.
     *
     * @param int $codeLength The length of the verification code to generate
     *
     * @return $this Fluent Builder
     */
    public function setCodeLength(int $codeLength): self
    {
        $this->options['codeLength'] = $codeLength;

        return $this;
    }

    /**
     * Whether to perform a lookup with each verification started and return info about the phone number.
     *
     * @param bool $lookupEnabled Whether to perform a lookup with each verification
     *
     * @return $this Fluent Builder
     */
    public function setLookupEnabled(bool $lookupEnabled): self
    {
        $this->options['lookupEnabled'] = $lookupEnabled;

        return $this;
    }

    /**
     * Whether to skip sending SMS verifications to landlines. Requires `lookup_enabled`.
     *
     * @param bool $skipSmsToLandlines Whether to skip sending SMS verifications to
     *                                 landlines
     *
     * @return $this Fluent Builder
     */
    public function setSkipSmsToLandlines(bool $skipSmsToLandlines): self
    {
        $this->options['skipSmsToLandlines'] = $skipSmsToLandlines;

        return $this;
    }

    /**
     * Whether to ask the user to press a number before delivering the verify code in a phone call.
     *
     * @param bool $dtmfInputRequired Whether to ask the user to press a number
     *                                before delivering the verify code in a phone
     *                                call
     *
     * @return $this Fluent Builder
     */
    public function setDtmfInputRequired(bool $dtmfInputRequired): self
    {
        $this->options['dtmfInputRequired'] = $dtmfInputRequired;

        return $this;
    }

    /**
     * The name of an alternative text-to-speech service to use in phone calls. Applies only to TTS languages.
     *
     * @param string $ttsName The name of an alternative text-to-speech service to
     *                        use in phone calls
     *
     * @return $this Fluent Builder
     */
    public function setTtsName(string $ttsName): self
    {
        $this->options['ttsName'] = $ttsName;

        return $this;
    }

    /**
     * Whether to pass PSD2 transaction parameters when starting a verification.
     *
     * @param bool $psd2Enabled Whether to pass PSD2 transaction parameters when
     *                          starting a verification
     *
     * @return $this Fluent Builder
     */
    public function setPsd2Enabled(bool $psd2Enabled): self
    {
        $this->options['psd2Enabled'] = $psd2Enabled;

        return $this;
    }

    /**
     * Whether to add a security warning at the end of an SMS verification body. Disabled by default and applies only to SMS. Example SMS body: `Your AppName verification code is: 1234. Don’t share this code with anyone; our employees will never ask for the code`.
     *
     * @param bool $doNotShareWarningEnabled whether to add a security warning at
     *                                       the end of an SMS
     *
     * @return $this Fluent Builder
     */
    public function setDoNotShareWarningEnabled(bool $doNotShareWarningEnabled): self
    {
        $this->options['doNotShareWarningEnabled'] = $doNotShareWarningEnabled;

        return $this;
    }

    /**
     * Whether to allow sending verifications with a custom code instead of a randomly generated one. Not available for all customers.
     *
     * @param bool $customCodeEnabled whether to allow sending verifications with a
     *                                custom code
     *
     * @return $this Fluent Builder
     */
    public function setCustomCodeEnabled(bool $customCodeEnabled): self
    {
        $this->options['customCodeEnabled'] = $customCodeEnabled;

        return $this;
    }

    /**
     * Optional configuration for the Push factors. If true, include the date in the Challenge's reponse. Otherwise, the date is omitted from the response. See [Challenge](https://www.twilio.com/docs/verify/api/challenge) resource’s details parameter for more info. Default: true.
     *
     * @param bool $pushIncludeDate Optional. Include the date in the Challenge's
     *                              reponse. Default: true
     *
     * @return $this Fluent Builder
     */
    public function setPushIncludeDate(bool $pushIncludeDate): self
    {
        $this->options['pushIncludeDate'] = $pushIncludeDate;

        return $this;
    }

    /**
     * Optional configuration for the Push factors. Set the APN Credential for this service. This will allow to send push notifications to iOS devices. See [Credential Resource](https://www.twilio.com/docs/notify/api/credential-resource).
     *
     * @param string $pushApnCredentialSid Optional. Set APN Credential for this
     *                                     service.
     *
     * @return $this Fluent Builder
     */
    public function setPushApnCredentialSid(string $pushApnCredentialSid): self
    {
        $this->options['pushApnCredentialSid'] = $pushApnCredentialSid;

        return $this;
    }

    /**
     * Optional configuration for the Push factors. Set the FCM Credential for this service. This will allow to send push notifications to Android devices. See [Credential Resource](https://www.twilio.com/docs/notify/api/credential-resource).
     *
     * @param string $pushFcmCredentialSid Optional. Set FCM Credential for this
     *                                     service.
     *
     * @return $this Fluent Builder
     */
    public function setPushFcmCredentialSid(string $pushFcmCredentialSid): self
    {
        $this->options['pushFcmCredentialSid'] = $pushFcmCredentialSid;

        return $this;
    }

    /**
     * Optional configuration for the TOTP factors. Set TOTP Issuer for this service. This will allow to configure the issuer of the TOTP URI. Defaults to the service friendly name if not provided.
     *
     * @param string $totpIssuer Optional. Set TOTP Issuer for this service.
     *
     * @return $this Fluent Builder
     */
    public function setTotpIssuer(string $totpIssuer): self
    {
        $this->options['totpIssuer'] = $totpIssuer;

        return $this;
    }

    /**
     * Optional configuration for the TOTP factors. Defines how often, in seconds, are TOTP codes generated. i.e, a new TOTP code is generated every time_step seconds. Must be between 20 and 60 seconds, inclusive. Defaults to 30 seconds.
     *
     * @param int $totpTimeStep Optional. How often, in seconds, are TOTP codes
     *                          generated
     *
     * @return $this Fluent Builder
     */
    public function setTotpTimeStep(int $totpTimeStep): self
    {
        $this->options['totpTimeStep'] = $totpTimeStep;

        return $this;
    }

    /**
     * Optional configuration for the TOTP factors. Number of digits for generated TOTP codes. Must be between 3 and 8, inclusive. Defaults to 6.
     *
     * @param int $totpCodeLength Optional. Number of digits for generated TOTP
     *                            codes
     *
     * @return $this Fluent Builder
     */
    public function setTotpCodeLength(int $totpCodeLength): self
    {
        $this->options['totpCodeLength'] = $totpCodeLength;

        return $this;
    }

    /**
     * Optional configuration for the TOTP factors. The number of time-steps, past and future, that are valid for validation of TOTP codes. Must be between 0 and 2, inclusive. Defaults to 1.
     *
     * @param int $totpSkew Optional. The number of past and future time-steps
     *                      valid at a given time
     *
     * @return $this Fluent Builder
     */
    public function setTotpSkew(int $totpSkew): self
    {
        $this->options['totpSkew'] = $totpSkew;

        return $this;
    }
}

class UpdateServiceOptions extends Options
{
    /**
     * @param string $friendlyName             A string to describe the verification service
     * @param int    $codeLength               The length of the verification code to generate
     * @param bool   $lookupEnabled            Whether to perform a lookup with each verification
     * @param bool   $skipSmsToLandlines       Whether to skip sending SMS verifications to
     *                                         landlines
     * @param bool   $dtmfInputRequired        Whether to ask the user to press a number
     *                                         before delivering the verify code in a phone
     *                                         call
     * @param string $ttsName                  The name of an alternative text-to-speech service to
     *                                         use in phone calls
     * @param bool   $psd2Enabled              Whether to pass PSD2 transaction parameters when
     *                                         starting a verification
     * @param bool   $doNotShareWarningEnabled whether to add a privacy warning at
     *                                         the end of an SMS
     * @param bool   $customCodeEnabled        whether to allow sending verifications with a
     *                                         custom code
     * @param bool   $pushIncludeDate          Optional. Include the date in the Challenge's
     *                                         reponse. Default: true
     * @param string $pushApnCredentialSid     Optional. Set APN Credential for this
     *                                         service.
     * @param string $pushFcmCredentialSid     Optional. Set FCM Credential for this
     *                                         service.
     * @param string $totpIssuer               Optional. Set TOTP Issuer for this service.
     * @param int    $totpTimeStep             Optional. How often, in seconds, are TOTP codes
     *                                         generated
     * @param int    $totpCodeLength           Optional. Number of digits for generated TOTP
     *                                         codes
     * @param int    $totpSkew                 Optional. The number of past and future time-steps
     *                                         valid at a given time
     */
    public function __construct(string $friendlyName = Values::NONE, int $codeLength = Values::NONE, bool $lookupEnabled = Values::NONE, bool $skipSmsToLandlines = Values::NONE, bool $dtmfInputRequired = Values::NONE, string $ttsName = Values::NONE, bool $psd2Enabled = Values::NONE, bool $doNotShareWarningEnabled = Values::NONE, bool $customCodeEnabled = Values::NONE, bool $pushIncludeDate = Values::NONE, string $pushApnCredentialSid = Values::NONE, string $pushFcmCredentialSid = Values::NONE, string $totpIssuer = Values::NONE, int $totpTimeStep = Values::NONE, int $totpCodeLength = Values::NONE, int $totpSkew = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['codeLength'] = $codeLength;
        $this->options['lookupEnabled'] = $lookupEnabled;
        $this->options['skipSmsToLandlines'] = $skipSmsToLandlines;
        $this->options['dtmfInputRequired'] = $dtmfInputRequired;
        $this->options['ttsName'] = $ttsName;
        $this->options['psd2Enabled'] = $psd2Enabled;
        $this->options['doNotShareWarningEnabled'] = $doNotShareWarningEnabled;
        $this->options['customCodeEnabled'] = $customCodeEnabled;
        $this->options['pushIncludeDate'] = $pushIncludeDate;
        $this->options['pushApnCredentialSid'] = $pushApnCredentialSid;
        $this->options['pushFcmCredentialSid'] = $pushFcmCredentialSid;
        $this->options['totpIssuer'] = $totpIssuer;
        $this->options['totpTimeStep'] = $totpTimeStep;
        $this->options['totpCodeLength'] = $totpCodeLength;
        $this->options['totpSkew'] = $totpSkew;
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $options = \http_build_query(Values::of($this->options), '', ' ');

        return '[Twilio.Verify.V2.UpdateServiceOptions '.$options.']';
    }

    /**
     * A descriptive string that you create to describe the verification service. It can be up to 30 characters long. **This value should not contain PII.**.
     *
     * @param string $friendlyName A string to describe the verification service
     *
     * @return $this Fluent Builder
     */
    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;

        return $this;
    }

    /**
     * The length of the verification code to generate. Must be an integer value between 4 and 10, inclusive.
     *
     * @param int $codeLength The length of the verification code to generate
     *
     * @return $this Fluent Builder
     */
    public function setCodeLength(int $codeLength): self
    {
        $this->options['codeLength'] = $codeLength;

        return $this;
    }

    /**
     * Whether to perform a lookup with each verification started and return info about the phone number.
     *
     * @param bool $lookupEnabled Whether to perform a lookup with each verification
     *
     * @return $this Fluent Builder
     */
    public function setLookupEnabled(bool $lookupEnabled): self
    {
        $this->options['lookupEnabled'] = $lookupEnabled;

        return $this;
    }

    /**
     * Whether to skip sending SMS verifications to landlines. Requires `lookup_enabled`.
     *
     * @param bool $skipSmsToLandlines Whether to skip sending SMS verifications to
     *                                 landlines
     *
     * @return $this Fluent Builder
     */
    public function setSkipSmsToLandlines(bool $skipSmsToLandlines): self
    {
        $this->options['skipSmsToLandlines'] = $skipSmsToLandlines;

        return $this;
    }

    /**
     * Whether to ask the user to press a number before delivering the verify code in a phone call.
     *
     * @param bool $dtmfInputRequired Whether to ask the user to press a number
     *                                before delivering the verify code in a phone
     *                                call
     *
     * @return $this Fluent Builder
     */
    public function setDtmfInputRequired(bool $dtmfInputRequired): self
    {
        $this->options['dtmfInputRequired'] = $dtmfInputRequired;

        return $this;
    }

    /**
     * The name of an alternative text-to-speech service to use in phone calls. Applies only to TTS languages.
     *
     * @param string $ttsName The name of an alternative text-to-speech service to
     *                        use in phone calls
     *
     * @return $this Fluent Builder
     */
    public function setTtsName(string $ttsName): self
    {
        $this->options['ttsName'] = $ttsName;

        return $this;
    }

    /**
     * Whether to pass PSD2 transaction parameters when starting a verification.
     *
     * @param bool $psd2Enabled Whether to pass PSD2 transaction parameters when
     *                          starting a verification
     *
     * @return $this Fluent Builder
     */
    public function setPsd2Enabled(bool $psd2Enabled): self
    {
        $this->options['psd2Enabled'] = $psd2Enabled;

        return $this;
    }

    /**
     * Whether to add a privacy warning at the end of an SMS. **Disabled by default and applies only for SMS.**.
     *
     * @param bool $doNotShareWarningEnabled whether to add a privacy warning at
     *                                       the end of an SMS
     *
     * @return $this Fluent Builder
     */
    public function setDoNotShareWarningEnabled(bool $doNotShareWarningEnabled): self
    {
        $this->options['doNotShareWarningEnabled'] = $doNotShareWarningEnabled;

        return $this;
    }

    /**
     * Whether to allow sending verifications with a custom code instead of a randomly generated one. Not available for all customers.
     *
     * @param bool $customCodeEnabled whether to allow sending verifications with a
     *                                custom code
     *
     * @return $this Fluent Builder
     */
    public function setCustomCodeEnabled(bool $customCodeEnabled): self
    {
        $this->options['customCodeEnabled'] = $customCodeEnabled;

        return $this;
    }

    /**
     * Optional configuration for the Push factors. If true, include the date in the Challenge's reponse. Otherwise, the date is omitted from the response. See [Challenge](https://www.twilio.com/docs/verify/api/challenge) resource’s details parameter for more info. Default: true.
     *
     * @param bool $pushIncludeDate Optional. Include the date in the Challenge's
     *                              reponse. Default: true
     *
     * @return $this Fluent Builder
     */
    public function setPushIncludeDate(bool $pushIncludeDate): self
    {
        $this->options['pushIncludeDate'] = $pushIncludeDate;

        return $this;
    }

    /**
     * Optional configuration for the Push factors. Set the APN Credential for this service. This will allow to send push notifications to iOS devices. See [Credential Resource](https://www.twilio.com/docs/notify/api/credential-resource).
     *
     * @param string $pushApnCredentialSid Optional. Set APN Credential for this
     *                                     service.
     *
     * @return $this Fluent Builder
     */
    public function setPushApnCredentialSid(string $pushApnCredentialSid): self
    {
        $this->options['pushApnCredentialSid'] = $pushApnCredentialSid;

        return $this;
    }

    /**
     * Optional configuration for the Push factors. Set the FCM Credential for this service. This will allow to send push notifications to Android devices. See [Credential Resource](https://www.twilio.com/docs/notify/api/credential-resource).
     *
     * @param string $pushFcmCredentialSid Optional. Set FCM Credential for this
     *                                     service.
     *
     * @return $this Fluent Builder
     */
    public function setPushFcmCredentialSid(string $pushFcmCredentialSid): self
    {
        $this->options['pushFcmCredentialSid'] = $pushFcmCredentialSid;

        return $this;
    }

    /**
     * Optional configuration for the TOTP factors. Set TOTP Issuer for this service. This will allow to configure the issuer of the TOTP URI.
     *
     * @param string $totpIssuer Optional. Set TOTP Issuer for this service.
     *
     * @return $this Fluent Builder
     */
    public function setTotpIssuer(string $totpIssuer): self
    {
        $this->options['totpIssuer'] = $totpIssuer;

        return $this;
    }

    /**
     * Optional configuration for the TOTP factors. Defines how often, in seconds, are TOTP codes generated. i.e, a new TOTP code is generated every time_step seconds. Must be between 20 and 60 seconds, inclusive. Defaults to 30 seconds.
     *
     * @param int $totpTimeStep Optional. How often, in seconds, are TOTP codes
     *                          generated
     *
     * @return $this Fluent Builder
     */
    public function setTotpTimeStep(int $totpTimeStep): self
    {
        $this->options['totpTimeStep'] = $totpTimeStep;

        return $this;
    }

    /**
     * Optional configuration for the TOTP factors. Number of digits for generated TOTP codes. Must be between 3 and 8, inclusive. Defaults to 6.
     *
     * @param int $totpCodeLength Optional. Number of digits for generated TOTP
     *                            codes
     *
     * @return $this Fluent Builder
     */
    public function setTotpCodeLength(int $totpCodeLength): self
    {
        $this->options['totpCodeLength'] = $totpCodeLength;

        return $this;
    }

    /**
     * Optional configuration for the TOTP factors. The number of time-steps, past and future, that are valid for validation of TOTP codes. Must be between 0 and 2, inclusive. Defaults to 1.
     *
     * @param int $totpSkew Optional. The number of past and future time-steps
     *                      valid at a given time
     *
     * @return $this Fluent Builder
     */
    public function setTotpSkew(int $totpSkew): self
    {
        $this->options['totpSkew'] = $totpSkew;

        return $this;
    }
}
