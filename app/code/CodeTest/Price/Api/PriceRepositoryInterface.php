<?php

namespace CodeTest\Price\Api;

use CodeTest\Price\Api\Data\PriceInterface;
use CodeTest\Price\Exception\PriceException;

/**
 * @api
 */
interface PriceRepositoryInterface
{
    /**
     * @param int $productId
     * @return PriceInterface|null
     * @throws PriceException
     */
    public function get(int $productId): ?PriceInterface;
}
