<?php

declare(strict_types=1);

namespace Mollie\Api\Resources;

class OrderLineCollection extends \Mollie\Api\Resources\BaseCollection
{
    /**
     * @return null|string
     */
    public function getCollectionResourceName()
    {
        return null;
    }

    /**
     * Get a specific order line.
     * Returns null if the order line cannot be found.
     *
     * @param string $lineId
     *
     * @return null|OrderLine
     */
    public function get($lineId)
    {
        foreach ($this as $line) {
            if ($line->id === $lineId) {
                return $line;
            }
        }

        return null;
    }
}
