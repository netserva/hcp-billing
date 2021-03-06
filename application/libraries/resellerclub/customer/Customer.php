<?php

declare(strict_types=1);

namespace Resellerclub;

require_once __DIR__.'/../core/Core.php';

/**
 * Contains customer related API calls.
 */
class Customer extends Core
{
    /**
     * Creates a Customer Account using the details provided.
     *
     * @see http://manage.resellerclub.com/kb/answer/804
     *
     * @param $customerDetails array See reference
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function createCustomer($customerDetails)
    {
        $this->validate('array', 'customer', $customerDetails);

        return $this->callApi(METHOD_POST, 'customers', 'signup', $customerDetails);
    }

    /**
     * Modifies the Account details of the specified Customer.
     *
     * @see http://manage.resellerclub.com/kb/answer/805
     *
     * @param $customerId integer Customer Id
     * @param $customerDetails array See reference
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function editCustomer($customerId, $customerDetails)
    {
        $customerDetails['customer-id'] = $customerId;
        $this->validate('array', 'customer', $customerDetails);

        return $this->callApi(METHOD_POST, 'customers', 'modify', $customerDetails);
    }

    /**
     * Gets the Customer details for the specified Customer Username.
     *
     * @see http://manage.resellerclub.com/kb/answer/874
     *
     * @param $userName string User name (email)
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function getCustomerByUserName($userName)
    {
        $customerDetails['username'] = $userName;
        $this->defaultValidate($customerDetails);

        return $this->callApi(METHOD_GET, 'customers', 'details', $customerDetails);
    }

    /**
     * Gets the Customer details for the specified Customer Id.
     *
     * @param $customerId integer Customer Id
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function getCustomerByCustomerId($customerId)
    {
        $customerDetails['customer-id'] = $customerId;
        $this->defaultValidate($customerDetails);

        return $this->callApi(METHOD_GET, 'customers', 'details-by-id', $customerDetails);
    }

    /**
     * Authenticates a Customer by returning an authentication token.
     *
     * @see http://manage.resellerclub.com/kb/answer/818
     *
     * @param $userName string User Name
     * @param $password string Password
     * @param $ip string IP address
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output. Token if successfully authenticated.
     */
    public function generateToken($userName, $password, $ip)
    {
        $customerDetails['username'] = $userName;
        $customerDetails['passwd'] = $password;
        $customerDetails['ip'] = $ip;
        $this->defaultValidate($customerDetails);

        return $this->callApi(METHOD_POST, 'customers', 'generate-token', $customerDetails);
    }

    /**
     * Authenticates the token generated by the Generate Token method.
     *
     * @param $token string Authentication token
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output. Customer details if authenticated.
     */
    public function authenticateToken($token)
    {
        $customerDetails['token'] = $token;
        $this->defaultValidate($customerDetails);

        return $this->callApi(METHOD_POST, 'customers', 'authenticate-token', $customerDetails);
    }

    /**
     * Changes the password for the specified Customer.
     *
     * @see http://manage.resellerclub.com/kb/answer/806
     *
     * @param $customerId integer Customer ID
     * @param $newPassword string New password
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output. TRUE is password change is successful.
     */
    public function changePassword($customerId, $newPassword)
    {
        $customerDetails['customer-id'] = $customerId;
        $customerDetails['new-passwd'] = $newPassword;
        $this->defaultValidate($customerDetails);

        return $this->callApi(METHOD_POST, 'customers', 'change-password', $customerDetails);
    }

    /**
     * Generates a temporary password for the specified Customer.
     *
     * @see http://manage.resellerclub.com/kb/answer/1648
     *
     * @param $customerId integer Customer ID
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function generateTemporaryPassword($customerId)
    {
        $customerDetails['customer-id'] = $customerId;
        $this->defaultValidate($customerDetails);

        return $this->callApi(METHOD_POST, 'customers', 'temp-password', $customerDetails);
    }

    /**
     * Gets details of the Customers that match the Search criteria.
     *
     * @see http://manage.resellerclub.com/kb/answer/1270
     *
     * @param $customerDetails array Details of customer. See reference.
     * @param int $page  page number
     * @param int $count number of records to fetch
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function searchCustomer($customerDetails, $count = 10, $page = 1)
    {
        $customerDetails['no-of-records'] = $count;
        $customerDetails['page-no'] = $page;
        $this->defaultValidate($customerDetails);

        return $this->callApi(METHOD_GET, 'customers', 'search', $customerDetails);
    }

    /**
     * Generates a forgot password email and sends it to the customer's email address.
     *
     * @see http://manage.resellerclub.com/kb/answer/2410
     *
     * @param $userName string Username
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function forgotPassword($userName)
    {
        $customerDetails['forgot-password'] = $userName;
        $this->defaultValidate($customerDetails);

        return $this->callApi(METHOD_POST, 'customers', 'forgot-password', $customerDetails);
    }

    /**
     * Deletes the specified Customer, if the Customer does not have any Active Order(s).
     *
     * @see http://manage.resellerclub.com/kb/answer/886
     *
     * @param $customerId integer Customer Id
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function deleteCustomer($customerId)
    {
        $customerDetails['customer-id'] = $customerId;
        $this->defaultValidate($customerDetails);

        return $this->callApi(METHOD_POST, 'customers', 'delete', $customerDetails);
    }
}
