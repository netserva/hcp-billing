<?php

declare(strict_types=1);

namespace Mollie\Api\Resources;

class PermissionCollection extends \Mollie\Api\Resources\BaseCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return 'permissions';
    }
}
