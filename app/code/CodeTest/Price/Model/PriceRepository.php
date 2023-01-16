<?php

namespace CodeTest\Price\Model;

use Magento\Framework\HTTP\Client\CurlFactory;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Pricing\Helper\Data as PriceHelper;
use CodeTest\Price\Logger\PriceLogger;
use CodeTest\Price\Api\Data\PriceInterface;
use CodeTest\Price\Api\PriceRepositoryInterface;
use CodeTest\Price\Model\Data\PriceFactory;

class PriceRepository implements PriceRepositoryInterface
{
    /**
     * Constant declaration
     */
    private const HTTP_SUCCESS = 200;
    private const PRICE_ENDPOINT = 'https://stagecerewards.carrierenterprise.com/v1/price/';

    /**
     * @param CurlFactory $curlFactory
     * @param Json $json
     * @param PriceLogger $priceLogger
     * @param PriceFactory $priceFactory
     * @param PriceHelper $priceHelper
     */
    public function __construct(
        private CurlFactory $curlFactory,
        private Json $json,
        private PriceLogger $priceLogger,
        private PriceFactory $priceFactory,
        private PriceHelper $priceHelper
    ) {
    }

    /**
     * Method to get the price data
     *
     * @param int $productId
     * @return PriceInterface|null
     */
    public function get(int $productId): ?PriceInterface
    {
        try {
            if (empty($productId)) {
                throw new \Exception(__('Product Id is required.'));
            }

            $priceResponse = $this->getPrice($productId);
            if (!empty($priceResponse)) {
                $displayPrice = $this->priceHelper->currency($priceResponse['unit_price'], true, false);

                /** @var \CodeTest\Price\Model\Data\Price $priceModel */
                $priceModel = $this->priceFactory->create();
                $priceModel->setProductId($priceResponse['product_id']);
                $priceModel->setUnitPrice($priceResponse['unit_price']);
                $priceModel->setDisplayPrice($displayPrice);

                return $priceModel;
            }
        } catch (\Exception $e) {
            $this->priceLogger->critical($e->getMessage());
        }

        return null;
    }

    /**
     * Method to get the price response
     *
     * @param int $productId
     * @return array
     */
    private function getPrice($productId): array
    {
        $endPoint = self::PRICE_ENDPOINT . $productId;

        /** @var \Magento\Framework\HTTP\Client\Curl $curl */
        $curl = $this->curlFactory->create();
        $curl->addHeader('Content-Type', 'application/json');
        $curl->addHeader('cache-control', 'no-cache');
        $curl->get($endPoint);
        $responseBody = $curl->getBody();

        if (!empty($responseBody)) {
            /**  Log Price API response */
            $response = $this->json->unserialize($responseBody);
            $this->priceLogger->info('Price Response: ', $response);

            if ($curl->getStatus() == self::HTTP_SUCCESS) {
                if (!empty($response['data']) && !empty($response['data']['product_id'])
                    && !empty($response['data']['unit_price'])) {
                    return $response['data'];
                }
            }
        }

        return [];
    }
}
