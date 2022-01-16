<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Whoisxmlapi extends MX_Controller
{
    private $key;

    public function __construct()
    {
        parent::__construct();
        User::logged_in();

        $this->load->model(['App']);
        $this->key = config_item('whoisxmlapi_key');
    }

    public function check_domain($sld, $tld)
    {
        $domain = $sld.'.'.$tld;

        $url = 'https://domain-availability-api.whoisxmlapi.com/api/v1?apiKey='.$this->key.'&domainName='.$domain.'&mode=DNS_AND_WHOIS';
        $res = json_decode(file_get_contents($url), true);

        if ($res['DomainInfo']['domainName'] == $domain && 'UNAVAILABLE' == $res['DomainInfo']['domainAvailability']) {
            return 0;
        }

        if ($res['DomainInfo']['domainName'] == $domain && 'AVAILABLE' == $res['DomainInfo']['domainAvailability']) {
            return 1;
        }
    }
}

// End of file
