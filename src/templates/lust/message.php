<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
<html>
<head>
<meta HTTP-EQUIV="REFRESH" CONTENT="322;URL=$url">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Language" content="zh-CN" />
<title>系统消息</title>
<style type="text/css">
<!--
body{
	font-family: Verdana, Arial, Helvetica, Georgia, sans-serif;
	font-size: 12px;
	text-align: center;
	vertical-align: top;
	color: #e29090;
}
a{
	text-decoration: underline;
	color: #bb0000;
}

a:hover{
	text-decoration: none;
}
#msg{
	margin:200px 0px;
	padding: 10px;
	line-height: 24px;
	text-align:center;
	width:260px;
	background-color:#860000;
}
-->
</style>
</head>
<body>
<div id="msg">
<h5>$msg</h5>
<p>3<span>秒后将自动跳转</span>
<p><a href="$url">如果没有自动跳转请点击这里!</a></p>
</div>
</body>
</html>
<!--
EOT;
?>-->
