<?php

declare(strict_types=1);

namespace Yabacon;

use Yabacon\Paystack\Helpers\Router;

class Paystack
{
    public const VERSION = '2.1.19';
    public $secret_key;
    public $use_guzzle = false;
    public static $fallback_to_file_get_contents = true;

    public function __construct($secret_key)
    {
        if (!is_string($secret_key) || !('sk_' === substr($secret_key, 0, 3))) {
            throw new \InvalidArgumentException('A Valid Paystack Secret Key must start with \'sk_\'.');
        }
        $this->secret_key = $secret_key;
    }

    public function __call($method, $args)
    {
        if ($singular_form = Router::singularFor($method)) {
            return $this->handlePlural($singular_form, $method, $args);
        }

        return $this->handleSingular($method, $args);
    }

    public function __get($name)
    {
        return new Router($name, $this);
    }

    public function useGuzzle(): void
    {
        $this->use_guzzle = true;
    }

    public static function disableFileGetContentsFallback(): void
    {
        Paystack::$fallback_to_file_get_contents = false;
    }

    public static function enableFileGetContentsFallback(): void
    {
        Paystack::$fallback_to_file_get_contents = true;
    }

    /**
     * @deprecated
     */
    public static function registerAutoloader(): void
    {
        trigger_error('Include "src/autoload.php" instead', E_DEPRECATED | E_USER_NOTICE);

        require_once __DIR__.'/../src/autoload.php';
    }

    private function handlePlural($singular_form, $method, $args)
    {
        if ((1 === count($args) && is_array($args[0])) || (0 === count($args))) {
            return $this->{$singular_form}->__call('getList', $args);
        }

        throw new \InvalidArgumentException(
            'Route "'.$method.'" can only accept an optional array of filters and '
            .'paging arguments (perPage, page).'
        );
    }

    private function handleSingular($method, $args)
    {
        if (1 === count($args)) {
            $args = [[], [Router::ID_KEY => $args[0]]];

            return $this->{$method}->__call('fetch', $args);
        }

        throw new \InvalidArgumentException(
            'Route "'.$method.'" can only accept an id or code.'
        );
    }
}
