<?php

declare(strict_types=1);

namespace Twilio;

class Values implements \ArrayAccess
{
    public const NONE = 'Twilio\\Values\\NONE';
    public const ARRAY_NONE = [self::NONE];

    protected $options;

    public function __construct(array $options)
    {
        $this->options = [];
        foreach ($options as $key => $value) {
            $this->options[\strtolower($key)] = $value;
        }
    }

    public static function array_get(array $array, string $key, string $default = null)
    {
        if (\array_key_exists($key, $array)) {
            return $array[$key];
        }

        return $default;
    }

    public static function of(array $array): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            if (self::NONE !== $value && self::ARRAY_NONE !== $value) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists.
     *
     * @see http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return bool true on success or false on failure.
     *              </p>
     *              <p>
     *              The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset): bool
    {
        return true;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve.
     *
     * @see http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed can return all value types
     */
    public function offsetGet($offset)
    {
        $offset = \strtolower($offset);

        return \array_key_exists($offset, $this->options) ? $this->options[$offset] : self::NONE;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set.
     *
     * @see http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     */
    public function offsetSet($offset, $value): void
    {
        $this->options[\strtolower($offset)] = $value;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset.
     *
     * @see http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     */
    public function offsetUnset($offset): void
    {
        unset($this->options[$offset]);
    }
}
