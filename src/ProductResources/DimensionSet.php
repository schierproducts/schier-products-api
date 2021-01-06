<?php


namespace SchierProducts\SchierProductApi\ProductResources;

/**
 * Class DimensionSet
 * @package SchierProducts\SchierProductApi\ProductResources
 * @property Dimensions $standard US-Standard dimensions (inches, lbs, etc)
 * @property Dimensions $metric Dimensions with the metric conversions
 */
class DimensionSet extends ProductResource
{
    const OBJECT_NAME = 'dimension-set';

}