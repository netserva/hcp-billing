<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class OAuthTest extends TestCase
{
    /**
     * @before
     */
    public function setUpClientId(): void
    {
        Stripe::setClientId('ca_test');
    }

    /**
     * @after
     */
    public function tearDownClientId(): void
    {
        Stripe::setClientId(null);
    }

    public function testAuthorizeUrl(): void
    {
        $uriStr = OAuth::authorizeUrl([
            'scope' => 'read_write',
            'state' => 'csrf_token',
            'stripe_user' => [
                'email' => 'test@example.com',
                'url' => 'https://example.com/profile/test',
                'country' => 'US',
            ],
        ]);

        $uri = parse_url($uriStr);
        parse_str($uri['query'], $params);

        $this->assertSame('https', $uri['scheme']);
        $this->assertSame('connect.stripe.com', $uri['host']);
        $this->assertSame('/oauth/authorize', $uri['path']);

        $this->assertSame('ca_test', $params['client_id']);
        $this->assertSame('read_write', $params['scope']);
        $this->assertSame('test@example.com', $params['stripe_user']['email']);
        $this->assertSame('https://example.com/profile/test', $params['stripe_user']['url']);
        $this->assertSame('US', $params['stripe_user']['country']);
    }

    public function testToken(): void
    {
        $this->stubRequest(
            'POST',
            '/oauth/token',
            [
                'grant_type' => 'authorization_code',
                'code' => 'this_is_an_authorization_code',
            ],
            null,
            false,
            [
                'access_token' => 'sk_access_token',
                'scope' => 'read_only',
                'livemode' => false,
                'token_type' => 'bearer',
                'refresh_token' => 'sk_refresh_token',
                'stripe_user_id' => 'acct_test',
                'stripe_publishable_key' => 'pk_test',
            ],
            200,
            Stripe::$connectBase
        );

        $resp = OAuth::token([
            'grant_type' => 'authorization_code',
            'code' => 'this_is_an_authorization_code',
        ]);
        $this->assertSame('sk_access_token', $resp->access_token);
    }

    public function testDeauthorize(): void
    {
        $this->stubRequest(
            'POST',
            '/oauth/deauthorize',
            [
                'stripe_user_id' => 'acct_test_deauth',
                'client_id' => 'ca_test',
            ],
            null,
            false,
            [
                'stripe_user_id' => 'acct_test_deauth',
            ],
            200,
            Stripe::$connectBase
        );

        $resp = OAuth::deauthorize([
            'stripe_user_id' => 'acct_test_deauth',
        ]);
        $this->assertSame('acct_test_deauth', $resp->stripe_user_id);
    }
}
