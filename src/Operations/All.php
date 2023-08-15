<?php


namespace SchierProducts\SchierProductApi\Operations;

use SchierProducts\SchierProductApi\SchierApiManager;
use SchierProducts\SchierProductApi\Utilities\Utilities;

/**
 * Trait for listable resources. Adds a `all()` static method to the class.
 *
 * This trait should only be applied to classes that derive from InventoryItem.
 */
trait All
{
    /**
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \SchierProducts\SchierProductApi\Exception\ApiErrorException if the request fails
     *
     * @return \SchierProducts\SchierProductApi\Collection of ApiResources
     */
    public static function all($params = null, $opts = null)
    {
        self::_validateParams($params);
        $url = static::classUrl();
        $httpFactory = SchierApiManager::getHttpClient();

        list($response, $opts) = static::_staticRequest('get', $url, $params, $opts, $httpFactory);
        $obj = Utilities::convertToInventoryItem($response->json, $opts);

        if (!($obj instanceof \SchierProducts\SchierProductApi\Collection)) {
            throw new \SchierProducts\SchierProductApi\Exception\UnexpectedValueException(
                'Expected type ' . \SchierProducts\SchierProductApi\Collection::class . ', got "' . \get_class($obj) . '" instead.'
            );
        }
        $obj->setFilters($params);

        return $obj;
    }
}