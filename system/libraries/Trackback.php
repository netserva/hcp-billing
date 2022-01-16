<?php

declare(strict_types=1);
/**
 * CodeIgniter.
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 *
 * @see	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Trackback Class.
 *
 * Trackback Sending/Receiving Class
 *
 * @category	Trackbacks
 *
 * @author		EllisLab Dev Team
 *
 * @see		https://codeigniter.com/user_guide/libraries/trackback.html
 */
class CI_Trackback
{
    /**
     * Character set.
     *
     * @var string
     */
    public $charset = 'UTF-8';

    /**
     * Trackback data.
     *
     * @var array
     */
    public $data = [
        'url' => '',
        'title' => '',
        'excerpt' => '',
        'blog_name' => '',
        'charset' => '',
    ];

    /**
     * Convert ASCII flag.
     *
     * Whether to convert high-ASCII and MS Word
     * characters to HTML entities.
     *
     * @var bool
     */
    public $convert_ascii = true;

    /**
     * Response.
     *
     * @var string
     */
    public $response = '';

    /**
     * Error messages list.
     *
     * @var string[]
     */
    public $error_msg = [];

    // --------------------------------------------------------------------

    /**
     * Constructor.
     */
    public function __construct()
    {
        log_message('info', 'Trackback Class Initialized');
    }

    // --------------------------------------------------------------------

    /**
     * Send Trackback.
     *
     * @param	array
     * @param mixed $tb_data
     *
     * @return bool
     */
    public function send($tb_data)
    {
        if (!is_array($tb_data)) {
            $this->set_error('The send() method must be passed an array');

            return false;
        }

        // Pre-process the Trackback Data
        foreach (['url', 'title', 'excerpt', 'blog_name', 'ping_url'] as $item) {
            if (!isset($tb_data[$item])) {
                $this->set_error('Required item missing: '.$item);

                return false;
            }

            switch ($item) {
                case 'ping_url':
                    ${$item} = $this->extract_urls($tb_data[$item]);

                    break;

                case 'excerpt':
                    ${$item} = $this->limit_characters($this->convert_xml(strip_tags(stripslashes($tb_data[$item]))));

                    break;

                case 'url':
                    ${$item} = str_replace('&#45;', '-', $this->convert_xml(strip_tags(stripslashes($tb_data[$item]))));

                    break;

                default:
                    ${$item} = $this->convert_xml(strip_tags(stripslashes($tb_data[$item])));

                    break;
            }

            // Convert High ASCII Characters
            if (true === $this->convert_ascii && in_array($item, ['excerpt', 'title', 'blog_name'], true)) {
                ${$item} = $this->convert_ascii(${$item});
            }
        }

        // Build the Trackback data string
        $charset = $tb_data['charset'] ?? $this->charset;

        $data = 'url='.rawurlencode($url).'&title='.rawurlencode($title).'&blog_name='.rawurlencode($blog_name)
            .'&excerpt='.rawurlencode($excerpt).'&charset='.rawurlencode($charset);

        // Send Trackback(s)
        $return = true;
        if (count($ping_url) > 0) {
            foreach ($ping_url as $url) {
                if (false === $this->process($url, $data)) {
                    $return = false;
                }
            }
        }

        return $return;
    }

    // --------------------------------------------------------------------

    /**
     * Receive Trackback  Data.
     *
     * This function simply validates the incoming TB data.
     * It returns FALSE on failure and TRUE on success.
     * If the data is valid it is set to the $this->data array
     * so that it can be inserted into a database.
     *
     * @return bool
     */
    public function receive()
    {
        foreach (['url', 'title', 'blog_name', 'excerpt'] as $val) {
            if (empty($_POST[$val])) {
                $this->set_error('The following required POST variable is missing: '.$val);

                return false;
            }

            $this->data['charset'] = isset($_POST['charset']) ? strtoupper(trim($_POST['charset'])) : 'auto';

            if ('url' !== $val && MB_ENABLED === true) {
                if (MB_ENABLED === true) {
                    $_POST[$val] = mb_convert_encoding($_POST[$val], $this->charset, $this->data['charset']);
                } elseif (ICONV_ENABLED === true) {
                    $_POST[$val] = @iconv($this->data['charset'], $this->charset.'//IGNORE', $_POST[$val]);
                }
            }

            $_POST[$val] = ('url' !== $val) ? $this->convert_xml(strip_tags($_POST[$val])) : strip_tags($_POST[$val]);

            if ('excerpt' === $val) {
                $_POST['excerpt'] = $this->limit_characters($_POST['excerpt']);
            }

            $this->data[$val] = $_POST[$val];
        }

        return true;
    }

    // --------------------------------------------------------------------

    /**
     * Send Trackback Error Message.
     *
     * Allows custom errors to be set. By default it
     * sends the "incomplete information" error, as that's
     * the most common one.
     *
     * @param	string
     * @param mixed $message
     */
    public function send_error($message = 'Incomplete Information'): void
    {
        exit('<?xml version="1.0" encoding="utf-8"?'.">\n<response>\n<error>1</error>\n<message>".$message."</message>\n</response>");
    }

    // --------------------------------------------------------------------

    /**
     * Send Trackback Success Message.
     *
     * This should be called when a trackback has been
     * successfully received and inserted.
     */
    public function send_success(): void
    {
        exit('<?xml version="1.0" encoding="utf-8"?'.">\n<response>\n<error>0</error>\n</response>");
    }

    // --------------------------------------------------------------------

    /**
     * Fetch a particular item.
     *
     * @param	string
     * @param mixed $item
     *
     * @return string
     */
    public function data($item)
    {
        return $this->data[$item] ?? '';
    }

    // --------------------------------------------------------------------

    /**
     * Process Trackback.
     *
     * Opens a socket connection and passes the data to
     * the server. Returns TRUE on success, FALSE on failure
     *
     * @param	string
     * @param	string
     * @param mixed $url
     * @param mixed $data
     *
     * @return bool
     */
    public function process($url, $data)
    {
        $target = parse_url($url);

        // Open the socket
        if (!$fp = @fsockopen($target['host'], 80)) {
            $this->set_error('Invalid Connection: '.$url);

            return false;
        }

        // Build the path
        $path = $target['path'] ?? $url;
        empty($target['query']) or $path .= '?'.$target['query'];

        // Add the Trackback ID to the data string
        if ($id = $this->get_id($url)) {
            $data = 'tb_id='.$id.'&'.$data;
        }

        // Transfer the data
        fwrite($fp, 'POST '.$path." HTTP/1.0\r\n");
        fwrite($fp, 'Host: '.$target['host']."\r\n");
        fwrite($fp, "Content-type: application/x-www-form-urlencoded\r\n");
        fwrite($fp, 'Content-length: '.strlen($data)."\r\n");
        fwrite($fp, "Connection: close\r\n\r\n");
        fwrite($fp, $data);

        // Was it successful?

        $this->response = '';
        while (!feof($fp)) {
            $this->response .= fgets($fp, 128);
        }
        @fclose($fp);

        if (false === stripos($this->response, '<error>0</error>')) {
            $message = preg_match('/<message>(.*?)<\/message>/is', $this->response, $match)
                ? trim($match[1])
                : 'An unknown error was encountered';
            $this->set_error($message);

            return false;
        }

        return true;
    }

    // --------------------------------------------------------------------

    /**
     * Extract Trackback URLs.
     *
     * This function lets multiple trackbacks be sent.
     * It takes a string of URLs (separated by comma or
     * space) and puts each URL into an array
     *
     * @param	string
     * @param mixed $urls
     *
     * @return string
     */
    public function extract_urls($urls)
    {
        // Remove the pesky white space and replace with a comma, then replace doubles.
        $urls = str_replace(',,', ',', preg_replace('/\s*(\S+)\s*/', '\\1,', $urls));

        // Break into an array via commas and remove duplicates
        $urls = array_unique(preg_split('/[,]/', rtrim($urls, ',')));

        array_walk($urls, [$this, 'validate_url']);

        return $urls;
    }

    // --------------------------------------------------------------------

    /**
     * Validate URL.
     *
     * Simply adds "http://" if missing
     *
     * @param	string
     * @param mixed $url
     */
    public function validate_url(&$url): void
    {
        $url = trim($url);

        if (0 !== stripos($url, 'http')) {
            $url = 'http://'.$url;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Find the Trackback URL's ID.
     *
     * @param	string
     * @param mixed $url
     *
     * @return string
     */
    public function get_id($url)
    {
        $tb_id = '';

        if (str_contains($url, '?')) {
            $tb_array = explode('/', $url);
            $tb_end = $tb_array[count($tb_array) - 1];

            if (!is_numeric($tb_end)) {
                $tb_end = $tb_array[count($tb_array) - 2];
            }

            $tb_array = explode('=', $tb_end);
            $tb_id = $tb_array[count($tb_array) - 1];
        } else {
            $url = rtrim($url, '/');

            $tb_array = explode('/', $url);
            $tb_id = $tb_array[count($tb_array) - 1];

            if (!is_numeric($tb_id)) {
                $tb_id = $tb_array[count($tb_array) - 2];
            }
        }

        return ctype_digit((string) $tb_id) ? $tb_id : false;
    }

    // --------------------------------------------------------------------

    /**
     * Convert Reserved XML characters to Entities.
     *
     * @param	string
     * @param mixed $str
     *
     * @return string
     */
    public function convert_xml($str)
    {
        $temp = '__TEMP_AMPERSANDS__';

        $str = preg_replace(['/&#(\d+);/', '/&(\w+);/'], $temp.'\\1;', $str);

        $str = str_replace(
            ['&', '<', '>', '"', "'", '-'],
            ['&amp;', '&lt;', '&gt;', '&quot;', '&#39;', '&#45;'],
            $str
        );

        return preg_replace(['/'.$temp.'(\d+);/', '/'.$temp.'(\w+);/'], ['&#\\1;', '&\\1;'], $str);
    }

    // --------------------------------------------------------------------

    /**
     * Character limiter.
     *
     * Limits the string based on the character count. Will preserve complete words.
     *
     * @param	string
     * @param	int
     * @param	string
     * @param mixed $str
     * @param mixed $n
     * @param mixed $end_char
     *
     * @return string
     */
    public function limit_characters($str, $n = 500, $end_char = '&#8230;')
    {
        if (strlen($str) < $n) {
            return $str;
        }

        $str = preg_replace('/\s+/', ' ', str_replace(["\r\n", "\r", "\n"], ' ', $str));

        if (strlen($str) <= $n) {
            return $str;
        }

        $out = '';
        foreach (explode(' ', trim($str)) as $val) {
            $out .= $val.' ';
            if (strlen($out) >= $n) {
                return rtrim($out).$end_char;
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * High ASCII to Entities.
     *
     * Converts Hight ascii text and MS Word special chars
     * to character entities
     *
     * @param	string
     * @param mixed $str
     *
     * @return string
     */
    public function convert_ascii($str)
    {
        $count = 1;
        $out = '';
        $temp = [];

        for ($i = 0, $s = strlen($str); $i < $s; ++$i) {
            $ordinal = ord($str[$i]);

            if ($ordinal < 128) {
                $out .= $str[$i];
            } else {
                if (0 === count($temp)) {
                    $count = ($ordinal < 224) ? 2 : 3;
                }

                $temp[] = $ordinal;

                if (count($temp) === $count) {
                    $number = (3 === $count)
                        ? (($temp[0] % 16) * 4096) + (($temp[1] % 64) * 64) + ($temp[2] % 64)
                        : (($temp[0] % 32) * 64) + ($temp[1] % 64);

                    $out .= '&#'.$number.';';
                    $count = 1;
                    $temp = [];
                }
            }
        }

        return $out;
    }

    // --------------------------------------------------------------------

    /**
     * Set error message.
     *
     * @param	string
     * @param mixed $msg
     */
    public function set_error($msg): void
    {
        log_message('error', $msg);
        $this->error_msg[] = $msg;
    }

    // --------------------------------------------------------------------

    /**
     * Show error messages.
     *
     * @param	string
     * @param	string
     * @param mixed $open
     * @param mixed $close
     *
     * @return string
     */
    public function display_errors($open = '<p>', $close = '</p>')
    {
        return (count($this->error_msg) > 0) ? $open.implode($close.$open, $this->error_msg).$close : '';
    }
}
