<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class EventTest extends TestCase
{
    public const TEST_RESOURCE_ID = 'evt_123';

    public function testIsListable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/events'
        );
        $resources = Event::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertInstanceOf('Stripe\\Event', $resources->data[0]);
    }

    public function testIsRetrievable(): void
    {
        $this->expectsRequest(
            'get',
            '/v1/events/'.self::TEST_RESOURCE_ID
        );
        $resource = Event::retrieve(self::TEST_RESOURCE_ID);
        $this->assertInstanceOf('Stripe\\Event', $resource);
    }
}
