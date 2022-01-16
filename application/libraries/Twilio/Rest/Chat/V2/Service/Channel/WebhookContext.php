<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Chat\V2\Service\Channel;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;

class WebhookContext extends InstanceContext
{
    /**
     * Initialize the WebhookContext.
     *
     * @param Version $version    Version that contains the resource
     * @param string  $serviceSid The SID of the Service with the Channel to fetch
     *                            the Webhook resource from
     * @param string  $channelSid The SID of the Channel the resource to fetch
     *                            belongs to
     * @param string  $sid        The SID of the Channel Webhook resource to fetch
     */
    public function __construct(Version $version, $serviceSid, $channelSid, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['serviceSid' => $serviceSid, 'channelSid' => $channelSid, 'sid' => $sid];

        $this->uri = '/Services/'.\rawurlencode($serviceSid).'/Channels/'.\rawurlencode($channelSid).'/Webhooks/'.\rawurlencode($sid).'';
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

        return '[Twilio.Chat.V2.WebhookContext '.\implode(' ', $context).']';
    }

    /**
     * Fetch the WebhookInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return WebhookInstance Fetched WebhookInstance
     */
    public function fetch(): WebhookInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);

        return new WebhookInstance(
            $this->version,
            $payload,
            $this->solution['serviceSid'],
            $this->solution['channelSid'],
            $this->solution['sid']
        );
    }

    /**
     * Update the WebhookInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return WebhookInstance Updated WebhookInstance
     */
    public function update(array $options = []): WebhookInstance
    {
        $options = new Values($options);

        $data = Values::of([
            'Configuration.Url' => $options['configurationUrl'],
            'Configuration.Method' => $options['configurationMethod'],
            'Configuration.Filters' => Serialize::map($options['configurationFilters'], fn ($e) => $e),
            'Configuration.Triggers' => Serialize::map($options['configurationTriggers'], fn ($e) => $e),
            'Configuration.FlowSid' => $options['configurationFlowSid'],
            'Configuration.RetryCount' => $options['configurationRetryCount'],
        ]);

        $payload = $this->version->update('POST', $this->uri, [], $data);

        return new WebhookInstance(
            $this->version,
            $payload,
            $this->solution['serviceSid'],
            $this->solution['channelSid'],
            $this->solution['sid']
        );
    }

    /**
     * Delete the WebhookInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return bool True if delete succeeds, false otherwise
     */
    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }
}
