<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Serverless\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Serverless\V1\Service\Asset\AssetVersionList;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains beta products that are subject to change. Use them with caution.
 *
 * @property AssetVersionList $assetVersions
 *
 * @method \Twilio\Rest\Serverless\V1\Service\Asset\AssetVersionContext assetVersions(string $sid)
 */
class AssetContext extends InstanceContext
{
    protected $_assetVersions;

    /**
     * Initialize the AssetContext.
     *
     * @param Version $version    Version that contains the resource
     * @param string  $serviceSid The SID of the Service to fetch the Asset resource
     *                            from
     * @param string  $sid        The SID that identifies the Asset resource to fetch
     */
    public function __construct(Version $version, $serviceSid, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid];

        $this->uri = '/Services/'.\rawurlencode($serviceSid).'/Assets/'.\rawurlencode($sid).'';
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

        return '[Twilio.Serverless.V1.AssetContext '.\implode(' ', $context).']';
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
        $payload = $this->version->fetch('GET', $this->uri);

        return new AssetInstance(
            $this->version,
            $payload,
            $this->solution['serviceSid'],
            $this->solution['sid']
        );
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
        return $this->version->delete('DELETE', $this->uri);
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
        $data = Values::of(['FriendlyName' => $friendlyName]);

        $payload = $this->version->update('POST', $this->uri, [], $data);

        return new AssetInstance(
            $this->version,
            $payload,
            $this->solution['serviceSid'],
            $this->solution['sid']
        );
    }

    /**
     * Access the assetVersions.
     */
    protected function getAssetVersions(): AssetVersionList
    {
        if (!$this->_assetVersions) {
            $this->_assetVersions = new AssetVersionList(
                $this->version,
                $this->solution['serviceSid'],
                $this->solution['sid']
            );
        }

        return $this->_assetVersions;
    }
}
