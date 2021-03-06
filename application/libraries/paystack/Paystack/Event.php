<?php

declare(strict_types=1);

namespace Yabacon\Paystack;

use Yabacon\Paystack\Http\Request;

class Event
{
    public const SIGNATURE_KEY = 'HTTP_X_PAYSTACK_SIGNATURE';
    public $raw = '';
    public $obj;
    protected $signature = '';

    protected function __construct()
    {
    }

    public static function capture()
    {
        $evt = new Event();
        $evt->raw = @file_get_contents('php://input');
        $evt->signature = ($_SERVER[self::SIGNATURE_KEY] ?? '');
        $evt->loadObject();

        return $evt;
    }

    public function discoverOwner(array $keys)
    {
        if (!$this->obj || !property_exists($this->obj, 'data')) {
            return;
        }
        foreach ($keys as $index => $key) {
            if ($this->validFor($key)) {
                return $index;
            }
        }
    }

    public function validFor($key)
    {
        if ($this->signature === hash_hmac('sha512', $this->raw, $key)) {
            return true;
        }

        return false;
    }

    public function package(array $additional_headers = [], $method = 'POST')
    {
        $pack = new Request();
        $pack->method = $method;
        $pack->headers = $additional_headers;
        $pack->headers['X-Paystack-Signature'] = $this->signature;
        $pack->headers['Content-Type'] = 'application/json';
        $pack->body = $this->raw;

        return $pack;
    }

    public function forwardTo($url, array $additional_headers = [], $method = 'POST')
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }
        $packed = $this->package($additional_headers, $method);
        $packed->endpoint = $url;

        return $packed->send()->wrapUp();
    }

    protected function loadObject(): void
    {
        $this->obj = json_decode($this->raw);
    }
}
