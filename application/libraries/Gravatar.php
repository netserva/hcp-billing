<?php

declare(strict_types=1);
defined('BASEPATH') or exit('No direct script access allowed.');

/*
 * Gravatar Library for CodeIgniter
 *
 * @author Ivan Tcholakov <ivantcholakov@gmail.com>, 2015
 * @author Ryan Marshall <ryan@irealms.co.uk>, 2011 - 2015, @link http://irealms.co.uk
 *
 * Code repository: @link https://github.com/ivantcholakov/Codeigniter-Gravatar
 *
 * @version 1.0.1
 *
 * @license The MIT License (MIT)
 * @link http://opensource.org/licenses/MIT
 */

// Gravatar pofile error results.
defined('GRAVATAR_NO_ERROR') or define('GRAVATAR_NO_ERROR', 0);
defined('GRAVATAR_CANT_CONNECT') or define('GRAVATAR_CANT_CONNECT', 1);
defined('GRAVATAR_INVALID_EMAIL') or define('GRAVATAR_INVALID_EMAIL', 2);
defined('GRAVATAR_PROFILE_DOES_NOT_EXIST') or define('GRAVATAR_PROFILE_DOES_NOT_EXIST', 3);
defined('GRAVATAR_INCORRECT_FORMAT') or define('GRAVATAR_INCORRECT_FORMAT', 4);

class Gravatar
{
    protected $base_url = 'https://www.gravatar.com/';
    protected $secure_base_url = 'https://secure.gravatar.com/';
    protected $image_extension = '.png';
    protected $image_size = 80;
    protected $default_image = '';
    protected $force_default_image = false;
    protected $rating = '';
    protected $useragent = 'PHP Gravatar Library';

    protected $last_error = GRAVATAR_NO_ERROR;

    protected $is_https;
    protected $curl_exists;
    protected $allow_url_fopen;

    public function __construct($config = [])
    {
        if (!is_array($config)) {
            $config = [];
        }

        if (isset($config['gravatar_base_url'])) {
            $this->base_url = (string) $config['gravatar_base_url'];
        }

        if (isset($config['gravatar_secure_base_url'])) {
            $this->secure_base_url = (string) $config['gravatar_secure_base_url'];
        }

        if (isset($config['gravatar_image_extension'])) {
            $this->image_extension = (string) $config['gravatar_image_extension'];
        }

        if (isset($config['gravatar_image_size'])) {
            $image_size = (int) $config['gravatar_image_size'];

            if ($image_size > 0) {
                $this->image_size = $image_size;
            }
        }

        if (isset($config['gravatar_default_image'])) {
            $this->default_image = (string) $config['gravatar_default_image'];
        }

        if (isset($config['gravatar_force_default_image'])) {
            $this->force_default_image = !empty($config['gravatar_force_default_image']);
        }

        if (isset($config['gravatar_rating'])) {
            $this->rating = (string) $config['gravatar_rating'];
        }

        if (isset($config['gravatar_useragent'])) {
            $this->useragent = (string) $config['gravatar_useragent'];
        }

        $this->is_https = $this->is_https();

        $this->curl_exists = function_exists('curl_init');

        $allow_url_fopen = @ini_get('allow_url_fopen');
        $allow_url_fopen = false === $allow_url_fopen || in_array(strtolower($allow_url_fopen), ['on', 'true', '1']);
        $this->allow_url_fopen = $allow_url_fopen;
    }

    /**
     * Creates a URL for requesting a Gravatar image.
     *
     * @see http://en.gravatar.com/site/implement/images/
     *
     * @param string $email               a registered email
     * @param int    $size                the requested size of the avarar in pixels (a square image)
     * @param string $default_image       the fallback image option: '', '404', 'mm', 'identicon', 'monsterid', 'wavatar', 'retro', 'blank'
     * @param bool   $force_default_image enforces the fallback image to be shown
     * @param string $rating              the level of allowed self-rate of the avatar: '', 'g' (default), 'pg', 'r', 'x'
     *
     * @return string Returns the URL of the avatar to be requested.
     *
     * When optional parameters are not set, their default values are taken
     * from the configuration file application/config/gravatar.php
     */
    public function get($email, $size = null, $default_image = null, $force_default_image = null, $rating = null)
    {
        $url = ($this->is_https ? $this->secure_base_url : $this->base_url).'avatar/'.$this->create_hash($email).$this->image_extension;

        $query = [];

        $size = (int) $size;

        if ($size <= 0) {
            $size = $this->image_size;
        }

        if ($size > 0) {
            $query['s'] = $size;
        }

        if (isset($default_image)) {
            $default_image = (string) $default_image;
        } else {
            $default_image = $this->default_image;
        }

        if ('' != $default_image) {
            $query['d'] = $default_image;
        }

        if (isset($force_default_image)) {
            $force_default_image = !empty($force_default_image);
        } else {
            $force_default_image = $this->force_default_image;
        }

        if ($force_default_image) {
            $query['f'] = 'y';
        }

        if (isset($rating)) {
            $rating = (string) $rating;
        } else {
            $rating = $this->rating;
        }

        if ('' != $rating) {
            $query['r'] = $rating;
        }

        if (!empty($query)) {
            $url = $url.'?'.http_build_query($query);
        }

        return $url;
    }

    /**
     * Executes a request for Gravatar profile data and returns it as a multidimensional array.
     *
     * @see https://en.gravatar.com/site/implement/profiles/
     *
     * @param string $email a registered email
     *
     * @return  array/null                  Received profile data
     */
    public function get_profile_data($email)
    {
        $result = $this->execute_profile_request($email, 'php');

        if (GRAVATAR_NO_ERROR != $this->last_error) {
            return null;
        }

        $result = @unserialize($result);

        if (false === $result) {
            $this->last_error = GRAVATAR_INCORRECT_FORMAT;

            return null;
        }

        if (!is_array($result)) {
            $this->last_error = GRAVATAR_PROFILE_DOES_NOT_EXIST;

            return null;
        }

        if (!isset($result['entry']) || !isset($result['entry'][0])) {
            $this->last_error = GRAVATAR_INCORRECT_FORMAT;

            return null;
        }

        return $result['entry'][0];
    }

    /**
     * Executes a request for Gravatar profile data and returns raw received response.
     *
     * @see https://en.gravatar.com/site/implement/profiles/
     *
     * @param string $email  a registered email
     * @param string $format '', 'json', 'xml', 'php', 'vcf', 'qr'
     *
     * @return  string/null             Received profile raw data
     */
    public function execute_profile_request($email, $format = null)
    {
        $this->last_error = GRAVATAR_NO_ERROR;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->last_error = GRAVATAR_INVALID_EMAIL;

            return null;
        }

        $format = trim($format);

        if ('' != $format) {
            $format = '.'.ltrim($format, '.');
        }

        $result = null;

        if ($this->curl_exists) {
            $url = $this->secure_base_url.$this->create_hash($email).$format;

            $ch = curl_init();

            $options = [
                CURLOPT_USERAGENT, $this->useragent,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => [],
                CURLOPT_URL => $url,
                CURLOPT_TIMEOUT => 3,
            ];

            if (!ini_get('safe_mode') && !ini_get('open_basedir')) {
                $options[CURLOPT_FOLLOWLOCATION] = true;
            }

            curl_setopt_array($ch, $options);

            $result = curl_exec($ch);

            $code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);

            @curl_close($ch);

            if (200 != $code) {
                $this->last_error = GRAVATAR_CANT_CONNECT;

                return null;
            }
        } elseif ($this->allow_url_fopen) {
            $url = $this->base_url.$this->create_hash($email).$format;

            $options = [
                'http' => [
                    'method' => 'GET',
                    'useragent' => $this->useragent,
                ],
            ];

            $context = stream_context_create($options);

            $result = @file_get_contents($url, false, $context);
        } else {
            $this->last_error = GRAVATAR_CANT_CONNECT;

            return null;
        }

        if (false === $result) {
            $this->last_error = GRAVATAR_CANT_CONNECT;

            return null;
        }

        return $result;
    }

    /**
     * Returns the error code as a result of the last profile request operation.
     *
     * @return int GRAVATAR_NO_ERROR - the last operation was successfull,
     *             other returned value indicates failure
     */
    public function last_error()
    {
        return $this->last_error;
    }

    /**
     * Creates a hash value from a provided e-mail address.
     *
     * @see https://en.gravatar.com/site/implement/hash/
     *
     * @param string $email a registered email
     *
     * @return  string/null             The hash for accessing the avatar or profile data
     */
    public function create_hash($email)
    {
        return md5(strtolower(trim($email)));
    }

    //--------------------------------------------------------------------------
    // The following original methods are kept here for backward compatibility.
    // Consider them as deprecated.
    //--------------------------------------------------------------------------

    /**
     * Set the email to be used, converting it into an md5 hash as required by gravatar.com.
     *
     * @param string $email
     *
     * @return null|string Email hash or if email didn't validate then return NULL
     *
     * @deprecated
     */
    public function set_email($email)
    {
        $email = trim(strtolower($email));

        if (false === !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return md5($email);
        }

        return null;
    }

    /**
     * get_gravatar_url.
     *
     * @see http://en.gravatar.com/site/implement/images/ for available options
     *
     * @param string $rating        defaults to g
     * @param string $size          defaults to 80
     * @param string $default_image default sets can be found on the above link
     * @param bool   $secure        set to TRUE if a secure url is required
     * @param mixed  $email
     *
     * @return string gratavar url
     *
     * @deprecated
     */
    public function get_gravatar($email, $rating = null, $size = null, $default_image = null, $secure = null)
    {
        $hash = $this->set_email($email);

        if (null === $hash) {
            // $hash has to be set to a value so the gravatar site can return a default image
            $hash = 'invalid_email';
        }

        $query_string = null;
        $options = [];

        if (null !== $rating) {
            $options['r'] = $rating;
        }

        if (null !== $size) {
            $options['s'] = $size;
        }

        if (null !== $default_image) {
            $options['d'] = urlencode($default_image);
        }

        if (count($options) > 0) {
            $query_string = '?'.http_build_query($options);
        }

        if (null !== $secure) {
            $base = $this->secure_base_url;
        } else {
            $base = $this->base_url;
        }

        return $base.'avatar/'.$hash.$query_string;
    }

    /**
     * Grab the full profile data for a given email from gravatar.com in xml format.
     *
     * @param string $email
     * @param string fetch_method defaults to file, 'curl' is the other option
     * @param mixed $fetch_method
     *
     * @return null|object $xml->entry on success, NULL on an error
     *
     * @deprecated
     */
    public function get_profile($email, $fetch_method = 'file')
    {
        $hash = $this->set_email($email);

        if (null === $hash) {
            // A hash value of NULL will return no xml so the method returns NULL
            return null;
        }

        libxml_use_internal_errors(true);

        if ('file' === $fetch_method) {
            if (false == ini_get('allow_url_fopen')) {
                return null;
            }

            $str = file_get_contents($this->base_url.$hash.'.xml');
        }

        if ('curl' === $fetch_method) {
            if (!function_exists('curl_init')) {
                return null;
            }

            $ch = curl_init();
            $options = [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_URL => $this->secure_base_url.$hash.'.xml',
                CURLOPT_TIMEOUT => 3,
            ];
            curl_setopt_array($ch, $options);
            $str = curl_exec($ch);
        }

        $xml = simplexml_load_string($str);

        if (false === $xml) {
            $errors = [];
            foreach (libxml_get_errors() as $error) {
                $errors[] = $error->message.'\n';
            }
            $error_string = implode('\n', $errors);

            throw new Exception('Failed loading XML\n'.$error_string);
        }

        return $xml->entry;
    }

    protected function is_https()
    {
        if (function_exists('is_https')) {
            return is_https();
        }

        if (!empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS'])) {
            return true;
        }
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && 'https' === $_SERVER['HTTP_X_FORWARDED_PROTO']) {
            return true;
        }
        if (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && 'off' !== strtolower($_SERVER['HTTP_FRONT_END_HTTPS'])) {
            return true;
        }

        return false;
    }
}
