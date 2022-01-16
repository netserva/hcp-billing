<?php

declare(strict_types=1);

namespace Resellerclub;

require_once __DIR__.'/../core/Core.php';

/**
 * Contains domain related API calls.
 */
class Domain extends Core
{
    /**
     * Checks the availability of the specified domain name(s).
     *
     * @see http://manage.resellerclub.com/kb/answer/764
     *
     * @param $domainName mixed Domain names, without tlds - array or string
     * @param $tlds mixed TLDs, array or string
     * @param bool $suggestAlternatives TRUE if domain name suggestions is needed
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function checkAvailability($domainName, $tlds, $suggestAlternatives = false)
    {
        $avail = [
            'domain-name' => $domainName,
            'tlds' => $tlds,
            'suggest-alternative' => $suggestAlternatives,
        ];
        $this->defaultValidate($avail);

        return $this->callApi(METHOD_GET, 'domains', 'available', $avail);
    }

    /**
     * Checks the availability of Internationalized Domain Name(s) (IDN).
     *
     * @see http://manage.resellerclub.com/kb/answer/1427
     *
     * @param $domainName mixed Domain name in unicode as array or string
     * @param $tld mixed TLDs as array or string
     * @param $idnLanguageCode string IDN language code
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function checkAvailabilityIdn($domainName, $tld, $idnLanguageCode)
    {
        $punyDomain = [];
        if (is_array($domainName)) {
            foreach ($domainName as $domain) {
                // Convert domain to puny code so that it can be
                // handled in ASCII itself
                $punyDomain[] = idn_to_ascii($domain, IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
            }
        } else {
            $punyDomain[] = idn_to_ascii($domainName, IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
        }
        $avail = [
            'domain-name' => $punyDomain,
            'tlds' => $tld,
            'idn-languagecode' => $idnLanguageCode,
        ];
        $this->defaultValidate($avail);

        return $this->callApi(METHOD_GET, 'domains', 'idn-available', $avail);
    }

    /**
     * Check availability of a premium domain name.
     *
     * @see http://manage.resellerclub.com/kb/answer/1948
     *
     * @param $keyWord string Keyword to search for
     * @param $tlds mixed Array or String of TLD(s)
     * @param $options array See references
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function checkAvailabilityPremium($keyWord, $tlds, $options)
    {
        $options['key-word'] = $keyWord;
        $options['tlds'] = $tlds;
        $this->defaultValidate($options);

        return $this->callApi(METHOD_GET, 'domains', 'available', $options, 'premium');
    }

    /**
     * Returns domain name suggestions for a user-specified keyword.
     *
     * @see http://manage.resellerclub.com/kb/answer/1085
     *
     * @param $keyWord string Search keywords
     * @param null $tld        limit search to given TLDs
     * @param bool $exactMatch FALSE if we don't want exact match
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function domainSuggestions($keyWord, $tld = null, $exactMatch = false)
    {
        $options = [];
        $options['keyword'] = $keyWord;
        $options['tld-only'] = $tld;
        $options['exact-match'] = $exactMatch;
        $this->defaultValidate($options);

        return $this->callApi(METHOD_GET, 'domains', 'suggest-names', $options, 'v5');
    }

    /**
     * Register a domain name.
     *
     * @see http://manage.resellerclub.com/kb/answer/752
     *
     * @param $domainName string Domain name
     * @param $options array Options, see reference
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function register($domainName, $options)
    {
        $options['domain-name'] = $domainName;
        $this->defaultValidate($options);

        return $this->callApi(METHOD_POST, 'domains', 'register', $options);
    }

    /**
     * Transfer a domain name.
     *
     * @see http://manage.resellerclub.com/kb/answer/758
     *
     * @param $domain string Domain name
     * @param $options array Options, see references
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function transfer($domain, $options)
    {
        $options['domain'] = $domain;
        $this->defaultValidate($options);

        return $this->callApi(METHOD_POST, 'domains', 'transfer', $options);
    }

    /**
     * Submit auth code for domain transfer.
     *
     * @see http://manage.resellerclub.com/kb/answer/2447
     *
     * @param $orderId integer Order Id
     * @param $authCode string Auth code from previous registrar
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function submitAuthCode($orderId, $authCode)
    {
        $options = [
            'order-id' => $orderId,
            'auth-code' => $authCode,
        ];
        $this->defaultValidate($options);

        return $this->callApi(METHOD_POST, 'domains', 'submit-auth-code', $options, 'transfer');
    }

    /**
     * Validate a transfer request.
     *
     * @see http://manage.resellerclub.com/kb/answer/1150
     *
     * @param $domain string Domain name
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function validateTransfer($domain)
    {
        $options = [
            'domain-name' => $domain,
        ];
        $this->defaultValidate($options);

        return $this->callApi(METHOD_GET, 'domains', 'validate-transfer', $options);
    }

    /**
     * Renew a domain.
     *
     * @see http://manage.resellerclub.com/kb/answer/746
     *
     * @param $orderid integer Order Id
     * @param $options array Options. See reference.
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function renew($orderid, $options)
    {
        $options['order-id'] = $orderid;
        $this->defaultValidate($options);

        return $this->callApi(METHOD_POST, 'domains', 'renew', $options);
    }

    /**
     * Search a domain.
     *
     * @see http://manage.resellerclub.com/kb/answer/771
     *
     * @param $options array Search options. See reference.
     * @param int $page  page number
     * @param int $count number of records to fetch
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function searchDomain($options, $page = 1, $count = 10)
    {
        $options['no-of-records'] = $count;
        $options['page-no'] = $page;
        $this->defaultValidate($options);

        return $this->callApi(METHOD_GET, 'domains', 'search', $options);
    }

    /**
     * Get the default nameserver for a domain.
     *
     * @see http://manage.resellerclub.com/kb/answer/788
     *
     * @param $customerId integer Customer ID
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function getDefaultNameServer($customerId)
    {
        $options = [
            'customer-id' => $customerId,
        ];
        $this->defaultValidate($options);

        return $this->callApi(METHOD_GET, 'domains', 'customer-default-ns', $options);
    }

    /**
     * Get order ID from domain name.
     *
     * @see http://manage.resellerclub.com/kb/answer/763
     *
     * @param $domain string Domain name
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function getOrderId($domain)
    {
        $options = [
            'domain' => $domain,
        ];
        $this->defaultValidate($options);

        return $this->callApi(METHOD_GET, 'domains', 'orderid', $options);
    }

    /**
     * Get details of domain by order ID.
     *
     * @see http://manage.resellerclub.com/kb/answer/770
     *
     * @param $orderId integer Order ID
     * @param $options string Options. See references.
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function getDomainDetailsByOrderId($orderId, $options)
    {
        // Since a parameter name is options, we are using variable as apiOptions
        $apiOptions = [
            'order-id' => $orderId,
        ];
        if (is_string($options)) {
            $apiOptions['options'] = $options;
        }
        $this->defaultValidate($apiOptions);

        return $this->callApi(METHOD_GET, 'domains', 'details', $apiOptions);
    }

    /**
     * Get details of domain by domain name.
     *
     * @see http://manage.resellerclub.com/kb/answer/1755
     *
     * @param $domain string Domain name
     * @param $options string See references for possible values
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API options
     */
    public function getDomainDetailsByDomain($domain, $options)
    {
        // Since a parameter name is options, we are using variable as apiOptions
        $apiOptions = [
            'domain-name' => $domain,
        ];
        if (is_string($options)) {
            $apiOptions['options'] = $options;
        }
        $this->defaultValidate($apiOptions);

        return $this->callApi(METHOD_GET, 'domains', 'details-by-name', $apiOptions);
    }

    /**
     * Set nameserver for an order.
     *
     * @see http://manage.resellerclub.com/kb/answer/776
     *
     * @param $orderId integer Order Id
     * @param $ns array Nameservers to set
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function setNameServer($orderId, $ns)
    {
        $options = [
            'order-id' => $orderId,
            'ns' => $ns,
        ];
        $this->defaultValidate($options);

        return $this->callApi(METHOD_POST, 'domains', 'modify-ns', $options);
    }

    /**
     * Set child name server for a domain.
     *
     * @see http://manage.resellerclub.com/kb/answer/780
     *
     * @param $orderId integer Order ID
     * @param $cns string Child Nameserver
     * @param $ips array IP addresses
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function setChildNameServer($orderId, $cns, $ips)
    {
        $options = [
            'order-id' => $orderId,
            'cns' => $cns,
            'ip' => $ips,
        ];

        return $this->callApi(METHOD_POST, 'domains', 'add-cns', $options);
    }

    /**
     * Modify Child nameserver host of a domain.
     *
     * @see http://manage.resellerclub.com/kb/answer/781
     *
     * @param $orderId integer Order ID
     * @param $oldCns string Old child nameserver
     * @param $newCns string New child nameserver
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function modifyChildNameServerHost($orderId, $oldCns, $newCns)
    {
        $options = [
            'order-id' => $orderId,
            'old-cns' => $oldCns,
            'new-cns' => $newCns,
        ];
        $this->defaultValidate($options);

        return $this->callApi(METHOD_POST, 'domains', 'modify-cns-name', $options);
    }

    /**
     * Modify a child name server's IP address.
     *
     * @see http://manage.resellerclub.com/kb/answer/782
     *
     * @param $orderId integer Order ID
     * @param $cns string Child name server to modify
     * @param $oldIp string Old IP address
     * @param $newIp string New IP address
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function modifyChildNameServerIp($orderId, $cns, $oldIp, $newIp)
    {
        $options = [
            'order-id' => $orderId,
            'cns' => $cns,
            'old-ip' => $oldIp,
            'new-ip' => $newIp,
        ];
        $this->defaultValidate($options);

        return $this->callApi(METHOD_POST, 'domains', 'modify-cns-ip', $options);
    }

    /**
     * Delete a child name server.
     *
     * @see http://manage.resellerclub.com/kb/answer/934
     *
     * @param $orderId integer Order ID
     * @param $cns string Child Nameserver
     * @param $ip string IP address
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function deleteChildNameServer($orderId, $cns, $ip)
    {
        $options = [
            'order-id' => $orderId,
            'cns' => $cns,
            'ip' => $ip,
        ];
        $this->defaultValidate($options);

        return $this->callApi(METHOD_POST, 'domains', 'delete-cns-ip', $options);
    }

    /**
     * Modify contacts of a domain name.
     *
     * @see http://manage.resellerclub.com/kb/answer/777
     *
     * @param $orderId int Order ID
     * @param $contactIds array Contact IDs in array, all are mandatory see reference
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function modifyDomainContacts($orderId, $contactIds)
    {
        $options = $contactIds;
        $options['order-id'] = $orderId;
        $this->defaultValidate($options);

        return $this->callApi(METHOD_POST, 'domains', 'modify-contact', $options);
    }

    /**
     * Add privacy protection for a domain.
     *
     * @see http://manage.resellerclub.com/kb/answer/2085
     *
     * @param $orderId integer Order ID
     * @param $invoiceOption string See references for allowed options
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function addPrivacyProtection($orderId, $invoiceOption)
    {
        $options = [
            'order-id' => $orderId,
            'invoice-option' => $invoiceOption,
        ];
        $this->defaultValidate($options);

        return $this->callApi(METHOD_POST, 'domains', 'purchase-privacy', $options);
    }

    /**
     * Modify privacy protection for an order.
     *
     * @see http://manage.resellerclub.com/kb/answer/778
     *
     * @param $orderId integer Order ID
     * @param $protectPrivacy boolean TRUE to enable privacy, else FALSE
     * @param $reason string Reason for change
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function modifyPrivacyProtection($orderId, $protectPrivacy, $reason)
    {
        $options = [
            'order-id' => $orderId,
            'protect-privacy' => $protectPrivacy,
            'reason' => $reason,
        ];
        $this->defaultValidate($options);

        return $this->callApi(METHOD_POST, 'domains', 'modify-privacy-protection', $options);
    }

    /**
     * Modify domain transfer Auth code.
     *
     * @see http://manage.resellerclub.com/kb/answer/779
     *
     * @param $orderId integer Order ID
     * @param $authCode string Auth Code for domain transfer
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function modifyAuthCode($orderId, $authCode)
    {
        $options = [
            'order-id' => $orderId,
            'auth-code' => $authCode,
        ];
        $this->defaultValidate($options);

        return $this->callApi(METHOD_POST, 'domains', 'modify-auth-code', $options);
    }

    /**
     * Modify theft protection status.
     *
     * @see http://manage.resellerclub.com/kb/answer/902
     * @see http://manage.resellerclub.com/kb/answer/903
     *
     * @param $orderId integer Order ID
     * @param $status boolean TRUE to enable theft protection, else FALSE
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function modifyTheftProtection($orderId, $status)
    {
        // Involves 2 API calls
        $options = [
            'order-id' => $orderId,
        ];
        $this->defaultValidate($options);
        $apiCall = $status ? 'enable-theft-protection' : 'disable-theft-protection';

        return $this->callApi(METHOD_POST, 'domains', $apiCall, $options);
    }

    /**
     * Suspend a domain.
     *
     * @see http://manage.resellerclub.com/kb/answer/1451
     *
     * @param $orderId integer Order ID
     * @param $reason string Reason for transfer
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API options
     */
    public function suspendDomain($orderId, $reason)
    {
        $options = [
            'order-id' => $orderId,
            'reason' => $reason,
        ];
        $this->defaultValidate($options);

        return $this->callApi(METHOD_POST, 'orders', 'suspend', $options);
    }

    /**
     * Unsuspend a domain.
     *
     * @see http://manage.resellerclub.com/kb/answer/1452
     *
     * @param $orderId integer Order ID to suspend
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function unsuspendDomain($orderId)
    {
        $options = [
            'order-id' => $orderId,
        ];
        $this->defaultValidate($options);

        return $this->callApi(METHOD_POST, 'orders', 'unsuspend', $options);
    }

    /**
     * Delete a domain.
     *
     * @see http://manage.resellerclub.com/kb/answer/745
     *
     * @param $orderId integer OrderID for domain to delete
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function deleteDomain($orderId)
    {
        $options = [
            'order-id' => $orderId,
        ];
        $this->defaultValidate($options);

        return $this->callApi(METHOD_POST, 'domains', 'delete', $options);
    }

    /**
     * Restore a domain.
     *
     * @see http://manage.resellerclub.com/kb/answer/760
     *
     * @param $orderId integer Order ID
     * @param $invoiceOption string See reference for allowed options
     *
     * @throws \Resellerclub\ApiConnectionException
     *
     * @return array API output
     */
    public function restoreDomain($orderId, $invoiceOption)
    {
        $options = [
            'order-id' => $orderId,
            'invoice-option' => $invoiceOption,
        ];
        $this->defaultValidate($options);

        return $this->callApi(METHOD_POST, 'domains', 'restore', $options);
    }
}
