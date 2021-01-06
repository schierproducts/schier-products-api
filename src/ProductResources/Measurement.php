<?php


namespace SchierProducts\SchierProductApi\ProductResources;

/**
 * Class Measurement
 * @package SchierProducts\SchierProductApi\ProductResources
 * @property int|float $value The value of the measurement
 * @property string $unit The unit of measurement
 */
class Measurement extends ProductResource
{
    const OBJECT_NAME = 'measurement';

}