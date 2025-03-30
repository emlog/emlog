<?php

/**
 * Captcha
 * @package EMLOG
 * @link https://www.emlog.net
 */

require_once './common.php';

if (!isset($_SESSION)) {
    session_start();
}

$randCode = '';
$chars = 'abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPRSTUVWXYZ23456789';
for ($i = 0; $i < 5; $i++) {
    $randCode .= substr($chars, em_rand(0, strlen($chars) - 1), 1);
}

$_SESSION['code'] = strtoupper($randCode);
$width = 120;
$height = 40;

$img = imagecreate($width, $height);
$bgColor = isset($_GET['mode']) && $_GET['mode'] == 't' ? imagecolorallocate($img, 245, 245, 245) : imagecolorallocate($img, 255, 255, 255);
$pixColor = imagecolorallocate($img, em_rand(30, 180), em_rand(10, 100), em_rand(40, 250));

// Load WOFF font
$fontFile = __DIR__ . '/captcha.ttf';
$fontColor = imagecolorallocate($img, em_rand(30, 180), em_rand(10, 100), em_rand(40, 250));

$charWidth = $width / 6;

for ($i = 0; $i < 5; $i++) {
    $x = ($i * $charWidth) + em_rand(5, 10);
    $y = em_rand(20, 30);
    imagettftext($img, 18, em_rand(-30, 30), $x, $y, $fontColor, $fontFile, $randCode[$i]);
}

for ($j = 0; $j < 80; $j++) {
    $x = em_rand(0, $width);
    $y = em_rand(0, $height);
    imagesetpixel($img, $x, $y, $pixColor);
}

for ($j = 0; $j < 4; $j++) {
    $x1 = em_rand(0, $width);
    $y1 = em_rand(0, $height);
    $x2 = em_rand(0, $width);
    $y2 = em_rand(0, $height);
    imageline($img, $x1, $y1, $x2, $y2, $pixColor);
}

header('Content-Type: image/png');
imagepng($img);
imagedestroy($img);
