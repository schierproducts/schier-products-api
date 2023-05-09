<?php


namespace SchierProducts\SchierProductApi;


use SchierProducts\SchierProductApi\HttpClient;
use SchierProducts\SchierProductApi\Utilities\Utilities;

class ApiRequest
{
    /**
     * @var null|string
     */
    private ?string $_apiKey;

    /**
     * @var string
     */
    private $_apiBase;



    /**
     * @var HttpClient\RequestClient
     */
    private static $_httpClient;
    private string $_apiVersion;

    /**
     * ApiRequest Constructor
     *
     * @param string|null $apiKey
     * @param string|null $apiBase
     */
    public function __construct(string $apiKey, string $apiBase, string $apiVersion = '1')
    {
        $this->_apiKey = $apiKey;
        $this->_apiVersion = $apiVersion;
        $this->_apiBase = $apiBase;
    }

    /**
     * @param string     $method
     * @param string     $url
     * @param null|array $params
     * @param null|array $headers
     *
     * @throws Exception\ApiErrorException
     *
     * @return array tuple containing (ApiReponse, API key)
     */
    public function request($method, $url, $params = null, $headers = null)
    {
        $params = $params ?: [];
        $headers = $headers ?: [];

        list($rbody, $rcode, $rheaders, $currentApiKey) =
            $this->_requestRaw($method, $url, $params, $headers);

        $json = $this->_interpretResponse($rbody, $rcode, $rheaders);
        $response = new ApiResponse($rbody, $rcode, $rheaders, $json);

        return [$response, $currentApiKey];
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $params
     * @param array $headers
     *
     * @throws Exception\AuthenticationException
     * @throws Exception\ApiConnectionException
     *
     * @return array
     */
    private function _requestRaw(string $method, string $url, array $params = [], array $headers = []): array
    {
        $currentApiKey = $this->_apiKey;

        if (!$currentApiKey) {
            $msg = 'No API key provided.  (HINT: set your API key using '
                . '"SchierProductApi::setApiKey(<API-KEY>)".  You can generate API keys from '
                . 'the Schier Product Api web interface.  See https://api.schierproducts.com for '
                . 'details, or email developers@schierproducts.com if you have any questions.';

            throw new Exception\AuthenticationException($msg);
        }

        $absUrl = $this->_apiBase . $url;
        $params = self::_encodeObjects($params);
        $defaultHeaders = $this->_defaultHeaders($currentApiKey);
        if ($this->_apiVersion) {
            $defaultHeaders['Product-Api-Version'] = $this->_apiVersion;
        }

        $combinedHeaders = \array_merge($defaultHeaders, $headers);
        $rawHeaders = [];

        foreach ($combinedHeaders as $header => $value) {
            $rawHeaders[] = $header . ': ' . $value;
        }

        list($rbody, $rcode, $rheaders) = $this->httpClient()->request(
            $method,
            $absUrl,
            $params,
            $rawHeaders,
        );

        return [$rbody, $rcode, $rheaders, $currentApiKey];
    }

    /**
     * @param string $responseBody
     * @param int    $responseCode
     * @param array  $responseHeaders
     *
     * @throws Exception\UnexpectedValueException
     * @throws Exception\ApiErrorException
     *
     * @return array
     */
    private function _interpretResponse(string $responseBody, int $responseCode, array $responseHeaders = [])
    {
        $response = \json_decode($responseBody, true);
        $jsonError = \json_last_error();
        if (null === $response && \JSON_ERROR_NONE !== $jsonError) {
            $msg = "Invalid response body from API: {$responseBody} "
                . "(HTTP response code was {$responseCode}, json_last_error() was {$jsonError})";

            throw new Exception\UnexpectedValueException($msg, $responseCode);
        }

        if ($responseCode < 200 || $responseCode >= 300) {
            $this->handleErrorResponse($responseBody, $responseCode, $responseHeaders, $response);
        }

        return $response;
    }

    /**
     * @param string $rbody a JSON string
     * @param int $rcode
     * @param array $rheaders
     * @param array $resp
     *
     * @throws Exception\UnexpectedValueException
     * @throws Exception\ApiErrorException
     */
    public function handleErrorResponse($rbody, $rcode, $rheaders, $resp)
    {
        if (!\is_array($resp) || (!isset($resp['error']) && !isset($resp['message']))) {
            $msg = "Invalid response object from API: {$rbody} "
                . "(HTTP response code was {$rcode})";

            throw new Exception\UnexpectedValueException($msg);
        }

        throw self::_specificAPIError($rbody, $rcode, $rheaders, $resp, $resp);
    }

    /**
     * @param string|null $apiKey
     * @return array|string[]
     */
    public function getDefaultHeaders(?string $apiKey = null) : array
    {
        if (!$apiKey) {
            $apiKey = $this->_apiKey;
        }
        return self::_defaultHeaders($apiKey);
    }

    /**
     * @static
     *
     * @param string $rbody
     * @param int    $rcode
     * @param array  $rheaders
     * @param array  $resp
     * @param array  $errorData
     *
     * @return Exception\ApiErrorException
     */
    private static function _specificAPIError($rbody, $rcode, $rheaders, $resp, $errorData)
    {
        if (isset($errorData['message'])) {
            $message = $errorData['message'];
        } elseif (isset($errorData['error'])) {
            $message = $errorData['error'];
        } else {
            // fallback
            $message = "An error has occurred";
        }

        switch ($rcode) {
            // no break
            case 404:
                return Exception\InvalidRequestException::factory($message, $rcode, $rbody, $resp, $rheaders);

            case 401:
                if (str_contains($message, 'Unauthenticated')) {
                    $message = 'It appears that your API key is not correct.';
                }

                return Exception\AuthenticationException::factory($message, $rcode, $rbody, $resp, $rheaders);

            case 403:
                return Exception\PermissionException::factory($message, $rcode, $rbody, $resp, $rheaders);

            case 429:
                return Exception\RateLimitException::factory($message, $rcode, $rbody, $resp, $rheaders);

            default:
                return Exception\UnknownApiErrorException::factory($message, $rcode, $rbody, $resp, $rheaders);
        }
    }

    /**
     * @static
     *
     * @param string $apiKey
     * @param null   $clientInfo
     *
     * @return array
     */
    private static function _defaultHeaders($apiKey, $clientInfo = null)
    {
        $langVersion = \PHP_VERSION;
        $ua = [
            'lang' => 'php',
            'lang_version' => $langVersion,
            'publisher' => 'schier',
        ];
        if ($clientInfo) {
            $ua = \array_merge($clientInfo, $ua);
        }

        return [
            'X-Schier-Client-User-Agent' => \json_encode($ua),
            'Authorization' => 'Bearer ' . $apiKey,
        ];
    }

    /**
     * @return HttpClient\RequestClient
     */
    private function httpClient()
    {
        if (!self::$_httpClient) {
            self::$_httpClient = HttpClient\RequestClient::instance();
        }

        return self::$_httpClient;
    }

    /**
     * @param HttpClient\RequestClient|\Illuminate\Http\Client\Factory $httpClient
     */
    public function setHttpClient($httpClient): void
    {
        $this->httpClient()
            ->setFactory($httpClient);
    }

    /**
     * @static
     *
     * @param ApiResource|array|bool|mixed $d
     *
     * @return ApiResource|array|mixed|string
     */
    private static function _encodeObjects($d)
    {
        if ($d instanceof ApiResource) {
            return Utilities::utf8($d->id);
        }
        if (true === $d) {
            return 'true';
        }
        if (false === $d) {
            return 'false';
        }
        if (\is_array($d)) {
            $res = [];
            foreach ($d as $k => $v) {
                $res[$k] = self::_encodeObjects($v);
            }

            return $res;
        }

        return Utilities::utf8($d);
    }
}