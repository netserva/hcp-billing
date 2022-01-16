<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class AccountTest extends TestCase
{
    public const TEST_RESOURCE_ID = 'acct_123';
    public const TEST_EXTERNALACCOUNT_ID = 'ba_123';

    public function testIsListable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/accounts'
        );
        $resources = Account::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\Account', $resources->data[0]);
    }

    public function testIsRetrievable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/accounts/'.self::TEST_RESOURCE_ID
        );
        $resource = Account::retrieve(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\Account', $resource);
    }

    public function testIsRetrievableWithoutId(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/account'
        );
        $resource = Account::retrieve();
        $this->assertInstanceOf('Stripe\\Account', $resource);
    }

    public function testIsCreatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/accounts'
        );
        $resource = Account::create(['type' => 'custom']);
        $this->assertInstanceOf('Stripe\\Account', $resource);
    }

    public function testIsSaveable(): void
    {
        $resource = Account::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/v1/accounts/'.self::TEST_RESOURCE_ID
        );
        $resource->save();
        $this->assertInstanceOf('Stripe\\Account', $resource);
    }

    public function testIsUpdatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/accounts/'.self::TEST_RESOURCE_ID
        );
        $resource = Account::update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        $this->assertInstanceOf('Stripe\\Account', $resource);
    }

    public function testIsDeletable(): void
    {
        $resource = Account::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'delete',
            '/v1/accounts/'.self::TEST_RESOURCE_ID
        );
        $resource->delete();
        $this->assertInstanceOf('Stripe\\Account', $resource);
    }

    public function testIsRejectable(): void
    {
        $account = Account::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/accounts/'.$account->id.'/reject'
        );
        $resource = $account->reject(['reason' => 'fraud']);
        $this->assertInstanceOf('Stripe\\Account', $resource);
        $this->assertSame($resource, $account);
    }

    public function testIsDeauthorizable(): void
    {
        $resource = Account::retrieve(self::TEST_RESOURCE_ID);
        $this->stubRequest(
            'post',
            '/oauth/deauthorize',
            [
                'client_id' => Stripe::getClientId(),
                'stripe_user_id' => $resource->id,
            ],
            null,
            false,
            [
                'stripe_user_id' => $resource->id,
            ],
            200,
            Stripe::$connectBase
        );
        $resource->deauthorize();
    }

    public function testCanCreateExternalAccount(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/accounts/'.self::TEST_RESOURCE_ID.'/external_accounts'
        );
        $resource = Account::createExternalAccount(self::TEST_RESOURCE_ID, ['external_account' => 'btok_123']);
        $this->assertInstanceOf('Stripe\\BankAccount', $resource);
    }

    public function testCanRetrieveExternalAccount(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/accounts/'.self::TEST_RESOURCE_ID.'/external_accounts/'.self::TEST_EXTERNALACCOUNT_ID
        );
        $resource = Account::retrieveExternalAccount(self::TEST_RESOURCE_ID, self::TEST_EXTERNALACCOUNT_ID);
        $this->assertInstanceOf('Stripe\\BankAccount', $resource);
    }

    public function testCanUpdateExternalAccount(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/accounts/'.self::TEST_RESOURCE_ID.'/external_accounts/'.self::TEST_EXTERNALACCOUNT_ID
        );
        $resource = Account::updateExternalAccount(self::TEST_RESOURCE_ID, self::TEST_EXTERNALACCOUNT_ID, ['name' => 'name']);
        $this->assertInstanceOf('Stripe\\BankAccount', $resource);
    }

    public function testCanDeleteExternalAccount(): void
    {
        $this->expectsRequest(
            'delete',
            '/v1/accounts/'.self::TEST_RESOURCE_ID.'/external_accounts/'.self::TEST_EXTERNALACCOUNT_ID
        );
        $resource = Account::deleteExternalAccount(self::TEST_RESOURCE_ID, self::TEST_EXTERNALACCOUNT_ID);
        $this->assertInstanceOf('Stripe\\BankAccount', $resource);
    }

    public function testCanListExternalAccounts(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/accounts/'.self::TEST_RESOURCE_ID.'/external_accounts'
        );
        $resources = Account::allExternalAccounts(self::TEST_RESOURCE_ID);
        $this->assertTrue(is_array($resources->data));
    }

    public function testCanCreateLoginLink(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/accounts/'.self::TEST_RESOURCE_ID.'/login_links'
        );
        $resource = Account::createLoginLink(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\LoginLink', $resource);
    }
}
