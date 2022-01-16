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

class SsmlProsody extends TwiML
{
    /**
     * SsmlProsody constructor.
     *
     * @param string $words      Words to speak
     * @param array  $attributes Optional attributes
     */
    public function __construct($words, $attributes = [])
    {
        parent::__construct('prosody', $words, $attributes);
    }

    /**
     * Add Volume attribute.
     *
     * @param string $volume Specify the volume, available values: default, silent,
     *                       x-soft, soft, medium, loud, x-loud, +ndB, -ndB
     */
    public function setVolume($volume): self
    {
        return $this->setAttribute('volume', $volume);
    }

    /**
     * Add Rate attribute.
     *
     * @param string $rate Specify the rate, available values: x-slow, slow,
     *                     medium, fast, x-fast, n%
     */
    public function setRate($rate): self
    {
        return $this->setAttribute('rate', $rate);
    }

    /**
     * Add Pitch attribute.
     *
     * @param string $pitch Specify the pitch, available values: default, x-low,
     *                      low, medium, high, x-high, +n%, -n%
     */
    public function setPitch($pitch): self
    {
        return $this->setAttribute('pitch', $pitch);
    }
}
