<?php


namespace SchierProducts\SchierProductApi;


class SchierProductApi
{
    /** @var string The API key to be used for requests. */
    public static $apiKey;

    public static $httpClient;

    /** @var string The base URL for the Schier API. */
    public static $apiBase = 'https://api.schierproducts.com/api';

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
     * Manually defines the HTTP client used to make requests.
     *
     * This is used for testing purposes.
     *
     * @param \Illuminate\Http\Client\Factory|mixed $httpClient
     */
    public static function setHttpClient($httpClient): void
    {
        self::$httpClient = $httpClient;
    }

    /**
     * @return \Illuminate\Http\Client\Factory
     */
    public static function getHttpClient() : \Illuminate\Http\Client\Factory
    {
        return self::$httpClient ?? new \Illuminate\Http\Client\Factory;
    }

    /**
     * Sets the base URL for requests
     *
     * @param string $apiBase
     */
    public static function setApiBase(string $apiBase)
    {
        self::$apiBase = $apiBase;
    }

    /**
     * @return string|null the API url base
     */
    public static function getApiBase() : ?string
    {
        return self::$apiBase;
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