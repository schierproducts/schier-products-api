<?php


namespace SchierProducts\SchierProductApi\HttpClient;


use SchierProducts\SchierProductApi\Exception;
use SchierProducts\SchierProductApi\SchierProductApi;
use SchierProducts\SchierProductApi\Utilities;
use SchierProducts\SchierProductApi\Utilities\RequestOptions;

class RequestClient implements ClientInterface
{
    /** @var self */
    private static $instance;

    protected $defaultOptions;

    /**
     * Used for unit testing
     *
     * @return RequestClient
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /** @var \Illuminate\Http\Client\Factory */
    protected \Illuminate\Http\Client\Factory $factory;

    /**
     * RequestClient constructor.
     *
     * Pass in a callable to $defaultOptions that returns an array of CURLOPT_* values to start
     * off a request with, or an flat array with the same format used by curl_setopt_array() to
     *
     * Note that request() will silently ignore a non-callable, non-array $defaultOptions, and will
     * throw an exception if $defaultOptions returns a non-array value.
     *
     * @param null|array|callable $defaultOptions
     */
    public function __construct($defaultOptions = null)
    {
        $this->defaultOptions = $defaultOptions;

        $this->factory = new \Illuminate\Http\Client\Factory();
    }

    /**
     * @param \Illuminate\Http\Client\Factory $factory
     */
    public function setFactory(\Illuminate\Http\Client\Factory $factory): void
    {
        $this->factory = $factory;
    }

    /**
     * @param string $method
     * @param string $absUrl
     * @param array $params
     * @param array $headers
     * @return array
     * @throws \Exception
     */
    public function request(string $method = 'get', string $absUrl = 'https://api.schierproducts.com', array $params = [], array $headers = []): array
    {
        $method = \strtolower($method);

        if ('get' === $method || 'delete' === $method) {
            if (\count($params) > 0) {
                $encoded = Utilities\Utilities::encodeParameters($params);
                $absUrl = "{$absUrl}?{$encoded}";
            }
        } elseif ($method !== 'put' && $method !== 'post') {
            throw new Exception\UnexpectedValueException("Unrecognized method {$method}");
        }

        $absUrl = Utilities\Utilities::utf8($absUrl);

        $response = $this->factory
            ->withHeaders($headers)
            ->withToken(SchierProductApi::getApiKey())
            ->acceptJson()
            ->send($method, $absUrl);

        return [
            $response->body(),
            $response->status(),
            $response->headers(),
        ];
    }
}