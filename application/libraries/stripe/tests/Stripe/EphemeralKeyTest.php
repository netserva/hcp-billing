<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class EphemeralKeyTest extends TestCase
{
    public function testIsCreatable(): void
    {
        $this->expectsRequest(
            'post',
            '/v1/ephemeral_keys',
            null,
            ['Stripe-Version: 2017-05-25']
        );
        $resource = EphemeralKey::create([
            'customer' => 'cus_123',
        ], ['stripe_version' => '2017-05-25']);
        $this->assertInstanceOf('Stripe\\EphemeralKey', $resource);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testIsNotCreatableWithoutAnExplicitApiVersion(): void
    {
        $resource = EphemeralKey::create([
            'customer' => 'cus_123',
        ]);
    }

    public function testIsDeletable(): void
    {
        $key = EphemeralKey::create([
            'customer' => 'cus_123',
        ], ['stripe_version' => '2017-05-25']);
        $this->expectsRequest(
            'delete',
            '/v1/ephemeral_keys/'.$key->id
        );
        $resource = $key->delete();
        $this->assertInstanceOf('Stripe\\EphemeralKey', $resource);
    }
}
