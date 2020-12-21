<?php


namespace SchierProducts\SchierProductApi\Client;


interface ClientInterface
{
    /**
     * @param string $method The HTTP method being used
     * @param string $absUrl The URL being requested, including domain and protocol
     * @param array $headers Headers to be used in the request (full strings, not KV pairs)
     * @param array $params KV pairs for parameters. Can be nested for arrays and hashes
     *                         CURLFile)
     *
     * @return array an array whose first element is raw request body, second
     *    element is HTTP status code and third array of HTTP headers
     * @throws \SchierProducts\SchierProductApi\Exception\ApiConnectionException
     */
    public function request(string $method = 'get', string $absUrl = 'https://api.schierproducts.com', array $headers = [], array $params = []): array;
}