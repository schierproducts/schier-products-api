<?php


namespace SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources;

/**
 * Class ProductOption
 *
 * Options that come available with specified part number and any associated markup
 * @package SchierProducts\SchierProductApi\ProductResources
 * @property int $id The unique id of the option
 * @property string $name The people-friendly name of the option
 * @property string $option_type The type of option that is being represented: cover, connection, etc
 * @property string|null $description Any other contextually relevant information associated with this option
 * @property ProductPrice $price The markup and pricing of the option
 * @property string $store_id The id of the option within the eCommerce platform
 * @property boolean $pumpout_port Whether or not this option has a pumpout port
 * @property array $connection_size The size of the connection for this option
 */
class ProductOption extends ProductResource
{
    public const OBJECT_NAME = 'product-option';
}