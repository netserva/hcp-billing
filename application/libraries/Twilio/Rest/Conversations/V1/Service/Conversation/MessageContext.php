<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Conversations\V1\Service\Conversation;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Conversations\V1\Service\Conversation\Message\DeliveryReceiptList;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;

/**
 * @property DeliveryReceiptList $deliveryReceipts
 *
 * @method \Twilio\Rest\Conversations\V1\Service\Conversation\Message\DeliveryReceiptContext deliveryReceipts(string $sid)
 */
class MessageContext extends InstanceContext
{
    protected $_deliveryReceipts;

    /**
     * Initialize the MessageContext.
     *
     * @param Version $version         Version that contains the resource
     * @param string  $chatServiceSid  the SID of the Conversation Service that the
     *                                 resource is associated with
     * @param string  $conversationSid the unique ID of the Conversation for this
     *                                 message
     * @param string  $sid             a 34 character string that uniquely identifies this
     *                                 resource
     */
    public function __construct(Version $version, $chatServiceSid, $conversationSid, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            'chatServiceSid' => $chatServiceSid,
            'conversationSid' => $conversationSid,
            'sid' => $sid,
        ];

        $this->uri = '/Services/'.\rawurlencode($chatServiceSid).'/Conversations/'.\rawurlencode($conversationSid).'/Messages/'.\rawurlencode($sid).'';
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

        return '[Twilio.Conversations.V1.MessageContext '.\implode(' ', $context).']';
    }

    /**
     * Update the MessageInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return MessageInstance Updated MessageInstance
     */
    public function update(array $options = []): MessageInstance
    {
        $options = new Values($options);

        $data = Values::of([
            'Author' => $options['author'],
            'Body' => $options['body'],
            'DateCreated' => Serialize::iso8601DateTime($options['dateCreated']),
            'DateUpdated' => Serialize::iso8601DateTime($options['dateUpdated']),
            'Attributes' => $options['attributes'],
        ]);
        $headers = Values::of(['X-Twilio-Webhook-Enabled' => $options['xTwilioWebhookEnabled']]);

        $payload = $this->version->update('POST', $this->uri, [], $data, $headers);

        return new MessageInstance(
            $this->version,
            $payload,
            $this->solution['chatServiceSid'],
            $this->solution['conversationSid'],
            $this->solution['sid']
        );
    }

    /**
     * Delete the MessageInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return bool True if delete succeeds, false otherwise
     */
    public function delete(array $options = []): bool
    {
        $options = new Values($options);

        $headers = Values::of(['X-Twilio-Webhook-Enabled' => $options['xTwilioWebhookEnabled']]);

        return $this->version->delete('DELETE', $this->uri, [], [], $headers);
    }

    /**
     * Fetch the MessageInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return MessageInstance Fetched MessageInstance
     */
    public function fetch(): MessageInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);

        return new MessageInstance(
            $this->version,
            $payload,
            $this->solution['chatServiceSid'],
            $this->solution['conversationSid'],
            $this->solution['sid']
        );
    }

    /**
     * Access the deliveryReceipts.
     */
    protected function getDeliveryReceipts(): DeliveryReceiptList
    {
        if (!$this->_deliveryReceipts) {
            $this->_deliveryReceipts = new DeliveryReceiptList(
                $this->version,
                $this->solution['chatServiceSid'],
                $this->solution['conversationSid'],
                $this->solution['sid']
            );
        }

        return $this->_deliveryReceipts;
    }
}
