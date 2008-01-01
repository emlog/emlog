<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
$load=$action?'':"onload=\"sendinfo('$calendar_url');\"";
print <<<EOT
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<body $load>
<div id="holder">
<div id="header">
	<div id="siteTitle">
	<ul>
  		<li id="blogname"><a href="./">$blogname</a></li>
  		<li id="blogdes">$blog_info</li>
	</ul>
  	</div>
	<div id="navBar">
    	<ul>
	      <li><a href="./">首页</a></li>
		  <li><a href="./?action=tag">标签</a></li>
          <li><a href="./adm/">登录</a></li>
    	</ul>
  	</div>
	</div>
<!--
EOT;
?>-->