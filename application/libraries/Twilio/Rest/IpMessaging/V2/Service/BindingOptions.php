<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\IpMessaging\V2\Service;

use Twilio\Options;
use Twilio\Values;

abstract class BindingOptions
{
    /**
     * @param string[] $bindingType The binding_type
     * @param string[] $identity    The identity
     *
     * @return ReadBindingOptions Options builder
     */
    public static function read(array $bindingType = Values::ARRAY_NONE, array $identity = Values::ARRAY_NONE): ReadBindingOptions
    {
        return new ReadBindingOptions($bindingType, $identity);
    }
}

class ReadBindingOptions extends Options
{
    /**
     * @param string[] $bindingType The binding_type
     * @param string[] $identity    The identity
     */
    public function __construct(array $bindingType = Values::ARRAY_NONE, array $identity = Values::ARRAY_NONE)
    {
        $this->options['bindingType'] = $bindingType;
        $this->options['identity'] = $identity;
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $options = \http_build_query(Values::of($this->options), '', ' ');

        return '[Twilio.IpMessaging.V2.ReadBindingOptions '.$options.']';
    }

    /**
     * The binding_type.
     *
     * @param string[] $bindingType The binding_type
     *
     * @return $this Fluent Builder
     */
    public function setBindingType(array $bindingType): self
    {
        $this->options['bindingType'] = $bindingType;

        return $this;
    }

    /**
     * The identity.
     *
     * @param string[] $identity The identity
     *
     * @return $this Fluent Builder
     */
    public function setIdentity(array $identity): self
    {
        $this->options['identity'] = $identity;

        return $this;
    }
}
