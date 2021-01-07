<?php


namespace SchierProducts\SchierProductApi\ProductResources;

/**
 * Class InstallationOptions
 * @package SchierProducts\SchierProductApi\ProductResources
 * @property InstallationOptionsLocation $location
 * @property string|null $location_as_text A "human-friendly" description of where this product can be installed
 * @property boolean $traffic_area If the product can be installed in a traffic area
 */
class InstallationOptions extends ProductResource
{
    public const OBJECT_NAME = 'installation-options';
}