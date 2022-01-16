<?php

declare(strict_types=1);

namespace Mollie\Api\Endpoints;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Resources\Profile;
use Mollie\Api\Resources\ProfileCollection;

class ProfileEndpoint extends \Mollie\Api\Endpoints\CollectionEndpointAbstract
{
    protected $resourcePath = 'profiles';
    protected $resourceClass = \Mollie\Api\Resources\Profile::class;

    /**
     * Creates a Profile in Mollie.
     *
     * @param array $data an array containing details on the profile
     *
     * @throws ApiException
     *
     * @return \Mollie\Api\Resources\BaseResource|\Mollie\Api\Resources\Profile
     */
    public function create(array $data = [], array $filters = [])
    {
        return $this->rest_create($data, $filters);
    }

    /**
     * Retrieve a Profile from Mollie.
     *
     * Will throw an ApiException if the profile id is invalid or the resource cannot be found.
     *
     * @param string $profileId
     *
     * @throws ApiException
     *
     * @return \Mollie\Api\Resources\BaseResource|\Mollie\Api\Resources\Profile
     */
    public function get($profileId, array $parameters = [])
    {
        if ('me' === $profileId) {
            return $this->getCurrent($parameters);
        }

        return $this->rest_read($profileId, $parameters);
    }

    /**
     * Retrieve the current Profile from Mollie.
     *
     * @throws ApiException
     *
     * @return \Mollie\Api\Resources\BaseResource|\Mollie\Api\Resources\CurrentProfile
     */
    public function getCurrent(array $parameters = [])
    {
        $this->resourceClass = \Mollie\Api\Resources\CurrentProfile::class;

        return $this->rest_read('me', $parameters);
    }

    /**
     * Delete a Profile from Mollie.
     *
     * Will throw a ApiException if the profile id is invalid or the resource cannot be found.
     * Returns with HTTP status No Content (204) if successful.
     *
     * @param string $profileId
     *
     * @throws ApiException
     *
     * @return \Mollie\Api\Resources\BaseResource|\Mollie\Api\Resources\Profile
     */
    public function delete($profileId, array $data = [])
    {
        return $this->rest_delete($profileId, $data);
    }

    /**
     * Retrieves a collection of Profiles from Mollie.
     *
     * @param string $from  the first profile ID you want to include in your list
     * @param int    $limit
     *
     * @throws ApiException
     *
     * @return \Mollie\Api\Resources\BaseCollection|\Mollie\Api\Resources\ProfileCollection
     */
    public function page($from = null, $limit = null, array $parameters = [])
    {
        return $this->rest_list($from, $limit, $parameters);
    }

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one type of object.
     *
     * @return Profile
     */
    protected function getResourceObject()
    {
        return new $this->resourceClass($this->client);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API endpoint uses one type of collection object.
     *
     * @param int       $count
     * @param \stdClass $_links
     *
     * @return ProfileCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new \Mollie\Api\Resources\ProfileCollection($this->client, $count, $_links);
    }
}
