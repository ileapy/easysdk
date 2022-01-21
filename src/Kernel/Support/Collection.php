<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/16 1:35
 * Copyright: php
 */

namespace easysdk\Kernel\Support;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use Serializable;

/**
 * Class Collection
 *
 * @package unionpay\Kernel
 */
class Collection implements ArrayAccess, Countable, IteratorAggregate, JsonSerializable, Serializable
{
    /**
     * The collection data.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Set the item value.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function set($key, $value)
    {
        self::setArr($this->items, $key, $value);
    }

    /**
     * Retrieve item from Collection.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return self::getArr($this->items, $key, $default);
    }

    /**
     * Build to array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->all();
    }

    /**
     * Return all items.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * @param array $array
     * @param $key
     * @return bool
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    public static function exists(array $array, $key)
    {
        return array_key_exists($key, $array);
    }

    /**
     * @param array $array
     * @param $key
     * @param null $default
     * @return array|mixed|null
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    public static function getArr(array $array, $key, $default = null)
    {
        if (is_null($key)) {
            return $array;
        }
        if (static::exists($array, $key)) {
            return $array[$key];
        }
        foreach (explode('.', $key) as $segment) {
            if (static::exists($array, $segment)) {
                $array = $array[$segment];
            } else {
                return $default;
            }
        }
        return $array;
    }

    /**
     * @param array $array
     * @param $key
     * @param $value
     * @return array|mixed
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    public static function setArr(array &$array, $key, $value)
    {
        $keys = explode('.', $key);
        while (count($keys) > 1) {
            $key = array_shift($keys);
            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = [];
            }
            $array = &$array[$key];
        }
        $array[array_shift($keys)] = $value;
        return $array;
    }

    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

    public function serialize()
    {
        // TODO: Implement serialize() method.
    }

    public function unserialize($data)
    {
        // TODO: Implement unserialize() method.
    }

    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }

    public function getIterator()
    {
        // TODO: Implement getIterator() method.
    }

    public function count()
    {
        // TODO: Implement count() method.
    }
}
