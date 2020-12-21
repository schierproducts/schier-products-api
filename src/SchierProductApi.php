<?php


namespace SchierProducts\SchierProductApi;


class SchierProductApi
{
    /** @var string The API key to be used for requests. */
    public static $apiKey;

    /** @var string The base URL for the Schier API. */
    public static $apiBase = 'https://api.schierproducts.com';

    /** @var null|string The version of the Schier Products API to use for requests. */
    public static $apiVersion = null;

    /**
     * Sets the API key to be used for requests.
     *
     * @param string $apiKey
     */
    public static function setApiKey(string $apiKey)
    {
        self::$apiKey = $apiKey;
    }

    /**
     * @return string|null the API key used for requests
     */
    public static function getApiKey() : ?string
    {
        return self::$apiKey;
    }

    /**
     * @return string The API version used for requests. null if we're using the
     *    latest version.
     */
    public static function getApiVersion()
    {
        return self::$apiVersion;
    }

    /**
     * @param string $apiVersion the API version to use for requests
     */
    public static function setApiVersion($apiVersion)
    {
        self::$apiVersion = $apiVersion;
    }
}