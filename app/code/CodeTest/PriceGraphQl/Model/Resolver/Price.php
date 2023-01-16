<?php

namespace CodeTest\PriceGraphQl\Model\Resolver;

use CodeTest\Price\Api\PriceRepositoryInterface;
use CodeTest\PriceGraphQl\Api\GraphQlPriceResultProcessorInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class Price implements ResolverInterface
{
    public function __construct(
        protected PriceRepositoryInterface $priceRepository,
        protected GraphQlPriceResultProcessorInterface $resultProcessor
    ) {
    }

    /**
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array|null
     * @throws GraphQlInputException
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (!isset($args['product_id'])) {
            throw new GraphQlInputException(__('Required parameter "product_id" is missing.'));
        }
        $productId = (int)$args['product_id'];

        $price = $this->priceRepository->get($productId);

        if ($price === null) {
            return null;
        }

        $result = [];
        $this->resultProcessor->process($price, $result);
        return $result;
    }

}
