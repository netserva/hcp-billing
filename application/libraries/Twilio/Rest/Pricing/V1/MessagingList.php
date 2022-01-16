<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Pricing\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Pricing\V1\Messaging\CountryList;
use Twilio\Version;

/**
 * @property CountryList $countries
 *
 * @method \Twilio\Rest\Pricing\V1\Messaging\CountryContext countries(string $isoCountry)
 */
class MessagingList extends ListResource
{
    protected $_countries;

    /**
     * Construct the MessagingList.
     *
     * @param Version $version Version that contains the resource
     */
    public function __construct(Version $version)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [];
    }

    /**
     * Magic getter to lazy load subresources.
     *
     * @param string $name Subresource to return
     *
     * @throws TwilioException For unknown subresources
     *
     * @return \Twilio\ListResource The requested subresource
     */
    public function __get(string $name)
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
        return '[Twilio.Pricing.V1.MessagingList]';
    }

    /**
     * Access the countries.
     */
    protected function getCountries(): CountryList
    {
        if (!$this->_countries) {
            $this->_countries = new CountryList($this->version);
        }

        return $this->_countries;
    }
}
