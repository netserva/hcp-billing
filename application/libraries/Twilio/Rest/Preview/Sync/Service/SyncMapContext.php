<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Preview\Sync\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Preview\Sync\Service\SyncMap\SyncMapItemList;
use Twilio\Rest\Preview\Sync\Service\SyncMap\SyncMapPermissionList;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains preview products that are subject to change. Use them with caution. If you currently do not have developer preview access, please contact help@twilio.com.
 *
 * @property SyncMapItemList       $syncMapItems
 * @property SyncMapPermissionList $syncMapPermissions
 *
 * @method \Twilio\Rest\Preview\Sync\Service\SyncMap\SyncMapItemContext       syncMapItems(string $key)
 * @method \Twilio\Rest\Preview\Sync\Service\SyncMap\SyncMapPermissionContext syncMapPermissions(string $identity)
 */
class SyncMapContext extends InstanceContext
{
    protected $_syncMapItems;
    protected $_syncMapPermissions;

    /**
     * Initialize the SyncMapContext.
     *
     * @param Version $version    Version that contains the resource
     * @param string  $serviceSid The service_sid
     * @param string  $sid        The sid
     */
    public function __construct(Version $version, $serviceSid, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid];

        $this->uri = '/Services/'.\rawurlencode($serviceSid).'/Maps/'.\rawurlencode($sid).'';
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

        return '[Twilio.Preview.Sync.SyncMapContext '.\implode(' ', $context).']';
    }

    /**
     * Fetch the SyncMapInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return SyncMapInstance Fetched SyncMapInstance
     */
    public function fetch(): SyncMapInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);

        return new SyncMapInstance(
            $this->version,
            $payload,
            $this->solution['serviceSid'],
            $this->solution['sid']
        );
    }

    /**
     * Delete the SyncMapInstance.
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
     * Access the syncMapItems.
     */
    protected function getSyncMapItems(): SyncMapItemList
    {
        if (!$this->_syncMapItems) {
            $this->_syncMapItems = new SyncMapItemList(
                $this->version,
                $this->solution['serviceSid'],
                $this->solution['sid']
            );
        }

        return $this->_syncMapItems;
    }

    /**
     * Access the syncMapPermissions.
     */
    protected function getSyncMapPermissions(): SyncMapPermissionList
    {
        if (!$this->_syncMapPermissions) {
            $this->_syncMapPermissions = new SyncMapPermissionList(
                $this->version,
                $this->solution['serviceSid'],
                $this->solution['sid']
            );
        }

        return $this->_syncMapPermissions;
    }
}
