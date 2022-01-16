<?php

declare(strict_types=1);

class Twocheckout_Option extends Twocheckout
{
    public static function create($params = [])
    {
        $request = new Twocheckout_Api_Requester();
        $urlSuffix = '/api/products/create_option';
        $result = $request->doCall($urlSuffix, $params);

        return Twocheckout_Util::returnResponse($result);
    }

    public static function retrieve($params = [])
    {
        $request = new Twocheckout_Api_Requester();
        if (array_key_exists('option_id', $params)) {
            $urlSuffix = '/api/products/detail_option';
        } else {
            $urlSuffix = '/api/products/list_options';
        }
        $result = $request->doCall($urlSuffix, $params);

        return Twocheckout_Util::returnResponse($result);
    }

    public static function update($params = [])
    {
        $request = new Twocheckout_Api_Requester();
        $urlSuffix = '/api/products/update_option';
        $result = $request->doCall($urlSuffix, $params);

        return Twocheckout_Util::returnResponse($result);
    }

    public static function delete($params = [])
    {
        $request = new Twocheckout_Api_Requester();
        $urlSuffix = '/api/products/delete_option';
        $result = $request->doCall($urlSuffix, $params);

        return Twocheckout_Util::returnResponse($result);
    }
}
