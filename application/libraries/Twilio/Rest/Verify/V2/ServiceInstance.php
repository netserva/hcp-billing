<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Verify\V2;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Verify\V2\Service\AccessTokenList;
use Twilio\Rest\Verify\V2\Service\EntityList;
use Twilio\Rest\Verify\V2\Service\MessagingConfigurationList;
use Twilio\Rest\Verify\V2\Service\RateLimitList;
use Twilio\Rest\Verify\V2\Service\VerificationCheckList;
use Twilio\Rest\Verify\V2\Service\VerificationList;
use Twilio\Rest\Verify\V2\Service\WebhookList;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string    $sid
 * @property string    $accountSid
 * @property string    $friendlyName
 * @property int       $codeLength
 * @property bool      $lookupEnabled
 * @property bool      $psd2Enabled
 * @property bool      $skipSmsToLandlines
 * @property bool      $dtmfInputRequired
 * @property string    $ttsName
 * @property bool      $doNotShareWarningEnabled
 * @property bool      $customCodeEnabled
 * @property array     $push
 * @property array     $totp
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 * @property string    $url
 * @property array     $links
 */
class ServiceInstance extends InstanceResource
{
    protected $_verifications;
    protected $_verificationChecks;
    protected $_rateLimits;
    protected $_messagingConfigurations;
    protected $_entities;
    protected $_webhooks;
    protected $_accessTokens;

    /**
     * Initialize the ServiceInstance.
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string  $sid     The unique string that identifies the resource
     */
    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'sid' => Values::array_get($payload, 'sid'),
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'friendlyName' => Values::array_get($payload, 'friendly_name'),
            'codeLength' => Values::array_get($payload, 'code_length'),
            'lookupEnabled' => Values::array_get($payload, 'lookup_enabled'),
            'psd2Enabled' => Values::array_get($payload, 'psd2_enabled'),
            'skipSmsToLandlines' => Values::array_get($payload, 'skip_sms_to_landlines'),
            'dtmfInputRequired' => Values::array_get($payload, 'dtmf_input_required'),
            'ttsName' => Values::array_get($payload, 'tts_name'),
            'doNotShareWarningEnabled' => Values::array_get($payload, 'do_not_share_warning_enabled'),
            'customCodeEnabled' => Values::array_get($payload, 'custom_code_enabled'),
            'push' => Values::array_get($payload, 'push'),
            'totp' => Values::array_get($payload, 'totp'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'url' => Values::array_get($payload, 'url'),
            'links' => Values::array_get($payload, 'links'),
        ];

        $this->solution = ['sid' => $sid ?: $this->properties['sid']];
    }

    /**
     * Magic getter to access properties.
     *
     * @param string $name Property to access
     *
     * @throws TwilioException For unknown properties
     *
     * @return mixed The requested property
     */
    public function __get(string $name)
    {
        if (\array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        if (\property_exists($this, '_'.$name)) {
            $method = 'get'.\ucfirst($name);

            return $this->{$method}();
        }

        throw new TwilioException('Unknown property: '.$name);
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

        return '[Twilio.Verify.V2.ServiceInstance '.\implode(' ', $context).']';
    }

    /**
     * Fetch the ServiceInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return ServiceInstance Fetched ServiceInstance
     */
    public function fetch(): ServiceInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Delete the ServiceInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return bool True if delete succeeds, false otherwise
     */
    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    /**
     * Update the ServiceInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return ServiceInstance Updated ServiceInstance
     */
    public function update(array $options = []): ServiceInstance
    {
        return $this->proxy()->update($options);
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context.
     *
     * @return ServiceContext Context for this ServiceInstance
     */
    protected function proxy(): ServiceContext
    {
        if (!$this->context) {
            $this->context = new ServiceContext($this->version, $this->solution['sid']);
        }

        return $this->context;
    }

    /**
     * Access the verifications.
     */
    protected function getVerifications(): VerificationList
    {
        return $this->proxy()->verifications;
    }

    /**
     * Access the verificationChecks.
     */
    protected function getVerificationChecks(): VerificationCheckList
    {
        return $this->proxy()->verificationChecks;
    }

    /**
     * Access the rateLimits.
     */
    protected function getRateLimits(): RateLimitList
    {
        return $this->proxy()->rateLimits;
    }

    /**
     * Access the messagingConfigurations.
     */
    protected function getMessagingConfigurations(): MessagingConfigurationList
    {
        return $this->proxy()->messagingConfigurations;
    }

    /**
     * Access the entities.
     */
    protected function getEntities(): EntityList
    {
        return $this->proxy()->entities;
    }

    /**
     * Access the webhooks.
     */
    protected function getWebhooks(): WebhookList
    {
        return $this->proxy()->webhooks;
    }

    /**
     * Access the accessTokens.
     */
    protected function getAccessTokens(): AccessTokenList
    {
        return $this->proxy()->accessTokens;
    }
}
