<?php
/**
 * 图片验证码生成
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-3.0.0
 * $Id$
 */

session_start();
header("Content-Type:image/png");

//创建图像标识符
$img = ImageCreate(45,22);

//颜色
$white = ImageColorAllocate($img,153,153,204);
$bgcolor = ImageColorAllocate($img,255,255,255);

//随机验证码
$letter = array('A','b','c','d','E','f','g','h','i','j','K','L','m','n','o','p','q','r','s','T','u','v','W','x','y','z','3','4','5','8');
for ($i = 1;$i <= 4;$i++) {
	$randcode .= $letter[mt_rand(0,29)];
}

$_SESSION['code'] = strtoupper($randcode);

//绘制图像
imagefill($img,0,0,$bgcolor);//背景色填充
ImageString($img,5,6,3,$randcode,$white);
for ($j=0;$j<80;$j++) {
	$x = mt_rand(0,55);
	$y = mt_rand(0,22);
	ImageSetPixel($img,$x,$y,$white);
}

//输出
Imagepng($img);

//结束
ImageDestroy($img);
?>