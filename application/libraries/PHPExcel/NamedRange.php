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
 * PHPExcel_NamedRange.
 *
 * @category   PHPExcel
 *
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_NamedRange
{
    /**
     * Range name.
     *
     * @var string
     */
    private $_name;

    /**
     * Worksheet on which the named range can be resolved.
     *
     * @var PHPExcel_Worksheet
     */
    private $_worksheet;

    /**
     * Range of the referenced cells.
     *
     * @var string
     */
    private $_range;

    /**
     * Is the named range local? (i.e. can only be used on $this->_worksheet).
     *
     * @var bool
     */
    private $_localOnly;

    /**
     * Scope.
     *
     * @var PHPExcel_Worksheet
     */
    private $_scope;

    /**
     * Create a new NamedRange.
     *
     * @param string                  $pName
     * @param string                  $pRange
     * @param bool                    $pLocalOnly
     * @param null|PHPExcel_Worksheet $pScope     Scope. Only applies when $pLocalOnly = true. Null for global scope.
     *
     * @throws PHPExcel_Exception
     */
    public function __construct($pName, PHPExcel_Worksheet $pWorksheet, $pRange = 'A1', $pLocalOnly = false, $pScope = null)
    {
        // Validate data
        if ((null === $pName) || (null === $pWorksheet) || (null === $pRange)) {
            throw new PHPExcel_Exception('Parameters can not be null.');
        }

        // Set local members
        $this->_name = $pName;
        $this->_worksheet = $pWorksheet;
        $this->_range = $pRange;
        $this->_localOnly = $pLocalOnly;
        $this->_scope = (true == $pLocalOnly) ?
                                ((null == $pScope) ? $pWorksheet : $pScope) : null;
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
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Set name.
     *
     * @param string $value
     *
     * @return PHPExcel_NamedRange
     */
    public function setName($value = null)
    {
        if (null !== $value) {
            // Old title
            $oldTitle = $this->_name;

            // Re-attach
            if (null !== $this->_worksheet) {
                $this->_worksheet->getParent()->removeNamedRange($this->_name, $this->_worksheet);
            }
            $this->_name = $value;

            if (null !== $this->_worksheet) {
                $this->_worksheet->getParent()->addNamedRange($this);
            }

            // New title
            $newTitle = $this->_name;
            PHPExcel_ReferenceHelper::getInstance()->updateNamedFormulas($this->_worksheet->getParent(), $oldTitle, $newTitle);
        }

        return $this;
    }

    /**
     * Get worksheet.
     *
     * @return PHPExcel_Worksheet
     */
    public function getWorksheet()
    {
        return $this->_worksheet;
    }

    /**
     * Set worksheet.
     *
     * @param PHPExcel_Worksheet $value
     *
     * @return PHPExcel_NamedRange
     */
    public function setWorksheet(PHPExcel_Worksheet $value = null)
    {
        if (null !== $value) {
            $this->_worksheet = $value;
        }

        return $this;
    }

    /**
     * Get range.
     *
     * @return string
     */
    public function getRange()
    {
        return $this->_range;
    }

    /**
     * Set range.
     *
     * @param string $value
     *
     * @return PHPExcel_NamedRange
     */
    public function setRange($value = null)
    {
        if (null !== $value) {
            $this->_range = $value;
        }

        return $this;
    }

    /**
     * Get localOnly.
     *
     * @return bool
     */
    public function getLocalOnly()
    {
        return $this->_localOnly;
    }

    /**
     * Set localOnly.
     *
     * @param bool $value
     *
     * @return PHPExcel_NamedRange
     */
    public function setLocalOnly($value = false)
    {
        $this->_localOnly = $value;
        $this->_scope = $value ? $this->_worksheet : null;

        return $this;
    }

    /**
     * Get scope.
     *
     * @return null|PHPExcel_Worksheet
     */
    public function getScope()
    {
        return $this->_scope;
    }

    /**
     * Set scope.
     *
     * @return PHPExcel_NamedRange
     */
    public function setScope(PHPExcel_Worksheet $value = null)
    {
        $this->_scope = $value;
        $this->_localOnly = (null == $value) ? false : true;

        return $this;
    }

    /**
     * Resolve a named range to a regular cell range.
     *
     * @param string                  $pNamedRange Named range
     * @param null|PHPExcel_Worksheet $pSheet      Scope. Use null for global scope
     *
     * @return PHPExcel_NamedRange
     */
    public static function resolveRange($pNamedRange, PHPExcel_Worksheet $pSheet)
    {
        return $pSheet->getParent()->getNamedRange($pNamedRange, $pSheet);
    }
}
