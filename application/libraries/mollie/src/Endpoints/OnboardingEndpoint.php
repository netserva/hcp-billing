<?php

declare(strict_types=1);

namespace Mollie\Api\Endpoints;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Resources\BaseResource;
use Mollie\Api\Resources\Onboarding;

class OnboardingEndpoint extends \Mollie\Api\Endpoints\EndpointAbstract
{
    protected $resourcePath = 'onboarding/me';

    /**
     * Retrieve the organization's onboarding status from Mollie.
     *
     * Will throw a ApiException if the resource cannot be found.
     *
     * @throws ApiException
     *
     * @return Onboarding
     */
    public function get()
    {
        return $this->rest_read('', []);
    }

    /**
     * Submit data that will be prefilled in the merchant’s onboarding.
     * Please note that the data you submit will only be processed when the onboarding status is needs-data.
     *
     * Information that the merchant has entered in their dashboard will not be overwritten.
     *
     * Will throw a ApiException if the resource cannot be found.
     *
     * @throws ApiException
     */
    public function submit(array $parameters = [])
    {
        return $this->rest_create($parameters, []);
    }

    protected function getResourceCollectionObject($count, $links): void
    {
        throw new \BadMethodCallException('not implemented');
    }

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one type of object.
     *
     * @return BaseResource
     */
    protected function getResourceObject()
    {
        return new \Mollie\Api\Resources\Onboarding($this->client);
    }

    protected function rest_read($id, array $filters)
    {
        $result = $this->client->performHttpCall(self::REST_READ, $this->getResourcePath().$this->buildQueryString($filters));

        return \Mollie\Api\Resources\ResourceFactory::createFromApiResult($result, $this->getResourceObject());
    }

    protected function rest_create(array $body, array $filters): void
    {
        $this->client->performHttpCall(self::REST_CREATE, $this->getResourcePath().$this->buildQueryString($filters), $this->parseRequestBody($body));
    }
}
