<?php

declare(strict_types=1);

namespace Twilio;

class ListResource
{
    protected $version;
    protected $solution = [];
    protected $uri;

    public function __construct(Version $version)
    {
        $this->version = $version;
    }

    public function __toString(): string
    {
        return '[ListResource]';
    }
}
