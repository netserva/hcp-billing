<?php

declare(strict_types=1);

abstract class Twocheckout
{
    public const VERSION = '0.3.1';
    public static $sid;
    public static $privateKey;
    public static $username;
    public static $password;
    public static $sandbox;
    public static $verifySSL = true;
    public static $baseUrl = 'https://www.2checkout.com';
    public static $error;
    public static $format = 'array';

    public static function sellerId($value = null): void
    {
        self::$sid = $value;
    }

    public static function privateKey($value = null): void
    {
        self::$privateKey = $value;
    }

    public static function username($value = null): void
    {
        self::$username = $value;
    }

    public static function password($value = null): void
    {
        self::$password = $value;
    }

    public static function sandbox($value = null): void
    {
        if (1 == $value || true == $value) {
            self::$sandbox = true;
            self::$baseUrl = 'https://sandbox.2checkout.com';
        } else {
            self::$sandbox = false;
            self::$baseUrl = 'https://www.2checkout.com';
        }
    }

    public static function verifySSL($value = null): void
    {
        if (0 == $value || false == $value) {
            self::$verifySSL = false;
        } else {
            self::$verifySSL = true;
        }
    }

    public static function format($value = null): void
    {
        self::$format = $value;
    }
}

require dirname(__FILE__).'/Twocheckout/Api/TwocheckoutAccount.php';

require dirname(__FILE__).'/Twocheckout/Api/TwocheckoutPayment.php';

require dirname(__FILE__).'/Twocheckout/Api/TwocheckoutApi.php';

require dirname(__FILE__).'/Twocheckout/Api/TwocheckoutSale.php';

require dirname(__FILE__).'/Twocheckout/Api/TwocheckoutProduct.php';

require dirname(__FILE__).'/Twocheckout/Api/TwocheckoutCoupon.php';

require dirname(__FILE__).'/Twocheckout/Api/TwocheckoutOption.php';

require dirname(__FILE__).'/Twocheckout/Api/TwocheckoutUtil.php';

require dirname(__FILE__).'/Twocheckout/Api/TwocheckoutError.php';

require dirname(__FILE__).'/Twocheckout/TwocheckoutReturn.php';

require dirname(__FILE__).'/Twocheckout/TwocheckoutNotification.php';

require dirname(__FILE__).'/Twocheckout/TwocheckoutCharge.php';

require dirname(__FILE__).'/Twocheckout/TwocheckoutMessage.php';
