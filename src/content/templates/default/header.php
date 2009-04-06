<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="generator" content="emlog" />
<title><?php echo $blogtitle; ?></title>
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo $blogurl; ?>rss.php">
<link href="<?php echo $em_tpldir; ?>main.css" rel="stylesheet" type="text/css" />
<script src="./lib/js/common_tpl.js" type="text/javascript"></script>
</head>
<body>
<div class="main">
	<div class="header">
		<ul>
			<li id="title"><h1><a href="./"><?php echo $blogname; ?></a></h1></li>
			<li id="tagline"><?php echo $bloginfo; ?></li>
		</ul>
		<ul id="menus">
			<li class="menus1"><a href="./index.php">首页</a></li>		
			<?php if(ISLOGIN): ?>
			<li class="menus2"><a href="./admin/write_log.php">写日志</a></li>
			<li class="menus2"><a href="./admin/">管理中心</a></li>
			<li class="menus2"><a href="./admin/index.php?action=logout">退出</a></li>
			<?php else: ?>
			<li class="menus2"><a href="./admin/index.php">登录</a></li>
			<?php endif; ?>
		</ul>
		<div class="clear"></div>
	</div>
	<!--header end-->