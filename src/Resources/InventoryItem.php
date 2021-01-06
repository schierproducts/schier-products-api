<?php


namespace SchierProducts\SchierProductApi\Resources;

/**
 * Class InventoryItem
 * @package SchierProducts\SchierProductApi\Resources
 * @property string $object - The type of object
 * @property string $url - The url that can be used to retrieve this object
 */
class InventoryItem
{
    /** @var array|\SchierProducts\SchierProductApi\Utilities\RequestOptions[] */
    protected $_opts;

    /** @var array */
    protected $_originalValues;

    /** @var array */
    protected $_values;

    /** @var null|array */
    protected $_retrieveOptions;

    /**
     * InventoryItem constructor.
     * @param null $id
     * @param null $opts
     */
    public function __construct($id = null, $opts = null)
    {
        $this->_opts = \SchierProducts\SchierProductApi\Utilities\RequestOptions::parse($opts);
        $this->_values = [];

        if (null !== $id) {
            $this->_values['id'] = $id;
        }
    }

    /**
     * @param string $k
     * @param mixed $v
     */
    public function __set($k, $v)
    {
        $this->_values[$k] = \SchierProducts\SchierProductApi\Utilities\Utilities::convertToInventoryItem($v, $this->_opts);
    }

    /**
     * @param string $k
     * @return bool
     */
    public function __isset($k)
    {
        return isset($this->_values[$k]);
    }

    /**
     * @param string $k
     */
    public function __unset($k)
    {
        unset($this->_values[$k]);
    }

    public function &__get($k)
    {
        // function should return a reference, using $nullval to return a reference to null
        $nullval = null;
        if (!empty($this->_values) && \array_key_exists($k, $this->_values)) {
            return $this->_values[$k];
        }
        if (!empty($this->_transientValues) && $this->_transientValues->includes($k)) {
            $class = static::class;
            $attrs = \implode(', ', \array_keys($this->_values));

            return $nullval;
        }

        return $nullval;
    }

    // Magic method for var_dump output. Only works with PHP >= 5.6
    public function __debugInfo()
    {
        return $this->_values;
    }

    // ArrayAccess methods
    public function offsetSet($k, $v)
    {
        $this->{$k} = $v;
    }

    public function offsetExists($k)
    {
        return \array_key_exists($k, $this->_values);
    }

    public function offsetUnset($k)
    {
        unset($this->{$k});
    }

    public function offsetGet($k)
    {
        return \array_key_exists($k, $this->_values) ? $this->_values[$k] : null;
    }

    // Countable method
    public function count()
    {
        return \count($this->_values);
    }

    public function keys()
    {
        return \array_keys($this->_values);
    }

    public function values()
    {
        return \array_values($this->_values);
    }

    /**
     * This unfortunately needs to be public to be used in Util\Util.
     *
     * @param array $values
     * @param null|array|string|\SchierProducts\SchierProductApi\Utilities\RequestOptions $opts
     *
     * @return static the object constructed from the given values
     */
    public static function constructFrom($values, $opts = null)
    {
        $obj = new static(isset($values['id']) ? $values['id'] : null);
        $obj->refreshFrom($values, $opts);

        return $obj;
    }

    /**
     * Refreshes this object using the provided values.
     *
     * @param array $values
     * @param null|array|string|\SchierProducts\SchierProductApi\Utilities\RequestOptions $opts
     * @param bool $partial defaults to false
     */
    public function refreshFrom($values, $opts, $partial = false)
    {
        $this->_opts = \SchierProducts\SchierProductApi\Utilities\RequestOptions::parse($opts);

        $this->_originalValues = self::deepCopy($values);

        if ($values instanceof InventoryItem) {
            $values = $values->toArray();
        }

        $this->updateAttributes($values, $opts);
    }

    /**
     * Mass assigns attributes on the model.
     *
     * @param array $values
     * @param null|array|string|\SchierProducts\SchierProductApi\Utilities\RequestOptions $opts
     */
    public function updateAttributes($values, $opts = null)
    {
        $nestedValues = [
            'product-image-library',
            'product-image',
            'dimension-set',
            'dimensions',
            'measurement',
        ];

        foreach ($values as $k => $v) {
            if (in_array($k, $nestedValues) && (\is_array($v))) {
                $this->_values[$k] = InventoryItem::constructFrom($v, $opts);
            } else {
                $this->_values[$k] = \SchierProducts\SchierProductApi\Utilities\Utilities::convertToInventoryItem($v, $opts);
            }
        }
    }

    /**
     * Returns an associative array with the key and values composing the
     * InventoryItem object.
     *
     * @return array the associative array
     */
    public function toArray(): array
    {
        $maybeToArray = function ($value) {
            if (null === $value) {
                return null;
            }

            return \is_object($value) && \method_exists($value, 'toArray') ? $value->toArray() : $value;
        };

        return \array_reduce(\array_keys($this->_values), function ($acc, $k) use ($maybeToArray) {
            if ('_' === \substr((string) $k, 0, 1)) {
                return $acc;
            }
            $v = $this->_values[$k];
            if (\SchierProducts\SchierProductApi\Utilities\Utilities::isList($v)) {
                $acc[$k] = \array_map($maybeToArray, $v);
            } else {
                $acc[$k] = $maybeToArray($v);
            }

            return $acc;
        }, []);
    }

    /**
     * Returns a pretty JSON representation of the Inventory Item object.
     *
     * @return string the JSON representation of the Inventory Item object
     */
    public function toJSON(): string
    {
        return \json_encode($this->toArray(), \JSON_PRETTY_PRINT);
    }

    public function __toString(): string
    {
        $class = static::class;

        return $class . ' JSON: ' . $this->toJSON();
    }

    /**
     * Produces a deep copy of the given object including support for arrays
     * and Inventory Items.
     *
     * @param mixed $obj
     * @return mixed
     */
    protected static function deepCopy($obj)
    {
        if (\is_array($obj)) {
            $copy = [];
            foreach ($obj as $k => $v) {
                $copy[$k] = self::deepCopy($v);
            }

            return $copy;
        }
        if ($obj instanceof InventoryItem) {
            return $obj::constructFrom(
                self::deepCopy($obj->_values),
                clone $obj->_opts
            );
        }

        return $obj;
    }
}