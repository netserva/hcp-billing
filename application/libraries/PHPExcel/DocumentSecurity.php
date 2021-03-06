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
 * PHPExcel_DocumentSecurity.
 *
 * @category   PHPExcel
 *
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_DocumentSecurity
{
    /**
     * LockRevision.
     *
     * @var bool
     */
    private $_lockRevision;

    /**
     * LockStructure.
     *
     * @var bool
     */
    private $_lockStructure;

    /**
     * LockWindows.
     *
     * @var bool
     */
    private $_lockWindows;

    /**
     * RevisionsPassword.
     *
     * @var string
     */
    private $_revisionsPassword;

    /**
     * WorkbookPassword.
     *
     * @var string
     */
    private $_workbookPassword;

    /**
     * Create a new PHPExcel_DocumentSecurity.
     */
    public function __construct()
    {
        // Initialise values
        $this->_lockRevision = false;
        $this->_lockStructure = false;
        $this->_lockWindows = false;
        $this->_revisionsPassword = '';
        $this->_workbookPassword = '';
    }

    /**
     * Implement PHP __clone to create a deep clone, not just a shallow copy.
     */
    public function __clone()
    {
        $vars = get_object_vars($this);
        foreach ($vars as $key => $value) {
            if (is_object($value)) {
                $this->{$key} = clone $value;
            } else {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * Is some sort of dcument security enabled?
     *
     * @return bool
     */
    public function isSecurityEnabled()
    {
        return $this->_lockRevision
                || $this->_lockStructure
                || $this->_lockWindows;
    }

    /**
     * Get LockRevision.
     *
     * @return bool
     */
    public function getLockRevision()
    {
        return $this->_lockRevision;
    }

    /**
     * Set LockRevision.
     *
     * @param bool $pValue
     *
     * @return PHPExcel_DocumentSecurity
     */
    public function setLockRevision($pValue = false)
    {
        $this->_lockRevision = $pValue;

        return $this;
    }

    /**
     * Get LockStructure.
     *
     * @return bool
     */
    public function getLockStructure()
    {
        return $this->_lockStructure;
    }

    /**
     * Set LockStructure.
     *
     * @param bool $pValue
     *
     * @return PHPExcel_DocumentSecurity
     */
    public function setLockStructure($pValue = false)
    {
        $this->_lockStructure = $pValue;

        return $this;
    }

    /**
     * Get LockWindows.
     *
     * @return bool
     */
    public function getLockWindows()
    {
        return $this->_lockWindows;
    }

    /**
     * Set LockWindows.
     *
     * @param bool $pValue
     *
     * @return PHPExcel_DocumentSecurity
     */
    public function setLockWindows($pValue = false)
    {
        $this->_lockWindows = $pValue;

        return $this;
    }

    /**
     * Get RevisionsPassword (hashed).
     *
     * @return string
     */
    public function getRevisionsPassword()
    {
        return $this->_revisionsPassword;
    }

    /**
     * Set RevisionsPassword.
     *
     * @param string $pValue
     * @param bool   $pAlreadyHashed If the password has already been hashed, set this to true
     *
     * @return PHPExcel_DocumentSecurity
     */
    public function setRevisionsPassword($pValue = '', $pAlreadyHashed = false)
    {
        if (!$pAlreadyHashed) {
            $pValue = PHPExcel_Shared_PasswordHasher::hashPassword($pValue);
        }
        $this->_revisionsPassword = $pValue;

        return $this;
    }

    /**
     * Get WorkbookPassword (hashed).
     *
     * @return string
     */
    public function getWorkbookPassword()
    {
        return $this->_workbookPassword;
    }

    /**
     * Set WorkbookPassword.
     *
     * @param string $pValue
     * @param bool   $pAlreadyHashed If the password has already been hashed, set this to true
     *
     * @return PHPExcel_DocumentSecurity
     */
    public function setWorkbookPassword($pValue = '', $pAlreadyHashed = false)
    {
        if (!$pAlreadyHashed) {
            $pValue = PHPExcel_Shared_PasswordHasher::hashPassword($pValue);
        }
        $this->_workbookPassword = $pValue;

        return $this;
    }
}
