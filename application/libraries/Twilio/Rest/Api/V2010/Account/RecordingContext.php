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
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Api\V2010\Account\Recording\AddOnResultList;
use Twilio\Rest\Api\V2010\Account\Recording\TranscriptionList;
use Twilio\Version;

/**
 * @property TranscriptionList $transcriptions
 * @property AddOnResultList   $addOnResults
 *
 * @method \Twilio\Rest\Api\V2010\Account\Recording\TranscriptionContext transcriptions(string $sid)
 * @method \Twilio\Rest\Api\V2010\Account\Recording\AddOnResultContext   addOnResults(string $sid)
 */
class RecordingContext extends InstanceContext
{
    protected $_transcriptions;
    protected $_addOnResults;

    /**
     * Initialize the RecordingContext.
     *
     * @param Version $version    Version that contains the resource
     * @param string  $accountSid The SID of the Account that created the resource
     *                            to fetch
     * @param string  $sid        The unique string that identifies the resource
     */
    public function __construct(Version $version, $accountSid, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['accountSid' => $accountSid, 'sid' => $sid];

        $this->uri = '/Accounts/'.\rawurlencode($accountSid).'/Recordings/'.\rawurlencode($sid).'.json';
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

        return '[Twilio.Api.V2010.RecordingContext '.\implode(' ', $context).']';
    }

    /**
     * Fetch the RecordingInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return RecordingInstance Fetched RecordingInstance
     */
    public function fetch(): RecordingInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);

        return new RecordingInstance(
            $this->version,
            $payload,
            $this->solution['accountSid'],
            $this->solution['sid']
        );
    }

    /**
     * Delete the RecordingInstance.
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
     * Access the transcriptions.
     */
    protected function getTranscriptions(): TranscriptionList
    {
        if (!$this->_transcriptions) {
            $this->_transcriptions = new TranscriptionList(
                $this->version,
                $this->solution['accountSid'],
                $this->solution['sid']
            );
        }

        return $this->_transcriptions;
    }

    /**
     * Access the addOnResults.
     */
    protected function getAddOnResults(): AddOnResultList
    {
        if (!$this->_addOnResults) {
            $this->_addOnResults = new AddOnResultList(
                $this->version,
                $this->solution['accountSid'],
                $this->solution['sid']
            );
        }

        return $this->_addOnResults;
    }
}
