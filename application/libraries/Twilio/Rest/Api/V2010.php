<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Api;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Rest\Api\V2010\AccountContext;
use Twilio\Rest\Api\V2010\AccountInstance;
use Twilio\Rest\Api\V2010\AccountList;
use Twilio\Version;

/**
 * @property AccountList $accounts
 *
 * @method \Twilio\Rest\Api\V2010\AccountContext accounts(string $sid)
 *
 * @property AccountContext                                                 $account
 * @property \Twilio\Rest\Api\V2010\Account\AddressList                     $addresses
 * @property \Twilio\Rest\Api\V2010\Account\ApplicationList                 $applications
 * @property \Twilio\Rest\Api\V2010\Account\AuthorizedConnectAppList        $authorizedConnectApps
 * @property \Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountryList $availablePhoneNumbers
 * @property \Twilio\Rest\Api\V2010\Account\BalanceList                     $balance
 * @property \Twilio\Rest\Api\V2010\Account\CallList                        $calls
 * @property \Twilio\Rest\Api\V2010\Account\ConferenceList                  $conferences
 * @property \Twilio\Rest\Api\V2010\Account\ConnectAppList                  $connectApps
 * @property \Twilio\Rest\Api\V2010\Account\IncomingPhoneNumberList         $incomingPhoneNumbers
 * @property \Twilio\Rest\Api\V2010\Account\KeyList                         $keys
 * @property \Twilio\Rest\Api\V2010\Account\MessageList                     $messages
 * @property \Twilio\Rest\Api\V2010\Account\NewKeyList                      $newKeys
 * @property \Twilio\Rest\Api\V2010\Account\NewSigningKeyList               $newSigningKeys
 * @property \Twilio\Rest\Api\V2010\Account\NotificationList                $notifications
 * @property \Twilio\Rest\Api\V2010\Account\OutgoingCallerIdList            $outgoingCallerIds
 * @property \Twilio\Rest\Api\V2010\Account\QueueList                       $queues
 * @property \Twilio\Rest\Api\V2010\Account\RecordingList                   $recordings
 * @property \Twilio\Rest\Api\V2010\Account\SigningKeyList                  $signingKeys
 * @property \Twilio\Rest\Api\V2010\Account\SipList                         $sip
 * @property \Twilio\Rest\Api\V2010\Account\ShortCodeList                   $shortCodes
 * @property \Twilio\Rest\Api\V2010\Account\TokenList                       $tokens
 * @property \Twilio\Rest\Api\V2010\Account\TranscriptionList               $transcriptions
 * @property \Twilio\Rest\Api\V2010\Account\UsageList                       $usage
 * @property \Twilio\Rest\Api\V2010\Account\ValidationRequestList           $validationRequests
 *
 * @method \Twilio\Rest\Api\V2010\Account\AddressContext                     addresses(string $sid)
 * @method \Twilio\Rest\Api\V2010\Account\ApplicationContext                 applications(string $sid)
 * @method \Twilio\Rest\Api\V2010\Account\AuthorizedConnectAppContext        authorizedConnectApps(string $connectAppSid)
 * @method \Twilio\Rest\Api\V2010\Account\AvailablePhoneNumberCountryContext availablePhoneNumbers(string $countryCode)
 * @method \Twilio\Rest\Api\V2010\Account\CallContext                        calls(string $sid)
 * @method \Twilio\Rest\Api\V2010\Account\ConferenceContext                  conferences(string $sid)
 * @method \Twilio\Rest\Api\V2010\Account\ConnectAppContext                  connectApps(string $sid)
 * @method \Twilio\Rest\Api\V2010\Account\IncomingPhoneNumberContext         incomingPhoneNumbers(string $sid)
 * @method \Twilio\Rest\Api\V2010\Account\KeyContext                         keys(string $sid)
 * @method \Twilio\Rest\Api\V2010\Account\MessageContext                     messages(string $sid)
 * @method \Twilio\Rest\Api\V2010\Account\NotificationContext                notifications(string $sid)
 * @method \Twilio\Rest\Api\V2010\Account\OutgoingCallerIdContext            outgoingCallerIds(string $sid)
 * @method \Twilio\Rest\Api\V2010\Account\QueueContext                       queues(string $sid)
 * @method \Twilio\Rest\Api\V2010\Account\RecordingContext                   recordings(string $sid)
 * @method \Twilio\Rest\Api\V2010\Account\SigningKeyContext                  signingKeys(string $sid)
 * @method \Twilio\Rest\Api\V2010\Account\ShortCodeContext                   shortCodes(string $sid)
 * @method \Twilio\Rest\Api\V2010\Account\TranscriptionContext               transcriptions(string $sid)
 */
class V2010 extends Version
{
    protected $_accounts;
    protected $_account;
    protected $_addresses;
    protected $_applications;
    protected $_authorizedConnectApps;
    protected $_availablePhoneNumbers;
    protected $_balance;
    protected $_calls;
    protected $_conferences;
    protected $_connectApps;
    protected $_incomingPhoneNumbers;
    protected $_keys;
    protected $_messages;
    protected $_newKeys;
    protected $_newSigningKeys;
    protected $_notifications;
    protected $_outgoingCallerIds;
    protected $_queues;
    protected $_recordings;
    protected $_signingKeys;
    protected $_sip;
    protected $_shortCodes;
    protected $_tokens;
    protected $_transcriptions;
    protected $_usage;
    protected $_validationRequests;

    /**
     * Construct the V2010 version of Api.
     *
     * @param Domain $domain Domain that contains the version
     */
    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
        $this->version = '2010-04-01';
    }

    /**
     * Magic getter to lazy load root resources.
     *
     * @param string $name Resource to return
     *
     * @throws TwilioException For unknown resource
     *
     * @return \Twilio\ListResource The requested resource
     */
    public function __get(string $name)
    {
        $method = 'get'.\ucfirst($name);
        if (\method_exists($this, $method)) {
            return $this->{$method}();
        }

        throw new TwilioException('Unknown resource '.$name);
    }

    /**
     * Magic caller to get resource contexts.
     *
     * @param string $name      Resource to return
     * @param array  $arguments Context parameters
     *
     * @throws TwilioException For unknown resource
     *
     * @return InstanceContext The requested resource context
     */
    public function __call(string $name, array $arguments): InstanceContext
    {
        $property = $this->{$name};
        if (\method_exists($property, 'getContext')) {
            return \call_user_func_array([$property, 'getContext'], $arguments);
        }

        throw new TwilioException('Resource does not have a context');
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        return '[Twilio.Api.V2010]';
    }

    /**
     * Setter to override the primary account.
     *
     * @param AccountContext|AccountInstance $account account to use as the primary
     *                                                account
     */
    public function setAccount($account): void
    {
        $this->_account = $account;
    }

    protected function getAccounts(): AccountList
    {
        if (!$this->_accounts) {
            $this->_accounts = new AccountList($this);
        }

        return $this->_accounts;
    }

    /**
     * @return AccountContext Account provided as the authenticating account
     */
    protected function getAccount(): AccountContext
    {
        if (!$this->_account) {
            $this->_account = new AccountContext(
                $this,
                $this->domain->getClient()->getAccountSid()
            );
        }

        return $this->_account;
    }

    protected function getAddresses(): V2010\Account\AddressList
    {
        return $this->account->addresses;
    }

    protected function getApplications(): V2010\Account\ApplicationList
    {
        return $this->account->applications;
    }

    protected function getAuthorizedConnectApps(): V2010\Account\AuthorizedConnectAppList
    {
        return $this->account->authorizedConnectApps;
    }

    protected function getAvailablePhoneNumbers(): V2010\Account\AvailablePhoneNumberCountryList
    {
        return $this->account->availablePhoneNumbers;
    }

    protected function getBalance(): V2010\Account\BalanceList
    {
        return $this->account->balance;
    }

    protected function getCalls(): V2010\Account\CallList
    {
        return $this->account->calls;
    }

    protected function getConferences(): V2010\Account\ConferenceList
    {
        return $this->account->conferences;
    }

    protected function getConnectApps(): V2010\Account\ConnectAppList
    {
        return $this->account->connectApps;
    }

    protected function getIncomingPhoneNumbers(): V2010\Account\IncomingPhoneNumberList
    {
        return $this->account->incomingPhoneNumbers;
    }

    protected function getKeys(): V2010\Account\KeyList
    {
        return $this->account->keys;
    }

    protected function getMessages(): V2010\Account\MessageList
    {
        return $this->account->messages;
    }

    protected function getNewKeys(): V2010\Account\NewKeyList
    {
        return $this->account->newKeys;
    }

    protected function getNewSigningKeys(): V2010\Account\NewSigningKeyList
    {
        return $this->account->newSigningKeys;
    }

    protected function getNotifications(): V2010\Account\NotificationList
    {
        return $this->account->notifications;
    }

    protected function getOutgoingCallerIds(): V2010\Account\OutgoingCallerIdList
    {
        return $this->account->outgoingCallerIds;
    }

    protected function getQueues(): V2010\Account\QueueList
    {
        return $this->account->queues;
    }

    protected function getRecordings(): V2010\Account\RecordingList
    {
        return $this->account->recordings;
    }

    protected function getSigningKeys(): V2010\Account\SigningKeyList
    {
        return $this->account->signingKeys;
    }

    protected function getSip(): V2010\Account\SipList
    {
        return $this->account->sip;
    }

    protected function getShortCodes(): V2010\Account\ShortCodeList
    {
        return $this->account->shortCodes;
    }

    protected function getTokens(): V2010\Account\TokenList
    {
        return $this->account->tokens;
    }

    protected function getTranscriptions(): V2010\Account\TranscriptionList
    {
        return $this->account->transcriptions;
    }

    protected function getUsage(): V2010\Account\UsageList
    {
        return $this->account->usage;
    }

    protected function getValidationRequests(): V2010\Account\ValidationRequestList
    {
        return $this->account->validationRequests;
    }
}
