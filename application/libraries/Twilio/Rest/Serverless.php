<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Serverless\V1;

/**
 * @property \Twilio\Rest\Serverless\V1             $v1
 * @property \Twilio\Rest\Serverless\V1\ServiceList $services
 *
 * @method \Twilio\Rest\Serverless\V1\ServiceContext services(string $sid)
 */
class Serverless extends Domain
{
    protected $_v1;

    /**
     * Construct the Serverless Domain.
     *
     * @param Client $client Client to communicate with Twilio
     */
    public function __construct(Client $client)
    {
        parent::__construct($client);

        $this->baseUrl = 'https://serverless.twilio.com';
    }

    /**
     * Magic getter to lazy load version.
     *
     * @param string $name Version to return
     *
     * @throws TwilioException For unknown versions
     *
     * @return \Twilio\Version The requested version
     */
    public function __get(string $name)
    {
        $method = 'get'.\ucfirst($name);
        if (\method_exists($this, $method)) {
            return $this->{$method}();
        }

        throw new TwilioException('Unknown version '.$name);
    }

    /**
     * Magic caller to get resource contexts.
     *
     * @param string $name      Resource to return
     * @param array  $arguments Context parameters
     *
     * @throws TwilioException For unknown resource
     *
     * @return \Twilio\InstanceContext The requested resource context
     */
    public function __call(string $name, array $arguments)
    {
        $method = 'context'.\ucfirst($name);
        if (\method_exists($this, $method)) {
            return \call_user_func_array([$this, $method], $arguments);
        }

        throw new TwilioException('Unknown context '.$name);
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        return '[Twilio.Serverless]';
    }

    /**
     * @return V1 Version v1 of serverless
     */
    protected function getV1(): V1
    {
        if (!$this->_v1) {
            $this->_v1 = new V1($this);
        }

        return $this->_v1;
    }

    protected function getServices(): Serverless\V1\ServiceList
    {
        return $this->v1->services;
    }

    /**
     * @param string $sid The SID of the Service resource to fetch
     */
    protected function contextServices(string $sid): Serverless\V1\ServiceContext
    {
        return $this->v1->services($sid);
    }
}
