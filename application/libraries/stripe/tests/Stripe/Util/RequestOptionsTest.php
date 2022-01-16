<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class RequestOptionsTest extends TestCase
{
    public function testStringAPIKey(): void
    {
        $opts = Util\RequestOptions::parse('foo');
        $this->assertSame('foo', $opts->apiKey);
        $this->assertSame([], $opts->headers);
    }

    public function testNull(): void
    {
        $opts = Util\RequestOptions::parse(null);
        $this->assertSame(null, $opts->apiKey);
        $this->assertSame([], $opts->headers);
    }

    public function testEmptyArray(): void
    {
        $opts = Util\RequestOptions::parse([]);
        $this->assertSame(null, $opts->apiKey);
        $this->assertSame([], $opts->headers);
    }

    public function testAPIKeyArray(): void
    {
        $opts = Util\RequestOptions::parse(
            [
                'api_key' => 'foo',
            ]
        );
        $this->assertSame('foo', $opts->apiKey);
        $this->assertSame([], $opts->headers);
    }

    public function testIdempotentKeyArray(): void
    {
        $opts = Util\RequestOptions::parse(
            [
                'idempotency_key' => 'foo',
            ]
        );
        $this->assertSame(null, $opts->apiKey);
        $this->assertSame(['Idempotency-Key' => 'foo'], $opts->headers);
    }

    public function testKeyArray(): void
    {
        $opts = Util\RequestOptions::parse(
            [
                'idempotency_key' => 'foo',
                'api_key' => 'foo',
            ]
        );
        $this->assertSame('foo', $opts->apiKey);
        $this->assertSame(['Idempotency-Key' => 'foo'], $opts->headers);
    }

    /**
     * @expectedException \Stripe\Error\Api
     */
    public function testWrongType(): void
    {
        $opts = Util\RequestOptions::parse(5);
    }
}
