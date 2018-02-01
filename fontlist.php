<?php
// ubuntuのtt-font directory
define('TRUE_TYPE_DIR', '/usr/share/fonts/truetype/');

// 外部shellコマンド find 使用
exec('find '.TRUE_TYPE_DIR.' -name "*.ttf"', $aryFontPath);

$image = imagecreate(1000, count($aryFontPath)*20+10);
$white = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
$black = imagecolorallocate($image, 0x00, 0x00, 0x00);

$i = 1;
foreach($aryFontPath as $fontpath) {
    $fontpath = str_replace(TRUE_TYPE_DIR, '', $fontpath);
    $output   = dirname($fontpath) . DIRECTORY_SEPARATOR
              . basename($fontpath, '.ttf')
              . ': abc, ABC, あいう';
    imagettftext($image, 13, 0, 10, 20*$i++, $black, $fontpath, $output);
}

header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
?>
