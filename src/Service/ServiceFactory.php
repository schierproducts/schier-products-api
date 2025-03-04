<?php


namespace SchierProducts\SchierProductApi\Service;

use SchierProducts\SchierProductApi\ApiClients\AverageUnitVolumeApi\Service\NationalBrandService;
use SchierProducts\SchierProductApi\ApiClients\AverageUnitVolumeApi\Service\ProductByCostService;
use SchierProducts\SchierProductApi\ApiClients\GreaseApi\Service\GreaseRatingService;
use SchierProducts\SchierProductApi\ApiClients\GreaseApi\Service\RestaurantTypeService;
use SchierProducts\SchierProductApi\ApiClients\ProductApi\Service\ProductService;
use SchierProducts\SchierProductApi\ApiClients\ProductApi\Service\ProductTypeService;
use SchierProducts\SchierProductApi\ApiClients\TerritoryApi\Service\RepFirmService;
use SchierProducts\SchierProductApi\ApiClients\TerritoryApi\Service\TerritoryService;

/**
 * Service factory class for API resources in the root namespace.
 *
 * @package SchierProducts\SchierProductApi\Service
 * @property ProductService $products
 * @property ProductTypeService $productTypes
 * @property ItemCollectionService $collections
 * @property TerritoryService $territories
 * @property RepFirmService $repFirms
 * @property GreaseRatingService $greaseRatings
 * @property RestaurantTypeService $restaurantTypes
 * @property NationalBrandService $nationalBrands
 * @property ProductByCostService $productByCost
 */
class ServiceFactory extends AbstractServiceFactory
{
    /**
     * @var array<string, string>
     */
    private static $classMap = [
        'products' => ProductService::class,
        'productTypes' => ProductTypeService::class,
        'collections' => ItemCollectionService::class,
        'territories' => TerritoryService::class,
        'repFirms' => RepFirmService::class,
        'greaseRatings' => GreaseRatingService::class,
        'restaurantTypes' => RestaurantTypeService::class,
        'nationalBrands' => NationalBrandService::class,
        'productByCost' => ProductByCostService::class,
    ];

    protected function getServiceClass($name)
    {
        return \array_key_exists($name, self::$classMap) ? self::$classMap[$name] : null;
    }
}