<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Sync\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Sync\V1\Service\SyncList\SyncListItemList;
use Twilio\Rest\Sync\V1\Service\SyncList\SyncListPermissionList;
use Twilio\Values;
use Twilio\Version;

/**
 * @property SyncListItemList       $syncListItems
 * @property SyncListPermissionList $syncListPermissions
 *
 * @method \Twilio\Rest\Sync\V1\Service\SyncList\SyncListItemContext       syncListItems(int $index)
 * @method \Twilio\Rest\Sync\V1\Service\SyncList\SyncListPermissionContext syncListPermissions(string $identity)
 */
class SyncListContext extends InstanceContext
{
    protected $_syncListItems;
    protected $_syncListPermissions;

    /**
     * Initialize the SyncListContext.
     *
     * @param Version $version    Version that contains the resource
     * @param string  $serviceSid The SID of the Sync Service with the Sync List
     *                            resource to fetch
     * @param string  $sid        The SID of the Sync List resource to fetch
     */
    public function __construct(Version $version, $serviceSid, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid];

        $this->uri = '/Services/'.\rawurlencode($serviceSid).'/Lists/'.\rawurlencode($sid).'';
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

        return '[Twilio.Sync.V1.SyncListContext '.\implode(' ', $context).']';
    }

    /**
     * Fetch the SyncListInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return SyncListInstance Fetched SyncListInstance
     */
    public function fetch(): SyncListInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);

        return new SyncListInstance(
            $this->version,
            $payload,
            $this->solution['serviceSid'],
            $this->solution['sid']
        );
    }

    /**
     * Delete the SyncListInstance.
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
     * Update the SyncListInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return SyncListInstance Updated SyncListInstance
     */
    public function update(array $options = []): SyncListInstance
    {
        $options = new Values($options);

        $data = Values::of(['Ttl' => $options['ttl'], 'CollectionTtl' => $options['collectionTtl']]);

        $payload = $this->version->update('POST', $this->uri, [], $data);

        return new SyncListInstance(
            $this->version,
            $payload,
            $this->solution['serviceSid'],
            $this->solution['sid']
        );
    }

    /**
     * Access the syncListItems.
     */
    protected function getSyncListItems(): SyncListItemList
    {
        if (!$this->_syncListItems) {
            $this->_syncListItems = new SyncListItemList(
                $this->version,
                $this->solution['serviceSid'],
                $this->solution['sid']
            );
        }

        return $this->_syncListItems;
    }

    /**
     * Access the syncListPermissions.
     */
    protected function getSyncListPermissions(): SyncListPermissionList
    {
        if (!$this->_syncListPermissions) {
            $this->_syncListPermissions = new SyncListPermissionList(
                $this->version,
                $this->solution['serviceSid'],
                $this->solution['sid']
            );
        }

        return $this->_syncListPermissions;
    }
}
