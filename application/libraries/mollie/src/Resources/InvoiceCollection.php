<?php

declare(strict_types=1);

namespace Mollie\Api\Resources;

class InvoiceCollection extends \Mollie\Api\Resources\CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return 'invoices';
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new \Mollie\Api\Resources\Invoice($this->client);
    }
}
