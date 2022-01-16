<?php

declare(strict_types=1);

namespace Mollie\Api\Endpoints;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\MollieApiClient;
use Mollie\Api\Resources\BaseCollection;
use Mollie\Api\Resources\BaseResource;

abstract class EndpointAbstract
{
    public const REST_CREATE = \Mollie\Api\MollieApiClient::HTTP_POST;
    public const REST_UPDATE = \Mollie\Api\MollieApiClient::HTTP_PATCH;
    public const REST_READ = \Mollie\Api\MollieApiClient::HTTP_GET;
    public const REST_LIST = \Mollie\Api\MollieApiClient::HTTP_GET;
    public const REST_DELETE = \Mollie\Api\MollieApiClient::HTTP_DELETE;
    /**
     * @var MollieApiClient
     */
    protected $client;
    /**
     * @var string
     */
    protected $resourcePath;
    /**
     * @var null|string
     */
    protected $parentId;

    public function __construct(MollieApiClient $api)
    {
        $this->client = $api;
    }

    /**
     * @param string $resourcePath
     */
    public function setResourcePath($resourcePath): void
    {
        $this->resourcePath = \strtolower($resourcePath);
    }

    /**
     * @throws ApiException
     *
     * @return string
     */
    public function getResourcePath()
    {
        if (\false !== \strpos($this->resourcePath, '_')) {
            [$parentResource, $childResource] = \explode('_', $this->resourcePath, 2);
            if (empty($this->parentId)) {
                throw new \Mollie\Api\Exceptions\ApiException("Subresource '{$this->resourcePath}' used without parent '{$parentResource}' ID.");
            }

            return "{$parentResource}/{$this->parentId}/{$childResource}";
        }

        return $this->resourcePath;
    }

    /**
     * @return string
     */
    protected function buildQueryString(array $filters)
    {
        if (empty($filters)) {
            return '';
        }
        foreach ($filters as $key => $value) {
            if (\true === $value) {
                $filters[$key] = 'true';
            }
            if (\false === $value) {
                $filters[$key] = 'false';
            }
        }

        return '?'.\http_build_query($filters, '', '&');
    }

    /**
     * @throws ApiException
     *
     * @return BaseResource
     */
    protected function rest_create(array $body, array $filters)
    {
        $result = $this->client->performHttpCall(self::REST_CREATE, $this->getResourcePath().$this->buildQueryString($filters), $this->parseRequestBody($body));

        return \Mollie\Api\Resources\ResourceFactory::createFromApiResult($result, $this->getResourceObject());
    }

    /**
     * Retrieves a single object from the REST API.
     *
     * @param string $id id of the object to retrieve
     *
     * @throws ApiException
     *
     * @return BaseResource
     */
    protected function rest_read($id, array $filters)
    {
        if (empty($id)) {
            throw new \Mollie\Api\Exceptions\ApiException('Invalid resource id.');
        }
        $id = \urlencode($id);
        $result = $this->client->performHttpCall(self::REST_READ, "{$this->getResourcePath()}/{$id}".$this->buildQueryString($filters));

        return \Mollie\Api\Resources\ResourceFactory::createFromApiResult($result, $this->getResourceObject());
    }

    /**
     * Sends a DELETE request to a single Molle API object.
     *
     * @param string $id
     *
     * @throws ApiException
     *
     * @return BaseResource
     */
    protected function rest_delete($id, array $body = [])
    {
        if (empty($id)) {
            throw new \Mollie\Api\Exceptions\ApiException('Invalid resource id.');
        }
        $id = \urlencode($id);
        $result = $this->client->performHttpCall(self::REST_DELETE, "{$this->getResourcePath()}/{$id}", $this->parseRequestBody($body));
        if (null === $result) {
            return null;
        }

        return \Mollie\Api\Resources\ResourceFactory::createFromApiResult($result, $this->getResourceObject());
    }

    /**
     * Get a collection of objects from the REST API.
     *
     * @param string $from  the first resource ID you want to include in your list
     * @param int    $limit
     *
     * @throws ApiException
     *
     * @return BaseCollection
     */
    protected function rest_list($from = null, $limit = null, array $filters = [])
    {
        $filters = \array_merge(['from' => $from, 'limit' => $limit], $filters);
        $apiPath = $this->getResourcePath().$this->buildQueryString($filters);
        $result = $this->client->performHttpCall(self::REST_LIST, $apiPath);
        /** @var BaseCollection $collection */
        $collection = $this->getResourceCollectionObject($result->count, $result->_links);
        foreach ($result->_embedded->{$collection->getCollectionResourceName()} as $dataResult) {
            $collection[] = \Mollie\Api\Resources\ResourceFactory::createFromApiResult($dataResult, $this->getResourceObject());
        }

        return $collection;
    }

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one type of object.
     *
     * @return BaseResource
     */
    abstract protected function getResourceObject();

    /**
     * @throws ApiException
     *
     * @return null|string
     */
    protected function parseRequestBody(array $body)
    {
        if (empty($body)) {
            return null;
        }

        try {
            $encoded = \_PhpScoper5ed105407e8f2\GuzzleHttp\json_encode($body);
        } catch (\InvalidArgumentException $e) {
            throw new \Mollie\Api\Exceptions\ApiException("Error encoding parameters into JSON: '".$e->getMessage()."'.");
        }

        return $encoded;
    }
}
