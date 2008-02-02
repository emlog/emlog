<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
<html>
<head>
<meta HTTP-EQUIV="REFRESH" CONTENT="3;URL=$url">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Language" content="zh-CN" />
<link href="{$tpl_dir}sea/style.css" rel="stylesheet" type="text/css">
<title>系统消息</title>
</head>
<body>
<div id="msg">
<h5>$msg</h5>
<p>3秒后将自动跳转<p>
<p><a href="$url">如果你不想等待或浏览器没有自动跳转请点击这里!</a></p>
</div>
</body>
</html>
<!--
EOT;
?>-->
