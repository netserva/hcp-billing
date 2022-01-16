<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class TokenTest extends TestCase
{
    public const TEST_RESOURCE_ID = 'tok_123';

    public function testIsRetrievable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/tokens/'.self::TEST_RESOURCE_ID
        );
        $resource = Token::retrieve(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\Token', $resource);
    }

    public function testIsCreatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/tokens'
        );
        $resource = Token::create(['card' => 'tok_visa']);
        $this->assertInstanceOf('Stripe\\Token', $resource);
    }
}
