<?php


namespace SchierProducts\SchierProductApi\ProductResources;

/**
 * Class Price
 *
 * Provides price details and any associated multiplier
 *
 * @package SchierProducts\SchierProductApi\ProductResources
 * @property int|float|null $multiplier If this price has been modified, the percentage
 * @property string $price
 */
class Price extends ProductResource
{
    public const OBJECT_NAME = 'price';

}