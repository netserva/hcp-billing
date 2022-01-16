<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Serverless\V1\Service\Asset;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains beta products that are subject to change. Use them with caution.
 *
 * @property string    $sid
 * @property string    $accountSid
 * @property string    $serviceSid
 * @property string    $assetSid
 * @property string    $path
 * @property string    $visibility
 * @property \DateTime $dateCreated
 * @property string    $url
 */
class AssetVersionInstance extends InstanceResource
{
    /**
     * Initialize the AssetVersionInstance.
     *
     * @param Version $version    Version that contains the resource
     * @param mixed[] $payload    The response payload
     * @param string  $serviceSid The SID of the Service that the Asset Version
     *                            resource is associated with
     * @param string  $assetSid   The SID of the Asset resource that is the parent of
     *                            the Asset Version
     * @param string  $sid        The SID that identifies the Asset Version resource to
     *                            fetch
     */
    public function __construct(Version $version, array $payload, string $serviceSid, string $assetSid, string $sid = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'sid' => Values::array_get($payload, 'sid'),
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'serviceSid' => Values::array_get($payload, 'service_sid'),
            'assetSid' => Values::array_get($payload, 'asset_sid'),
            'path' => Values::array_get($payload, 'path'),
            'visibility' => Values::array_get($payload, 'visibility'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'url' => Values::array_get($payload, 'url'),
        ];

        $this->solution = [
            'serviceSid' => $serviceSid,
            'assetSid' => $assetSid,
            'sid' => $sid ?: $this->properties['sid'],
        ];
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

        return '[Twilio.Serverless.V1.AssetVersionInstance '.\implode(' ', $context).']';
    }

    /**
     * Fetch the AssetVersionInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return AssetVersionInstance Fetched AssetVersionInstance
     */
    public function fetch(): AssetVersionInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context.
     *
     * @return AssetVersionContext Context for this AssetVersionInstance
     */
    protected function proxy(): AssetVersionContext
    {
        if (!$this->context) {
            $this->context = new AssetVersionContext(
                $this->version,
                $this->solution['serviceSid'],
                $this->solution['assetSid'],
                $this->solution['sid']
            );
        }

        return $this->context;
    }
}
