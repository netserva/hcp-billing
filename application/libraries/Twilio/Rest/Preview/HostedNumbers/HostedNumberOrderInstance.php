<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Preview\HostedNumbers;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains preview products that are subject to change. Use them with caution. If you currently do not have developer preview access, please contact help@twilio.com.
 *
 * @property string    $sid
 * @property string    $accountSid
 * @property string    $incomingPhoneNumberSid
 * @property string    $addressSid
 * @property string    $signingDocumentSid
 * @property string    $phoneNumber
 * @property string    $capabilities
 * @property string    $friendlyName
 * @property string    $uniqueName
 * @property string    $status
 * @property string    $failureReason
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 * @property int       $verificationAttempts
 * @property string    $email
 * @property string[]  $ccEmails
 * @property string    $url
 * @property string    $verificationType
 * @property string    $verificationDocumentSid
 * @property string    $extension
 * @property int       $callDelay
 * @property string    $verificationCode
 * @property string[]  $verificationCallSids
 */
class HostedNumberOrderInstance extends InstanceResource
{
    /**
     * Initialize the HostedNumberOrderInstance.
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string  $sid     hostedNumberOrder sid
     */
    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'sid' => Values::array_get($payload, 'sid'),
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'incomingPhoneNumberSid' => Values::array_get($payload, 'incoming_phone_number_sid'),
            'addressSid' => Values::array_get($payload, 'address_sid'),
            'signingDocumentSid' => Values::array_get($payload, 'signing_document_sid'),
            'phoneNumber' => Values::array_get($payload, 'phone_number'),
            'capabilities' => Values::array_get($payload, 'capabilities'),
            'friendlyName' => Values::array_get($payload, 'friendly_name'),
            'uniqueName' => Values::array_get($payload, 'unique_name'),
            'status' => Values::array_get($payload, 'status'),
            'failureReason' => Values::array_get($payload, 'failure_reason'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'verificationAttempts' => Values::array_get($payload, 'verification_attempts'),
            'email' => Values::array_get($payload, 'email'),
            'ccEmails' => Values::array_get($payload, 'cc_emails'),
            'url' => Values::array_get($payload, 'url'),
            'verificationType' => Values::array_get($payload, 'verification_type'),
            'verificationDocumentSid' => Values::array_get($payload, 'verification_document_sid'),
            'extension' => Values::array_get($payload, 'extension'),
            'callDelay' => Values::array_get($payload, 'call_delay'),
            'verificationCode' => Values::array_get($payload, 'verification_code'),
            'verificationCallSids' => Values::array_get($payload, 'verification_call_sids'),
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

        return '[Twilio.Preview.HostedNumbers.HostedNumberOrderInstance '.\implode(' ', $context).']';
    }

    /**
     * Fetch the HostedNumberOrderInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return HostedNumberOrderInstance Fetched HostedNumberOrderInstance
     */
    public function fetch(): HostedNumberOrderInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Delete the HostedNumberOrderInstance.
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
     * Update the HostedNumberOrderInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return HostedNumberOrderInstance Updated HostedNumberOrderInstance
     */
    public function update(array $options = []): HostedNumberOrderInstance
    {
        return $this->proxy()->update($options);
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context.
     *
     * @return HostedNumberOrderContext Context for this HostedNumberOrderInstance
     */
    protected function proxy(): HostedNumberOrderContext
    {
        if (!$this->context) {
            $this->context = new HostedNumberOrderContext($this->version, $this->solution['sid']);
        }

        return $this->context;
    }
}
