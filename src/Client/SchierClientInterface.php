<?php


namespace SchierProducts\SchierProductApi\Client;

/**
 * Interface for a Schier client.
 */
interface SchierClientInterface
{
    /**
     * Gets the API key used by the client to send requests.
     *
     * @return null|string the API key used by the client to send requests
     */
    public function getApiKey();

    /**
     * Gets the base URL for Schier's Product API.
     *
     * @return string the base URL for Schier's Product API
     */
    public function getApiBase();

    /**
     * Sends a request to Stripe's API.
     *
     * @param string $method the HTTP method
     * @param string $path the path of the request
     * @param array $params the parameters of the request
     * @param array|\SchierProducts\SchierProductApi\Utilities\RequestOptions $opts the special modifiers of the request
     *
     * @return \SchierProducts\SchierProductApi\Resources\InventoryItem the object returned by Stripe's API
     */
    public function request($method, $path, $params, $opts);
}