<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
require_once (getViews('module'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="generator" content="emlog" />
<title><?php echo $blogtitle; ?></title>
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php">
<link href="<?php echo CERTEMPLATE_URL; ?>/main.css" rel="stylesheet" type="text/css" />
<script src="<?php echo BLOG_URL; ?>lib/js/common_tpl.js" type="text/javascript"></script>
<?php doAction('index_head'); ?>
</head>
<body>
<div id="wrapper">

<div id="headerwrapper"><div id="header">
<div id="title">
<h1><a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a></h1>
<h3><?php echo $bloginfo; ?></h3>
</div><!-- Closes title -->

<div id="topright">
    <a href="<?php echo BLOG_URL; ?>rss.php"><img src="<?php echo CERTEMPLATE_URL; ?>/images/rss2.gif" alt="订阅Rss"/></a>
</div><!-- Closes topright -->

<div id="nav">
<div id="search"><form method="get" id="searchform" name="keyform" action="<?php echo BLOG_URL; ?>">
<div>
<input type="text" value="" name="keyword" id="searchbox"/>
<input type="submit" id="searchbutton" value="" onclick="return keyw()" />
</div>
</form></div> <!-- Closes search -->
<ul>
	<li><a href="<?php echo BLOG_URL; ?>">首页</a></li>
<?php if(ISLOGIN): ?>
	<li class="page_item page-item-2"><a href="<?php echo BLOG_URL; ?>admin/write_log.php">写日志</a></li>
	<li class="page_item page-item-2"><a href="<?php echo BLOG_URL; ?>admin/">管理中心</a></li>
	<li class="page_item page-item-2"><a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a></li>
<?php else: ?>
	<li class="page_item page-item-2"><a href="<?php echo BLOG_URL; ?>admin/">登录</a></li>
<?php endif; ?>
</ul>
</div> <!-- Closes nav -->
</div></div> <!-- Closes header --><!-- Closes headerwrapper -->
<div id="main">

<div id="contentwrapper"><div id="content">

