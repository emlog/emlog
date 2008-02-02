<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">

	<title>$blogtitle</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Language" content="zh-CN" />
	<meta name="description" content="$sitekey" />
	<meta name="keywords" content="emlog,blog,$sitekey" />
	<meta name="copyright" content="emlog" />
	<meta name="author" content="emlog" />

	<link rel="alternate" type="application/rss+xml" title="订阅我的博客"  href="./rss.php">
	<link href="{$tpl_dir}half-life/main.css" rel="stylesheet" type="text/css" />
	<script src="{$tpl_dir}half-life/main.js" type="text/javascript"></script>
</head>

<body onload="sendinfo('$calendar_url');">

<div class="container">

	<div class="page">

		<div id="banner">&#160;</div>

		<div id="menu">
<ul>
	<li><h1><a href="./">$blogname</a> </h1><smaill> ($blog_info)</small></li>
</ul>
		</div>
EOT;
include getViews('side');
?>