<?php


namespace SchierProducts\SchierProductApi;

use SchierProducts\SchierProductApi\ProductResources\AwarenessProduct;
use SchierProducts\SchierProductApi\ProductResources\BaseModel;
use SchierProducts\SchierProductApi\ProductResources\ProductPrice;

/**
 * Class SimpleProduct
 *
 * Base product object with minimal content/specs
 * @package SchierProducts\SchierProductApi
 * @property string $name The user-friendly name of the product type
 * @property string $short_name A shorter, easier to use name
 * @property string[] $types The product type categories that this product is associated with
 * @property string $part_number The default part number of this product
 * @property BaseModel $base_model The base model information
 * @property string|null $store_id The unique id of this product in the ecommerce website
 * @property ProductPrice $price Pricing information for the product
 * @property AwarenessProduct $processing Any available processing time information associated with the retrieved product
 */
class SimpleProduct extends ApiResource
{
    const OBJECT_NAME = 'simple-product';

    public function instanceUrl()
    {
        if ($this->part_number === null || null === $this->toArray()['part_number']) {
            return '/products';
        } else if ((property_exists($this, 'part_number') && $this->part_number !== null) || (array_key_exists('part_number', $this->toArray()) && $this->toArray()['part_number'] !== null)) {
            return '/products/'.$this->toArray()['part_number'];
        }

        return parent::instanceUrl();
    }
}