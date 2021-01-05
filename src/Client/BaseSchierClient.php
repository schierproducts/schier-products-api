<?php


namespace SchierProducts\SchierProductApi\Client;

use \SchierProducts\SchierProductApi\Exception;
use SchierProducts\SchierProductApi\HttpClient\RequestClient;
use SchierProducts\SchierProductApi\Resources\InventoryItem;
use SchierProducts\SchierProductApi\SchierProductApi;
use \SchierProducts\SchierProductApi\Utilities;

class BaseSchierClient implements \SchierProducts\SchierProductApi\Client\SchierClientInterface
{
    /** @var string default base URL for the product API */
    const DEFAULT_API_BASE = 'https://api.schierproducts.com';

    /** @var array<string, mixed> */
    private $config;

    /** @var Utilities\RequestOptions */
    private $defaultOpts;

    /**
     * RequestClient constructor.
     *
     * @param array<string, mixed>|string $config the API key as a string, or an array containing
     *   the client configuration settings
     */
    public function __construct($config = [])
    {
        if (\is_string($config)) {
            $config = ['api_key' => $config];
        } elseif (!\is_array($config)) {
            throw new Exception\InvalidArgumentException('$config must be a string or an array');
        }

        $config = \array_merge($this->_defaultConfig(), $config);
        $this->validateConfig($config);

        $this->config = $config;

        SchierProductApi::setApiKey($this->config['api_key']);
        SchierProductApi::setApiBase($this->config['api_base']);

        $this->defaultOpts = Utilities\RequestOptions::parse([
            'api_version' => $config['api_version'],
        ]);
    }

    /**
     * Sends a request to the Schier Product API.
     *
     * @param string $method the HTTP method
     * @param string $path the path of the request
     * @param array $params the parameters of the request
     * @param array|Utilities\RequestOptions $opts the special modifiers of the request
     *
     * @return InventoryItem the object returned by Stripe's API
     * @throws Exception\AuthenticationException|Exception\ApiErrorException
     */
    public function request($method, $path, $params, $opts)
    {
        $opts = $this->defaultOpts->merge($opts, true);
        $baseUrl = $opts->apiBase ?: $this->getApiBase();
        $httpFactory = SchierProductApi::getHttpClient();

        $request = new \SchierProducts\SchierProductApi\ApiRequest($this->apiKeyForRequest($opts), $baseUrl);
        $request->setHttpClient($httpFactory);

        list($response, $opts->apiKey) = $request->request($method, $path, $params, $opts->headers);
        return  Utilities\Utilities::convertToInventoryItem($response->json, $opts);
    }

    /**
     * Sends a request to the Schier Product API.
     *
     * @param string $method the HTTP method
     * @param string $path the path of the request
     * @param array $params the parameters of the request
     * @param array|\SchierProducts\SchierProductApi\Utilities\RequestOptions $options the special modifiers of the request
     *
     * @return \SchierProducts\SchierProductApi\Collection of ApiResources
     */
    public function requestCollection($method, $path, $params, $options)
    {
        $obj = $this->request($method, $path, $params, $options);

        if (!($obj instanceof \SchierProducts\SchierProductApi\Collection)) {
            $received_class = \get_class($obj);
            $msg = "Expected to receive `SchierProducts\\SchierProductApi\\Collection` object from Schier Product API. Instead received `{$received_class}`.";

            throw new Exception\UnexpectedValueException($msg);
        }
        $obj->setFilters($params);

        return $obj;
    }

    /**
     * @inheritDoc
     */
    public function getApiKey()
    {
        return $this->config['api_key'];
    }

    /**
     * @inheritDoc
     */
    public function getApiBase()
    {
        return $this->config['api_base'];
    }

    /**
     * @param \SchierProducts\SchierProductApi\Utilities\RequestOptions $options
     *
     * @throws Exception\AuthenticationException
     *
     * @return string
     */
    private function apiKeyForRequest($options)
    {
        $apiKey = $options->apiKey ?: $this->getApiKey();

        if (null === $apiKey) {
            $msg = 'No API key provided. Set your API key when constructing the '
                . 'SchierClient instance, or provide it on a per-request basis '
                . 'using the `api_key` key in the $options argument.';

            throw new Exception\AuthenticationException($msg);
        }

        return $apiKey;
    }

    /**
     * @return array
     */
    private function _defaultConfig() : array
    {
        return [
            'api_key' => null,
            'api_version' => null,
            'api_base' => self::DEFAULT_API_BASE,
            'factory' => new \Illuminate\Http\Client\Factory
        ];
    }

    /**
     * @param array<string, mixed> $config
     *
     * @throws \SchierProducts\SchierProductApi\Exception\InvalidArgumentException
     */
    private function validateConfig($config)
    {
        // api_key
        if (null !== $config['api_key'] && !\is_string($config['api_key'])) {
            throw new \SchierProducts\SchierProductApi\Exception\InvalidArgumentException('api_key must be null or a string');
        }

        if (null !== $config['api_key'] && ('' === $config['api_key'])) {
            $msg = 'api_key cannot be the empty string';

            throw new \SchierProducts\SchierProductApi\Exception\InvalidArgumentException($msg);
        }

        if (null !== $config['api_key'] && (\preg_match('/\s/', $config['api_key']))) {
            $msg = 'api_key cannot contain whitespace';

            throw new \SchierProducts\SchierProductApi\Exception\InvalidArgumentException($msg);
        }

        // api_version
        if (null !== $config['api_version'] && !\is_string($config['api_version'])) {
            throw new \SchierProducts\SchierProductApi\Exception\InvalidArgumentException('api_version must be null or a string');
        }

        // api_base
        if (!\is_string($config['api_base'])) {
            throw new \SchierProducts\SchierProductApi\Exception\InvalidArgumentException('api_base must be a string');
        }

        // factory
        if (null !== $config['factory'] && !$config['factory'] instanceof \Illuminate\Http\Client\Factory) {
            throw new \SchierProducts\SchierProductApi\Exception\InvalidArgumentException('factory must be an instance of \\Illuminate\\Http\\Client\\Factory');
        }

        // check absence of extra keys
        $extraConfigKeys = \array_diff(\array_keys($config), \array_keys($this->_defaultConfig()));
        if (!empty($extraConfigKeys)) {
            // Wrap in single quote to more easily catch trailing spaces errors
            $invalidKeys = "'" . \implode("', '", $extraConfigKeys) . "'";

            throw new \SchierProducts\SchierProductApi\Exception\InvalidArgumentException('Found unknown key(s) in configuration array: ' . $invalidKeys);
        }
    }
}