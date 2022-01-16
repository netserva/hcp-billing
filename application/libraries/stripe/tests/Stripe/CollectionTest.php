<?php

declare(strict_types=1);

namespace Stripe;

/**
 * @internal
 * @coversNothing
 */
class CollectionTest extends TestCase
{
    /**
     * @before
     */
    public function setUpFixture(): void
    {
        $this->fixture = Collection::constructFrom([
            'data' => [['id' => 1]],
            'has_more' => true,
            'url' => '/things',
        ], new Util\RequestOptions());
    }

    public function testCanList(): void
    {
        $this->stubRequest(
            'GET',
            '/things',
            [],
            null,
            false,
            [
                'data' => [['id' => 1]],
                'has_more' => true,
                'url' => '/things',
            ]
        );

        $resources = $this->fixture->all();
        $this->assertTrue(is_array($resources->data));
    }

    public function testCanRetrieve(): void
    {
        $this->stubRequest(
            'GET',
            '/things/1',
            [],
            null,
            false,
            [
                'id' => 1,
            ]
        );

        $this->fixture->retrieve(1);
    }

    public function testCanCreate(): void
    {
        $this->stubRequest(
            'POST',
            '/things',
            [
                'foo' => 'bar',
            ],
            null,
            false,
            [
                'id' => 2,
            ]
        );

        $this->fixture->create([
            'foo' => 'bar',
        ]);
    }

    public function testProvidesAutoPagingIterator(): void
    {
        $this->stubRequest(
            'GET',
            '/things',
            [
                'starting_after' => 1,
            ],
            null,
            false,
            [
                'data' => [['id' => 2], ['id' => 3]],
                'has_more' => false,
            ]
        );

        $seen = [];
        foreach ($this->fixture->autoPagingIterator() as $item) {
            array_push($seen, $item['id']);
        }

        $this->assertSame([1, 2, 3], $seen);
    }

    public function testSupportsIteratorToArray(): void
    {
        $this->stubRequest(
            'GET',
            '/things',
            [
                'starting_after' => 1,
            ],
            null,
            false,
            [
                'data' => [['id' => 2], ['id' => 3]],
                'has_more' => false,
            ]
        );

        $seen = [];
        foreach (iterator_to_array($this->fixture->autoPagingIterator()) as $item) {
            array_push($seen, $item['id']);
        }

        $this->assertSame([1, 2, 3], $seen);
    }
}
