<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Preview\DeployedDevices;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Preview\DeployedDevices\Fleet\CertificateList;
use Twilio\Rest\Preview\DeployedDevices\Fleet\DeploymentList;
use Twilio\Rest\Preview\DeployedDevices\Fleet\DeviceList;
use Twilio\Rest\Preview\DeployedDevices\Fleet\KeyList;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains preview products that are subject to change. Use them with caution. If you currently do not have developer preview access, please contact help@twilio.com.
 *
 * @property DeviceList      $devices
 * @property DeploymentList  $deployments
 * @property CertificateList $certificates
 * @property KeyList         $keys
 *
 * @method \Twilio\Rest\Preview\DeployedDevices\Fleet\DeviceContext      devices(string $sid)
 * @method \Twilio\Rest\Preview\DeployedDevices\Fleet\DeploymentContext  deployments(string $sid)
 * @method \Twilio\Rest\Preview\DeployedDevices\Fleet\CertificateContext certificates(string $sid)
 * @method \Twilio\Rest\Preview\DeployedDevices\Fleet\KeyContext         keys(string $sid)
 */
class FleetContext extends InstanceContext
{
    protected $_devices;
    protected $_deployments;
    protected $_certificates;
    protected $_keys;

    /**
     * Initialize the FleetContext.
     *
     * @param Version $version Version that contains the resource
     * @param string  $sid     a string that uniquely identifies the Fleet
     */
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['sid' => $sid];

        $this->uri = '/Fleets/'.\rawurlencode($sid).'';
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

        return '[Twilio.Preview.DeployedDevices.FleetContext '.\implode(' ', $context).']';
    }

    /**
     * Fetch the FleetInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return FleetInstance Fetched FleetInstance
     */
    public function fetch(): FleetInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);

        return new FleetInstance($this->version, $payload, $this->solution['sid']);
    }

    /**
     * Delete the FleetInstance.
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
     * Update the FleetInstance.
     *
     * @param array|Options $options Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return FleetInstance Updated FleetInstance
     */
    public function update(array $options = []): FleetInstance
    {
        $options = new Values($options);

        $data = Values::of([
            'FriendlyName' => $options['friendlyName'],
            'DefaultDeploymentSid' => $options['defaultDeploymentSid'],
        ]);

        $payload = $this->version->update('POST', $this->uri, [], $data);

        return new FleetInstance($this->version, $payload, $this->solution['sid']);
    }

    /**
     * Access the devices.
     */
    protected function getDevices(): DeviceList
    {
        if (!$this->_devices) {
            $this->_devices = new DeviceList($this->version, $this->solution['sid']);
        }

        return $this->_devices;
    }

    /**
     * Access the deployments.
     */
    protected function getDeployments(): DeploymentList
    {
        if (!$this->_deployments) {
            $this->_deployments = new DeploymentList($this->version, $this->solution['sid']);
        }

        return $this->_deployments;
    }

    /**
     * Access the certificates.
     */
    protected function getCertificates(): CertificateList
    {
        if (!$this->_certificates) {
            $this->_certificates = new CertificateList($this->version, $this->solution['sid']);
        }

        return $this->_certificates;
    }

    /**
     * Access the keys.
     */
    protected function getKeys(): KeyList
    {
        if (!$this->_keys) {
            $this->_keys = new KeyList($this->version, $this->solution['sid']);
        }

        return $this->_keys;
    }
}
