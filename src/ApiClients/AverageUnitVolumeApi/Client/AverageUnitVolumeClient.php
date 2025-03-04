<?php

namespace SchierProducts\SchierProductApi\ApiClients\AverageUnitVolumeApi\Client;

use SchierProducts\SchierProductApi\ApiClients\AverageUnitVolumeApi\Resources\MealTable;
use SchierProducts\SchierProductApi\ApiClients\AverageUnitVolumeApi\Resources\NationalBrand;
use SchierProducts\SchierProductApi\ApiClients\AverageUnitVolumeApi\Resources\RecommendedProduct;
use SchierProducts\SchierProductApi\ApiClients\AverageUnitVolumeApi\Service\NationalBrandService;
use SchierProducts\SchierProductApi\ApiClients\AverageUnitVolumeApi\Service\ProductByCostService;
use SchierProducts\SchierProductApi\ApiClients\AverageUnitVolumeApi\Utilities\ProductByCostParamBuilder;
use SchierProducts\SchierProductApi\Client\BaseSchierClient;
use SchierProducts\SchierProductApi\Collection;
use SchierProducts\SchierProductApi\Resources\InventoryItem;
use SchierProducts\SchierProductApi\Service\ServiceFactory;

/**
 * Class AverageUnitVolumeClient
 * @property NationalBrandService $nationalBrands
 * @property ProductByCostService $productByCost
 */
class AverageUnitVolumeClient extends BaseSchierClient
{
    private ?ServiceFactory $serviceFactory;

    public function __get(string $name)
    {
        if (empty($this->serviceFactory)) {
            $this->serviceFactory = new ServiceFactory($this);
        }

        return $this->serviceFactory->__get($name);
    }

    public function nationalBrands(string|null $key = null, array|null $params = []): Collection|NationalBrand|InventoryItem
    {
        if ($key) {
            return $this->nationalBrands->retrieve($key, $params);
        }

        return $this->nationalBrands->all($params);
    }

    public function mealTable(ProductByCostParamBuilder $params): InventoryItem|MealTable
    {
        return $this->productByCost->table($params);
    }

    public function productByCost(ProductByCostParamBuilder $params) : RecommendedProduct|InventoryItem
    {
        return $this->productByCost->recommendedProduct($params);
    }
}