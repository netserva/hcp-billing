<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Api\V2010\Account\Recording;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Api\V2010\Account\Recording\AddOnResult\PayloadList;
use Twilio\Version;

/**
 * @property PayloadList $payloads
 *
 * @method \Twilio\Rest\Api\V2010\Account\Recording\AddOnResult\PayloadContext payloads(string $sid)
 */
class AddOnResultContext extends InstanceContext
{
    protected $_payloads;

    /**
     * Initialize the AddOnResultContext.
     *
     * @param Version $version      Version that contains the resource
     * @param string  $accountSid   The SID of the Account that created the resource
     *                              to fetch
     * @param string  $referenceSid The SID of the recording to which the result to
     *                              fetch belongs
     * @param string  $sid          The unique string that identifies the resource to fetch
     */
    public function __construct(Version $version, $accountSid, $referenceSid, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['accountSid' => $accountSid, 'referenceSid' => $referenceSid, 'sid' => $sid];

        $this->uri = '/Accounts/'.\rawurlencode($accountSid).'/Recordings/'.\rawurlencode($referenceSid).'/AddOnResults/'.\rawurlencode($sid).'.json';
    }

    /**
     * Magic getter to lazy load subresources.
     *
     * @param string $name Subresource to return
     *
     * @throws TwilioException For unknown subresources
     *
     * @return ListResource The requested subresource
     */
    public function __get(string $name): ListResource
    {
        if (\property_exists($this, '_'.$name)) {
            $method = 'get'.\ucfirst($name);

            return $this->{$method}();
        }

        throw new TwilioException('Unknown subresource '.$name);
    }

    /**
     * Magic caller to get resource contexts.
     *
     * @param string $name      Resource to return
     * @param array  $arguments Context parameters
     *
     * @throws TwilioException For unknown resource
     *
     * @return InstanceContext The requested resource context
     */
    public function __call(string $name, array $arguments): InstanceContext
    {
        $property = $this->{$name};
        if (\method_exists($property, 'getContext')) {
            return \call_user_func_array([$property, 'getContext'], $arguments);
        }

        throw new TwilioException('Resource does not have a context');
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

        return '[Twilio.Api.V2010.AddOnResultContext '.\implode(' ', $context).']';
    }

    /**
     * Fetch the AddOnResultInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return AddOnResultInstance Fetched AddOnResultInstance
     */
    public function fetch(): AddOnResultInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);

        return new AddOnResultInstance(
            $this->version,
            $payload,
            $this->solution['accountSid'],
            $this->solution['referenceSid'],
            $this->solution['sid']
        );
    }

    /**
     * Delete the AddOnResultInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return bool True if delete succeeds, false otherwise
     */
    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    /**
     * Access the payloads.
     */
    protected function getPayloads(): PayloadList
    {
        if (!$this->_payloads) {
            $this->_payloads = new PayloadList(
                $this->version,
                $this->solution['accountSid'],
                $this->solution['referenceSid'],
                $this->solution['sid']
            );
        }

        return $this->_payloads;
    }
}
