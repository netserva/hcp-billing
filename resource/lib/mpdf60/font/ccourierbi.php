<?php

declare(strict_types=1);

for ($i = 0; $i <= 255; ++$i) {
    $cw[chr($i)] = 600;
}

//$desc=array('Ascent'=>629,'Descent'=>-157,'CapHeight'=>562,'FontBBox'=>'[-57 -250 869 801]');
$desc = ['Flags' => 97, 'FontBBox' => '[-57 -250 869 801]', 'ItalicAngle' => -12, 'Ascent' => 801, 'Descent' => -250, 'Leading' => 0, 'CapHeight' => 562, 'XHeight' => 439, 'StemV' => 106, 'StemH' => 84, 'AvgWidth' => 600, 'MaxWidth' => 600, 'MissingWidth' => 600];
$up = -100;
$ut = 50;
