<?php

declare(strict_types=1);

class wmf
{
    public $mpdf;

    public $gdiObjectArray;

    public function __construct(mPDF $mpdf)
    {
        $this->mpdf = $mpdf;
    }

    public function _getWMFimage($data)
    {
        $k = _MPDFK;

        $this->gdiObjectArray = [];
        $a = unpack('stest', "\1\0");
        if (1 != $a['test']) {
            return [0, 'Error parsing WMF image - Big-endian architecture not supported'];
        }
        // check for Aldus placeable metafile header
        $key = unpack('Lmagic', substr($data, 0, 4));
        $p = 18;  // WMF header
        if ($key['magic'] == (int) 0x9AC6CDD7) {
            $p += 22;
        } // Aldus header
        // define some state variables
        $wo = null; // window origin
        $we = null; // window extent
        $polyFillMode = 0;
        $nullPen = false;
        $nullBrush = false;
        $endRecord = false;
        $wmfdata = '';
        while ($p < strlen($data) && !$endRecord) {
            $recordInfo = unpack('Lsize/Sfunc', substr($data, $p, 6));
            $p += 6;
            // size of record given in WORDs (= 2 bytes)
            $size = $recordInfo['size'];
            // func is number of GDI function
            $func = $recordInfo['func'];
            if ($size > 3) {
                $parms = substr($data, $p, 2 * ($size - 3));
                $p += 2 * ($size - 3);
            }

            switch ($func) {
                case 0x020B:  // SetWindowOrg
                    // do not allow window origin to be changed
                    // after drawing has begun
                    if (!$wmfdata) {
                        $wo = array_reverse(unpack('s2', $parms));
                    }

                    break;

                case 0x020C:  // SetWindowExt
                    // do not allow window extent to be changed
                    // after drawing has begun
                    if (!$wmfdata) {
                        $we = array_reverse(unpack('s2', $parms));
                    }

                    break;

                case 0x02FC:  // CreateBrushIndirect
                    $brush = unpack('sstyle/Cr/Cg/Cb/Ca/Shatch', $parms);
                    $brush['type'] = 'B';
                    $this->_AddGDIObject($brush);

                    break;

                case 0x02FA:  // CreatePenIndirect
                    $pen = unpack('Sstyle/swidth/sdummy/Cr/Cg/Cb/Ca', $parms);
                    // convert width from twips to user unit
                    $pen['width'] /= (20 * $k);
                    $pen['type'] = 'P';
                    $this->_AddGDIObject($pen);

                    break;
                // MUST create other GDI objects even if we don't handle them
                case 0x06FE: // CreateBitmap
                case 0x02FD: // CreateBitmapIndirect
                case 0x00F8: // CreateBrush
                case 0x02FB: // CreateFontIndirect
                case 0x00F7: // CreatePalette
                case 0x01F9: // CreatePatternBrush
                case 0x06FF: // CreateRegion
                case 0x0142: // DibCreatePatternBrush
                    $dummyObject = ['type' => 'D'];
                    $this->_AddGDIObject($dummyObject);

                    break;

                case 0x0106:  // SetPolyFillMode
                    $polyFillMode = unpack('smode', $parms);
                    $polyFillMode = $polyFillMode['mode'];

                    break;

                case 0x01F0:  // DeleteObject
                    $idx = unpack('Sidx', $parms);
                    $idx = $idx['idx'];
                    $this->_DeleteGDIObject($idx);

                    break;

                case 0x012D:  // SelectObject
                    $idx = unpack('Sidx', $parms);
                    $idx = $idx['idx'];
                    $obj = $this->_GetGDIObject($idx);

                    switch ($obj['type']) {
                        case 'B':
                            $nullBrush = false;
                            if (1 == $obj['style']) {
                                $nullBrush = true;
                            } else {
                                $wmfdata .= $this->mpdf->SetFColor($this->mpdf->ConvertColor('rgb('.$obj['r'].','.$obj['g'].','.$obj['b'].')'), true)."\n";
                            }

                            break;

                        case 'P':
                            $nullPen = false;
                            $dashArray = [];
                            // dash parameters are custom
                            switch ($obj['style']) {
                                case 0: // PS_SOLID
                                    break;

                                case 1: // PS_DASH
                                    $dashArray = [3, 1];

                                    break;

                                case 2: // PS_DOT
                                    $dashArray = [0.5, 0.5];

                                    break;

                                case 3: // PS_DASHDOT
                                    $dashArray = [2, 1, 0.5, 1];

                                    break;

                                case 4: // PS_DASHDOTDOT
                                    $dashArray = [2, 1, 0.5, 1, 0.5, 1];

                                    break;

                                case 5: // PS_NULL
                                    $nullPen = true;

                                    break;
                            }
                            if (!$nullPen) {
                                $wmfdata .= $this->mpdf->SetDColor($this->mpdf->ConvertColor('rgb('.$obj['r'].','.$obj['g'].','.$obj['b'].')'), true)."\n";
                                $wmfdata .= sprintf("%.3F w\n", $obj['width'] * $k);
                            }
                            if (!empty($dashArray)) {
                                $s = '[';
                                for ($i = 0; $i < count($dashArray); ++$i) {
                                    $s .= $dashArray[$i] * $k;
                                    if ($i != count($dashArray) - 1) {
                                        $s .= ' ';
                                    }
                                }
                                $s .= '] 0 d';
                                $wmfdata .= $s."\n";
                            }

                            break;
                    }

                    break;

                case 0x0325: // Polyline
                case 0x0324: // Polygon
                    $coords = unpack('s'.($size - 3), $parms);
                    $numpoints = $coords[1];
                    for ($i = $numpoints; $i > 0; --$i) {
                        $px = $coords[2 * $i];
                        $py = $coords[2 * $i + 1];

                        if ($i < $numpoints) {
                            $wmfdata .= $this->_LineTo($px, $py);
                        } else {
                            $wmfdata .= $this->_MoveTo($px, $py);
                        }
                    }
                    if (0x0325 == $func) {
                        $op = 's';
                    } elseif (0x0324 == $func) {
                        if ($nullPen) {
                            if ($nullBrush) {
                                $op = 'n';
                            } // no op
                            else {
                                $op = 'f';
                            } // fill
                        } else {
                            if ($nullBrush) {
                                $op = 's';
                            } // stroke
                            else {
                                $op = 'b';
                            } // stroke and fill
                        }
                        if (1 == $polyFillMode && ('b' == $op || 'f' == $op)) {
                            $op .= '*';
                        } // use even-odd fill rule
                    }
                    $wmfdata .= $op."\n";

                    break;

                case 0x0538: // PolyPolygon
                    $coords = unpack('s'.($size - 3), $parms);
                    $numpolygons = $coords[1];
                    $adjustment = $numpolygons;
                    for ($j = 1; $j <= $numpolygons; ++$j) {
                        $numpoints = $coords[$j + 1];
                        for ($i = $numpoints; $i > 0; --$i) {
                            $px = $coords[2 * $i + $adjustment];
                            $py = $coords[2 * $i + 1 + $adjustment];
                            if ($i == $numpoints) {
                                $wmfdata .= $this->_MoveTo($px, $py);
                            } else {
                                $wmfdata .= $this->_LineTo($px, $py);
                            }
                        }
                        $adjustment += $numpoints * 2;
                    }

                    if ($nullPen) {
                        if ($nullBrush) {
                            $op = 'n';
                        } // no op
                        else {
                            $op = 'f';
                        } // fill
                    } else {
                        if ($nullBrush) {
                            $op = 's';
                        } // stroke
                        else {
                            $op = 'b';
                        } // stroke and fill
                    }
                    if (1 == $polyFillMode && ('b' == $op || 'f' == $op)) {
                        $op .= '*';
                    } // use even-odd fill rule
                    $wmfdata .= $op."\n";

                    break;

                case 0x0000:
                    $endRecord = true;

                    break;
            }
        }

        return [1, $wmfdata, $wo, $we];
    }

    public function _MoveTo($x, $y)
    {
        return "{$x} {$y} m\n";
    }

    // a line must have been started using _MoveTo() first
    public function _LineTo($x, $y)
    {
        return "{$x} {$y} l\n";
    }

    public function _AddGDIObject($obj): void
    {
        // find next available slot
        $idx = 0;
        if (!empty($this->gdiObjectArray)) {
            $empty = false;
            $i = 0;
            while (!$empty) {
                $empty = !isset($this->gdiObjectArray[$i]);
                ++$i;
            }
            $idx = $i - 1;
        }
        $this->gdiObjectArray[$idx] = $obj;
    }

    public function _GetGDIObject($idx)
    {
        return $this->gdiObjectArray[$idx];
    }

    public function _DeleteGDIObject($idx): void
    {
        unset($this->gdiObjectArray[$idx]);
    }
}
