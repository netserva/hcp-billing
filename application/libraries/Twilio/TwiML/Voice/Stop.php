<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Stop extends TwiML
{
    /**
     * Stop constructor.
     */
    public function __construct()
    {
        parent::__construct('Stop', null);
    }

    /**
     * Add Stream child.
     *
     * @param array $attributes Optional attributes
     *
     * @return Stream child element
     */
    public function stream($attributes = []): Stream
    {
        return $this->nest(new Stream($attributes));
    }

    /**
     * Add Siprec child.
     *
     * @param array $attributes Optional attributes
     *
     * @return Siprec child element
     */
    public function siprec($attributes = []): Siprec
    {
        return $this->nest(new Siprec($attributes));
    }
}
