<?php
/**
 * Captcha
 * @package EMLOG
 * @link https://www.emlog.net
 */

if (!isset($_SESSION)) {
	session_start();
}

$randCode = '';
$chars = 'abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPRSTUVWXYZ23456789';
for ($i = 0; $i < 5; $i++) {
	$randCode .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
}

$_SESSION['code'] = strtoupper($randCode);
$width = 90;
$height = 30;

$img = imagecreate($width, $height);
$bgColor = isset($_GET['mode']) && $_GET['mode'] == 't' ? imagecolorallocate($img, 245, 245, 245) : imagecolorallocate($img, 255, 255, 255);
$pixColor = imagecolorallocate($img, mt_rand(30, 180), mt_rand(10, 100), mt_rand(40, 250));

for ($i = 0; $i < 5; $i++) {
	$x = $i * 13 + mt_rand(0, 5) - 2;
	$y = mt_rand(0, 8);
	$text_color = imagecolorallocate($img, mt_rand(30, 180), mt_rand(10, 100), mt_rand(40, 250));
	imagechar($img, 5, $x + 5, $y + 3, $randCode[$i], $text_color);
}
for ($j = 0; $j < 80; $j++) {
	$x = mt_rand(0, $width);
	$y = mt_rand(0, $height);
	imagesetpixel($img, $x, $y, $pixColor);
}

for ($j = 0; $j < 4; $j++) {
	$x = mt_rand(0, $width);
	$y = mt_rand(0, $height);
	$x2 = mt_rand(0, $width);
	$y2 = mt_rand(0, $height);
	imageline($img, $x, $y, $x2, $y2, $pixColor);
}

header('Content-Type: image/png');
imagepng($img);
imagedestroy($img);
