<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="generator" content="emlog" />
<title><?php echo $blogtitle; ?></title>
<link rel="alternate" type="application/rss+xml" title="订阅我的博客"  href="./rss.php">
<link href="<?php echo $em_tpldir; ?>main.css" rel="stylesheet" type="text/css" />
<script src="./lib/js/common_tpl.js" type="text/javascript"></script>
</head>
<body>
<div id="wrapper">

<div id="headerwrapper"><div id="header">
<div id="title">
<h1><a href="./"><?php echo $blogname; ?></a></h1>
<h3><?php echo $bloginfo; ?></h3>
</div><!-- Closes title -->

<div id="topright">
    <a href="./rss.php"><img src="<?php echo $em_tpldir; ?>images/rss2.gif" alt="订阅Rss"/></a>
</div><!-- Closes topright -->

<div id="nav">
<div id="search"><form method="get" id="searchform" name="keyform" action="index.php">
<div>
<input type="text" value="" name="keyword" id="searchbox"/>
<input type="submit" id="searchbutton" value="" onclick="return keyw()" />
</div>
</form></div> <!-- Closes search -->
<ul>
	<li><a href="./index.php">首页</a></li>
<?php if(ISLOGIN): ?>
	<li class="page_item page-item-2"><a href="./admin/add_log.php">写日志</a></li>
	<li class="page_item page-item-2"><a href="./admin/">管理中心</a></li>
	<li class="page_item page-item-2"><a href="./admin/index.php?action=logout">退出</a></li>
<?php else: ?>
	<li class="page_item page-item-2"><a href="./admin/index.php">登录</a></li>
<?php endif; ?>
</ul>
</div> <!-- Closes nav -->
</div></div> <!-- Closes header --><!-- Closes headerwrapper -->
<div id="main">

<div id="contentwrapper"><div id="content">

