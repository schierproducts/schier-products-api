<?php


namespace SchierProducts\SchierProductApi;

use SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\ImageLibrary;
use SchierProducts\SchierProductApi\ApiClients\ProductApi\Resources\Product;

/**
 * Class ItemCollection
 *
 * Defines a collection of inventory items that have been grouped together by common attributes
 * @package SchierProducts\SchierProductApi
 * @property string $name
 * @property string $key
 * @property int $size
 * @property ImageLibrary $image
 * @property Collection<Product>|null $items
 */
class ItemCollection extends ApiResource
{
    use Operations\All;
    use Operations\Retrieve;

    const OBJECT_NAME = 'collection';

    public function instanceUrl()
    {
        if ($this->key === null || null === $this->toArray()['key']) {
            return '/collections';
        } else if ((property_exists($this, 'key') && $this->key !== null) || (array_key_exists('key', $this->toArray()) && $this->toArray()['key'] !== null)) {
            return '/collections/'.$this->toArray()['key'];
        }

        return parent::instanceUrl();
    }

    /**
     * @param array|string $key the unique slug that identifies this collection
     * @param null|array|string $opts
     *
     * @throws  \SchierProducts\SchierProductApi\Exception\ApiErrorException if the request fails
     *
     * @return static
     */
    public static function retrieve($key, $opts = null)
    {
        $opts = \SchierProducts\SchierProductApi\Utilities\RequestOptions::parse($opts);
        $instance = new static($key, $opts);
        $instance->refresh();

        return $instance;
    }
}