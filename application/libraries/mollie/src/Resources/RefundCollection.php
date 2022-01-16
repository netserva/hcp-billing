<?php

declare(strict_types=1);

namespace Mollie\Api\Resources;

class RefundCollection extends \Mollie\Api\Resources\CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return 'refunds';
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new \Mollie\Api\Resources\Refund($this->client);
    }
}
