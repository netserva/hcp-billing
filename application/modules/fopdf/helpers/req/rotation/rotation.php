<?php

declare(strict_types=1);
class tFPDF_rotation extends tFPDF
{
    public $angle = 0;

    public function Rotate($angle, $x = -1, $y = -1): void
    {
        if (-1 == $x) {
            $x = $this->x;
        }
        if (-1 == $y) {
            $y = $this->y;
        }
        if (0 != $this->angle) {
            $this->_out('Q');
        }
        $this->angle = $angle;
        if (0 != $angle) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    public function _endpage(): void
    {
        if (0 != $this->angle) {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }
}
