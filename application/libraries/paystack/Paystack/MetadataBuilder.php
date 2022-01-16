<?php

declare(strict_types=1);

namespace Yabacon\Paystack;

use Yabacon\Paystack\Exception\BadMetaNameException;

class MetadataBuilder
{
    public static $auto_snake_case = true;
    private $meta;

    public function __construct()
    {
        $this->meta = [];
    }

    public function __call($method, $args)
    {
        if ((str_starts_with($method, 'with')) && ('with' !== $method)) {
            $name = substr($method, 4);
            if (MetadataBuilder::$auto_snake_case) {
                $name = $this->toSnakeCase($name);
            }

            return $this->with($name, $args[0]);
        }

        throw new \BadMethodCallException('Call to undefined function: '.get_class($this).'::'.$method);
    }

    public function withCustomField($title, $value)
    {
        if (!array_key_exists('custom_fields', $this->meta)) {
            $this->meta['custom_fields'] = [];
        }
        $this->meta['custom_fields'][] = [
            'display_name' => strval($title),
            'variable_name' => strval($title),
            'value' => strval($value),
        ];

        return $this;
    }

    public function build()
    {
        return json_encode($this->meta);
    }

    private function with($name, $value)
    {
        if ('custom_fields' === $name) {
            throw new BadMetaNameException('Please use the withCustomField method to add custom fields');
        }
        $this->meta[$name] = $value;

        return $this;
    }

    private function toSnakeCase($input)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }

        return implode('_', $ret);
    }
}
