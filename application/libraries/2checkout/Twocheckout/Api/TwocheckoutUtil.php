<?php

declare(strict_types=1);

class Twocheckout_Util extends Twocheckout
{
    public static function returnResponse($contents, $format = null)
    {
        $format = null == $format ? Twocheckout::$format : $format;

        switch ($format) {
            case 'array':
                $response = self::objectToArray($contents);
                self::checkError($response);

                break;

            case 'force_json':
                $response = self::objectToJson($contents);

                break;

            default:
                $response = self::objectToArray($contents);
                self::checkError($response);
                $response = json_encode($contents);
                $response = json_decode($response);
        }

        return $response;
    }

    public static function objectToArray($object)
    {
        $object = json_decode($object, true);
        $array = [];
        foreach ($object as $member => $data) {
            $array[$member] = $data;
        }

        return $array;
    }

    public static function objectToJson($object)
    {
        return json_encode($object);
    }

    public static function getRecurringLineitems($saleDetail)
    {
        $i = 0;
        $invoiceData = [];

        while (isset($saleDetail['sale']['invoices'][$i])) {
            $invoiceData[$i] = $saleDetail['sale']['invoices'][$i];
            ++$i;
        }

        $invoice = max($invoiceData);
        $i = 0;
        $lineitemData = [];

        while (isset($invoice['lineitems'][$i])) {
            if ('active' == $invoice['lineitems'][$i]['billing']['recurring_status']) {
                $lineitemData[] = $invoice['lineitems'][$i]['billing']['lineitem_id'];
            }
            ++$i;
        }

        return $lineitemData;
    }

    public static function checkError($contents): void
    {
        if (isset($contents['errors'])) {
            throw new Twocheckout_Error($contents['errors'][0]['message']);
        }
        if (isset($contents['exception'])) {
            throw new Twocheckout_Error($contents['exception']['errorMsg'], $contents['exception']['errorCode']);
        }
    }
}
