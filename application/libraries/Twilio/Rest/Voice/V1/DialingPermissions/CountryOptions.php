<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Voice\V1\DialingPermissions;

use Twilio\Options;
use Twilio\Values;

/**
 * PLEASE NOTE that this class contains preview products that are subject to change. Use them with caution. If you currently do not have developer preview access, please contact help@twilio.com.
 */
abstract class CountryOptions
{
    /**
     * @param string $isoCode                         Filter to retrieve the country permissions by
     *                                                specifying the ISO country code
     * @param string $continent                       Filter to retrieve the country permissions by
     *                                                specifying the continent
     * @param string $countryCode                     Country code filter
     * @param bool   $lowRiskNumbersEnabled           Filter to retrieve the country
     *                                                permissions with dialing to low-risk
     *                                                numbers enabled
     * @param bool   $highRiskSpecialNumbersEnabled   Filter to retrieve the country
     *                                                permissions with dialing to
     *                                                high-risk special service numbers
     *                                                enabled
     * @param bool   $highRiskTollfraudNumbersEnabled Filter to retrieve the country
     *                                                permissions with dialing to
     *                                                high-risk toll fraud numbers
     *                                                enabled
     *
     * @return ReadCountryOptions Options builder
     */
    public static function read(string $isoCode = Values::NONE, string $continent = Values::NONE, string $countryCode = Values::NONE, bool $lowRiskNumbersEnabled = Values::NONE, bool $highRiskSpecialNumbersEnabled = Values::NONE, bool $highRiskTollfraudNumbersEnabled = Values::NONE): ReadCountryOptions
    {
        return new ReadCountryOptions($isoCode, $continent, $countryCode, $lowRiskNumbersEnabled, $highRiskSpecialNumbersEnabled, $highRiskTollfraudNumbersEnabled);
    }
}

class ReadCountryOptions extends Options
{
    /**
     * @param string $isoCode                         Filter to retrieve the country permissions by
     *                                                specifying the ISO country code
     * @param string $continent                       Filter to retrieve the country permissions by
     *                                                specifying the continent
     * @param string $countryCode                     Country code filter
     * @param bool   $lowRiskNumbersEnabled           Filter to retrieve the country
     *                                                permissions with dialing to low-risk
     *                                                numbers enabled
     * @param bool   $highRiskSpecialNumbersEnabled   Filter to retrieve the country
     *                                                permissions with dialing to
     *                                                high-risk special service numbers
     *                                                enabled
     * @param bool   $highRiskTollfraudNumbersEnabled Filter to retrieve the country
     *                                                permissions with dialing to
     *                                                high-risk toll fraud numbers
     *                                                enabled
     */
    public function __construct(string $isoCode = Values::NONE, string $continent = Values::NONE, string $countryCode = Values::NONE, bool $lowRiskNumbersEnabled = Values::NONE, bool $highRiskSpecialNumbersEnabled = Values::NONE, bool $highRiskTollfraudNumbersEnabled = Values::NONE)
    {
        $this->options['isoCode'] = $isoCode;
        $this->options['continent'] = $continent;
        $this->options['countryCode'] = $countryCode;
        $this->options['lowRiskNumbersEnabled'] = $lowRiskNumbersEnabled;
        $this->options['highRiskSpecialNumbersEnabled'] = $highRiskSpecialNumbersEnabled;
        $this->options['highRiskTollfraudNumbersEnabled'] = $highRiskTollfraudNumbersEnabled;
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $options = \http_build_query(Values::of($this->options), '', ' ');

        return '[Twilio.Voice.V1.ReadCountryOptions '.$options.']';
    }

    /**
     * Filter to retrieve the country permissions by specifying the [ISO country code](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2).
     *
     * @param string $isoCode Filter to retrieve the country permissions by
     *                        specifying the ISO country code
     *
     * @return $this Fluent Builder
     */
    public function setIsoCode(string $isoCode): self
    {
        $this->options['isoCode'] = $isoCode;

        return $this;
    }

    /**
     * Filter to retrieve the country permissions by specifying the continent.
     *
     * @param string $continent Filter to retrieve the country permissions by
     *                          specifying the continent
     *
     * @return $this Fluent Builder
     */
    public function setContinent(string $continent): self
    {
        $this->options['continent'] = $continent;

        return $this;
    }

    /**
     * Filter the results by specified [country codes](https://www.itu.int/itudoc/itu-t/ob-lists/icc/e164_763.html).
     *
     * @param string $countryCode Country code filter
     *
     * @return $this Fluent Builder
     */
    public function setCountryCode(string $countryCode): self
    {
        $this->options['countryCode'] = $countryCode;

        return $this;
    }

    /**
     * Filter to retrieve the country permissions with dialing to low-risk numbers enabled. Can be: `true` or `false`.
     *
     * @param bool $lowRiskNumbersEnabled Filter to retrieve the country
     *                                    permissions with dialing to low-risk
     *                                    numbers enabled
     *
     * @return $this Fluent Builder
     */
    public function setLowRiskNumbersEnabled(bool $lowRiskNumbersEnabled): self
    {
        $this->options['lowRiskNumbersEnabled'] = $lowRiskNumbersEnabled;

        return $this;
    }

    /**
     * Filter to retrieve the country permissions with dialing to high-risk special service numbers enabled. Can be: `true` or `false`.
     *
     * @param bool $highRiskSpecialNumbersEnabled Filter to retrieve the country
     *                                            permissions with dialing to
     *                                            high-risk special service numbers
     *                                            enabled
     *
     * @return $this Fluent Builder
     */
    public function setHighRiskSpecialNumbersEnabled(bool $highRiskSpecialNumbersEnabled): self
    {
        $this->options['highRiskSpecialNumbersEnabled'] = $highRiskSpecialNumbersEnabled;

        return $this;
    }

    /**
     * Filter to retrieve the country permissions with dialing to high-risk [toll fraud](https://www.twilio.com/learn/voice-and-video/toll-fraud) numbers enabled. Can be: `true` or `false`.
     *
     * @param bool $highRiskTollfraudNumbersEnabled Filter to retrieve the country
     *                                              permissions with dialing to
     *                                              high-risk toll fraud numbers
     *                                              enabled
     *
     * @return $this Fluent Builder
     */
    public function setHighRiskTollfraudNumbersEnabled(bool $highRiskTollfraudNumbersEnabled): self
    {
        $this->options['highRiskTollfraudNumbersEnabled'] = $highRiskTollfraudNumbersEnabled;

        return $this;
    }
}
