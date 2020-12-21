<?php


namespace SchierProducts\SchierProductApi\Client;


use Illuminate\Support\Facades\Http;
use SchierProducts\SchierProductApi\Exception;
use SchierProducts\SchierProductApi\Utilities;

class RequestClient implements ClientInterface
{
    private static $instance;

    protected \Illuminate\Http\Client\Factory $factory;

    /**
     * RequestClient constructor.
     */
    public function __construct()
    {
        $this->factory = new \Illuminate\Http\Client\Factory();
    }

    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
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
     * @param array $headers
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public function request(string $method = 'get', string $absUrl = 'https://api.schierproducts.com', array $headers = [], array $params = []): array
    {
        $method = \strtolower($method);

        if ('get' === $method || 'delete' === $method) {
            if (\count($params) > 0) {
                $encoded = Utilities\Utilities::urlEncode($params);
                $absUrl = "{$absUrl}?{$encoded}";
            }
        } elseif ($method !== 'put' && $method !== 'post') {
            throw new Exception\UnexpectedValueException("Unrecognized method {$method}");
        }

        $absUrl = Utilities\Utilities::utf8($absUrl);

        $response = $this->factory->withHeaders($headers)
            ->send($method, $absUrl);

        return [
            $response->body(),
            $response->status(),
            $response->headers(),
        ];
    }
}