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
 * @category	PHPExcel
 *
 * @copyright	Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license		http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 *
 * @version		##VERSION##, ##DATE##
 */

/**
 * PHPExcel_Chart_PlotArea.
 *
 * @category	PHPExcel
 *
 * @copyright	Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Chart_PlotArea
{
    /**
     * PlotArea Layout.
     *
     * @var PHPExcel_Chart_Layout
     */
    private $_layout;

    /**
     * Plot Series.
     *
     * @var array of PHPExcel_Chart_DataSeries
     */
    private $_plotSeries = [];

    /**
     * Create a new PHPExcel_Chart_PlotArea.
     *
     * @param mixed $plotSeries
     */
    public function __construct(PHPExcel_Chart_Layout $layout = null, $plotSeries = [])
    {
        $this->_layout = $layout;
        $this->_plotSeries = $plotSeries;
    }

    /**
     * Get Layout.
     *
     * @return PHPExcel_Chart_Layout
     */
    public function getLayout()
    {
        return $this->_layout;
    }

    /**
     * Get Number of Plot Groups.
     *
     * @return array of PHPExcel_Chart_DataSeries
     */
    public function getPlotGroupCount()
    {
        return count($this->_plotSeries);
    }

    /**
     * Get Number of Plot Series.
     *
     * @return int
     */
    public function getPlotSeriesCount()
    {
        $seriesCount = 0;
        foreach ($this->_plotSeries as $plot) {
            $seriesCount += $plot->getPlotSeriesCount();
        }

        return $seriesCount;
    }

    /**
     * Get Plot Series.
     *
     * @return array of PHPExcel_Chart_DataSeries
     */
    public function getPlotGroup()
    {
        return $this->_plotSeries;
    }

    /**
     * Get Plot Series by Index.
     *
     * @param mixed $index
     *
     * @return PHPExcel_Chart_DataSeries
     */
    public function getPlotGroupByIndex($index)
    {
        return $this->_plotSeries[$index];
    }

    /**
     * Set Plot Series.
     *
     * @param [PHPExcel_Chart_DataSeries]
     * @param mixed $plotSeries
     *
     * @return PHPExcel_Chart_PlotArea
     */
    public function setPlotSeries($plotSeries = [])
    {
        $this->_plotSeries = $plotSeries;

        return $this;
    }

    public function refresh(PHPExcel_Worksheet $worksheet): void
    {
        foreach ($this->_plotSeries as $plotSeries) {
            $plotSeries->refresh($worksheet);
        }
    }
}
