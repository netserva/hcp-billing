<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Fax;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Rest\Fax\V1\FaxList;
use Twilio\Version;

/**
 * @property FaxList $faxes
 *
 * @method \Twilio\Rest\Fax\V1\FaxContext faxes(string $sid)
 */
class V1 extends Version
{
    protected $_faxes;

    /**
     * Construct the V1 version of Fax.
     *
     * @param Domain $domain Domain that contains the version
     */
    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
        $this->version = 'v1';
    }

    /**
     * Magic getter to lazy load root resources.
     *
     * @param string $name Resource to return
     *
     * @throws TwilioException For unknown resource
     *
     * @return \Twilio\ListResource The requested resource
     */
    public function __get(string $name)
    {
        $method = 'get'.\ucfirst($name);
        if (\method_exists($this, $method)) {
            return $this->{$method}();
        }

        throw new TwilioException('Unknown resource '.$name);
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
        return '[Twilio.Fax.V1]';
    }

    protected function getFaxes(): FaxList
    {
        if (!$this->_faxes) {
            $this->_faxes = new FaxList($this);
        }

        return $this->_faxes;
    }
}
