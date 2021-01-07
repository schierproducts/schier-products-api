<?php


namespace SchierProducts\SchierProductApi\Utilities;


class Types
{
    /**
     * @var array Mapping from object types to resource classes
     */
    const CLASS_MAP = [
        \SchierProducts\SchierProductApi\Collection::OBJECT_NAME => \SchierProducts\SchierProductApi\Collection::class,
        \SchierProducts\SchierProductApi\Product::OBJECT_NAME => \SchierProducts\SchierProductApi\Product::class,
        \SchierProducts\SchierProductApi\ProductType::OBJECT_NAME => \SchierProducts\SchierProductApi\ProductType::class,
        \SchierProducts\SchierProductApi\SimpleProduct::OBJECT_NAME => \SchierProducts\SchierProductApi\SimpleProduct::class,

        // Individual product resources
        \SchierProducts\SchierProductApi\ProductResources\Certification::OBJECT_NAME => \SchierProducts\SchierProductApi\ProductResources\Certification::class,
        \SchierProducts\SchierProductApi\ProductResources\Dimensions::OBJECT_NAME => \SchierProducts\SchierProductApi\ProductResources\Dimensions::class,
        \SchierProducts\SchierProductApi\ProductResources\DimensionSet::OBJECT_NAME => \SchierProducts\SchierProductApi\ProductResources\DimensionSet::class,
        \SchierProducts\SchierProductApi\ProductResources\DocumentLibrary::OBJECT_NAME => \SchierProducts\SchierProductApi\ProductResources\DocumentLibrary::class,
        \SchierProducts\SchierProductApi\ProductResources\FlowRating::OBJECT_NAME => \SchierProducts\SchierProductApi\ProductResources\FlowRating::class,
        \SchierProducts\SchierProductApi\ProductResources\GreaseCapacityMeasurement::OBJECT_NAME => \SchierProducts\SchierProductApi\ProductResources\GreaseCapacityMeasurement::class,
        \SchierProducts\SchierProductApi\ProductResources\InstallationOptions::OBJECT_NAME => \SchierProducts\SchierProductApi\ProductResources\InstallationOptions::class,
        \SchierProducts\SchierProductApi\ProductResources\InstallationOptionsLocation::OBJECT_NAME => \SchierProducts\SchierProductApi\ProductResources\InstallationOptionsLocation::class,
        \SchierProducts\SchierProductApi\ProductResources\Measurement::OBJECT_NAME => \SchierProducts\SchierProductApi\ProductResources\Measurement::class,
        \SchierProducts\SchierProductApi\ProductResources\Price::OBJECT_NAME => \SchierProducts\SchierProductApi\ProductResources\Price::class,
        \SchierProducts\SchierProductApi\ProductResources\ProductImage::OBJECT_NAME => \SchierProducts\SchierProductApi\ProductResources\ProductImage::class,
        \SchierProducts\SchierProductApi\ProductResources\ProductImageLibrary::OBJECT_NAME => \SchierProducts\SchierProductApi\ProductResources\ProductImageLibrary::class,
        \SchierProducts\SchierProductApi\ProductResources\ProductOption::OBJECT_NAME => \SchierProducts\SchierProductApi\ProductResources\ProductOption::class,
        \SchierProducts\SchierProductApi\ProductResources\ProductPrice::OBJECT_NAME => \SchierProducts\SchierProductApi\ProductResources\ProductPrice::class,
    ];
}