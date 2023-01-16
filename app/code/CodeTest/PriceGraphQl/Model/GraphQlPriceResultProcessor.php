<?php

namespace CodeTest\PriceGraphQl\Model;

use CodeTest\Price\Api\Data\PriceInterface;
use CodeTest\PriceGraphQl\Api\GraphQlPriceResultProcessorInterface;

class GraphQlPriceResultProcessor implements GraphQlPriceResultProcessorInterface
{
    /**
     * @param GraphQlPriceResultProcessorInterface[] $processors
     */
    public function __construct(protected array $processors = [])
    {
    }

    public function process(PriceInterface $price, array &$graphQlResult): void
    {
        foreach ($this->processors as $processor) {
            $processor->process($price, $graphQlResult);
        }
    }
}
