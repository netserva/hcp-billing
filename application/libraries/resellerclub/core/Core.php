<?php

declare(strict_types=1);

namespace Resellerclub;

/**
 * Class contains core abstractions.
 */
class Core
{
    /**
     * Create URL parameter string from an array.
     *
     * @param $parameters array Parameter to be made into string as an array
     *
     * @throws \Resellerclub\InvalidUrlArrayException if URL array is invalid
     *
     * @return string URL parameters separated by &
     */
    public function createUrlParameters($parameters)
    {
        $parameterItems = [];
        foreach ($parameters as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $item) {
                    if ($this->isValidUrlParameter($item)) {
                        $parameterItems[] = $key.'='.urlencode($item);
                    }
                }
            } elseif ($this->isValidUrlParameter($value)) {
                $parameterItems[] = $key.'='.urlencode($value);
            } else {
                throw new InvalidUrlArrayException('Invalid URL Array');
            }
        }

        return implode('&', $parameterItems);
    }

    /**
     * Create a URL from the parameters. Used for GET requests.
     *
     * @param $urlFullArray array URL array in full format
     *
     * @return string full request path
     */
    public function createUrl($urlFullArray)
    {
        $requestPath = $this->createRequestPath($urlFullArray);
        $parameterString = $this->createParameterString($urlFullArray);

        return $requestPath.'?'.$parameterString;
    }

    /**
     * Calls the Resellerclub API with the given parameters.
     *
     * @param $method bool METHOD_GET or METHOD_POST
     * @param $section string Section as specified in the resellerclub API
     * @param $apiName string Name of API call to be called
     * @param $urlArray array Parameters to be passed as URL
     * @param null $section2 Some API calls needs additional section. They are nuts.
     *
     * @throws \Resellerclub\ApiConnectionException if connection to API is failed
     *
     * @return array result of the API call
     */
    public function callApi($method, $section, $apiName, $urlArray, $section2 = null)
    {
        $urlFullArray = [
            'head' => [
                'protocol' => 'https',
                'domain' => RESELLER_DOMAIN,
                'section' => $section,
                'section2' => $section2,
                'api-name' => $apiName,
                'format' => 'json',
                'auth-userid' => RESELLER_ID,
                'api-key' => RESELLER_API_KEY,
            ],
            'content' => $urlArray,
        ];
        // Here, we have to check whether the URL is test or production.
        // As production URLs accept only POST requests for things that need
        // modifications. It was a bit tricky to find, but yes, its there...
        $curl = curl_init();
        if (METHOD_GET === $method) {
            $url = $this->createUrl($urlFullArray);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        } else {
            // METHOD_POST
            $requestPath = $this->createRequestPath($urlFullArray);

            curl_setopt($curl, CURLOPT_URL, $requestPath);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            // Set the request as a POST FIELD for curl.
            $parameterString = $this->createParameterString($urlFullArray);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $parameterString);
        }
        $json_result = curl_exec($curl);
        if (curl_errno($curl)) {
            // This means curl can't connect to server
            // It can be because IP is not whitelisted or
            // Connection not available or
            // Curl is not installed or
            // Dinosaurs are extinct.
            throw new ApiConnectionException('Cannot connect to API server.');
        }
        curl_close($curl);

        return json_decode($json_result);
    }

    /**
     * This serves as alias to Validation::validate.
     *
     * @param mixed $type
     * @param mixed $subType
     * @param mixed $parameters
     */
    public function validate($type, $subType, $parameters)
    {
        $validator = new Validation();

        return $validator->validate($type, $subType, $parameters);
    }

    /**
     * Validates a general array.
     *
     * @param $parameters array Array to be validated
     *
     * @return bool TRUE if valid
     */
    public function defaultValidate($parameters)
    {
        return $this->validate('array', 'default', $parameters);
    }

    /**
     * Check if a URL parameter is valid.
     *
     * @param $parameter mixed Parameter to validate
     *
     * @return bool TRUE is parameter is valid, else FALSE
     */
    private function isValidUrlParameter($parameter)
    {
        if (is_string($parameter) || is_int($parameter) || is_bool($parameter)) {
            return true;
        }

        return false;
    }

    /**
     * Create request path, without parameters.
     *
     * @param $urlFullArray array URL array in full format
     *
     * @return string request path without parameters
     */
    private function createRequestPath($urlFullArray)
    {
        $head = $urlFullArray['head'];
        $protocol = $head['protocol'];
        $domain = $head['domain'];
        $section = $head['section'];
        $section2 = $head['section2'];
        $apiName = $head['api-name'];
        $format = $head['format'];

        if (null == $section2) {
            $requestPath = "{$protocol}://{$domain}/api/{$section}/{$apiName}.{$format}";
        } else {
            $requestPath = "{$protocol}://{$domain}/api/{$section}/{$section2}/{$apiName}.{$format}";
        }

        return $requestPath;
    }

    /**
     * Create Parameter string from the URL array.
     *
     * @param $urlFullArray array URL array in full format
     *
     * @throws \Exception
     *
     * @return string the parameter string, separated by &
     */
    private function createParameterString($urlFullArray)
    {
        $head = $urlFullArray['head'];
        $urlArray = $urlFullArray['content'];
        if (isset($head['auth-userid'], $head['api-key'])) {
            $authParameter = [
                'auth-userid' => $head['auth-userid'],
                'api-key' => $head['api-key'],
            ];
            $authParameterString = $this->createUrlParameters($authParameter);
        }
        $parameterString = $this->createUrlParameters($urlArray);
        $parameters = '';
        if (!empty($parameterString)) {
            if (!empty($authParameterString)) {
                $parameters .= $authParameterString.'&';
            }
            $parameters .= $parameterString;
        }

        return $parameters;
    }
}
