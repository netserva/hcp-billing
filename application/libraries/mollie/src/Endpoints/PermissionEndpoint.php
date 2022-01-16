<?php

declare(strict_types=1);

namespace Mollie\Api\Endpoints;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Resources\Permission;
use Mollie\Api\Resources\PermissionCollection;

class PermissionEndpoint extends \Mollie\Api\Endpoints\CollectionEndpointAbstract
{
    protected $resourcePath = 'permissions';

    /**
     * Retrieve a single Permission from Mollie.
     *
     * Will throw an ApiException if the permission id is invalid.
     *
     * @param string $permissionId
     *
     * @throws ApiException
     *
     * @return Permission
     */
    public function get($permissionId, array $parameters = [])
    {
        return $this->rest_read($permissionId, $parameters);
    }

    /**
     * Retrieve all permissions.
     *
     * @throws ApiException
     *
     * @return PermissionCollection
     */
    public function all(array $parameters = [])
    {
        return parent::rest_list(null, null, $parameters);
    }

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one
     * type of object.
     *
     * @return Permission
     */
    protected function getResourceObject()
    {
        return new \Mollie\Api\Resources\Permission($this->client);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API
     * endpoint uses one type of collection object.
     *
     * @param int       $count
     * @param \stdClass $_links
     *
     * @return PermissionCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new \Mollie\Api\Resources\PermissionCollection($count, $_links);
    }
}
