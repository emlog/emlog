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
	<link href="{$tpl_dir}g7/main.css" rel="stylesheet" type="text/css" />
	<script src="{$tpl_dir}g7/main.js" type="text/javascript"></script>
</head>

<body>

<div id="header"><div id="ing">
<div id="ing_info"><div id="home"><img src="{$tpl_dir}g7/images/underone_logo_4.gif" alt="blog" align="absmiddle"/><a href="./">$blogname</a></div>
$blog_info

</div>
    <div><form id="searchform" name="keyform" method="get" action="index.php">
<div>    <input name="keyword"  type="text" id="s" value="" />
	<input name="action" type="hidden" value="search" />
<input type="submit" id="searchsubmit" value="GO" />
</div>
</form></div>
	</div>
</div>
<div id="page">
<div id="content">
EOT;
?>