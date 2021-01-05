<?php


namespace SchierProducts\SchierProductApi\Utilities;


class Types
{
    /**
     * @var array Mapping from object types to resource classes
     */
    const CLASS_MAP = [
        \SchierProducts\SchierProductApi\ProductType::OBJECT_NAME => \SchierProducts\SchierProductApi\ProductType::class,
        \SchierProducts\SchierProductApi\Collection::OBJECT_NAME => \SchierProducts\SchierProductApi\Collection::class,
    ];
}