<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="generator" content="emlog" />
<title><?php echo $blogtitle; ?></title>
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php">
<link href="<?php echo CERTEMPLATE_URL; ?>/style.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]>
<link rel="stylesheet" href="<?php echo CERTEMPLATE_URL; ?>/ie7.css" type="text/css" media="screen" />
<![endif]-->
<!--[if IE 6]>
<link rel="stylesheet" href="<?php echo CERTEMPLATE_URL; ?>/ie6.css" type="text/css" media="screen" />
<![endif]-->


<script src="<?php echo BLOG_URL; ?>lib/js/common_tpl.js" type="text/javascript"></script>
</head>
<body>
<div class="all">
	<div class="header">
		<h1><a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a></h1>
		<h2><?php echo $bloginfo; ?></h2>
	</div> <!-- HEADER -->
<form name="f" method="post" action="<?php echo BLOG_URL; ?>?action=login">
<div class="menu1">
<div class="menu2">
<ul>

<?php if(ISLOGIN): ?>
	<li class="nocurrent_page_item"><a href="<?php echo BLOG_URL; ?>admin/write_log.php">写日志</a></li>
	<li class="nocurrent_page_item"><a href="<?php echo BLOG_URL; ?>admin/">管理中心</a></li>
	<li class="nocurrent_page_item"><a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a></li>
<?php else: ?>
	<li class="nocurrent_page_item"><a href="<?php echo BLOG_URL; ?>admin/">登录</a></li>
<?php endif; ?>
</ul>
</div> <!-- MENU 2 -->
</div> <!-- MENU 1 -->
</form>