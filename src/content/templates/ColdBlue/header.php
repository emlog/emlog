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
<link rel="stylesheet" href="<?php echo CERTEMPLATE_URL; ?>/css/reset.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo CERTEMPLATE_URL; ?>/css/style.css" type="text/css" media="screen" />
<script src="<?php echo BLOG_URL; ?>lib/js/common_tpl.js" type="text/javascript"></script>
</head>
<body>
	<div id="header"><div class="inner clear">
		<h1><a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a></h1>
		<ul id="navigation">
			<li><?php echo $bloginfo; ?></li>
		</ul>
	</div></div>
	
	<div id="search"><div class="inner clear">
		<a id="rss-link" href="<?php echo BLOG_URL; ?>index.php"><strong>首页</strong></a>
		<?php if(ISLOGIN): ?>
	<a id="rss-link" href="<?php echo BLOG_URL; ?>admin/write_log.php">写日志</a>
	<a id="rss-link" href="<?php echo BLOG_URL; ?>admin/">管理中心</a>
	<a id="rss-link" href="<?php echo BLOG_URL; ?>admin/index.php?action=logout">退出</a>
<?php else: ?>
	<a id="rss-link" href="<?php echo BLOG_URL; ?>admin/index.php">登录</a>
<?php endif; ?>
		<form name="keyform" method="get" id="searchform" action="<?php echo BLOG_URL; ?>index.php"><div>
	<input name="keyword"  type="text" value="" id="s" />
	<input type="submit" id="searchsubmit" value="Search" onclick="return keyw()" />
</div></form>
	</div></div>
	<div id="wrapper" class="clear">
	<div id="content">