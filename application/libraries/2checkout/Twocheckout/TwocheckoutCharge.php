<?php

declare(strict_types=1);

class Twocheckout_Charge extends Twocheckout
{
    public static function form($params, $type = 'Checkout'): void
    {
        echo '<form id="2checkout" action="'.Twocheckout::$baseUrl.'/checkout/purchase" method="post">';

        foreach ($params as $key => $value) {
            echo '<input type="hidden" name="'.htmlspecialchars($key, ENT_QUOTES, 'UTF-8').'" value="'.htmlspecialchars($value, ENT_QUOTES, 'UTF-8').'"/>';
        }
        if ('auto' == $type) {
            echo '<input type="submit" value="Click here if you are not redirected automatically" /></form>';
            echo '<script type="text/javascript">document.getElementById("2checkout").submit();</script>';
        } else {
            echo '<input type="submit" value="'.$type.'" />';
            echo '</form>';
        }
    }

    public static function direct($params, $type = 'Checkout'): void
    {
        echo '<form id="2checkout" action="'.Twocheckout::$baseUrl.'/checkout/purchase" method="post">';

        foreach ($params as $key => $value) {
            echo '<input type="hidden" name="'.$key.'" value="'.$value.'"/>';
        }

        if ('auto' == $type) {
            echo '<input type="submit" value="Click here if the payment form does not open automatically." /></form>';
            echo '<script type="text/javascript">
                    function submitForm() {
                        document.getElementById("tco_lightbox").style.display = "block";
                        document.getElementById("2checkout").submit();
                    }
                    setTimeout("submitForm()", 2000);
                  </script>';
        } else {
            echo '<input type="submit" value="'.$type.'" />';
            echo '</form>';
        }

        echo '<script src="'.Twocheckout::$baseUrl.'/static/checkout/javascript/direct.min.js"></script>';
    }

    public static function link($params)
    {
        return Twocheckout::$baseUrl.'/checkout/purchase?'.http_build_query($params, '', '&amp;');
    }

    public static function redirect($params): void
    {
        $url = Twocheckout::$baseUrl.'/checkout/purchase?'.http_build_query($params, '', '&amp;');
        header("Location: {$url}");
    }

    public static function auth($params = [])
    {
        $params['api'] = 'checkout';
        $request = new Twocheckout_Api_Requester();
        $result = $request->doCall('/checkout/api/1/'.self::$sid.'/rs/authService', $params);

        return Twocheckout_Util::returnResponse($result);
    }
}
