<?php

declare(strict_types=1);

namespace Resellerclub;

require_once __DIR__.'/../core/Core.php';

/**
 * Contains validation functions.
 */
class Validation extends Core
{
    /**
     * Validate a parameter array.
     *
     * @param $type string Main validation type
     * @param $subType string Sub validation type
     * @param $parameters mixed Parameters to validate
     *
     * @throws InvalidValidationException invalid validation
     *
     * @return bool TRUE is valid, else FALSE or exception
     */
    public function validate($type, $subType, $parameters)
    {
        $validationFunction = $this->getValidationFunction($type, $subType);
        if (null === $validationFunction) {
            throw new InvalidValidationException('Invalid validation function.');
        }

        if (method_exists($this, $validationFunction)) {
            return $this->{$validationFunction}($parameters);
        }
    }

    /**
     * Get the name of the validation function.
     *
     * @param $type string Main category of validation
     * @param $subType string Validation function name
     *
     * @return string name of validation function or NULL if not found
     */
    private function getValidationFunction($type, $subType)
    {
        $validations = [];

        // Validators
        // Array Validators
        $validations['array']['default'] = 'validateArrayDefault';
        $validations['array']['contact'] = 'validateContact';
        $validations['array']['customer'] = 'validateCustomer';

        // Basic Validators
        $validations['string']['email'] = 'validateEmail';
        $validations['string']['ip'] = 'validateIp';
        $validations['string']['customer-id'] = 'validateCustomerId';
        $validations['string']['contact-id'] = 'validateContactId';

        if (!empty($validations[$type][$subType])) {
            return $validations[$type][$subType];
        }

        return null;
    }

    /**
     * Validates an input array for an API.
     *
     * @param $inputArray array The original array
     * @param $mandatory array The mandatory elements to be present in the array
     * @param array $optional optional elements that can be in the array
     *
     * @throws \Resellerclub\InvalidArrayException     input is not an array
     * @throws \Resellerclub\InvalidParameterException there are parameters other than specified in mandatory and optional
     * @throws \Resellerclub\MissingParameterException if parameters are missing from the specified mandatory list
     * @throws \Resellerclub\InvalidItemException      if an item is invalid
     *
     * @return bool TRUE if array is valid, else exception
     */
    private function validateArray($inputArray, $mandatory, $optional = [])
    {
        if (!is_array($inputArray)) {
            // Not even an array. Who does that :\ ?
            throw new InvalidArrayException('Input is not an array');
        }
        foreach ($inputArray as $key => $value) {
            if (!(in_array($key, $mandatory) or in_array($key, $optional))
        and !empty($optional)) {
                // If its not in mandatory or optional,
                // then parameter is not valid.
                // We don't want outsiders here.
                // If $optional is empty, it means, general validator.
                throw new InvalidParameterException('There are invalid parameters.');
            }
            // If the value in array is correct.
            if (!(
                is_array($value)
        or is_string($value)
        or is_int($value)
        or is_bool($value)
        or is_float($value)
        or is_null($value)
            )) {
                if (is_array($value)) {
                    foreach ($value as $parameter) {
                        if (!(
                            is_string($parameter)
              or is_int($parameter)
              or is_bool($parameter)
              or is_float($parameter)
              or is_null($parameter)
                        )) {
                            return false;
                        }
                    }
                }

                throw new InvalidArrayException('Input is not an array.');
            }
            if (true !== $this->validateItem($key, $value)) {
                throw new InvalidItemException('Item is invalid.');
            }
        }

        // Check for mandatory elements.
        foreach ($mandatory as $mandatoryItem) {
            // If any of the mandatory array elements is not found, then array is invalid.
            if (!isset($inputArray[$mandatoryItem])) {
                throw new MissingParameterException('Mandatory items in array missing');
            }
        }

        return true;
    }

    /**
     * Validate an item using a validator function.
     *
     * @param $itemValidator string Name of item's validator function
     * @param $item mixed The item to be validated
     *
     * @return bool TRUE if valid, else FALSE
     */
    private function validateItem($itemValidator, $item)
    {
        // We need to do something about this.
        $itemValidators = [
            'email' => ['string', 'email'],
            'username' => ['string', 'email'],
            'customer-id' => ['string', 'customer-id'],
            'contact-id' => ['string', 'contact-id'],
            'ip' => ['string', 'ip'],
        ];

        // Get validator function if present
        if (!empty($itemValidators[$itemValidator])) {
            $validator = $itemValidators[$itemValidator];
            $validatorFunction = $this->getValidationFunction($validator[0], $validator[1]);
        } else {
            $validatorFunction = null;
        }

        // If validator function is there, validate
        if (null !== $validatorFunction) {
            return $this->{$validatorFunction}($item);
        }

        // It doesn't have item validator.
        // We give it the benefit of doubt.
        return true;
    }

    /**
     * String Validators.
     *
     * @param mixed $email
     */

    /**
     * Validate an email address.
     *
     * @param $email string Email address
     *
     * @return bool TRUE is valid, else FALSE
     */
    private function validateEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }

    /**
     * Validate the IP address.
     *
     * @param $IpAddress mixed IP address or array of Ips
     *
     * @return bool TRUE if valid, else FALSE
     */
    private function validateIp($IpAddress)
    {
        if (filter_var($IpAddress, FILTER_VALIDATE_IP)) {
            return true;
        }

        return false;
    }

    /**
     * Validates Customer ID.
     *
     * @param $customerId integer Contact ID
     *
     * @return bool TRUE if valid
     */
    private function validateCustomerId($customerId)
    {
        if (is_numeric($customerId) && (8 === strlen($customerId))) {
            return true;
        }

        return false;
    }

    /**
     * Validates Contact ID.
     *
     * @param $contactId integer Contact ID
     *
     * @return bool TRUE if valid
     */
    private function validateContactId($contactId)
    {
        if (is_numeric($contactId) && (8 === strlen($contactId))) {
            return true;
        }

        return false;
    }

    /**
     * Array Validators.
     *
     * @param mixed $validateArray
     */

    /**
     * Default validator for arrays. It also execute item validators.
     *
     * @param $validateArray array Array to be validated
     *
     * @throws \Resellerclub\InvalidArrayException
     * @throws \Resellerclub\InvalidItemException
     * @throws \Resellerclub\InvalidParameterException
     * @throws \Resellerclub\MissingParameterException
     *
     * @return bool TRUE if valid, else exception
     */
    private function validateArrayDefault($validateArray)
    {
        // No mandatory and optional elements
        return $this->validateArray($validateArray, []);
    }

    /**
     * Validates a contact array.
     *
     * @param $contactDetails array Contact Details array
     *
     * @throws \Resellerclub\InvalidArrayException
     * @throws \Resellerclub\InvalidItemException
     * @throws \Resellerclub\InvalidParameterException
     * @throws \Resellerclub\MissingParameterException
     *
     * @return bool TRUE if valid. Else, exception.
     */
    private function validateContact($contactDetails)
    {
        $mandatory = [
            'name',
            'company',
            'email',
            'address-line-1',
            'city',
            'country',
            'zipcode',
            'phone-cc',
            'phone',
            'customer-id',
            'type',
        ];
        $optional = [
            'contact-id',
            'address-line-2',
            'address-line-3',
            'state',
            'fax-cc',
            'fax',
            'attr-name',
            'attr-value',
        ];

        return $this->validateArray($contactDetails, $mandatory, $optional);
    }

    /**
     * Validates a customer array.
     *
     * @param $customerDetails array Customer Details array
     *
     * @throws \Resellerclub\InvalidArrayException
     * @throws \Resellerclub\InvalidItemException
     * @throws \Resellerclub\InvalidParameterException
     * @throws \Resellerclub\MissingParameterException
     *
     * @return bool TRUE if valid, else exception
     */
    private function validateCustomer($customerDetails)
    {
        $mandatory = [
            'username',
            'passwd',
            'name',
            'company',
            'address-line-1',
            'city',
            'state',
            'country',
            'zipcode',
            'phone-cc',
            'phone',
            'lang-pref',
        ];
        $optional = [
            'other-state',
            'address-line-2',
            'address-line-3',
            'alt-phone-cc',
            'alt-phone',
            'fax-cc',
            'fax',
            'mobile-cc',
            'mobile',
            'customer-id',
        ];
        if ($this->validateArray($customerDetails, $mandatory, $optional)) {
            return true;
        }

        return false;
    }
}
