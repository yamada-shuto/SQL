<?php
$formname="jpegimage";
$font = "/usr/share/fonts/truetype/takao-gothic/TakaoExGothic.ttf";

switch($_POST['cmd']){
 case 'upload':
	$upfilename = $_FILES[$formname]['name'];
	$tempfile   = $_FILES[$formname]['tmp_name'];
	//拡張子の切り出し
	$ext=substr($upfilename, strrpos($upfilename, '.') + 1);

	$string=$_POST['text'];
	if($string==""){$string="SAMPLE";}

	switch($ext){
		case 'jpeg':
		case 'jpg':
			$img = imagecreatefromjpeg($tempfile);
			break;
		case 'gif':
			$img = imagecreatefromgif($tempfile);
			break;
		case 'png':
			$img = imagecreatefrompng($tempfile);
			break;
		default:
			echo "<h2>扱える画像ファイルではありません</h2>";
			exit;
			break;
	}
	list($width, $height, $type, $attr) = getimagesize($tempfile);
	$font_size=$width/strlen($string);
	$font_angle=5;

	$tbox = imagettfbbox($font_size, $font_angle, $font, $string);

	$black=imagecolorallocate($img,0x00,0x00,0x00);
	$white=imagecolorallocate($img,0xff,0xff,0xff);

	$font_x = ($width  - ($tbox[2]-$tbox[0])) / 2;
	$font_y = ($height - ($tbox[5]-$tbox[3])) / 2;

	imagettftext($img,$font_size,$font_angle,$font_x+3,$font_y,$black,$font,$string);
	imagettftext($img,$font_size,$font_angle,$font_x+0,$font_y,$white,$font,$string);

	header('Content-type:image/png');
	imagepng($img);
	imagedestroy($img);
    break;
 default:
	echo "<h2>直接の呼び出しは不可です</h2>";
}
?>
