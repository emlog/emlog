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
<?php doAction('index_header'); ?>
</head>
<body>
	
<div id="container">
<div id="header">
<h1><a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a></a></h1>
<?php echo $bloginfo; ?>
	
<div id="search">
	<form name="keyform" method="get" action="<?php echo BLOG_URL; ?>">
	<div>
<input type="text" name="keyword" id="keyword" onblur="this.value=(this.value=='') ? 'Search' : this.value;" onfocus="this.value=(this.value=='Search') ? '' : this.value;" value="Search" />
	<input type="submit" id="searchsubmit" value="" />
	</div>
	</form>	
</div>
</div>

<div id="navbar">
<div class="menu">
<ul>
	<li><a href="<?php echo BLOG_URL; ?>">首页</a></li>
<?php if(ISLOGIN): ?>
	<li><a href="<?php echo BLOG_URL; ?>admin/write_log.php">写日志</a></li>
	<li><a href="<?php echo BLOG_URL; ?>admin/">管理中心</a></li>
	<li><a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a></li>
<?php else: ?>
	<li><a href="<?php echo BLOG_URL; ?>admin/">登录</a></li>
<?php endif; ?>
</ul>
</div>
</div>
<div id="posts">