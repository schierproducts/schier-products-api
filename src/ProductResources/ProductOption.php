<?php


namespace SchierProducts\SchierProductApi\ProductResources;

/**
 * Class ProductOption
 *
 * Options that come available with specified part number and any associated markup
 * @package SchierProducts\SchierProductApi\ProductResources
 * @property int $id The unique id of the option
 * @property string $name The people-friendly name of the option
 * @property string $option_type The type of option that is being represented: cover, connection, etc
 * @property string|null $description Any other contextually relevant information associated with this option
 * @property string $price The markup of the option
 * @property string $store_id The id of the option within the eCommerce platform
 */
class ProductOption extends ProductResource
{
    public const OBJECT_NAME = 'product-option';
}