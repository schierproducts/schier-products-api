<?php


namespace SchierProducts\SchierProductApi\Utilities;

use SchierProducts\SchierProductApi\Exception;
use SchierProducts\SchierProductApi\SchierProductApi;

class RequestOptions
{
    /** @var array<string, string> */
    public $headers;

    /** @var null|string */
    public $apiKey;

    /** @var null|string */
    public $apiBase;

    /**
     * @param null|string $key
     * @param array<string, string> $headers
     * @param null|string $base
     */
    public function __construct($key = null, $headers = [], $base = null)
    {
        $this->apiKey = $key;
        $this->headers = $headers;
        $this->apiBase = $base;
    }

    /**
     * @return array<string, string>
     */
    public function __debugInfo()
    {
        return [
            'apiKey' => $this->redactedApiKey(),
            'headers' => $this->headers,
            'apiBase' => $this->apiBase,
        ];
    }

    /**
     * Unpacks an options array and merges it into the existing RequestOptions
     * object.
     *
     * @param null|array|RequestOptions|string $options a key => value array
     * @param bool $strict when true, forbid string form and arbitrary keys in array form
     *
     * @return RequestOptions
     */
    public function merge($options, $strict = false)
    {
        $other_options = self::parse($options, $strict);
        if (null === $other_options->apiKey) {
            $other_options->apiKey = $this->apiKey;
        }
        if (null === $other_options->apiBase) {
            $other_options->apiBase = $this->apiBase;
        }
        $other_options->headers = \array_merge($this->headers, $other_options->headers);

        return $other_options;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return [
            'headers' => $this->headers,
            'api_key' => $this->apiKey,
            'api_base' => $this->apiBase,
        ];
    }

    /**
     * Unpacks an options array into an RequestOptions object.
     *
     * @param null|array|RequestOptions|string $options a key => value array
     * @param bool $strict when true, forbid string form and arbitrary keys in array form
     *
     * @throws Exception\InvalidArgumentException
     *
     * @return RequestOptions
     */
    public static function parse($options, $strict = false)
    {
        if ($options instanceof self) {
            return $options;
        }

        if (null === $options) {
            return new RequestOptions(null, [], null);
        }

        if (\is_string($options)) {
            if ($strict) {
                $message = 'Do not pass a string for request options. If you want to set the '
                    . 'API key, pass an array like ["api_key" => <apiKey>] instead.';

                throw new Exception\InvalidArgumentException($message);
            }

            return new RequestOptions($options, [], null);
        }

        if (\is_array($options)) {
            $headers = [];
            $key = null;
            $base = null;

            if (\array_key_exists('api_key', $options)) {
                $key = $options['api_key'];
                unset($options['api_key']);
            }
            if (\array_key_exists('api_version', $options)) {
                $headers['Product-Api-Version'] = $options['api_version'];
                unset($options['api_version']);
            }
            if (\array_key_exists('api_base', $options)) {
                $base = $options['api_base'];
                unset($options['api_base']);
            }

            if ($strict && !empty($options)) {
                $message = 'Got unexpected keys in options array: ' . \implode(', ', \array_keys($options));

                throw new Exception\InvalidArgumentException($message);
            }

            return new RequestOptions($key, $headers, $base);
        }

        $message = 'The second argument to Schier Product API method calls is an '
            . 'optional per-request apiKey, which must be a string, or '
            . 'per-request options, which must be an array. (HINT: you can set '
            . 'a global apiKey by "SchierProductApi::setApiKey(<apiKey>)")';

        throw new Exception\InvalidArgumentException($message);
    }

    private function redactedApiKey()
    {
        $pieces = \explode('_', $this->apiKey, 3);
        $last = \array_pop($pieces);
        $redactedLast = \strlen($last) > 4
            ? (\str_repeat('*', \strlen($last) - 4) . \substr($last, -4))
            : $last;
        $pieces[] = $redactedLast;

        return \implode('_', $pieces);
    }
}