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
<link rel="stylesheet" href="<?php echo $em_tpldir; ?>css/reset.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $em_tpldir; ?>css/style.css" type="text/css" media="screen" />
<script src="./lib/js/common_tpl.js" type="text/javascript"></script>
</head>
<body>
	<div id="header"><div class="inner clear">
		<h1><a href="./"><?php echo $blogname; ?></a></h1>
		<ul id="navigation">
			<li><?php echo $bloginfo; ?></li>
		</ul>
	</div></div>
	
	<div id="search"><div class="inner clear">
		<a id="rss-link" href="./index.php"><strong>首页</strong></a>
		<?php if(ISLOGIN): ?>
	<a id="rss-link" href="./admin/write_log.php">写日志</a>
	<a id="rss-link" href="./admin/">管理中心</a>
	<a id="rss-link" href="./admin/index.php?action=logout">退出</a>
<?php else: ?>
	<a id="rss-link" href="./admin/index.php">登录</a>
<?php endif; ?>
		<form name="keyform" method="get" id="searchform" action="index.php"><div>
	<input name="keyword"  type="text" value="" id="s" />
	<input type="submit" id="searchsubmit" value="Search" onclick="return keyw()" />
</div></form>
	</div></div>
	<div id="wrapper" class="clear">
	<div id="content">