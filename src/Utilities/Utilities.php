<?php


namespace SchierProducts\SchierProductApi\Utilities;


class Utilities
{
    /**
     * @var null|bool
     */
    private static $isMbstringAvailable = null;

    /**
     * @param string|mixed $key a string to URL-encode
     *
     * @return string the URL-encoded string
     */
    public static function urlEncode($key) : string
    {
        $s = \urlencode((string) $key);

        // Don't use strict form encoding by changing the square bracket control
        // characters back to their literals. This is fine by the server, and
        // makes these parameter strings easier to read.
        $s = \str_replace('%5B', '[', $s);

        return \str_replace('%5D', ']', $s);
    }

    /**
     * @param array $params
     *
     * @return string
     */
    public static function encodeParameters($params)
    {
        $flattenedParams = self::flattenParams($params);
        $pieces = [];
        foreach ($flattenedParams as $param) {
            list($k, $v) = $param;
            $pieces[] = self::urlEncode($k) . '=' . self::urlEncode($v);
        }

        return \implode('&', $pieces);
    }

    /**
     * @param array $params
     * @param null|string $parentKey
     *
     * @return array
     */
    public static function flattenParams($params, $parentKey = null)
    {
        $result = [];

        foreach ($params as $key => $value) {
            $calculatedKey = $parentKey ? "{$parentKey}[{$key}]" : $key;

            if (self::isList($value)) {
                $result = \array_merge($result, self::flattenParamsList($value, $calculatedKey));
            } elseif (\is_array($value)) {
                $result = \array_merge($result, self::flattenParams($value, $calculatedKey));
            } else {
                \array_push($result, [$calculatedKey, $value]);
            }
        }

        return $result;
    }

    /**
     * @param array $value
     * @param string $calculatedKey
     *
     * @return array
     */
    public static function flattenParamsList($value, $calculatedKey)
    {
        $result = [];

        foreach ($value as $i => $elem) {
            if (self::isList($elem)) {
                $result = \array_merge($result, self::flattenParamsList($elem, $calculatedKey));
            } elseif (\is_array($elem)) {
                $result = \array_merge($result, self::flattenParams($elem, "{$calculatedKey}[{$i}]"));
            } else {
                \array_push($result, ["{$calculatedKey}[{$i}]", $elem]);
            }
        }

        return $result;
    }

    /**
     * @param mixed|string $value a string to UTF8-encode
     *
     * @return mixed|string the UTF8-encoded string, or the object passed in if
     *    it wasn't a string
     */
    public static function utf8($value)
    {
        if (null === self::$isMbstringAvailable) {
            self::$isMbstringAvailable = \function_exists('mb_detect_encoding');

            if (!self::$isMbstringAvailable) {
                \trigger_error('It looks like the mbstring extension is not enabled. ' .
                    'UTF-8 strings will not properly be encoded. Ask your system ' .
                    'administrator to enable the mbstring extension, or write to ' .
                    'developers@schierproducts.com if you have any questions.', \E_USER_WARNING);
            }
        }

        if (\is_string($value) && self::$isMbstringAvailable && 'UTF-8' !== \mb_detect_encoding($value, 'UTF-8', true)) {
            return \utf8_encode($value);
        }

        return $value;
    }

    /**
     * Whether the provided array (or other) is a list rather than a dictionary.
     * A list is defined as an array for which all the keys are consecutive
     * integers starting at 0. Empty arrays are considered to be lists.
     *
     * @param array|mixed $array
     *
     * @return bool true if the given object is a list
     */
    public static function isList($array)
    {
        if (!\is_array($array)) {
            return false;
        }
        if ([] === $array) {
            return true;
        }

        if (\array_keys($array) !== \range(0, \count($array) - 1)) {
            return false;
        }

        return true;
    }

    /**
     * Converts a response from the Schier Product API to the corresponding PHP object.
     *
     * @param array $resp the response from the Schier Product API
     * @param array|\SchierProducts\SchierProductApi\Utilities\RequestOptions $opts
     *
     * @return array|\SchierProducts\SchierProductApi\Resources\InventoryItem|\SchierProducts\SchierProductApi\Collection
     */
    public static function convertToInventoryItem($resp, $opts)
    {
        $types = \SchierProducts\SchierProductApi\Utilities\Types::getClassMap();
        if (self::isList($resp)) {
            $mapped = [];
            foreach ($resp as $i) {
                $mapped[] = self::convertToInventoryItem($i, $opts);
            }

            return $mapped;
        }
        if (\is_array($resp)) {
            if (isset($resp['object']) && \is_string($resp['object']) && isset($types[$resp['object']])) {
                $class = $types[$resp['object']];
            } else {
                $class = \SchierProducts\SchierProductApi\Resources\InventoryItem::class;
            }

            return $class::constructFrom($resp, $opts);
        }

        return $resp;
    }
}