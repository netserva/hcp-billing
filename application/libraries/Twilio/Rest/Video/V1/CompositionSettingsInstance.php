<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Video\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string $accountSid
 * @property string $friendlyName
 * @property string $awsCredentialsSid
 * @property string $awsS3Url
 * @property bool   $awsStorageEnabled
 * @property string $encryptionKeySid
 * @property bool   $encryptionEnabled
 * @property string $url
 */
class CompositionSettingsInstance extends InstanceResource
{
    /**
     * Initialize the CompositionSettingsInstance.
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     */
    public function __construct(Version $version, array $payload)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'friendlyName' => Values::array_get($payload, 'friendly_name'),
            'awsCredentialsSid' => Values::array_get($payload, 'aws_credentials_sid'),
            'awsS3Url' => Values::array_get($payload, 'aws_s3_url'),
            'awsStorageEnabled' => Values::array_get($payload, 'aws_storage_enabled'),
            'encryptionKeySid' => Values::array_get($payload, 'encryption_key_sid'),
            'encryptionEnabled' => Values::array_get($payload, 'encryption_enabled'),
            'url' => Values::array_get($payload, 'url'),
        ];

        $this->solution = [];
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

        return '[Twilio.Video.V1.CompositionSettingsInstance '.\implode(' ', $context).']';
    }

    /**
     * Fetch the CompositionSettingsInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return CompositionSettingsInstance Fetched CompositionSettingsInstance
     */
    public function fetch(): CompositionSettingsInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Create the CompositionSettingsInstance.
     *
     * @param string        $friendlyName A descriptive string that you create to describe
     *                                    the resource
     * @param array|Options $options      Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return CompositionSettingsInstance Created CompositionSettingsInstance
     */
    public function create(string $friendlyName, array $options = []): CompositionSettingsInstance
    {
        return $this->proxy()->create($friendlyName, $options);
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context.
     *
     * @return CompositionSettingsContext Context for this
     *                                    CompositionSettingsInstance
     */
    protected function proxy(): CompositionSettingsContext
    {
        if (!$this->context) {
            $this->context = new CompositionSettingsContext($this->version);
        }

        return $this->context;
    }
}
