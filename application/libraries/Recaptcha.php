<?php

declare(strict_types=1);

/**
 * CodeIgniter NO Captcha ReCAPTCHA a.k.a reCAPTCHA Version 2.0 library.
 *
 * This library is based on official reCAPTCHA library for PHP
 * https://github.com/google/ReCAPTCHA
 */
defined('BASEPATH') or exit('No direct script access allowed');

class ReCaptcha
{
    private $signup_url = 'https://www.google.com/recaptcha/admin';
    private $_siteVerifyUrl = 'https://www.google.com/recaptcha/api/siteverify?';
    private $_secret;
    private $_sitekey;
    private $_lang;
    private $_version = 'php_1.0';

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->config('recaptcha', true);
        if (null == $this->ci->config->item('recaptcha_secretkey', 'recaptcha') || '' == $this->ci->config->item('recaptcha_secretkey', 'recaptcha')) {
            exit("To use reCAPTCHA you must get an API key from <a href='"
                    .$this->signup_url."'>".$this->signup_url.'</a>');
        }
        if (null == $this->ci->config->item('recaptcha_sitekey', 'recaptcha') || '' == $this->ci->config->item('recaptcha_sitekey', 'recaptcha')) {
            exit("To use reCAPTCHA you must get an API key from <a href='"
                    .$this->signup_url."'>".$this->signup_url.'</a>');
        }

        $this->_secret = '' == config_item('recaptcha_secretkey') ? $this->ci->config->item('recaptcha_secretkey', 'recaptcha') : config_item('recaptcha_secretkey');
        $this->_sitekey = '' == config_item('recaptcha_sitekey') ? $this->ci->config->item('recaptcha_sitekey', 'recaptcha') : config_item('recaptcha_sitekey');
        if (null == $this->ci->config->item('lang', 'recaptcha') || '' == $this->ci->config->item('lang', 'recaptcha')) {
            $this->_lang = 'en';
        } else {
            $this->_lang = $this->ci->config->item('lang', 'recaptcha');
        }
    }

    /**
     * Function for rendering reCAPTCHA widget into views
     * Call this function in your view.
     *
     * @return string embedded HTML
     */
    public function render()
    {
        return '<div class="g-recaptcha" data-sitekey="'.$this->_sitekey.'"></div>
            <script src="https://www.google.com/recaptcha/api.js?hl='.$this->_lang.'" async defer></script>';
    }

    /**
     * Function for verifying user's input.
     *
     * @param string $response User's input
     * @param string $remoteIp Remote IP you wish to send to reCAPTCHA, if NULL $this->input->ip_address() will be called
     *
     * @return array Array of response
     */
    public function verifyResponse($response, $remoteIp = null)
    {
        if (null == $response || 0 == strlen($response)) {
            // Empty user's input
            $return = [
                'success' => false,
                'error_codes' => 'missing-input',
            ];
        }

        $getResponse = $this->_submitHttpGet(
            $this->_siteVerifyUrl,
            [
                'secret' => $this->_secret,
                'remoteip' => (!is_null($remoteIp)) ? $remoteIp : $this->ci->input->ip_address(),
                'v' => $this->_version,
                'response' => $response,
            ]
        );
        $answers = json_decode($getResponse, true);

        if (true == trim($answers['success'])) {
            // Right captcha!
            $return = [
                'success' => true,
                'error_codes' => '',
            ];
        } else {
            // Wrong captcha!
            $return = [
                'success' => false,
                'error_codes' => $answers['error-codes'],
            ];
        }

        return $return;
    }

    /**
     * Function to convert an array into query string.
     *
     * @param array $data Array of params
     *
     * @return string query string of parameters
     */
    private function _encodeQS($data)
    {
        $req = '';
        foreach ($data as $key => $value) {
            $req .= $key.'='.urlencode(stripslashes($value)).'&';
        }

        return substr($req, 0, strlen($req) - 1);
    }

    /**
     * HTTP GET to communicate with reCAPTCHA server.
     *
     * @param string $path URL to GET
     * @param array  $data Array of params
     *
     * @return string JSON response from reCAPTCHA server
     */
    private function _submitHTTPGet($path, $data)
    {
        $req = $this->_encodeQS($data);

        return Applib::curl_get_contents($path.$req);
    }
}
