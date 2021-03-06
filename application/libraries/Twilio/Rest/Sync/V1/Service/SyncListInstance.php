<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Sync\V1\Service;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Sync\V1\Service\SyncList\SyncListItemList;
use Twilio\Rest\Sync\V1\Service\SyncList\SyncListPermissionList;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string    $sid
 * @property string    $uniqueName
 * @property string    $accountSid
 * @property string    $serviceSid
 * @property string    $url
 * @property array     $links
 * @property string    $revision
 * @property \DateTime $dateExpires
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 * @property string    $createdBy
 */
class SyncListInstance extends InstanceResource
{
    protected $_syncListItems;
    protected $_syncListPermissions;

    /**
     * Initialize the SyncListInstance.
     *
     * @param Version $version    Version that contains the resource
     * @param mixed[] $payload    The response payload
     * @param string  $serviceSid The SID of the Sync Service that the resource is
     *                            associated with
     * @param string  $sid        The SID of the Sync List resource to fetch
     */
    public function __construct(Version $version, array $payload, string $serviceSid, string $sid = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'sid' => Values::array_get($payload, 'sid'),
            'uniqueName' => Values::array_get($payload, 'unique_name'),
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'serviceSid' => Values::array_get($payload, 'service_sid'),
            'url' => Values::array_get($payload, 'url'),
            'links' => Values::array_get($payload, 'links'),
            'revision' => Values::array_get($payload, 'revision'),
            'dateExpires' => Deserialize::dateTime(Values::array_get($payload, 'date_expires')),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'createdBy' => Values::array_get($payload, 'created_by'),
        ];

        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid ?: $this->properties['sid']];
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

        return '[Twilio.Sync.V1.SyncListInstance '.\implode(' ', $context).']';
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
        return $this->proxy()->fetch();
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
        return $this->proxy()->delete();
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
        return $this->proxy()->update($options);
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context.
     *
     * @return SyncListContext Context for this SyncListInstance
     */
    protected function proxy(): SyncListContext
    {
        if (!$this->context) {
            $this->context = new SyncListContext(
                $this->version,
                $this->solution['serviceSid'],
                $this->solution['sid']
            );
        }

        return $this->context;
    }

    /**
     * Access the syncListItems.
     */
    protected function getSyncListItems(): SyncListItemList
    {
        return $this->proxy()->syncListItems;
    }

    /**
     * Access the syncListPermissions.
     */
    protected function getSyncListPermissions(): SyncListPermissionList
    {
        return $this->proxy()->syncListPermissions;
    }
}
