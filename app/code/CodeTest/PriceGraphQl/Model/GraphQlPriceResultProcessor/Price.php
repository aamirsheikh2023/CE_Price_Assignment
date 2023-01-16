<?php

namespace CodeTest\PriceGraphQl\Model\GraphQlPriceResultProcessor;

use CodeTest\Price\Api\Data\PriceInterface;
use CodeTest\PriceGraphQl\Api\GraphQlPriceResultProcessorInterface;

class Price implements GraphQlPriceResultProcessorInterface
{
    /**
     * ResultKey => GraphQlKey
     *
     * @var string[]
     */
    private array $fieldMap = [
        PriceInterface::PRODUCT_ID => 'product_id',
        PriceInterface::UNIT_PRICE => 'unit_price',
        PriceInterface::DISPLAY_PRICE => 'display_price',
    ];

    public function process(PriceInterface $price, array &$graphQlResult): void
    {
        $priceResult = $price->toArray();
        foreach ($priceResult as $resultKey => $resultValue) {
            $graphQlKey = $this->fieldMap[$resultKey] ?? $resultKey;
            $graphQlResult[$graphQlKey] = $resultValue;
        }
    }
}
