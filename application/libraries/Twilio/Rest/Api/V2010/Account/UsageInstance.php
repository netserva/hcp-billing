<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Version;

class UsageInstance extends InstanceResource
{
    /**
     * Initialize the UsageInstance.
     *
     * @param Version $version    Version that contains the resource
     * @param mixed[] $payload    The response payload
     * @param string  $accountSid a 34 character string that uniquely identifies
     *                            this resource
     */
    public function __construct(Version $version, array $payload, string $accountSid)
    {
        parent::__construct($version);

        $this->solution = ['accountSid' => $accountSid];
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
        return '[Twilio.Api.V2010.UsageInstance]';
    }
}
