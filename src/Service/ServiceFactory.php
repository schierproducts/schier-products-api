<?php


namespace SchierProducts\SchierProductApi\Service;

/**
 * Service factory class for API resources in the root namespace.
 *
 * @package SchierProducts\SchierProductApi\Service
 * @property ProductService $products
 * @property ProductTypeService $productTypes
 * @property ItemCollectionService $collections
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
    ];

    protected function getServiceClass($name)
    {
        return \array_key_exists($name, self::$classMap) ? self::$classMap[$name] : null;
    }
}