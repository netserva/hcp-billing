<?php

declare(strict_types=1);

namespace Mollie\Api\Resources;

use Mollie\Api\Exceptions\ApiException;

class CurrentProfile extends \Mollie\Api\Resources\Profile
{
    /**
     * Enable a payment method for this profile.
     *
     * @param string $methodId
     *
     * @throws ApiException
     *
     * @return Method
     */
    public function enableMethod($methodId, array $data = [])
    {
        return $this->client->profileMethods->createForCurrentProfile($methodId, $data);
    }

    /**
     * Disable a payment method for this profile.
     *
     * @param string $methodId
     *
     * @throws ApiException
     *
     * @return Method
     */
    public function disableMethod($methodId, array $data = [])
    {
        return $this->client->profileMethods->deleteForCurrentProfile($methodId, $data);
    }
}
