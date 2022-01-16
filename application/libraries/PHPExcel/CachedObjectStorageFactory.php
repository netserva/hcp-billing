<?php

declare(strict_types=1);

/**
 * PHPExcel.
 *
 * Copyright (c) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 *
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 *
 * @version    ##VERSION##, ##DATE##
 */

/**
 * PHPExcel_CachedObjectStorageFactory.
 *
 * @category    PHPExcel
 *
 * @copyright    Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_CachedObjectStorageFactory
{
    public const cache_in_memory = 'Memory';
    public const cache_in_memory_gzip = 'MemoryGZip';
    public const cache_in_memory_serialized = 'MemorySerialized';
    public const cache_igbinary = 'Igbinary';
    public const cache_to_discISAM = 'DiscISAM';
    public const cache_to_apc = 'APC';
    public const cache_to_memcache = 'Memcache';
    public const cache_to_phpTemp = 'PHPTemp';
    public const cache_to_wincache = 'Wincache';
    public const cache_to_sqlite = 'SQLite';
    public const cache_to_sqlite3 = 'SQLite3';

    /**
     * Name of the method used for cell cacheing.
     *
     * @var string
     */
    private static $_cacheStorageMethod;

    /**
     * Name of the class used for cell cacheing.
     *
     * @var string
     */
    private static $_cacheStorageClass;

    /**
     * List of all possible cache storage methods.
     *
     * @var string[]
     */
    private static $_storageMethods = [
        self::cache_in_memory,
        self::cache_in_memory_gzip,
        self::cache_in_memory_serialized,
        self::cache_igbinary,
        self::cache_to_phpTemp,
        self::cache_to_discISAM,
        self::cache_to_apc,
        self::cache_to_memcache,
        self::cache_to_wincache,
        self::cache_to_sqlite,
        self::cache_to_sqlite3,
    ];

    /**
     * Default arguments for each cache storage method.
     *
     * @var array of mixed array
     */
    private static $_storageMethodDefaultParameters = [
        self::cache_in_memory => [
        ],
        self::cache_in_memory_gzip => [
        ],
        self::cache_in_memory_serialized => [
        ],
        self::cache_igbinary => [
        ],
        self::cache_to_phpTemp => ['memoryCacheSize' => '1MB',
        ],
        self::cache_to_discISAM => ['dir' => null,
        ],
        self::cache_to_apc => ['cacheTime' => 600,
        ],
        self::cache_to_memcache => ['memcacheServer' => 'localhost',
            'memcachePort' => 11211,
            'cacheTime' => 600,
        ],
        self::cache_to_wincache => ['cacheTime' => 600,
        ],
        self::cache_to_sqlite => [
        ],
        self::cache_to_sqlite3 => [
        ],
    ];

    /**
     * Arguments for the active cache storage method.
     *
     * @var array of mixed array
     */
    private static $_storageMethodParameters = [];

    /**
     * Return the current cache storage method.
     *
     * @return null|string
     */
    public static function getCacheStorageMethod()
    {
        return self::$_cacheStorageMethod;
    }   //    function getCacheStorageMethod()

    /**
     * Return the current cache storage class.
     *
     * @return null|PHPExcel_CachedObjectStorage_ICache
     */
    public static function getCacheStorageClass()
    {
        return self::$_cacheStorageClass;
    }   //    function getCacheStorageClass()

    /**
     * Return the list of all possible cache storage methods.
     *
     * @return string[]
     */
    public static function getAllCacheStorageMethods()
    {
        return self::$_storageMethods;
    }   //    function getCacheStorageMethods()

    /**
     * Return the list of all available cache storage methods.
     *
     * @return string[]
     */
    public static function getCacheStorageMethods()
    {
        $activeMethods = [];
        foreach (self::$_storageMethods as $storageMethod) {
            $cacheStorageClass = 'PHPExcel_CachedObjectStorage_'.$storageMethod;
            if (call_user_func([$cacheStorageClass, 'cacheMethodIsAvailable'])) {
                $activeMethods[] = $storageMethod;
            }
        }

        return $activeMethods;
    }   //    function getCacheStorageMethods()

    /**
     * Identify the cache storage method to use.
     *
     * @param string $method Name of the method to use for cell cacheing
     * @param    array of mixed    $arguments    Additional arguments to pass to the cell caching class
     *                                        when instantiating
     *
     * @return bool
     */
    public static function initialize($method = self::cache_in_memory, $arguments = [])
    {
        if (!in_array($method, self::$_storageMethods)) {
            return false;
        }

        $cacheStorageClass = 'PHPExcel_CachedObjectStorage_'.$method;
        if (!call_user_func([$cacheStorageClass,
            'cacheMethodIsAvailable', ])) {
            return false;
        }

        self::$_storageMethodParameters[$method] = self::$_storageMethodDefaultParameters[$method];
        foreach ($arguments as $k => $v) {
            if (array_key_exists($k, self::$_storageMethodParameters[$method])) {
                self::$_storageMethodParameters[$method][$k] = $v;
            }
        }

        if (null === self::$_cacheStorageMethod) {
            self::$_cacheStorageClass = 'PHPExcel_CachedObjectStorage_'.$method;
            self::$_cacheStorageMethod = $method;
        }

        return true;
    }   //    function initialize()

    /**
     * Initialise the cache storage.
     *
     * @param PHPExcel_Worksheet $parent Enable cell caching for this worksheet
     *
     * @return PHPExcel_CachedObjectStorage_ICache
     */
    public static function getInstance(PHPExcel_Worksheet $parent)
    {
        $cacheMethodIsAvailable = true;
        if (null === self::$_cacheStorageMethod) {
            $cacheMethodIsAvailable = self::initialize();
        }

        if ($cacheMethodIsAvailable) {
            $instance = new self::$_cacheStorageClass(
                $parent,
                self::$_storageMethodParameters[self::$_cacheStorageMethod]
            );
            if (null !== $instance) {
                return $instance;
            }
        }

        return false;
    }   //    function getInstance()

    /**
     * Clear the cache storage.
     */
    public static function finalize(): void
    {
        self::$_cacheStorageMethod = null;
        self::$_cacheStorageClass = null;
        self::$_storageMethodParameters = [];
    }
}
