<?php

declare(strict_types=1);

/**
 * Paystack Autoloader
 * For use when library is being used without composer.
 */
$paystack_autoloader = function ($class_name): void {
    if (str_starts_with($class_name, 'Yabacon\Paystack')) {
        $file = dirname(__FILE__).DIRECTORY_SEPARATOR;
        $file .= str_replace(['Yabacon\\', '\\'], ['', DIRECTORY_SEPARATOR], $class_name).'.php';

        include_once $file;
    }
};

spl_autoload_register($paystack_autoloader);

return $paystack_autoloader;
