<?php

declare(strict_types=1);

namespace Yabacon\Paystack\Contracts;

interface RouteInterface
{
    public const METHOD_KEY = 'method';
    public const ENDPOINT_KEY = 'endpoint';
    public const PARAMS_KEY = 'params';
    public const ARGS_KEY = 'args';
    public const REQUIRED_KEY = 'required';
    public const POST_METHOD = 'post';
    public const PUT_METHOD = 'put';
    public const GET_METHOD = 'get';

    public static function root();
}
