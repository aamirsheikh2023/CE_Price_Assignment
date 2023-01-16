<?php

namespace CodeTest\Price\Model\Data;

use CodeTest\Price\Api\Data\PriceInterface;
use Magento\Framework\DataObject;

class Price extends DataObject implements PriceInterface
{
    /**
     * @return int
     */
    public function getProductId(): int
    {
        return (int)$this->getData(self::PRODUCT_ID);
    }

    /**
     * @param int $productId
     * @return void
     */
    public function setProductId(int $productId): void
    {
        $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * @return float
     */
    public function getUnitPrice(): float
    {
        return (float)$this->getData(self::UNIT_PRICE);
    }

    /**
     * @param float $unitPrice
     * @return void
     */
    public function setUnitPrice(float $unitPrice): void
    {
        $this->setData(self::UNIT_PRICE, $unitPrice);
    }

    /**
     * @return string
     */
    public function getDisplayPrice(): string
    {
        return (string)$this->getData(self::DISPLAY_PRICE);
    }

    /**
     * @param string $unitPrice
     * @return void
     */
    public function setDisplayPrice(string $unitPrice): void
    {
        $this->setData(self::DISPLAY_PRICE, $unitPrice);
    }

    /**
     * @param array $keys
     * @return array
     */
    public function toArray(array $keys = []): array
    {
        return parent::toArray($keys);
    }
}
