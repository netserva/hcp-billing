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
use Twilio\Values;
use Twilio\Version;

/**
 * @property string    $sid
 * @property string    $accountSid
 * @property string    $serviceSid
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 * @property string    $conversionStatus
 * @property string    $channel
 * @property array     $channelData
 * @property string    $url
 */
class VerificationAttemptInstance extends InstanceResource
{
    /**
     * Initialize the VerificationAttemptInstance.
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string  $sid     verification Attempt Sid
     */
    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'sid' => Values::array_get($payload, 'sid'),
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'serviceSid' => Values::array_get($payload, 'service_sid'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'conversionStatus' => Values::array_get($payload, 'conversion_status'),
            'channel' => Values::array_get($payload, 'channel'),
            'channelData' => Values::array_get($payload, 'channel_data'),
            'url' => Values::array_get($payload, 'url'),
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

        return '[Twilio.Verify.V2.VerificationAttemptInstance '.\implode(' ', $context).']';
    }

    /**
     * Fetch the VerificationAttemptInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return VerificationAttemptInstance Fetched VerificationAttemptInstance
     */
    public function fetch(): VerificationAttemptInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context.
     *
     * @return VerificationAttemptContext Context for this
     *                                    VerificationAttemptInstance
     */
    protected function proxy(): VerificationAttemptContext
    {
        if (!$this->context) {
            $this->context = new VerificationAttemptContext($this->version, $this->solution['sid']);
        }

        return $this->context;
    }
}
