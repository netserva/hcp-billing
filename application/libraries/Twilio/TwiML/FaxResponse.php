<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\TwiML;

class FaxResponse extends TwiML
{
    /**
     * FaxResponse constructor.
     */
    public function __construct()
    {
        parent::__construct('Response', null);
    }

    /**
     * Add Receive child.
     *
     * @param array $attributes Optional attributes
     *
     * @return Fax\Receive child element
     */
    public function receive($attributes = []): Fax\Receive
    {
        return $this->nest(new Fax\Receive($attributes));
    }
}
