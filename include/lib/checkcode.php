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
$width = 120;
$height = 40;

$img = imagecreate($width, $height);
$bgColor = isset($_GET['mode']) && $_GET['mode'] == 't' ? imagecolorallocate($img, 245, 245, 245) : imagecolorallocate($img, 255, 255, 255);
$pixColor = imagecolorallocate($img, mt_rand(30, 180), mt_rand(10, 100), mt_rand(40, 250));

// Load WOFF font
$fontFile = __DIR__ . '/captcha.ttf';
$fontColor = imagecolorallocate($img, mt_rand(30, 180), mt_rand(10, 100), mt_rand(40, 250));

$charWidth = $width / 6;

for ($i = 0; $i < 5; $i++) {
    $x = ($i * $charWidth) + mt_rand(5, 10);
    $y = mt_rand(20, 30);
    imagettftext($img, 18, mt_rand(-30, 30), $x, $y, $fontColor, $fontFile, $randCode[$i]);
}

for ($j = 0; $j < 80; $j++) {
    $x = mt_rand(0, $width);
    $y = mt_rand(0, $height);
    imagesetpixel($img, $x, $y, $pixColor);
}

for ($j = 0; $j < 4; $j++) {
    $x1 = mt_rand(0, $width);
    $y1 = mt_rand(0, $height);
    $x2 = mt_rand(0, $width);
    $y2 = mt_rand(0, $height);
    imageline($img, $x1, $y1, $x2, $y2, $pixColor);
}

header('Content-Type: image/png');
imagepng($img);
imagedestroy($img);
