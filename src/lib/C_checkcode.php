<?php
/**
 * 图片验证码生成
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-3.0.0
 * $Id$
 */

session_start();

$randStr = '';
$chars = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPRSTUVWXYZ23456789';
for ( $i = 0; $i < 4; $i++ )
{
	$randcode .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
}

$_SESSION['code'] = strtoupper($randcode);

$img = imagecreate(55,22);
$bgColor = imagecolorallocate($img,255,255,255);
$pixColor = imagecolorallocate($img,mt_rand(30, 180), mt_rand(10, 100), mt_rand(40, 250));

for($i = 0; $i < 4; $i++)
{
	$x = $i * 13 + mt_rand(0, 4) - 2;
	$y = mt_rand(0, 3);
	$text_color = imagecolorallocate($img, mt_rand(30, 180), mt_rand(10, 100), mt_rand(40, 250));
	imagechar($img, 5, $x + 5, $y + 3, $randcode[$i], $text_color);
}
for($j = 0; $j < 50; $j++)
{
	$x = mt_rand(0,55);
	$y = mt_rand(0,22);
	imagesetpixel($img,$x,$y,$pixColor);
}

header("Content-Type:image/png");
imagepng($img);
imagedestroy($img);

?>