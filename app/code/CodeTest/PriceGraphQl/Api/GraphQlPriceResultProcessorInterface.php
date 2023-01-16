<?php

namespace CodeTest\PriceGraphQl\Api;

use CodeTest\Price\Api\Data\PriceInterface;

/**
 * @api
 */
interface GraphQlPriceResultProcessorInterface
{
    /**
     * @param PriceInterface $price
     * @param array $graphQlResult
     * @return void
     */
    public function process(PriceInterface $price, array &$graphQlResult): void;
}
