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
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 *
 * @version    ##VERSION##, ##DATE##
 */

/**
 * PHPExcel_CachedObjectStorage_SQLite.
 *
 * @category   PHPExcel
 *
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_CachedObjectStorage_SQLite extends PHPExcel_CachedObjectStorage_CacheBase implements PHPExcel_CachedObjectStorage_ICache
{
    /**
     * Database table name.
     *
     * @var string
     */
    private $_TableName;

    /**
     * Database handle.
     *
     * @var resource
     */
    private $_DBHandle;

    /**
     * Initialise this new cell collection.
     *
     * @param PHPExcel_Worksheet $parent The worksheet for this cell collection
     */
    public function __construct(PHPExcel_Worksheet $parent)
    {
        parent::__construct($parent);
        if (is_null($this->_DBHandle)) {
            $this->_TableName = str_replace('.', '_', $this->_getUniqueID());
            $_DBName = ':memory:';

            $this->_DBHandle = new SQLiteDatabase($_DBName);
            if (false === $this->_DBHandle) {
                throw new PHPExcel_Exception(sqlite_error_string($this->_DBHandle->lastError()));
            }
            if (!$this->_DBHandle->queryExec('CREATE TABLE kvp_'.$this->_TableName.' (id VARCHAR(12) PRIMARY KEY, value BLOB)')) {
                throw new PHPExcel_Exception(sqlite_error_string($this->_DBHandle->lastError()));
            }
        }
    }	//	function __construct()

    /**
     * Destroy this cell collection.
     */
    public function __destruct()
    {
        if (!is_null($this->_DBHandle)) {
            $this->_DBHandle->queryExec('DROP TABLE kvp_'.$this->_TableName);
        }
        $this->_DBHandle = null;
    }	//	function __destruct()

    /**
     * Add or Update a cell in cache identified by coordinate address.
     *
     * @param string        $pCoord Coordinate address of the cell to update
     * @param PHPExcel_Cell $cell   Cell to update
     *
     * @throws PHPExcel_Exception
     *
     * @return PHPExcel_Cell
     */
    public function addCacheData($pCoord, PHPExcel_Cell $cell)
    {
        if (($pCoord !== $this->_currentObjectID) && (null !== $this->_currentObjectID)) {
            $this->_storeData();
        }

        $this->_currentObjectID = $pCoord;
        $this->_currentObject = $cell;
        $this->_currentCellIsDirty = true;

        return $cell;
    }	//	function addCacheData()

    /**
     * Get cell at a specific coordinate.
     *
     * @param string $pCoord Coordinate of the cell
     *
     * @throws PHPExcel_Exception
     *
     * @return PHPExcel_Cell Cell that was found, or null if not found
     */
    public function getCacheData($pCoord)
    {
        if ($pCoord === $this->_currentObjectID) {
            return $this->_currentObject;
        }
        $this->_storeData();

        $query = 'SELECT value FROM kvp_'.$this->_TableName." WHERE id='".$pCoord."'";
        $cellResultSet = $this->_DBHandle->query($query, SQLITE_ASSOC);
        if (false === $cellResultSet) {
            throw new PHPExcel_Exception(sqlite_error_string($this->_DBHandle->lastError()));
        }
        if (0 == $cellResultSet->numRows()) {
            //	Return null if requested entry doesn't exist in cache
            return null;
        }

        //	Set current entry to the requested entry
        $this->_currentObjectID = $pCoord;

        $cellResult = $cellResultSet->fetchSingle();
        $this->_currentObject = unserialize($cellResult);
        //    Re-attach this as the cell's parent
        $this->_currentObject->attach($this);

        //	Return requested entry
        return $this->_currentObject;
    }	//	function getCacheData()

    /**
     * Is a value set for an indexed cell?
     *
     * @param string $pCoord Coordinate address of the cell to check
     *
     * @return bool
     */
    public function isDataSet($pCoord)
    {
        if ($pCoord === $this->_currentObjectID) {
            return true;
        }

        //	Check if the requested entry exists in the cache
        $query = 'SELECT id FROM kvp_'.$this->_TableName." WHERE id='".$pCoord."'";
        $cellResultSet = $this->_DBHandle->query($query, SQLITE_ASSOC);
        if (false === $cellResultSet) {
            throw new PHPExcel_Exception(sqlite_error_string($this->_DBHandle->lastError()));
        }
        if (0 == $cellResultSet->numRows()) {
            //	Return null if requested entry doesn't exist in cache
            return false;
        }

        return true;
    }	//	function isDataSet()

    /**
     * Delete a cell in cache identified by coordinate address.
     *
     * @param string $pCoord Coordinate address of the cell to delete
     *
     * @throws PHPExcel_Exception
     */
    public function deleteCacheData($pCoord): void
    {
        if ($pCoord === $this->_currentObjectID) {
            $this->_currentObject->detach();
            $this->_currentObjectID = $this->_currentObject = null;
        }

        //	Check if the requested entry exists in the cache
        $query = 'DELETE FROM kvp_'.$this->_TableName." WHERE id='".$pCoord."'";
        if (!$this->_DBHandle->queryExec($query)) {
            throw new PHPExcel_Exception(sqlite_error_string($this->_DBHandle->lastError()));
        }

        $this->_currentCellIsDirty = false;
    }	//	function deleteCacheData()

    /**
     * Move a cell object from one address to another.
     *
     * @param string $fromAddress Current address of the cell to move
     * @param string $toAddress   Destination address of the cell to move
     *
     * @return bool
     */
    public function moveCell($fromAddress, $toAddress)
    {
        if ($fromAddress === $this->_currentObjectID) {
            $this->_currentObjectID = $toAddress;
        }

        $query = 'DELETE FROM kvp_'.$this->_TableName." WHERE id='".$toAddress."'";
        $result = $this->_DBHandle->exec($query);
        if (false === $result) {
            throw new PHPExcel_Exception($this->_DBHandle->lastErrorMsg());
        }

        $query = 'UPDATE kvp_'.$this->_TableName." SET id='".$toAddress."' WHERE id='".$fromAddress."'";
        $result = $this->_DBHandle->exec($query);
        if (false === $result) {
            throw new PHPExcel_Exception($this->_DBHandle->lastErrorMsg());
        }

        return true;
    }	//	function moveCell()

    /**
     * Get a list of all cell addresses currently held in cache.
     *
     * @return string[]
     */
    public function getCellList()
    {
        if (null !== $this->_currentObjectID) {
            $this->_storeData();
        }

        $query = 'SELECT id FROM kvp_'.$this->_TableName;
        $cellIdsResult = $this->_DBHandle->unbufferedQuery($query, SQLITE_ASSOC);
        if (false === $cellIdsResult) {
            throw new PHPExcel_Exception(sqlite_error_string($this->_DBHandle->lastError()));
        }

        $cellKeys = [];
        foreach ($cellIdsResult as $row) {
            $cellKeys[] = $row['id'];
        }

        return $cellKeys;
    }	//	function getCellList()

    /**
     * Clone the cell collection.
     *
     * @param PHPExcel_Worksheet $parent The new worksheet
     */
    public function copyCellCollection(PHPExcel_Worksheet $parent): void
    {
        $this->_currentCellIsDirty;
        $this->_storeData();

        //	Get a new id for the new table name
        $tableName = str_replace('.', '_', $this->_getUniqueID());
        if (!$this->_DBHandle->queryExec('CREATE TABLE kvp_'.$tableName.' (id VARCHAR(12) PRIMARY KEY, value BLOB)
													AS SELECT * FROM kvp_'.$this->_TableName)) {
            throw new PHPExcel_Exception(sqlite_error_string($this->_DBHandle->lastError()));
        }

        //	Copy the existing cell cache file
        $this->_TableName = $tableName;
    }	//	function copyCellCollection()

    /**
     * Clear the cell collection and disconnect from our parent.
     */
    public function unsetWorksheetCells(): void
    {
        if (!is_null($this->_currentObject)) {
            $this->_currentObject->detach();
            $this->_currentObject = $this->_currentObjectID = null;
        }
        //	detach ourself from the worksheet, so that it can then delete this object successfully
        $this->_parent = null;

        //	Close down the temporary cache file
        $this->__destruct();
    }	//	function unsetWorksheetCells()

    /**
     * Identify whether the caching method is currently available
     * Some methods are dependent on the availability of certain extensions being enabled in the PHP build.
     *
     * @return bool
     */
    public static function cacheMethodIsAvailable()
    {
        if (!function_exists('sqlite_open')) {
            return false;
        }

        return true;
    }

    /**
     * Store cell data in cache for the current cell object if it's "dirty",
     *     and the 'nullify' the current cell object.
     *
     * @throws PHPExcel_Exception
     */
    protected function _storeData(): void
    {
        if ($this->_currentCellIsDirty && !empty($this->_currentObjectID)) {
            $this->_currentObject->detach();

            if (!$this->_DBHandle->queryExec('INSERT OR REPLACE INTO kvp_'.$this->_TableName." VALUES('".$this->_currentObjectID."','".sqlite_escape_string(serialize($this->_currentObject))."')")) {
                throw new PHPExcel_Exception(sqlite_error_string($this->_DBHandle->lastError()));
            }
            $this->_currentCellIsDirty = false;
        }
        $this->_currentObjectID = $this->_currentObject = null;
    }	//	function _storeData()
}
