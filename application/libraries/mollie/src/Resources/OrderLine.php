<?php

declare(strict_types=1);

namespace Mollie\Api\Resources;

class OrderLine extends \Mollie\Api\Resources\BaseResource
{
    /**
     * Always 'orderline'.
     *
     * @var string
     */
    public $resource;
    /**
     * Id of the order line.
     *
     * @var string
     */
    public $id;
    /**
     * The ID of the order this line belongs to.
     *
     * @example ord_kEn1PlbGa
     *
     * @var string
     */
    public $orderId;
    /**
     * The type of product bought.
     *
     * @example physical
     *
     * @var string
     */
    public $type;
    /**
     * A description of the order line.
     *
     * @example LEGO 4440 Forest Police Station
     *
     * @var string
     */
    public $name;
    /**
     * The status of the order line.
     *
     * @var string
     */
    public $status;
    /**
     * Can this order line be canceled?
     *
     * @var bool
     */
    public $isCancelable;
    /**
     * The number of items in the order line.
     *
     * @var int
     */
    public $quantity;
    /**
     * The price of a single item in the order line.
     *
     * @var \stdClass
     */
    public $unitPrice;
    /**
     * Any discounts applied to the order line.
     *
     * @var null|\stdClass
     */
    public $discountAmount;
    /**
     * The total amount of the line, including VAT and discounts.
     *
     * @var \stdClass
     */
    public $totalAmount;
    /**
     * The VAT rate applied to the order line. It is defined as a string
     * and not as a float to ensure the correct number of decimals are
     * passed.
     *
     * @example "21.00"
     *
     * @var string
     */
    public $vatRate;
    /**
     * The amount of value-added tax on the line.
     *
     * @var \stdClass
     */
    public $vatAmount;
    /**
     * The SKU, EAN, ISBN or UPC of the product sold.
     *
     * @var null|string
     */
    public $sku;
    /**
     * A link pointing to an image of the product sold.
     *
     * @var null|string
     */
    public $imageUrl;
    /**
     * A link pointing to the product page in your web shop of the product sold.
     *
     * @var null|string
     */
    public $productUrl;
    /**
     * During creation of the order you can set custom metadata on order lines that is stored with
     * the order, and given back whenever you retrieve that order line.
     *
     * @var null|mixed|\stdClass
     */
    public $metadata;
    /**
     * The order line's date and time of creation, in ISO 8601 format.
     *
     * @example 2018-08-02T09:29:56+00:00
     *
     * @var string
     */
    public $createdAt;
    /**
     * @var \stdClass
     */
    public $_links;

    /**
     * Is this order line created?
     *
     * @return bool
     */
    public function isCreated()
    {
        return \Mollie\Api\Types\OrderLineStatus::STATUS_CREATED === $this->status;
    }

    /**
     * Is this order line paid for?
     *
     * @return bool
     */
    public function isPaid()
    {
        return \Mollie\Api\Types\OrderLineStatus::STATUS_PAID === $this->status;
    }

    /**
     * Is this order line authorized?
     *
     * @return bool
     */
    public function isAuthorized()
    {
        return \Mollie\Api\Types\OrderLineStatus::STATUS_AUTHORIZED === $this->status;
    }

    /**
     * Is this order line canceled?
     *
     * @return bool
     */
    public function isCanceled()
    {
        return \Mollie\Api\Types\OrderLineStatus::STATUS_CANCELED === $this->status;
    }

    /**
     * (Deprecated) Is this order line refunded?
     *
     * @deprecated 2018-11-27
     *
     * @return bool
     */
    public function isRefunded()
    {
        return \Mollie\Api\Types\OrderLineStatus::STATUS_REFUNDED === $this->status;
    }

    /**
     * Is this order line shipping?
     *
     * @return bool
     */
    public function isShipping()
    {
        return \Mollie\Api\Types\OrderLineStatus::STATUS_SHIPPING === $this->status;
    }

    /**
     * Is this order line completed?
     *
     * @return bool
     */
    public function isCompleted()
    {
        return \Mollie\Api\Types\OrderLineStatus::STATUS_COMPLETED === $this->status;
    }

    /**
     * Is this order line for a physical product?
     *
     * @return bool
     */
    public function isPhysical()
    {
        return \Mollie\Api\Types\OrderLineType::TYPE_PHYSICAL === $this->type;
    }

    /**
     * Is this order line for applying a discount?
     *
     * @return bool
     */
    public function isDiscount()
    {
        return \Mollie\Api\Types\OrderLineType::TYPE_DISCOUNT === $this->type;
    }

    /**
     * Is this order line for a digital product?
     *
     * @return bool
     */
    public function isDigital()
    {
        return \Mollie\Api\Types\OrderLineType::TYPE_DIGITAL === $this->type;
    }

    /**
     * Is this order line for applying a shipping fee?
     *
     * @return bool
     */
    public function isShippingFee()
    {
        return \Mollie\Api\Types\OrderLineType::TYPE_SHIPPING_FEE === $this->type;
    }

    /**
     * Is this order line for store credit?
     *
     * @return bool
     */
    public function isStoreCredit()
    {
        return \Mollie\Api\Types\OrderLineType::TYPE_STORE_CREDIT === $this->type;
    }

    /**
     * Is this order line for a gift card?
     *
     * @return bool
     */
    public function isGiftCard()
    {
        return \Mollie\Api\Types\OrderLineType::TYPE_GIFT_CARD === $this->type;
    }

    /**
     * Is this order line for a surcharge?
     *
     * @return bool
     */
    public function isSurcharge()
    {
        return \Mollie\Api\Types\OrderLineType::TYPE_SURCHARGE === $this->type;
    }

    public function update()
    {
        $body = \json_encode(['name' => $this->name, 'imageUrl' => $this->imageUrl, 'productUrl' => $this->productUrl, 'quantity' => $this->quantity, 'unitPrice' => $this->unitPrice, 'discountAmount' => $this->discountAmount, 'totalAmount' => $this->totalAmount, 'vatAmount' => $this->vatAmount, 'vatRate' => $this->vatRate]);
        $url = "orders/{$this->orderId}/lines/{$this->id}";
        $result = $this->client->performHttpCall(\Mollie\Api\MollieApiClient::HTTP_PATCH, $url, $body);

        return \Mollie\Api\Resources\ResourceFactory::createFromApiResult($result, new \Mollie\Api\Resources\Order($this->client));
    }
}
