<?php

declare(strict_types=1);

namespace Mollie\Api\Exceptions;

class IncompatiblePlatform extends \Mollie\Api\Exceptions\ApiException
{
    public const INCOMPATIBLE_PHP_VERSION = 1000;
    public const INCOMPATIBLE_CURL_EXTENSION = 2000;
    public const INCOMPATIBLE_CURL_FUNCTION = 2500;
    public const INCOMPATIBLE_JSON_EXTENSION = 3000;
}
