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
 * Form Validation Class.
 *
 * @category	Validation
 *
 * @author		EllisLab Dev Team
 *
 * @see		https://codeigniter.com/user_guide/libraries/form_validation.html
 */
class CI_Form_validation
{
    /**
     * Custom data to validate.
     *
     * @var array
     */
    public $validation_data = [];

    /**
     * Reference to the CodeIgniter instance.
     *
     * @var object
     */
    protected $CI;

    /**
     * Validation data for the current form submission.
     *
     * @var array
     */
    protected $_field_data = [];

    /**
     * Validation rules for the current form.
     *
     * @var array
     */
    protected $_config_rules = [];

    /**
     * Array of validation errors.
     *
     * @var array
     */
    protected $_error_array = [];

    /**
     * Array of custom error messages.
     *
     * @var array
     */
    protected $_error_messages = [];

    /**
     * Start tag for error wrapping.
     *
     * @var string
     */
    protected $_error_prefix = '<p>';

    /**
     * End tag for error wrapping.
     *
     * @var string
     */
    protected $_error_suffix = '</p>';

    /**
     * Custom error message.
     *
     * @var string
     */
    protected $error_string = '';

    /**
     * Whether the form data has been validated as safe.
     *
     * @var bool
     */
    protected $_safe_form_data = false;

    /**
     * Initialize Form_Validation class.
     *
     * @param array $rules
     */
    public function __construct($rules = [])
    {
        $this->CI = &get_instance();

        // applies delimiters set in config file.
        if (isset($rules['error_prefix'])) {
            $this->_error_prefix = $rules['error_prefix'];
            unset($rules['error_prefix']);
        }
        if (isset($rules['error_suffix'])) {
            $this->_error_suffix = $rules['error_suffix'];
            unset($rules['error_suffix']);
        }

        // Validation rules can be stored in a config file.
        $this->_config_rules = $rules;

        // Automatically load the form helper
        $this->CI->load->helper('form');

        log_message('info', 'Form Validation Class Initialized');
    }

    // --------------------------------------------------------------------

    /**
     * Set Rules.
     *
     * This function takes an array of field names and validation
     * rules as input, any custom error messages, validates the info,
     * and stores it
     *
     * @param mixed  $field
     * @param string $label
     * @param mixed  $rules
     * @param array  $errors
     *
     * @return CI_Form_validation
     */
    public function set_rules($field, $label = '', $rules = [], $errors = [])
    {
        // No reason to set rules if we have no POST data
        // or a validation array has not been specified
        if ('post' !== $this->CI->input->method() && empty($this->validation_data)) {
            return $this;
        }

        // If an array was passed via the first parameter instead of individual string
        // values we cycle through it and recursively call this function.
        if (is_array($field)) {
            foreach ($field as $row) {
                // Houston, we have a problem...
                if (!isset($row['field'], $row['rules'])) {
                    continue;
                }

                // If the field label wasn't passed we use the field name
                $label = $row['label'] ?? $row['field'];

                // Add the custom error message array
                $errors = (isset($row['errors']) && is_array($row['errors'])) ? $row['errors'] : [];

                // Here we go!
                $this->set_rules($row['field'], $label, $row['rules'], $errors);
            }

            return $this;
        }

        // No fields or no rules? Nothing to do...
        if (!is_string($field) or '' === $field or empty($rules)) {
            return $this;
        }
        if (!is_array($rules)) {
            // BC: Convert pipe-separated rules string to an array
            if (!is_string($rules)) {
                return $this;
            }

            $rules = preg_split('/\|(?![^\[]*\])/', $rules);
        }

        // If the field label wasn't passed we use the field name
        $label = ('' === $label) ? $field : $label;

        $indexes = [];

        // Is the field name an array? If it is an array, we break it apart
        // into its components so that we can fetch the corresponding POST data later
        if (($is_array = (bool) preg_match_all('/\[(.*?)\]/', $field, $matches)) === true) {
            sscanf($field, '%[^[][', $indexes[0]);

            for ($i = 0, $c = count($matches[0]); $i < $c; ++$i) {
                if ('' !== $matches[1][$i]) {
                    $indexes[] = $matches[1][$i];
                }
            }
        }

        // Build our master array
        $this->_field_data[$field] = [
            'field' => $field,
            'label' => $label,
            'rules' => $rules,
            'errors' => $errors,
            'is_array' => $is_array,
            'keys' => $indexes,
            'postdata' => null,
            'error' => '',
        ];

        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * By default, form validation uses the $_POST array to validate.
     *
     * If an array is set through this method, then this array will
     * be used instead of the $_POST array
     *
     * Note that if you are validating multiple arrays, then the
     * reset_validation() function should be called after validating
     * each array due to the limitations of CI's singleton
     *
     * @return CI_Form_validation
     */
    public function set_data(array $data)
    {
        if (!empty($data)) {
            $this->validation_data = $data;
        }

        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Set Error Message.
     *
     * Lets users set their own error messages on the fly. Note:
     * The key name has to match the function name that it corresponds to.
     *
     * @param	array
     * @param	string
     * @param mixed $lang
     * @param mixed $val
     *
     * @return CI_Form_validation
     */
    public function set_message($lang, $val = '')
    {
        if (!is_array($lang)) {
            $lang = [$lang => $val];
        }

        $this->_error_messages = array_merge($this->_error_messages, $lang);

        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Set The Error Delimiter.
     *
     * Permits a prefix/suffix to be added to each error message
     *
     * @param	string
     * @param	string
     * @param mixed $prefix
     * @param mixed $suffix
     *
     * @return CI_Form_validation
     */
    public function set_error_delimiters($prefix = '<p>', $suffix = '</p>')
    {
        $this->_error_prefix = $prefix;
        $this->_error_suffix = $suffix;

        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Get Error Message.
     *
     * Gets the error message associated with a particular field
     *
     * @param string $field  Field name
     * @param string $prefix HTML start tag
     * @param string $suffix HTML end tag
     *
     * @return string
     */
    public function error($field, $prefix = '', $suffix = '')
    {
        if (empty($this->_field_data[$field]['error'])) {
            return '';
        }

        if ('' === $prefix) {
            $prefix = $this->_error_prefix;
        }

        if ('' === $suffix) {
            $suffix = $this->_error_suffix;
        }

        return $prefix.$this->_field_data[$field]['error'].$suffix;
    }

    // --------------------------------------------------------------------

    /**
     * Get Array of Error Messages.
     *
     * Returns the error messages as an array
     *
     * @return array
     */
    public function error_array()
    {
        return $this->_error_array;
    }

    // --------------------------------------------------------------------

    /**
     * Error String.
     *
     * Returns the error messages as a string, wrapped in the error delimiters
     *
     * @param	string
     * @param	string
     * @param mixed $prefix
     * @param mixed $suffix
     *
     * @return string
     */
    public function error_string($prefix = '', $suffix = '')
    {
        // No errors, validation passes!
        if (0 === count($this->_error_array)) {
            return '';
        }

        if ('' === $prefix) {
            $prefix = $this->_error_prefix;
        }

        if ('' === $suffix) {
            $suffix = $this->_error_suffix;
        }

        // Generate the error string
        $str = '';
        foreach ($this->_error_array as $val) {
            if ('' !== $val) {
                $str .= $prefix.$val.$suffix."\n";
            }
        }

        return $str;
    }

    // --------------------------------------------------------------------

    /**
     * Run the Validator.
     *
     * This function does all the work.
     *
     * @param string $group
     *
     * @return bool
     */
    public function run($group = '')
    {
        $validation_array = empty($this->validation_data)
            ? $_POST
            : $this->validation_data;

        // Does the _field_data array containing the validation rules exist?
        // If not, we look to see if they were assigned via a config file
        if (0 === count($this->_field_data)) {
            // No validation rules?  We're done...
            if (0 === count($this->_config_rules)) {
                return false;
            }

            if (empty($group)) {
                // Is there a validation rule for the particular URI being accessed?
                $group = trim($this->CI->uri->ruri_string(), '/');
                isset($this->_config_rules[$group]) or $group = $this->CI->router->class.'/'.$this->CI->router->method;
            }

            $this->set_rules($this->_config_rules[$group] ?? $this->_config_rules);

            // Were we able to set the rules correctly?
            if (0 === count($this->_field_data)) {
                log_message('debug', 'Unable to find validation rules');

                return false;
            }
        }

        // Load the language file containing error messages
        $this->CI->lang->load('form_validation');

        // Cycle through the rules for each field and match the corresponding $validation_data item
        foreach ($this->_field_data as $field => &$row) {
            // Fetch the data from the validation_data array item and cache it in the _field_data array.
            // Depending on whether the field name is an array or a string will determine where we get it from.
            if (true === $row['is_array']) {
                $this->_field_data[$field]['postdata'] = $this->_reduce_array($validation_array, $row['keys']);
            } elseif (isset($validation_array[$field])) {
                $this->_field_data[$field]['postdata'] = $validation_array[$field];
            }
        }

        // Execute validation rules
        // Note: A second foreach (for now) is required in order to avoid false-positives
        //	 for rules like 'matches', which correlate to other validation fields.
        foreach ($this->_field_data as $field => &$row) {
            // Don't try to validate if we have no rules set
            if (empty($row['rules'])) {
                continue;
            }

            $this->_execute($row, $row['rules'], $row['postdata']);
        }

        // Did we end up with any errors?
        $total_errors = count($this->_error_array);
        if ($total_errors > 0) {
            $this->_safe_form_data = true;
        }

        // Now we need to re-set the POST data with the new, processed data
        empty($this->validation_data) && $this->_reset_post_array();

        return 0 === $total_errors;
    }

    // --------------------------------------------------------------------

    /**
     * Checks if the rule is present within the validator.
     *
     * Permits you to check if a rule is present within the validator
     *
     * @param	string	the field name
     * @param mixed $field
     *
     * @return bool
     */
    public function has_rule($field)
    {
        return isset($this->_field_data[$field]);
    }

    // --------------------------------------------------------------------

    /**
     * Get the value from a form.
     *
     * Permits you to repopulate a form field with the value it was submitted
     * with, or, if that value doesn't exist, with the default
     *
     * @param	string	the field name
     * @param	string
     * @param mixed $field
     * @param mixed $default
     *
     * @return string
     */
    public function set_value($field = '', $default = '')
    {
        if (!isset($this->_field_data[$field], $this->_field_data[$field]['postdata'])) {
            return $default;
        }

        // If the data is an array output them one at a time.
        //	E.g: form_input('name[]', set_value('name[]');
        if (is_array($this->_field_data[$field]['postdata'])) {
            return array_shift($this->_field_data[$field]['postdata']);
        }

        return $this->_field_data[$field]['postdata'];
    }

    // --------------------------------------------------------------------

    /**
     * Set Select.
     *
     * Enables pull-down lists to be set to the value the user
     * selected in the event of an error
     *
     * @param	string
     * @param	string
     * @param	bool
     * @param mixed $field
     * @param mixed $value
     * @param mixed $default
     *
     * @return string
     */
    public function set_select($field = '', $value = '', $default = false)
    {
        if (!isset($this->_field_data[$field], $this->_field_data[$field]['postdata'])) {
            return (true === $default && 0 === count($this->_field_data)) ? ' selected="selected"' : '';
        }

        $field = $this->_field_data[$field]['postdata'];
        $value = (string) $value;
        if (is_array($field)) {
            // Note: in_array('', array(0)) returns TRUE, do not use it
            foreach ($field as &$v) {
                if ($value === $v) {
                    return ' selected="selected"';
                }
            }

            return '';
        }
        if (('' === $field or '' === $value) or ($field !== $value)) {
            return '';
        }

        return ' selected="selected"';
    }

    // --------------------------------------------------------------------

    /**
     * Set Radio.
     *
     * Enables radio buttons to be set to the value the user
     * selected in the event of an error
     *
     * @param	string
     * @param	string
     * @param	bool
     * @param mixed $field
     * @param mixed $value
     * @param mixed $default
     *
     * @return string
     */
    public function set_radio($field = '', $value = '', $default = false)
    {
        if (!isset($this->_field_data[$field], $this->_field_data[$field]['postdata'])) {
            return (true === $default && 0 === count($this->_field_data)) ? ' checked="checked"' : '';
        }

        $field = $this->_field_data[$field]['postdata'];
        $value = (string) $value;
        if (is_array($field)) {
            // Note: in_array('', array(0)) returns TRUE, do not use it
            foreach ($field as &$v) {
                if ($value === $v) {
                    return ' checked="checked"';
                }
            }

            return '';
        }
        if (('' === $field or '' === $value) or ($field !== $value)) {
            return '';
        }

        return ' checked="checked"';
    }

    // --------------------------------------------------------------------

    /**
     * Set Checkbox.
     *
     * Enables checkboxes to be set to the value the user
     * selected in the event of an error
     *
     * @param	string
     * @param	string
     * @param	bool
     * @param mixed $field
     * @param mixed $value
     * @param mixed $default
     *
     * @return string
     */
    public function set_checkbox($field = '', $value = '', $default = false)
    {
        // Logic is exactly the same as for radio fields
        return $this->set_radio($field, $value, $default);
    }

    // --------------------------------------------------------------------

    /**
     * Required.
     *
     * @param	string
     * @param mixed $str
     *
     * @return bool
     */
    public function required($str)
    {
        return is_array($str)
            ? (false === empty($str))
            : ('' !== trim($str));
    }

    // --------------------------------------------------------------------

    /**
     * Performs a Regular Expression match test.
     *
     * @param	string
     * @param	string	regex
     * @param mixed $str
     * @param mixed $regex
     *
     * @return bool
     */
    public function regex_match($str, $regex)
    {
        return (bool) preg_match($regex, $str);
    }

    // --------------------------------------------------------------------

    /**
     * Match one field to another.
     *
     * @param string $str   string to compare against
     * @param string $field
     *
     * @return bool
     */
    public function matches($str, $field)
    {
        return isset($this->_field_data[$field], $this->_field_data[$field]['postdata'])
            ? ($str === $this->_field_data[$field]['postdata'])
            : false;
    }

    // --------------------------------------------------------------------

    /**
     * Differs from another field.
     *
     * @param	string
     * @param	string	field
     * @param mixed $str
     * @param mixed $field
     *
     * @return bool
     */
    public function differs($str, $field)
    {
        return !(isset($this->_field_data[$field]) && $this->_field_data[$field]['postdata'] === $str);
    }

    // --------------------------------------------------------------------

    /**
     * Is Unique.
     *
     * Check if the input value doesn't already exist
     * in the specified database field.
     *
     * @param string $str
     * @param string $field
     *
     * @return bool
     */
    public function is_unique($str, $field)
    {
        sscanf($field, '%[^.].%[^.]', $table, $field);

        return isset($this->CI->db)
            ? (0 === $this->CI->db->limit(1)->get_where($table, [$field => $str])->num_rows())
            : false;
    }

    // --------------------------------------------------------------------

    /**
     * Minimum Length.
     *
     * @param	string
     * @param	string
     * @param mixed $str
     * @param mixed $val
     *
     * @return bool
     */
    public function min_length($str, $val)
    {
        if (!is_numeric($val)) {
            return false;
        }

        return $val <= mb_strlen($str);
    }

    // --------------------------------------------------------------------

    /**
     * Max Length.
     *
     * @param	string
     * @param	string
     * @param mixed $str
     * @param mixed $val
     *
     * @return bool
     */
    public function max_length($str, $val)
    {
        if (!is_numeric($val)) {
            return false;
        }

        return $val >= mb_strlen($str);
    }

    // --------------------------------------------------------------------

    /**
     * Exact Length.
     *
     * @param	string
     * @param	string
     * @param mixed $str
     * @param mixed $val
     *
     * @return bool
     */
    public function exact_length($str, $val)
    {
        if (!is_numeric($val)) {
            return false;
        }

        return mb_strlen($str) === (int) $val;
    }

    // --------------------------------------------------------------------

    /**
     * Valid URL.
     *
     * @param string $str
     *
     * @return bool
     */
    public function valid_url($str)
    {
        if (empty($str)) {
            return false;
        }
        if (preg_match('/^(?:([^:]*)\:)?\/\/(.+)$/', $str, $matches)) {
            if (empty($matches[2])) {
                return false;
            }
            if (!in_array(strtolower($matches[1]), ['http', 'https'], true)) {
                return false;
            }

            $str = $matches[2];
        }

        // Apparently, FILTER_VALIDATE_URL doesn't reject digit-only names for some reason ...
        // See https://github.com/bcit-ci/CodeIgniter/issues/5755
        if (ctype_digit($str)) {
            return false;
        }

        // PHP 7 accepts IPv6 addresses within square brackets as hostnames,
        // but it appears that the PR that came in with https://bugs.php.net/bug.php?id=68039
        // was never merged into a PHP 5 branch ... https://3v4l.org/8PsSN
        if (preg_match('/^\[([^\]]+)\]/', $str, $matches) && !is_php('7') && false !== filter_var($matches[1], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $str = 'ipv6.host'.substr($str, strlen($matches[1]) + 2);
        }

        return false !== filter_var('http://'.$str, FILTER_VALIDATE_URL);
    }

    // --------------------------------------------------------------------

    /**
     * Valid Email.
     *
     * @param	string
     * @param mixed $str
     *
     * @return bool
     */
    public function valid_email($str)
    {
        if (function_exists('idn_to_ascii') && preg_match('#\A([^@]+)@(.+)\z#', $str, $matches)) {
            $domain = defined('INTL_IDNA_VARIANT_UTS46')
                ? idn_to_ascii($matches[2], 0, INTL_IDNA_VARIANT_UTS46)
                : idn_to_ascii($matches[2]);

            if (false !== $domain) {
                $str = $matches[1].'@'.$domain;
            }
        }

        return (bool) filter_var($str, FILTER_VALIDATE_EMAIL);
    }

    // --------------------------------------------------------------------

    /**
     * Valid Emails.
     *
     * @param	string
     * @param mixed $str
     *
     * @return bool
     */
    public function valid_emails($str)
    {
        if (!str_contains($str, ',')) {
            return $this->valid_email(trim($str));
        }

        foreach (explode(',', $str) as $email) {
            if ('' !== trim($email) && false === $this->valid_email(trim($email))) {
                return false;
            }
        }

        return true;
    }

    // --------------------------------------------------------------------

    /**
     * Validate IP Address.
     *
     * @param	string
     * @param	string	'ipv4' or 'ipv6' to validate a specific IP format
     * @param mixed $ip
     * @param mixed $which
     *
     * @return bool
     */
    public function valid_ip($ip, $which = '')
    {
        return $this->CI->input->valid_ip($ip, $which);
    }

    // --------------------------------------------------------------------

    /**
     * Alpha.
     *
     * @param	string
     * @param mixed $str
     *
     * @return bool
     */
    public function alpha($str)
    {
        return ctype_alpha($str);
    }

    // --------------------------------------------------------------------

    /**
     * Alpha-numeric.
     *
     * @param	string
     * @param mixed $str
     *
     * @return bool
     */
    public function alpha_numeric($str)
    {
        return ctype_alnum((string) $str);
    }

    // --------------------------------------------------------------------

    /**
     * Alpha-numeric w/ spaces.
     *
     * @param	string
     * @param mixed $str
     *
     * @return bool
     */
    public function alpha_numeric_spaces($str)
    {
        return (bool) preg_match('/^[A-Z0-9 ]+$/i', $str);
    }

    // --------------------------------------------------------------------

    /**
     * Alpha-numeric with underscores and dashes.
     *
     * @param	string
     * @param mixed $str
     *
     * @return bool
     */
    public function alpha_dash($str)
    {
        return (bool) preg_match('/^[a-z0-9_-]+$/i', $str);
    }

    // --------------------------------------------------------------------

    /**
     * Numeric.
     *
     * @param	string
     * @param mixed $str
     *
     * @return bool
     */
    public function numeric($str)
    {
        return (bool) preg_match('/^[\-+]?[0-9]*\.?[0-9]+$/', $str);
    }

    // --------------------------------------------------------------------

    /**
     * Integer.
     *
     * @param	string
     * @param mixed $str
     *
     * @return bool
     */
    public function integer($str)
    {
        return (bool) preg_match('/^[\-+]?[0-9]+$/', $str);
    }

    // --------------------------------------------------------------------

    /**
     * Decimal number.
     *
     * @param	string
     * @param mixed $str
     *
     * @return bool
     */
    public function decimal($str)
    {
        return (bool) preg_match('/^[\-+]?[0-9]+\.[0-9]+$/', $str);
    }

    // --------------------------------------------------------------------

    /**
     * Greater than.
     *
     * @param	string
     * @param	int
     * @param mixed $str
     * @param mixed $min
     *
     * @return bool
     */
    public function greater_than($str, $min)
    {
        return is_numeric($str) ? ($str > $min) : false;
    }

    // --------------------------------------------------------------------

    /**
     * Equal to or Greater than.
     *
     * @param	string
     * @param	int
     * @param mixed $str
     * @param mixed $min
     *
     * @return bool
     */
    public function greater_than_equal_to($str, $min)
    {
        return is_numeric($str) ? ($str >= $min) : false;
    }

    // --------------------------------------------------------------------

    /**
     * Less than.
     *
     * @param	string
     * @param	int
     * @param mixed $str
     * @param mixed $max
     *
     * @return bool
     */
    public function less_than($str, $max)
    {
        return is_numeric($str) ? ($str < $max) : false;
    }

    // --------------------------------------------------------------------

    /**
     * Equal to or Less than.
     *
     * @param	string
     * @param	int
     * @param mixed $str
     * @param mixed $max
     *
     * @return bool
     */
    public function less_than_equal_to($str, $max)
    {
        return is_numeric($str) ? ($str <= $max) : false;
    }

    // --------------------------------------------------------------------

    /**
     * Value should be within an array of values.
     *
     * @param	string
     * @param	string
     * @param mixed $value
     * @param mixed $list
     *
     * @return bool
     */
    public function in_list($value, $list)
    {
        return in_array($value, explode(',', $list), true);
    }

    // --------------------------------------------------------------------

    /**
     * Is a Natural number  (0,1,2,3, etc.).
     *
     * @param	string
     * @param mixed $str
     *
     * @return bool
     */
    public function is_natural($str)
    {
        return ctype_digit((string) $str);
    }

    // --------------------------------------------------------------------

    /**
     * Is a Natural number, but not a zero  (1,2,3, etc.).
     *
     * @param	string
     * @param mixed $str
     *
     * @return bool
     */
    public function is_natural_no_zero($str)
    {
        return 0 != $str && ctype_digit((string) $str);
    }

    // --------------------------------------------------------------------

    /**
     * Valid Base64.
     *
     * Tests a string for characters outside of the Base64 alphabet
     * as defined by RFC 2045 http://www.faqs.org/rfcs/rfc2045
     *
     * @param	string
     * @param mixed $str
     *
     * @return bool
     */
    public function valid_base64($str)
    {
        return base64_encode(base64_decode($str)) === $str;
    }

    // --------------------------------------------------------------------

    /**
     * Prep data for form.
     *
     * This function allows HTML to be safely shown in a form.
     * Special characters are converted.
     *
     * @deprecated	3.0.6	Not used anywhere within the framework and pretty much useless
     *
     * @param mixed $data Input data
     *
     * @return mixed
     */
    public function prep_for_form($data)
    {
        if (false === $this->_safe_form_data or empty($data)) {
            return $data;
        }

        if (is_array($data)) {
            foreach ($data as $key => $val) {
                $data[$key] = $this->prep_for_form($val);
            }

            return $data;
        }

        return str_replace(["'", '"', '<', '>'], ['&#39;', '&quot;', '&lt;', '&gt;'], stripslashes($data));
    }

    // --------------------------------------------------------------------

    /**
     * Prep URL.
     *
     * @param	string
     * @param mixed $str
     *
     * @return string
     */
    public function prep_url($str = '')
    {
        if ('http://' === $str or '' === $str) {
            return '';
        }

        if (!str_starts_with($str, 'http://') && !str_starts_with($str, 'https://')) {
            return 'http://'.$str;
        }

        return $str;
    }

    // --------------------------------------------------------------------

    /**
     * Strip Image Tags.
     *
     * @param	string
     * @param mixed $str
     *
     * @return string
     */
    public function strip_image_tags($str)
    {
        return $this->CI->security->strip_image_tags($str);
    }

    // --------------------------------------------------------------------

    /**
     * Convert PHP tags to entities.
     *
     * @param	string
     * @param mixed $str
     *
     * @return string
     */
    public function encode_php_tags($str)
    {
        return str_replace(['<?', '?>'], ['&lt;?', '?&gt;'], $str);
    }

    // --------------------------------------------------------------------

    /**
     * Reset validation vars.
     *
     * Prevents subsequent validation routines from being affected by the
     * results of any previous validation routine due to the CI singleton.
     *
     * @return CI_Form_validation
     */
    public function reset_validation()
    {
        $this->_field_data = [];
        $this->_error_array = [];
        $this->_error_messages = [];
        $this->error_string = '';

        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Prepare rules.
     *
     * Re-orders the provided rules in order of importance, so that
     * they can easily be executed later without weird checks ...
     *
     * "Callbacks" are given the highest priority (always called),
     * followed by 'required' (called if callbacks didn't fail),
     * and then every next rule depends on the previous one passing.
     *
     * @param array $rules
     *
     * @return array
     */
    protected function _prepare_rules($rules)
    {
        $new_rules = [];
        $callbacks = [];

        foreach ($rules as &$rule) {
            // Let 'required' always be the first (non-callback) rule
            if ('required' === $rule) {
                array_unshift($new_rules, 'required');
            }
            // 'isset' is a kind of a weird alias for 'required' ...
            elseif ('isset' === $rule && (empty($new_rules) or 'required' !== $new_rules[0])) {
                array_unshift($new_rules, 'isset');
            }
            // The old/classic 'callback_'-prefixed rules
            elseif (is_string($rule) && 0 === strncmp('callback_', $rule, 9)) {
                $callbacks[] = $rule;
            }
            // Proper callables
            elseif (is_callable($rule)) {
                $callbacks[] = $rule;
            }
            // "Named" callables; i.e. array('name' => $callable)
            elseif (is_array($rule) && isset($rule[0], $rule[1]) && is_callable($rule[1])) {
                $callbacks[] = $rule;
            }
            // Everything else goes at the end of the queue
            else {
                $new_rules[] = $rule;
            }
        }

        return array_merge($callbacks, $new_rules);
    }

    // --------------------------------------------------------------------

    /**
     * Traverse a multidimensional $_POST array index until the data is found.
     *
     * @param	array
     * @param	array
     * @param	int
     * @param mixed $array
     * @param mixed $keys
     * @param mixed $i
     *
     * @return mixed
     */
    protected function _reduce_array($array, $keys, $i = 0)
    {
        if (is_array($array) && isset($keys[$i])) {
            return isset($array[$keys[$i]]) ? $this->_reduce_array($array[$keys[$i]], $keys, ($i + 1)) : null;
        }

        // NULL must be returned for empty fields
        return ('' === $array) ? null : $array;
    }

    // --------------------------------------------------------------------

    /**
     * Re-populate the _POST array with our finalized and processed data.
     */
    protected function _reset_post_array(): void
    {
        foreach ($this->_field_data as $field => $row) {
            if (null !== $row['postdata']) {
                if (false === $row['is_array']) {
                    isset($_POST[$field]) && $_POST[$field] = is_array($row['postdata']) ? null : $row['postdata'];
                } else {
                    // start with a reference
                    $post_ref = &$_POST;

                    // before we assign values, make a reference to the right POST key
                    if (1 === count($row['keys'])) {
                        $post_ref = &$post_ref[current($row['keys'])];
                    } else {
                        foreach ($row['keys'] as $val) {
                            $post_ref = &$post_ref[$val];
                        }
                    }

                    $post_ref = $row['postdata'];
                }
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Executes the Validation routines.
     *
     * @param	array
     * @param	array
     * @param	mixed
     * @param	int
     * @param mixed      $row
     * @param mixed      $rules
     * @param null|mixed $postdata
     * @param mixed      $cycles
     *
     * @return mixed
     */
    protected function _execute($row, $rules, $postdata = null, $cycles = 0)
    {
        // If the $_POST data is an array we will run a recursive call
        //
        // Note: We MUST check if the array is empty or not!
        //       Otherwise empty arrays will always pass validation.
        if (is_array($postdata) && !empty($postdata)) {
            foreach ($postdata as $key => $val) {
                $this->_execute($row, $rules, $val, $key);
            }

            return;
        }

        $rules = $this->_prepare_rules($rules);
        foreach ($rules as $rule) {
            $_in_array = false;

            // We set the $postdata variable with the current data in our master array so that
            // each cycle of the loop is dealing with the processed data from the last cycle
            if (true === $row['is_array'] && is_array($this->_field_data[$row['field']]['postdata'])) {
                // We shouldn't need this safety, but just in case there isn't an array index
                // associated with this cycle we'll bail out
                if (!isset($this->_field_data[$row['field']]['postdata'][$cycles])) {
                    continue;
                }

                $postdata = $this->_field_data[$row['field']]['postdata'][$cycles];
                $_in_array = true;
            } else {
                // If we get an array field, but it's not expected - then it is most likely
                // somebody messing with the form on the client side, so we'll just consider
                // it an empty field
                $postdata = is_array($this->_field_data[$row['field']]['postdata'])
                    ? null
                    : $this->_field_data[$row['field']]['postdata'];
            }

            // Is the rule a callback?
            $callback = $callable = false;
            if (is_string($rule)) {
                if (str_starts_with($rule, 'callback_')) {
                    $rule = substr($rule, 9);
                    $callback = true;
                }
            } elseif (is_callable($rule)) {
                $callable = true;
            } elseif (is_array($rule) && isset($rule[0], $rule[1]) && is_callable($rule[1])) {
                // We have a "named" callable, so save the name
                $callable = $rule[0];
                $rule = $rule[1];
            }

            // Strip the parameter (if exists) from the rule
            // Rules can contain a parameter: max_length[5]
            $param = false;
            if (!$callable && preg_match('/(.*?)\[(.*)\]/', $rule, $match)) {
                $rule = $match[1];
                $param = $match[2];
            }

            // Ignore empty, non-required inputs with a few exceptions ...
            if (
                (null === $postdata or '' === $postdata)
                && false === $callback
                && false === $callable
                && !in_array($rule, ['required', 'isset', 'matches'], true)
            ) {
                continue;
            }

            // Call the function that corresponds to the rule
            if ($callback or false !== $callable) {
                if ($callback) {
                    if (!method_exists($this->CI, $rule)) {
                        log_message('debug', 'Unable to find callback validation rule: '.$rule);
                        $result = false;
                    } else {
                        // Run the function and grab the result
                        $result = $this->CI->{$rule}($postdata, $param);
                    }
                } else {
                    $result = is_array($rule)
                        ? $rule[0]->{$rule[1]}($postdata)
                        : $rule($postdata);

                    // Is $callable set to a rule name?
                    if (false !== $callable) {
                        $rule = $callable;
                    }
                }

                // Re-assign the result to the master data array
                if (true === $_in_array) {
                    $this->_field_data[$row['field']]['postdata'][$cycles] = is_bool($result) ? $postdata : $result;
                } else {
                    $this->_field_data[$row['field']]['postdata'] = is_bool($result) ? $postdata : $result;
                }
            } elseif (!method_exists($this, $rule)) {
                // If our own wrapper function doesn't exist we see if a native PHP function does.
                // Users can use any native PHP function call that has one param.
                if (function_exists($rule)) {
                    // Native PHP functions issue warnings if you pass them more parameters than they use
                    $result = (false !== $param) ? $rule($postdata, $param) : $rule($postdata);

                    if (true === $_in_array) {
                        $this->_field_data[$row['field']]['postdata'][$cycles] = is_bool($result) ? $postdata : $result;
                    } else {
                        $this->_field_data[$row['field']]['postdata'] = is_bool($result) ? $postdata : $result;
                    }
                } else {
                    log_message('debug', 'Unable to find validation rule: '.$rule);
                    $result = false;
                }
            } else {
                $result = $this->{$rule}($postdata, $param);

                if (true === $_in_array) {
                    $this->_field_data[$row['field']]['postdata'][$cycles] = is_bool($result) ? $postdata : $result;
                } else {
                    $this->_field_data[$row['field']]['postdata'] = is_bool($result) ? $postdata : $result;
                }
            }

            // Did the rule test negatively? If so, grab the error.
            if (false === $result) {
                // Callable rules might not have named error messages
                if (!is_string($rule)) {
                    $line = $this->CI->lang->line('form_validation_error_message_not_set').'(Anonymous function)';
                } else {
                    $line = $this->_get_error_message($rule, $row['field']);
                }

                // Is the parameter we are inserting into the error message the name
                // of another field? If so we need to grab its "field label"
                if (isset($this->_field_data[$param], $this->_field_data[$param]['label'])) {
                    $param = $this->_translate_fieldname($this->_field_data[$param]['label']);
                }

                // Build the error message
                $message = $this->_build_error_msg($line, $this->_translate_fieldname($row['label']), $param);

                // Save the error message
                $this->_field_data[$row['field']]['error'] = $message;

                if (!isset($this->_error_array[$row['field']])) {
                    $this->_error_array[$row['field']] = $message;
                }

                return;
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Get the error message for the rule.
     *
     * @param string $rule  The rule name
     * @param string $field The field name
     *
     * @return string
     */
    protected function _get_error_message($rule, $field)
    {
        // check if a custom message is defined through validation config row.
        if (isset($this->_field_data[$field]['errors'][$rule])) {
            return $this->_field_data[$field]['errors'][$rule];
        }
        // check if a custom message has been set using the set_message() function
        if (isset($this->_error_messages[$rule])) {
            return $this->_error_messages[$rule];
        }
        if (false !== ($line = $this->CI->lang->line('form_validation_'.$rule))) {
            return $line;
        }
        // DEPRECATED support for non-prefixed keys, lang file again
        if (false !== ($line = $this->CI->lang->line($rule, false))) {
            return $line;
        }

        return $this->CI->lang->line('form_validation_error_message_not_set').'('.$rule.')';
    }

    // --------------------------------------------------------------------

    /**
     * Translate a field name.
     *
     * @param	string	the field name
     * @param mixed $fieldname
     *
     * @return string
     */
    protected function _translate_fieldname($fieldname)
    {
        // Do we need to translate the field name? We look for the prefix 'lang:' to determine this
        // If we find one, but there's no translation for the string - just return it
        if (1 === sscanf($fieldname, 'lang:%s', $line) && false === ($fieldname = $this->CI->lang->line($line, false))) {
            return $line;
        }

        return $fieldname;
    }

    // --------------------------------------------------------------------

    /**
     * Build an error message using the field and param.
     *
     * @param	string	The error message line
     * @param	string	A field's human name
     * @param	mixed	A rule's optional parameter
     * @param mixed $line
     * @param mixed $field
     * @param mixed $param
     *
     * @return string
     */
    protected function _build_error_msg($line, $field = '', $param = '')
    {
        // Check for %s in the string for legacy support.
        if (str_contains($line, '%s')) {
            return sprintf($line, $field, $param);
        }

        return str_replace(['{field}', '{param}'], [$field, $param], $line);
    }
}
