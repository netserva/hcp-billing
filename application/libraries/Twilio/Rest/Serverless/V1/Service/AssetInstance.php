<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Serverless\V1\Service;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Rest\Serverless\V1\Service\Asset\AssetVersionList;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains beta products that are subject to change. Use them with caution.
 *
 * @property string    $sid
 * @property string    $accountSid
 * @property string    $serviceSid
 * @property string    $friendlyName
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 * @property string    $url
 * @property array     $links
 */
class AssetInstance extends InstanceResource
{
    protected $_assetVersions;

    /**
     * Initialize the AssetInstance.
     *
     * @param Version $version    Version that contains the resource
     * @param mixed[] $payload    The response payload
     * @param string  $serviceSid The SID of the Service that the Asset resource is
     *                            associated with
     * @param string  $sid        The SID that identifies the Asset resource to fetch
     */
    public function __construct(Version $version, array $payload, string $serviceSid, string $sid = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'sid' => Values::array_get($payload, 'sid'),
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'serviceSid' => Values::array_get($payload, 'service_sid'),
            'friendlyName' => Values::array_get($payload, 'friendly_name'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'url' => Values::array_get($payload, 'url'),
            'links' => Values::array_get($payload, 'links'),
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

        return '[Twilio.Serverless.V1.AssetInstance '.\implode(' ', $context).']';
    }

    /**
     * Fetch the AssetInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return AssetInstance Fetched AssetInstance
     */
    public function fetch(): AssetInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Delete the AssetInstance.
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
     * Update the AssetInstance.
     *
     * @param string $friendlyName A string to describe the Asset resource
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return AssetInstance Updated AssetInstance
     */
    public function update(string $friendlyName): AssetInstance
    {
        return $this->proxy()->update($friendlyName);
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context.
     *
     * @return AssetContext Context for this AssetInstance
     */
    protected function proxy(): AssetContext
    {
        if (!$this->context) {
            $this->context = new AssetContext(
                $this->version,
                $this->solution['serviceSid'],
                $this->solution['sid']
            );
        }

        return $this->context;
    }

    /**
     * Access the assetVersions.
     */
    protected function getAssetVersions(): AssetVersionList
    {
        return $this->proxy()->assetVersions;
    }
}
