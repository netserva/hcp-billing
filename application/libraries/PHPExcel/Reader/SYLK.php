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

// PHPExcel root directory
if (!defined('PHPEXCEL_ROOT')) {
    // @ignore
    define('PHPEXCEL_ROOT', dirname(__FILE__).'/../../');

    require PHPEXCEL_ROOT.'PHPExcel/Autoloader.php';
}

/**
 * PHPExcel_Reader_SYLK.
 *
 * @category   PHPExcel
 *
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Reader_SYLK extends PHPExcel_Reader_Abstract implements PHPExcel_Reader_IReader
{
    /**
     * Input encoding.
     *
     * @var string
     */
    private $_inputEncoding = 'ANSI';

    /**
     * Sheet index to read.
     *
     * @var int
     */
    private $_sheetIndex = 0;

    /**
     * Formats.
     *
     * @var array
     */
    private $_formats = [];

    /**
     * Format Count.
     *
     * @var int
     */
    private $_format = 0;

    /**
     * Create a new PHPExcel_Reader_SYLK.
     */
    public function __construct()
    {
        $this->_readFilter = new PHPExcel_Reader_DefaultReadFilter();
    }

    /**
     * Set input encoding.
     *
     * @param string $pValue Input encoding
     */
    public function setInputEncoding($pValue = 'ANSI')
    {
        $this->_inputEncoding = $pValue;

        return $this;
    }

    /**
     * Get input encoding.
     *
     * @return string
     */
    public function getInputEncoding()
    {
        return $this->_inputEncoding;
    }

    /**
     * Return worksheet info (Name, Last Column Letter, Last Column Index, Total Rows, Total Columns).
     *
     * @param string $pFilename
     *
     * @throws PHPExcel_Reader_Exception
     */
    public function listWorksheetInfo($pFilename)
    {
        // Open file
        $this->_openFile($pFilename);
        if (!$this->_isValidFormat()) {
            fclose($this->_fileHandle);

            throw new PHPExcel_Reader_Exception($pFilename.' is an Invalid Spreadsheet file.');
        }
        $fileHandle = $this->_fileHandle;
        rewind($fileHandle);

        $worksheetInfo = [];
        $worksheetInfo[0]['worksheetName'] = 'Worksheet';
        $worksheetInfo[0]['lastColumnLetter'] = 'A';
        $worksheetInfo[0]['lastColumnIndex'] = 0;
        $worksheetInfo[0]['totalRows'] = 0;
        $worksheetInfo[0]['totalColumns'] = 0;

        // Loop through file
        $rowData = [];

        // loop through one row (line) at a time in the file
        $rowIndex = 0;
        while (($rowData = fgets($fileHandle)) !== false) {
            $columnIndex = 0;

            // convert SYLK encoded $rowData to UTF-8
            $rowData = PHPExcel_Shared_String::SYLKtoUTF8($rowData);

            // explode each row at semicolons while taking into account that literal semicolon (;)
            // is escaped like this (;;)
            $rowData = explode("\t", str_replace('¤', ';', str_replace(';', "\t", str_replace(';;', '¤', rtrim($rowData)))));

            $dataType = array_shift($rowData);
            if ('C' == $dataType) {
                //  Read cell value data
                foreach ($rowData as $rowDatum) {
                    switch ($rowDatum[0]) {
                        case 'C':
                        case 'X':
                            $columnIndex = substr($rowDatum, 1) - 1;

                            break;

                        case 'R':
                        case 'Y':
                            $rowIndex = substr($rowDatum, 1);

                            break;
                    }

                    $worksheetInfo[0]['totalRows'] = max($worksheetInfo[0]['totalRows'], $rowIndex);
                    $worksheetInfo[0]['lastColumnIndex'] = max($worksheetInfo[0]['lastColumnIndex'], $columnIndex);
                }
            }
        }

        $worksheetInfo[0]['lastColumnLetter'] = PHPExcel_Cell::stringFromColumnIndex($worksheetInfo[0]['lastColumnIndex']);
        $worksheetInfo[0]['totalColumns'] = $worksheetInfo[0]['lastColumnIndex'] + 1;

        // Close file
        fclose($fileHandle);

        return $worksheetInfo;
    }

    /**
     * Loads PHPExcel from file.
     *
     * @param string $pFilename
     *
     * @throws PHPExcel_Reader_Exception
     *
     * @return PHPExcel
     */
    public function load($pFilename)
    {
        // Create new PHPExcel
        $objPHPExcel = new PHPExcel();

        // Load into this instance
        return $this->loadIntoExisting($pFilename, $objPHPExcel);
    }

    /**
     * Loads PHPExcel from file into PHPExcel instance.
     *
     * @param string $pFilename
     *
     * @throws PHPExcel_Reader_Exception
     *
     * @return PHPExcel
     */
    public function loadIntoExisting($pFilename, PHPExcel $objPHPExcel)
    {
        // Open file
        $this->_openFile($pFilename);
        if (!$this->_isValidFormat()) {
            fclose($this->_fileHandle);

            throw new PHPExcel_Reader_Exception($pFilename.' is an Invalid Spreadsheet file.');
        }
        $fileHandle = $this->_fileHandle;
        rewind($fileHandle);

        // Create new PHPExcel
        while ($objPHPExcel->getSheetCount() <= $this->_sheetIndex) {
            $objPHPExcel->createSheet();
        }
        $objPHPExcel->setActiveSheetIndex($this->_sheetIndex);

        $fromFormats = ['\-',	'\ '];
        $toFormats = ['-',	' '];

        // Loop through file
        $rowData = [];
        $column = $row = '';

        // loop through one row (line) at a time in the file
        while (($rowData = fgets($fileHandle)) !== false) {
            // convert SYLK encoded $rowData to UTF-8
            $rowData = PHPExcel_Shared_String::SYLKtoUTF8($rowData);

            // explode each row at semicolons while taking into account that literal semicolon (;)
            // is escaped like this (;;)
            $rowData = explode("\t", str_replace('¤', ';', str_replace(';', "\t", str_replace(';;', '¤', rtrim($rowData)))));

            $dataType = array_shift($rowData);
            //	Read shared styles
            if ('P' == $dataType) {
                $formatArray = [];
                foreach ($rowData as $rowDatum) {
                    switch ($rowDatum[0]) {
                        case 'P':	$formatArray['numberformat']['code'] = str_replace($fromFormats, $toFormats, substr($rowDatum, 1));

                                    break;

                        case 'E':
                        case 'F':	$formatArray['font']['name'] = substr($rowDatum, 1);

                                    break;

                        case 'L':	$formatArray['font']['size'] = substr($rowDatum, 1);

                                    break;

                        case 'S':	$styleSettings = substr($rowDatum, 1);
                                    for ($i = 0; $i < strlen($styleSettings); ++$i) {
                                        switch ($styleSettings[$i]) {
                                            case 'I':	$formatArray['font']['italic'] = true;

                                                        break;

                                            case 'D':	$formatArray['font']['bold'] = true;

                                                        break;

                                            case 'T':	$formatArray['borders']['top']['style'] = PHPExcel_Style_Border::BORDER_THIN;

                                                        break;

                                            case 'B':	$formatArray['borders']['bottom']['style'] = PHPExcel_Style_Border::BORDER_THIN;

                                                        break;

                                            case 'L':	$formatArray['borders']['left']['style'] = PHPExcel_Style_Border::BORDER_THIN;

                                                        break;

                                            case 'R':	$formatArray['borders']['right']['style'] = PHPExcel_Style_Border::BORDER_THIN;

                                                        break;
                                        }
                                    }

                                    break;
                    }
                }
                $this->_formats['P'.$this->_format++] = $formatArray;
            //	Read cell value data
            } elseif ('C' == $dataType) {
                $hasCalculatedValue = false;
                $cellData = $cellDataFormula = '';
                foreach ($rowData as $rowDatum) {
                    switch ($rowDatum[0]) {
                        case 'C':
                        case 'X':	$column = substr($rowDatum, 1);

                                    break;

                        case 'R':
                        case 'Y':	$row = substr($rowDatum, 1);

                                    break;

                        case 'K':	$cellData = substr($rowDatum, 1);

                                    break;

                        case 'E':	$cellDataFormula = '='.substr($rowDatum, 1);
                                    //	Convert R1C1 style references to A1 style references (but only when not quoted)
                                    $temp = explode('"', $cellDataFormula);
                                    $key = false;
                                    foreach ($temp as &$value) {
                                        //	Only count/replace in alternate array entries
                                        if ($key = !$key) {
                                            preg_match_all('/(R(\[?-?\d*\]?))(C(\[?-?\d*\]?))/', $value, $cellReferences, PREG_SET_ORDER + PREG_OFFSET_CAPTURE);
                                            //	Reverse the matches array, otherwise all our offsets will become incorrect if we modify our way
                                            //		through the formula from left to right. Reversing means that we work right to left.through
                                            //		the formula
                                            $cellReferences = array_reverse($cellReferences);
                                            //	Loop through each R1C1 style reference in turn, converting it to its A1 style equivalent,
                                            //		then modify the formula to use that new reference
                                            foreach ($cellReferences as $cellReference) {
                                                $rowReference = $cellReference[2][0];
                                                //	Empty R reference is the current row
                                                if ('' == $rowReference) {
                                                    $rowReference = $row;
                                                }
                                                //	Bracketed R references are relative to the current row
                                                if ('[' == $rowReference[0]) {
                                                    $rowReference = $row + trim($rowReference, '[]');
                                                }
                                                $columnReference = $cellReference[4][0];
                                                //	Empty C reference is the current column
                                                if ('' == $columnReference) {
                                                    $columnReference = $column;
                                                }
                                                //	Bracketed C references are relative to the current column
                                                if ('[' == $columnReference[0]) {
                                                    $columnReference = $column + trim($columnReference, '[]');
                                                }
                                                $A1CellReference = PHPExcel_Cell::stringFromColumnIndex($columnReference - 1).$rowReference;

                                                $value = substr_replace($value, $A1CellReference, $cellReference[0][1], strlen($cellReference[0][0]));
                                            }
                                        }
                                    }
                                    unset($value);
                                    //	Then rebuild the formula string
                                    $cellDataFormula = implode('"', $temp);
                                    $hasCalculatedValue = true;

                                    break;
                    }
                }
                $columnLetter = PHPExcel_Cell::stringFromColumnIndex($column - 1);
                $cellData = PHPExcel_Calculation::_unwrapResult($cellData);

                // Set cell value
                $objPHPExcel->getActiveSheet()->getCell($columnLetter.$row)->setValue(($hasCalculatedValue) ? $cellDataFormula : $cellData);
                if ($hasCalculatedValue) {
                    $cellData = PHPExcel_Calculation::_unwrapResult($cellData);
                    $objPHPExcel->getActiveSheet()->getCell($columnLetter.$row)->setCalculatedValue($cellData);
                }
                //	Read cell formatting
            } elseif ('F' == $dataType) {
                $formatStyle = $columnWidth = $styleSettings = '';
                $styleData = [];
                foreach ($rowData as $rowDatum) {
                    switch ($rowDatum[0]) {
                        case 'C':
                        case 'X':	$column = substr($rowDatum, 1);

                                    break;

                        case 'R':
                        case 'Y':	$row = substr($rowDatum, 1);

                                    break;

                        case 'P':	$formatStyle = $rowDatum;

                                    break;

                        case 'W':	[$startCol, $endCol, $columnWidth] = explode(' ', substr($rowDatum, 1));

                                    break;

                        case 'S':	$styleSettings = substr($rowDatum, 1);
                                    for ($i = 0; $i < strlen($styleSettings); ++$i) {
                                        switch ($styleSettings[$i]) {
                                            case 'I':	$styleData['font']['italic'] = true;

                                                        break;

                                            case 'D':	$styleData['font']['bold'] = true;

                                                        break;

                                            case 'T':	$styleData['borders']['top']['style'] = PHPExcel_Style_Border::BORDER_THIN;

                                                        break;

                                            case 'B':	$styleData['borders']['bottom']['style'] = PHPExcel_Style_Border::BORDER_THIN;

                                                        break;

                                            case 'L':	$styleData['borders']['left']['style'] = PHPExcel_Style_Border::BORDER_THIN;

                                                        break;

                                            case 'R':	$styleData['borders']['right']['style'] = PHPExcel_Style_Border::BORDER_THIN;

                                                        break;
                                        }
                                    }

                                    break;
                    }
                }
                if (($formatStyle > '') && ($column > '') && ($row > '')) {
                    $columnLetter = PHPExcel_Cell::stringFromColumnIndex($column - 1);
                    if (isset($this->_formats[$formatStyle])) {
                        $objPHPExcel->getActiveSheet()->getStyle($columnLetter.$row)->applyFromArray($this->_formats[$formatStyle]);
                    }
                }
                if ((!empty($styleData)) && ($column > '') && ($row > '')) {
                    $columnLetter = PHPExcel_Cell::stringFromColumnIndex($column - 1);
                    $objPHPExcel->getActiveSheet()->getStyle($columnLetter.$row)->applyFromArray($styleData);
                }
                if ($columnWidth > '') {
                    if ($startCol == $endCol) {
                        $startCol = PHPExcel_Cell::stringFromColumnIndex($startCol - 1);
                        $objPHPExcel->getActiveSheet()->getColumnDimension($startCol)->setWidth($columnWidth);
                    } else {
                        $startCol = PHPExcel_Cell::stringFromColumnIndex($startCol - 1);
                        $endCol = PHPExcel_Cell::stringFromColumnIndex($endCol - 1);
                        $objPHPExcel->getActiveSheet()->getColumnDimension($startCol)->setWidth($columnWidth);
                        do {
                            $objPHPExcel->getActiveSheet()->getColumnDimension(++$startCol)->setWidth($columnWidth);
                        } while ($startCol != $endCol);
                    }
                }
            } else {
                foreach ($rowData as $rowDatum) {
                    switch ($rowDatum[0]) {
                        case 'C':
                        case 'X':	$column = substr($rowDatum, 1);

                                    break;

                        case 'R':
                        case 'Y':	$row = substr($rowDatum, 1);

                                    break;
                    }
                }
            }
        }

        // Close file
        fclose($fileHandle);

        // Return
        return $objPHPExcel;
    }

    /**
     * Get sheet index.
     *
     * @return int
     */
    public function getSheetIndex()
    {
        return $this->_sheetIndex;
    }

    /**
     * Set sheet index.
     *
     * @param int $pValue Sheet index
     *
     * @return PHPExcel_Reader_SYLK
     */
    public function setSheetIndex($pValue = 0)
    {
        $this->_sheetIndex = $pValue;

        return $this;
    }

    /**
     * Validate that the current file is a SYLK file.
     *
     * @return bool
     */
    protected function _isValidFormat()
    {
        // Read sample data (first 2 KB will do)
        $data = fread($this->_fileHandle, 2048);

        // Count delimiters in file
        $delimiterCount = substr_count($data, ';');
        if ($delimiterCount < 1) {
            return false;
        }

        // Analyze first line looking for ID; signature
        $lines = explode("\n", $data);
        if ('ID;P' != substr($lines[0], 0, 4)) {
            return false;
        }

        return true;
    }
}
