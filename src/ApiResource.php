<?php


namespace SchierProducts\SchierProductApi;


use SchierProducts\SchierProductApi\Resources\InventoryItem;
use SchierProducts\SchierProductApi\Utilities\Utilities;

/**
 * Class ApiResource
 * @package SchierProducts\SchierProductApi
 */
abstract class ApiResource extends InventoryItem
{
    use Operations\Request;

    /**
     * @return string the base URL for the given class
     */
    public static function baseUrl()
    {
        return SchierApiManager::$apiBase;
    }

    /**
     * @return string the endpoint URL for the given class
     */
    public static function classUrl()
    {
        // Replace dots with slashes for namespaced resources, e.g. if the object's name is
        // "foo.bar", then its URL will be "/foo/bars".
        $base = \str_replace('.', '/', static::OBJECT_NAME);

        return "/{$base}s";
    }

    /**
     * @param null|string $id the ID of the resource
     *
     * @throws Exception\UnexpectedValueException if $id is null
     *
     * @return string the instance endpoint URL for the given class
     */
    public static function resourceUrl($id)
    {
        if (null === $id) {
            $class = static::class;
            $message = 'Could not determine which URL to request: '
                . "{$class} instance has invalid ID: {$id}";

            throw new Exception\UnexpectedValueException($message);
        }
        $id = Utilities::utf8($id);
        $base = static::classUrl();
        $extn = \urlencode($id);

        return "{$base}/{$extn}";
    }

    /**
     * @return string the full API URL for this API resource
     */
    public function instanceUrl()
    {
        return static::resourceUrl($this->toArray()['id']);
    }
}