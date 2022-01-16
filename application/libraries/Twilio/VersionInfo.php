<?php

declare(strict_types=1);

namespace Twilio;

class VersionInfo
{
    public const MAJOR = 6;
    public const MINOR = 27;
    public const PATCH = 1;

    public static function string()
    {
        return implode('.', [self::MAJOR, self::MINOR, self::PATCH]);
    }
}
