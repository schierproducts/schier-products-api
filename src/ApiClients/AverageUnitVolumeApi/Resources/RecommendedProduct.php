<?php

namespace SchierProducts\SchierProductApi\ApiClients\AverageUnitVolumeApi\Resources;

/**
 * Class RecommendedProduct
 * @property string $name
 * @property string $image
 * @property string $part_number
 * @property int $grease_capacity
 * @property int $difference
 * @property int $id
 * @property int $percent_empty
 */
class RecommendedProduct extends \SchierProducts\SchierProductApi\Resources\ApiResource
{
    const OBJECT_NAME = 'recommended-product';
}