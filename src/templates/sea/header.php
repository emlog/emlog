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
	<link href="{$tpl_dir}sea/style.css" rel="stylesheet" type="text/css" />
	<script src="{$tpl_dir}sea/main.js" type="text/javascript"></script>
</head>

<body onload="sendinfo('$calendar_url');">

<div id="container">

	<div id="page">

		<div id="menu">
<ul>
	<li><a href="./">$blogname</a></li>
	<li>$blog_info</li>
</ul>
		</div>

		<div id="banner">&#160;</div>

		<div class="widecolumn_bottom"><div class="widecolumn_top">
		<div class="narrowcolumn">
<!--
EOT;
?>-->