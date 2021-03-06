<?php

declare(strict_types=1);

namespace Yabacon\Paystack\Exception;

class BadMetaNameException extends PaystackException
{
    public $errors;

    public function __construct($message, array $errors = [])
    {
        parent::__construct($message);
        $this->errors = $errors;
    }
}
