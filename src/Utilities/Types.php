<?php


namespace SchierProducts\SchierProductApi\Utilities;


use SchierProducts\SchierProductApi\ApiClients\TerritoryApi\Resources\County;
use SchierProducts\SchierProductApi\ApiClients\TerritoryApi\Resources\Manager;
use SchierProducts\SchierProductApi\ApiClients\TerritoryApi\Resources\RepFirm;
use SchierProducts\SchierProductApi\ApiClients\TerritoryApi\Resources\Territory;
use SchierProducts\SchierProductApi\ApiClients\TerritoryApi\Resources\ZipCode;

class Types
{
    /**
     * @var array Mapping from object types to resource classes
     */
    const CLASS_MAP = [
        \SchierProducts\SchierProductApi\Collection::OBJECT_NAME => \SchierProducts\SchierProductApi\Collection::class,
        \SchierProducts\SchierProductApi\ItemCollection::OBJECT_NAME => \SchierProducts\SchierProductApi\ItemCollection::class,
        \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Product::OBJECT_NAME => \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Product::class,
        \SchierProducts\SchierProductApi\ApiClients\ProductApi\ProductType::OBJECT_NAME => \SchierProducts\SchierProductApi\ApiClients\ProductApi\ProductType::class,
        \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\SimpleProduct::OBJECT_NAME => \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\SimpleProduct::class,

        // Individual product resources
        \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Certification::OBJECT_NAME => \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Certification::class,
        \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Dimensions::OBJECT_NAME => \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Dimensions::class,
        \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\DimensionSet::OBJECT_NAME => \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\DimensionSet::class,
        \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\DocumentLibrary::OBJECT_NAME => \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\DocumentLibrary::class,
        \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\FlowRating::OBJECT_NAME => \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\FlowRating::class,
        \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\GreaseCapacityMeasurement::OBJECT_NAME => \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\GreaseCapacityMeasurement::class,
        \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\InstallationOptions::OBJECT_NAME => \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\InstallationOptions::class,
        \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\InstallationOptionsLocation::OBJECT_NAME => \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\InstallationOptionsLocation::class,
        \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Measurement::OBJECT_NAME => \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Measurement::class,
        \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Price::OBJECT_NAME => \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Price::class,
        \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\ImageLibrary::OBJECT_NAME => \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\ImageLibrary::class,
        \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\ProductImageLibrary::OBJECT_NAME => \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\ProductImageLibrary::class,
        \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\ProductOption::OBJECT_NAME => \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\ProductOption::class,
        \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\ProductPrice::OBJECT_NAME => \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\ProductPrice::class,
        \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\AwarenessProduct::OBJECT_NAME => \SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\AwarenessProduct::class,

    ];

    public static function getClassMap() : array
    {
        return [...self::CLASS_MAP, ...self::getTerritoryClassMap()];
    }

    public static function getTerritoryClassMap() : array
    {
        $classes = [
            County::class,
            Manager::class,
            RepFirm::class,
            Territory::class,
            ZipCode::class,
        ];


        return self::toClassMap($classes);
    }

    private static function toClassMap(array $classes) : array
    {
        $map = [];
        foreach ($classes as $class) {
            $map[$class::OBJECT_NAME] = $class;
        }

        return $map;
    }

}