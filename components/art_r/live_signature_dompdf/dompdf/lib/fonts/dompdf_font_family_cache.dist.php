<?php
$distFontDir = $rootDir . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'fonts' . DIRECTORY_SEPARATOR;


/* var_dump($distFontDir . 'times');exit; */


return array(

  'serif' =>
  array(
    'normal' => $distFontDir . 'times.ufm',
    'bold' => $distFontDir . 'timesbd.ufm',
    'italic' => $distFontDir . 'timesi.ufm',
    'bold_italic' => $distFontDir . 'timesbi.ufm'
  ),
  'arial' => 
  array (
    'normal' => $distFontDir . 'arial',
    'bold' => $distFontDir . 'arial-Bold',
    'italic' => $distFontDir . 'arial-Oblique',
    'bold_italic' => $distFontDir . 'arial-BoldOblique'
  ),
);