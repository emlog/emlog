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
	<link href="{$tpl_dir}mac-1/main.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="stylesheet" href="{$tpl_dir}mac-1/dbx.css" type="text/css" media="screen, projection" />
	<link rel="stylesheet" href="{$tpl_dir}mac-1/print.css" type="text/css" media="print" />
	<script src="{$tpl_dir}mac-1/main.js" type="text/javascript"></script>
</head>
<body onload="sendinfo('$calendar_url');">
<div id="page">
  <div id="wrapper">
    <div id="header">
      <h1><a href="./">$blogname</a></h1>
      <div class="description">$blog_info</div>
      <form method="get" id="searchform" action="index.php">
<div><input type="text" value="Search" name="keyword" id="s" onfocus="if (this.value == 'Search') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search';}" />
<input name="action" type="hidden" value="search" size="12" />
<input type="submit" id="searchsubmit" value="Go" />
</div>
</form>
    </div>
    <div id="left-col">	
<!--
EOT;
?>-->