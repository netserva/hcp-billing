<?php

declare(strict_types=1);

namespace Stripe\Service;

/**
 * Abstract base class for all services.
 */
abstract class AbstractService
{
    /**
     * @var \Stripe\StripeClientInterface
     */
    protected $client;

    /**
     * Initializes a new instance of the {@link AbstractService} class.
     *
     * @param \Stripe\StripeClientInterface $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Gets the client used by this service to send requests.
     *
     * @return \Stripe\StripeClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    protected function request($method, $path, $params, $opts)
    {
        return $this->getClient()->request($method, $path, static::formatParams($params), $opts);
    }

    protected function requestCollection($method, $path, $params, $opts)
    {
        return $this->getClient()->requestCollection($method, $path, static::formatParams($params), $opts);
    }

    protected function buildPath($basePath, ...$ids)
    {
        foreach ($ids as $id) {
            if (null === $id || '' === \trim($id)) {
                $msg = 'The resource ID cannot be null or whitespace.';

                throw new \Stripe\Exception\InvalidArgumentException($msg);
            }
        }

        return \sprintf($basePath, ...\array_map('\urlencode', $ids));
    }

    /**
     * Translate null values to empty strings. For service methods,
     * we interpret null as a request to unset the field, which
     * corresponds to sending an empty string for the field to the
     * API.
     *
     * @param null|array $params
     */
    private static function formatParams($params)
    {
        if (null === $params) {
            return null;
        }
        \array_walk_recursive($params, function (&$value, $key): void {
            if (null === $value) {
                $value = '';
            }
        });

        return $params;
    }
}
