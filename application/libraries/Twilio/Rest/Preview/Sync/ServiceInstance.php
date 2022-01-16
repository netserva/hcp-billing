<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Preview\Sync;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Preview\Sync\Service\DocumentList;
use Twilio\Rest\Preview\Sync\Service\SyncListList;
use Twilio\Rest\Preview\Sync\Service\SyncMapList;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains preview products that are subject to change. Use them with caution. If you currently do not have developer preview access, please contact help@twilio.com.
 *
 * @property string    $sid
 * @property string    $accountSid
 * @property string    $friendlyName
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 * @property string    $url
 * @property string    $webhookUrl
 * @property bool      $reachabilityWebhooksEnabled
 * @property bool      $aclEnabled
 * @property array     $links
 */
class ServiceInstance extends InstanceResource
{
    protected $_documents;
    protected $_syncLists;
    protected $_syncMaps;

    /**
     * Initialize the ServiceInstance.
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string  $sid     The sid
     */
    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'sid' => Values::array_get($payload, 'sid'),
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'friendlyName' => Values::array_get($payload, 'friendly_name'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'url' => Values::array_get($payload, 'url'),
            'webhookUrl' => Values::array_get($payload, 'webhook_url'),
            'reachabilityWebhooksEnabled' => Values::array_get($payload, 'reachability_webhooks_enabled'),
            'aclEnabled' => Values::array_get($payload, 'acl_enabled'),
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

        return '[Twilio.Preview.Sync.ServiceInstance '.\implode(' ', $context).']';
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
     * Access the documents.
     */
    protected function getDocuments(): DocumentList
    {
        return $this->proxy()->documents;
    }

    /**
     * Access the syncLists.
     */
    protected function getSyncLists(): SyncListList
    {
        return $this->proxy()->syncLists;
    }

    /**
     * Access the syncMaps.
     */
    protected function getSyncMaps(): SyncMapList
    {
        return $this->proxy()->syncMaps;
    }
}
