<?php

declare(strict_types=1);

namespace Mollie\Api\Resources;

class IssuerCollection extends \Mollie\Api\Resources\BaseCollection
{
    /**
     * @return null|string
     */
    public function getCollectionResourceName()
    {
        return null;
    }
}
