<?php

declare(strict_types=1);

namespace Mollie\Api\Endpoints;

use Mollie\Api\Resources\Method;
use Mollie\Api\Resources\MethodCollection;
use Mollie\Api\Resources\Profile;

class ProfileMethodEndpoint extends \Mollie\Api\Endpoints\CollectionEndpointAbstract
{
    protected $resourcePath = 'profiles_methods';

    /**
     * Enable a method for the provided Profile ID.
     *
     * @param $profileId
     * @param $methodId
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return \Mollie\Api\Resources\BaseResource
     */
    public function createForId($profileId, $methodId, array $data = [])
    {
        $this->parentId = $profileId;
        $resource = $this->getResourcePath().'/'.\urlencode($methodId);
        $body = null;
        if (\count($data) > 0) {
            $body = \json_encode($data);
        }
        $result = $this->client->performHttpCall(self::REST_CREATE, $resource, $body);

        return \Mollie\Api\Resources\ResourceFactory::createFromApiResult($result, new \Mollie\Api\Resources\Method($this->client));
    }

    /**
     * Enable a method for the provided Profile object.
     *
     * @param Profile $profile
     * @param string  $methodId
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return Method
     */
    public function createFor($profile, $methodId, array $data = [])
    {
        return $this->createForId($profile->id, $methodId, $data);
    }

    /**
     * Enable a method for the current profile.
     *
     * @param $methodId
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return \Mollie\Api\Resources\BaseResource
     */
    public function createForCurrentProfile($methodId, array $data = [])
    {
        return $this->createForId('me', $methodId, $data);
    }

    /**
     * Disable a method for the provided Profile ID.
     *
     * @param $profileId
     * @param $methodId
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return \Mollie\Api\Resources\BaseResource
     */
    public function deleteForId($profileId, $methodId, array $data = [])
    {
        $this->parentId = $profileId;

        return $this->rest_delete($methodId, $data);
    }

    /**
     * Disable a method for the provided Profile object.
     *
     * @param $profile
     * @param $methodId
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return \Mollie\Api\Resources\BaseResource
     */
    public function deleteFor($profile, $methodId, array $data = [])
    {
        return $this->deleteForId($profile->id, $methodId, $data);
    }

    /**
     * Disable a method for the current profile.
     *
     * @param $methodId
     *
     * @throws \Mollie\Api\Exceptions\ApiException
     *
     * @return \Mollie\Api\Resources\BaseResource
     */
    public function deleteForCurrentProfile($methodId, array $data)
    {
        return $this->deleteForId('me', $methodId, $data);
    }

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one type of object.
     *
     * @return Method
     */
    protected function getResourceObject()
    {
        return new \Mollie\Api\Resources\Method($this->client);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API endpoint uses one type of collection object.
     *
     * @param int       $count
     * @param \stdClass $_links
     *
     * @return MethodCollection()
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new \Mollie\Api\Resources\MethodCollection($count, $_links);
    }
}
