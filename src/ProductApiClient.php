<?php


namespace SchierProducts\SchierProductApi;

/**
 * Client used to send requests
 *
 * @ProductApiClient
 * @package SchierProducts\SchierProductApi
 * @property \SchierProducts\SchierProductApi\Service\ProductTypeService $productTypes
 * @property \SchierProducts\SchierProductApi\Service\ProductService $products
 */
class ProductApiClient extends Client\BaseSchierClient
{
    /**
     * @var null|\SchierProducts\SchierProductApi\Service\ServiceFactory
     */
    private $serviceFactory;

    public function __get($name)
    {
        if (null === $this->serviceFactory) {
            $this->serviceFactory = new \SchierProducts\SchierProductApi\Service\ServiceFactory($this);
        }

        return $this->serviceFactory->__get($name);
    }
}