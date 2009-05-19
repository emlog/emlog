<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
require_once (getViews('module'));
if($action ==''):
		$home_style = 'current_page_item';
		$style = 'page_item';
	elseif($action =='tag'):
		$home_style = 'page_item';
		$style = 'current_page_item';
	else:
		$home_style = 'page_item';
		$style = 'page_item';
	endif;	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="generator" content="emlog" />
<title><?php echo $blogtitle;?></title>
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php">
<link href="<?php echo CERTEMPLATE_URL; ?>/main.css" rel="stylesheet" type="text/css" />
<script src="<?php echo BLOG_URL; ?>lib/js/common_tpl.js" type="text/javascript"></script>
<?php doAction('index_head'); ?>
</head>
<body>
<div id="header"><div class="wrap_center">
	<h1><a href="<?php echo BLOG_URL; ?>"><?php echo $blogname;?></a></h1>
</div></div>

<div class="clear"></div>

<div id="menu">
<ul>
	<li class="$home_style"><a href="<?php echo BLOG_URL; ?>" title="Home">Home</a></li>
<?php if(ISLOGIN): ?>
	<li><a href="<?php echo BLOG_URL; ?>admin/write_log.php">写日志</a></li>
	<li><a href="<?php echo BLOG_URL; ?>admin/">管理中心</a></li>
	<li><a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a></li>
<?php else: ?>
	<li><a href="<?php echo BLOG_URL; ?>admin/">登录</a></li>
<?php endif; ?>
	<li class="rss"><a href="<?php echo BLOG_URL; ?>rss.php" title="Subscribe to Feed">Subscribe to Feed</a></li>
</ul>
</div>

<div class="clear"></div>

<div id="page"><div class="wrap_center"><div class="wrap_float">