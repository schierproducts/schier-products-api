<?php


namespace SchierProducts\SchierProductApi\ApiClients\ProductApi;


use SchierProducts\SchierProductApi\ApiResource;
use SchierProducts\SchierProductApi\Collection;
use SchierProducts\SchierProductApi\Exception;
use SchierProducts\SchierProductApi\Operations;
use SchierProducts\SchierProductApi\SchierProductApi;
use SchierProducts\SchierProductApi\Utilities\RequestOptions;
use SchierProducts\SchierProductApi\Utilities\Utilities;

/**
 * Class ProductType
 * @package SchierProducts\SchierProductApi
 * @property string $name - The user-friendly name of the product type
 * @property string $key - The unique identifier of this product type
 * @property boolean $active - If the product type is currently being used
 * @property string $image - The image that is used to represent this product type
 * @property ProductType|null $parent - If the product type is a child association
 * @property Collection|null $products - A list of products that are associated with that product type
 * @property string $created - A timestamp of when the resource was created
 */
class ProductType extends ApiResource
{
    const OBJECT_NAME = 'product-type';

    use Operations\All;
    use Operations\Retrieve;

    public function instanceUrl()
    {
        if ($this->key === null || null === $this->toArray()['key']) {
            return '/product-types';
        } else if ((property_exists($this, 'key') && $this->key !== null) || (array_key_exists('key', $this->toArray()) && $this->toArray()['key'] !== null)) {
            return '/product-types/'.$this->toArray()['key'];
        }

        return parent::instanceUrl();
    }

    /**
     * @param string $key the unique key id of the product type
     * @param null|array|string $opts
     *
     * @throws  \SchierProducts\SchierProductApi\Exception\ApiErrorException if the request fails
     *
     * @return static
     */
    public static function retrieve($key, $opts = null)
    {
        $opts = RequestOptions::parse($opts);
        $instance = new static($key, $opts);
        $instance->refresh();

        return $instance;
    }

    /**
     * Retrieves the products that have been assigned to the queried product type
     *
     * @param null|array $params
     * @param null|array|RequestOptions $opts
     * @return \SchierProducts\SchierProductApi\Collection
     *@throws Exception\ApiErrorException if the request fails
     */
    public function products($params = null)
    {
        $url = $this->instanceUrl().'/products';
        $response = $this->_request('get', $url, $params, $this->_opts, SchierProductApi::getHttpClient());
        return Utilities::convertToInventoryItem($response, []);
    }
}