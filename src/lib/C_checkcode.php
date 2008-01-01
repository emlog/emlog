<?php
/* emlog 2.5.0 Emlog.Net */
session_start();
header("Content-Type:image/png");

//创建图像标识符
$img=ImageCreate(45,22);

//颜色
$white=ImageColorAllocate($img,255,255,255);
$ss=ImageColorAllocate($img,153,153,204);

//随机验证码
$letter = array('A','b','C','D','e','F','G','H','i','J','K','L','m','n','O','p','q','R','S','T','U','V','w','x','Y','z');
for($i=1;$i<=4;$i++){
	$randcode.=$letter[mt_rand(0,25)];
}

$_SESSION['code'] = strtoupper($randcode);

//绘制图像
imagefill($img,0,0,$ss);//背景色填充
ImageString($img,5,6,3,$randcode,$white);
for($j=0;$j<80;$j++){
	$x = mt_rand(0,55);
	$y = mt_rand(0,22);
	ImageSetPixel($img,$x,$y,$white);
}


//输出
Imagepng($img);

//结束
ImageDestroy($img);
?>