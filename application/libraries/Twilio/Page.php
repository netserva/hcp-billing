<?php

declare(strict_types=1);

namespace Twilio;

use Twilio\Exceptions\DeserializeException;
use Twilio\Exceptions\RestException;
use Twilio\Http\Response;

abstract class Page implements \Iterator
{
    protected static $metaKeys = [
        'end',
        'first_page_uri',
        'next_page_uri',
        'last_page_uri',
        'page',
        'page_size',
        'previous_page_uri',
        'total',
        'num_pages',
        'start',
        'uri',
    ];

    protected $version;
    protected $payload;
    protected $solution;
    protected $records;

    public function __construct(Version $version, Response $response)
    {
        $payload = $this->processResponse($response);

        $this->version = $version;
        $this->payload = $payload;
        $this->solution = [];
        $this->records = new \ArrayIterator($this->loadPage());
    }

    public function __toString(): string
    {
        return '[Page]';
    }

    abstract public function buildInstance(array $payload);

    public function getPreviousPageUrl(): ?string
    {
        if ($this->hasMeta('previous_page_url')) {
            return $this->getMeta('previous_page_url');
        }
        if (\array_key_exists('previous_page_uri', $this->payload) && $this->payload['previous_page_uri']) {
            return $this->getVersion()->getDomain()->absoluteUrl($this->payload['previous_page_uri']);
        }

        return null;
    }

    public function getNextPageUrl(): ?string
    {
        if ($this->hasMeta('next_page_url')) {
            return $this->getMeta('next_page_url');
        }
        if (\array_key_exists('next_page_uri', $this->payload) && $this->payload['next_page_uri']) {
            return $this->getVersion()->getDomain()->absoluteUrl($this->payload['next_page_uri']);
        }

        return null;
    }

    public function nextPage(): ?Page
    {
        if (!$this->getNextPageUrl()) {
            return null;
        }

        $response = $this->getVersion()->getDomain()->getClient()->request('GET', $this->getNextPageUrl());

        return new static($this->getVersion(), $response, $this->solution);
    }

    public function previousPage(): ?Page
    {
        if (!$this->getPreviousPageUrl()) {
            return null;
        }

        $response = $this->getVersion()->getDomain()->getClient()->request('GET', $this->getPreviousPageUrl());

        return new static($this->getVersion(), $response, $this->solution);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element.
     *
     * @see http://php.net/manual/en/iterator.current.php
     *
     * @return mixed can return any type
     */
    public function current()
    {
        return $this->buildInstance($this->records->current());
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element.
     *
     * @see http://php.net/manual/en/iterator.next.php
     */
    public function next(): void
    {
        $this->records->next();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element.
     *
     * @see http://php.net/manual/en/iterator.key.php
     *
     * @return mixed scalar on success, or null on failure
     */
    public function key()
    {
        return $this->records->key();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid.
     *
     * @see http://php.net/manual/en/iterator.valid.php
     *
     * @return bool The return value will be casted to boolean and then evaluated.
     *              Returns true on success or false on failure.
     */
    public function valid(): bool
    {
        return $this->records->valid();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element.
     *
     * @see http://php.net/manual/en/iterator.rewind.php
     */
    public function rewind(): void
    {
        $this->records->rewind();
    }

    public function getVersion(): Version
    {
        return $this->version;
    }

    protected function processResponse(Response $response)
    {
        if (200 !== $response->getStatusCode() && !$this->isPagingEol($response->getContent())) {
            $message = '[HTTP '.$response->getStatusCode().'] Unable to fetch page';
            $code = $response->getStatusCode();

            $content = $response->getContent();
            $details = [];
            $moreInfo = '';

            if (\is_array($content)) {
                $message .= isset($content['message']) ? ': '.$content['message'] : '';
                $code = $content['code'] ?? $code;
                $moreInfo = $content['more_info'] ?? '';
                $details = $content['details'] ?? [];
            }

            throw new RestException($message, $code, $response->getStatusCode(), $moreInfo, $details);
        }

        return $response->getContent();
    }

    protected function isPagingEol(?array $content): bool
    {
        return null !== $content && \array_key_exists('code', $content) && 20006 === $content['code'];
    }

    protected function hasMeta(string $key): bool
    {
        return \array_key_exists('meta', $this->payload) && \array_key_exists($key, $this->payload['meta']);
    }

    protected function getMeta(string $key, string $default = null): ?string
    {
        return $this->hasMeta($key) ? $this->payload['meta'][$key] : $default;
    }

    protected function loadPage(): array
    {
        $key = $this->getMeta('key');
        if ($key) {
            return $this->payload[$key];
        }

        $keys = \array_keys($this->payload);
        $key = \array_diff($keys, self::$metaKeys);
        $key = \array_values($key);

        if (1 === \count($key)) {
            return $this->payload[$key[0]];
        }

        // handle end of results error code
        if ($this->isPagingEol($this->payload)) {
            return [];
        }

        throw new DeserializeException('Page Records can not be deserialized');
    }
}
