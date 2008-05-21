<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<meta name="description" content="$sitekey" />
<meta name="keywords" content="emlog,blog,$sitekey" />
<meta name="copyright" content="emlog" />
<meta name="author" content="emlog" />
<title>$blogtitle</title>
<link rel="alternate" type="application/rss+xml" title="订阅我的博客"  href="./rss.php">
<link href="{$tpl_dir}default/main.css" rel="stylesheet" type="text/css" />
<script src="{$tpl_dir}default/main.js" type="text/javascript"></script>
</head>
<body>
<div id="holder">
<div id="header">
	<div id="siteTitle">
	<ul>
  		<li id="blogname"><a href="./">$blogname</a></li>
  		<li id="blogdes">$blog_info</li>
	</ul>
  	</div>
<form name="f" method="post" action="index.php?action=login">
<div id="navBar">
<ul>
<?php
EOT;
if(ISLOGIN){
echo <<<EOT
?>
	<li><a href="./adm/add_log.php">写日志</a></li>
	<li><a href="./adm/">管理中心</a></li>
	<li><a href="./index.php?action=logout">退出</a></li>
<?php
EOT;
}else{
	$login_code=='y'?
	$ckcode = "<img src=\"./lib/C_checkcode.php\" align=\"absmiddle\"><input name=\"imgcode\" type=\"text\" class=\"input\" style=\"width:40px;\">":
	$ckcode = '';
echo <<<EOT
?>
<li onclick="showlogin('loginfm')" style="cursor:pointer;">登录</li>
<li id="loginfm" style="display:none">
用户:<input name="user" type="text" class="input" style="width:80px;"/>
密码:<input name="pw" type="password"  class="input" style="width:80px;"/>
$ckcode 
<input type="submit" value="登录">
</li>
<?php
EOT;
}echo <<<EOT
?>
</ul>
</div>
</form>
</div>
<?php
EOT;
?>