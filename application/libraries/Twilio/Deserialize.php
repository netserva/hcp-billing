<?php

declare(strict_types=1);

namespace Twilio;

class Deserialize
{
    /**
     * Deserialize a string date into a DateTime object.
     *
     * @param string $s a date or date and time, can be iso8601, rfc2822,
     *                  YYYY-MM-DD format
     *
     * @return \DateTime|string dateTime corresponding to the input string, in UTC time
     */
    public static function dateTime(?string $s)
    {
        try {
            if ($s) {
                return new \DateTime($s, new \DateTimeZone('UTC'));
            }
        } catch (\Exception $e) {
            // no-op
        }

        return $s;
    }
}
