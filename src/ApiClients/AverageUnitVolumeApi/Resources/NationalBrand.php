<?php

namespace SchierProducts\SchierProductApi\ApiClients\AverageUnitVolumeApi\Resources;

/**
 * Class NationalBrand
 * @property string $id
 * @property string $name
 * @property int $auv
 * @property string $restaurant_type
 * @property int $average_meal_cost
 * @property float $grease_per_meal
 * @property string $menu_type
 * @property boolean $uses_flatware
 * @property int $ninety_day_grease_capacity
 * @property RecommendedProduct $recommended_product
 */
class NationalBrand extends \SchierProducts\SchierProductApi\Resources\ApiResource
{
    const OBJECT_NAME = 'national-brand';

}