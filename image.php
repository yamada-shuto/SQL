<?php

$string = $_GET['text'];

$img = ImageCreate(300,50);
$black = ImageColorAllocate($img, 0x00, 0x00, 0x00);
ImageFilledRectangle($img, 0,0, 300,50, $black);

$font=5;
$yellow = ImageColorAllocate($img, 0xff, 0xff, 0x00);
$font_width =imagefontwidth ($font);
$font_height=imagefontheight($font);
$px     = (imagesx($img) - $font_width * strlen($string)) / 2;
$py     = (imagesy($img) - $font_height)/2;

imagestring($img, $font, $px, $py, $string, $yellow);

header("Content-type: image/png");
imagepng($img);
imagedestroy($img);

?>
