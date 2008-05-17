<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">

	<title>$blogtitle</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Language" content="zh-CN" />
	<meta name="description" content="$sitekey" />
	<meta name="keywords" content="emlog,blog,$sitekey" />
	<meta name="copyright" content="emlog" />
	<meta name="author" content="emlog" />

	<link rel="alternate" type="application/rss+xml" title="订阅我的博客"  href="./rss.php">
	<link href="{$tpl_dir}techpress/main.css" rel="stylesheet" type="text/css" />
	<script src="{$tpl_dir}techpress/main.js" type="text/javascript"></script>
</head>
<body>
<div id="container">
<div id="page">
	<div id="header">
		<div class="site_title">
			<h1><a href="./">$blogname</a></h1>
		</div>
		<div class="syndication">
<ul>
	<li>$blog_info</li>
</ul>
		</div>
		<div class="topmenu">
<ul>
	<li><a href="./">首页</a></li>
<!--
EOT;
if(ISLOGIN){
echo <<<EOT
-->
	<li><a href="./adm/add_log.php">写日志</a></li>
	<li><a href="./adm/">管理中心</a></li>
	<li><a href="./index.php?action=logout">退出</a></li>
<!--
EOT;
}
echo <<<EOT
-->
</ul>
		</div>
	</div>
	<div class="columns_wrapper">
<!--
EOT;
?>-->