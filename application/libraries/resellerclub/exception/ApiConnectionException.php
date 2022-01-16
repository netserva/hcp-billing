<?php

declare(strict_types=1);
/**
 * ApiConnectionException.
 */

namespace Resellerclub;

/**
 * Class ApiConnectionException.
 *
 * Throws when API connection cannot be made.
 * Usual suspects are:
 * # IP not whitelisted.
 * # Internet is not present.
 * # Secure connection cannot be obtained.
 * # API server is down.
 */
class ApiConnectionException extends \Exception
{
}
