<?php


namespace SchierProducts\SchierProductApi\Resources;

use SchierProducts\SchierProductApi\ApiRequest;
use \SchierProducts\SchierProductApi\Exception;
use \SchierProducts\SchierProductApi\Operations;
use SchierProducts\SchierProductApi\SchierProductApi;
use \SchierProducts\SchierProductApi\Utilities;

/**
 * Class ApiResource
 * @package SchierProducts\SchierProductApi\Resources
 */
class ApiResource extends InventoryItem
{
    use Operations\Request;

    /**
     * @return Utilities\Set A list of fields that can be their own type of
     * API resource (say a nested card under an account for example), and if
     * that resource is set, it should be transmitted to the API on a create or
     * update. Doing so is not the default behavior because API resources
     * should normally be persisted on their own RESTful endpoints.
     */
    public static function getSavedNestedResources()
    {
        static $savedNestedResources = null;
        if (null === $savedNestedResources) {
            $savedNestedResources = new Utilities\Set();
        }

        return $savedNestedResources;
    }

    public function __set($k, $v)
    {
        parent::__set($k, $v);
        $v = $this->{$k};
        if ((static::getSavedNestedResources()->includes($k))
            && ($v instanceof ApiResource)) {
            $v->saveWithParent = true;
        }
    }

    /**
     * @throws Exception\ApiErrorException
     *
     * @return ApiResource the refreshed resource
     */
    public function refresh()
    {
        $requestor = new ApiRequest($this->_opts->apiKey, static::baseUrl());
        $url = $this->instanceUrl();

        list($response, $this->_opts->apiKey) = $requestor->request(
            'get',
            $url,
            $this->_retrieveOptions,
            $this->_opts->headers
        );
        $this->refreshFrom($response->json, $this->_opts);

        return $this;
    }

    /**
     * @return string the base URL for the given class
     */
    public static function baseUrl()
    {
        return SchierProductApi::$apiBase;
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
        $id = Utilities\Utilities::utf8($id);
        $base = static::classUrl();
        $extn = \urlencode($id);

        return "{$base}/{$extn}";
    }

    /**
     * @return string the full API URL for this API resource
     */
    public function instanceUrl()
    {
        return static::resourceUrl($this['id']);
    }
}