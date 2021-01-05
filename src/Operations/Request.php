<?php

namespace SchierProducts\SchierProductApi\Operations;

use SchierProducts\SchierProductApi\Exception;

/**
 * Trait for resources that need to make API requests.
 */
trait Request
{
    /**
     * @param null|array|mixed $params The list of parameters to validate
     *
     * @throws Exception\InvalidArgumentException if $params exists and is not an array
     */
    protected static function _validateParams($params = null)
    {
        if ($params && !\is_array($params)) {
            $message = 'You must pass an array as the first argument to Schier Product API method calls.';

            throw new Exception\InvalidArgumentException($message);
        }
    }

    /**
     * @param string $method HTTP method ('get', 'post', etc.)
     * @param string $url URL for the request
     * @param array $params list of parameters for the request
     * @param null|\Illuminate\Http\Client\Factory Allows us to manually override the request factory for mocking
     *
     * @throws Exception\ApiErrorException if the request fails
     *
     * @return string|array json response
     */
    protected function _request($method, $url, $params = [], ?\Illuminate\Http\Client\Factory $factory = null)
    {
        list($resp) = static::_staticRequest($method, $url, $params, null, $factory);
        return $resp->json;
    }

    /**
     * @param string $method HTTP method ('get', 'post', etc.)
     * @param string $url URL for the request
     * @param ?array $params list of parameters for the request
     * @param null|array|string $options
     * @param null|\Illuminate\Http\Client\Factory Allows us to manually override the request factory for mocking
     *
     * @throws Exception\ApiErrorException if the request fails
     *
     * @return array tuple containing (the JSON response, $options)
     */
    protected static function _staticRequest(string $method, string $url, ?array $params = [], ?array $options = null, ?\Illuminate\Http\Client\Factory $factory = null)
    {
        $opts = \SchierProducts\SchierProductApi\Utilities\RequestOptions::parse($options);
        $baseUrl = isset($opts->apiBase) ? $opts->apiBase : static::baseUrl();
        $request = new \SchierProducts\SchierProductApi\ApiRequest($opts->apiKey, $baseUrl);
        if ($factory) {
            $request->setHttpClient($factory);
        }
        list($response, $opts->apiKey) = $request->request($method, $url, $params, $opts->headers);

        return [$response, $opts];
    }
}