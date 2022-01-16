<?php

declare(strict_types=1);

class Twocheckout_Message
{
    public static function message($code, $message)
    {
        $response = [];
        $response['response_code'] = $code;
        $response['response_message'] = $message;

        return json_encode($response);
    }
}
