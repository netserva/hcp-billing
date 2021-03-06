<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Sync\V1\Service\Document;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string $accountSid
 * @property string $serviceSid
 * @property string $documentSid
 * @property string $identity
 * @property bool   $read
 * @property bool   $write
 * @property bool   $manage
 * @property string $url
 */
class DocumentPermissionInstance extends InstanceResource
{
    /**
     * Initialize the DocumentPermissionInstance.
     *
     * @param Version $version     Version that contains the resource
     * @param mixed[] $payload     The response payload
     * @param string  $serviceSid  The SID of the Sync Service that the resource is
     *                             associated with
     * @param string  $documentSid The Sync Document SID
     * @param string  $identity    The application-defined string that uniquely
     *                             identifies the User's Document Permission resource
     *                             to fetch
     */
    public function __construct(Version $version, array $payload, string $serviceSid, string $documentSid, string $identity = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'serviceSid' => Values::array_get($payload, 'service_sid'),
            'documentSid' => Values::array_get($payload, 'document_sid'),
            'identity' => Values::array_get($payload, 'identity'),
            'read' => Values::array_get($payload, 'read'),
            'write' => Values::array_get($payload, 'write'),
            'manage' => Values::array_get($payload, 'manage'),
            'url' => Values::array_get($payload, 'url'),
        ];

        $this->solution = [
            'serviceSid' => $serviceSid,
            'documentSid' => $documentSid,
            'identity' => $identity ?: $this->properties['identity'],
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

        return '[Twilio.Sync.V1.DocumentPermissionInstance '.\implode(' ', $context).']';
    }

    /**
     * Fetch the DocumentPermissionInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return DocumentPermissionInstance Fetched DocumentPermissionInstance
     */
    public function fetch(): DocumentPermissionInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Delete the DocumentPermissionInstance.
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
     * Update the DocumentPermissionInstance.
     *
     * @param bool $read   Read access
     * @param bool $write  Write access
     * @param bool $manage Manage access
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return DocumentPermissionInstance Updated DocumentPermissionInstance
     */
    public function update(bool $read, bool $write, bool $manage): DocumentPermissionInstance
    {
        return $this->proxy()->update($read, $write, $manage);
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context.
     *
     * @return DocumentPermissionContext Context for this DocumentPermissionInstance
     */
    protected function proxy(): DocumentPermissionContext
    {
        if (!$this->context) {
            $this->context = new DocumentPermissionContext(
                $this->version,
                $this->solution['serviceSid'],
                $this->solution['documentSid'],
                $this->solution['identity']
            );
        }

        return $this->context;
    }
}
