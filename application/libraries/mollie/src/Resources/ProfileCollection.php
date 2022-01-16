<?php

declare(strict_types=1);

namespace Mollie\Api\Resources;

class ProfileCollection extends \Mollie\Api\Resources\CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return 'profiles';
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new \Mollie\Api\Resources\Profile($this->client);
    }
}
