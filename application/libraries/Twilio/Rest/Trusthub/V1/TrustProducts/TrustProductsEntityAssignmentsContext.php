<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Trusthub\V1\TrustProducts;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Version;

class TrustProductsEntityAssignmentsContext extends InstanceContext
{
    /**
     * Initialize the TrustProductsEntityAssignmentsContext.
     *
     * @param Version $version         Version that contains the resource
     * @param string  $trustProductSid the unique string that identifies the
     *                                 resource
     * @param string  $sid             The unique string that identifies the resource
     */
    public function __construct(Version $version, $trustProductSid, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['trustProductSid' => $trustProductSid, 'sid' => $sid];

        $this->uri = '/TrustProducts/'.\rawurlencode($trustProductSid).'/EntityAssignments/'.\rawurlencode($sid).'';
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

        return '[Twilio.Trusthub.V1.TrustProductsEntityAssignmentsContext '.\implode(' ', $context).']';
    }

    /**
     * Fetch the TrustProductsEntityAssignmentsInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return TrustProductsEntityAssignmentsInstance Fetched
     *                                                TrustProductsEntityAssignmentsInstance
     */
    public function fetch(): TrustProductsEntityAssignmentsInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);

        return new TrustProductsEntityAssignmentsInstance(
            $this->version,
            $payload,
            $this->solution['trustProductSid'],
            $this->solution['sid']
        );
    }

    /**
     * Delete the TrustProductsEntityAssignmentsInstance.
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return bool True if delete succeeds, false otherwise
     */
    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }
}
