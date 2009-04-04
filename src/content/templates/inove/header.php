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
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo $blogurl; ?>rss.php">
<link href="<?php echo $em_tpldir; ?>main.css" rel="stylesheet" type="text/css" />
<script src="./lib/js/common_tpl.js" type="text/javascript"></script>
</head>
<body>
<!-- wrap START -->
<div id="wrap">

<!-- container START -->
<div id="container">

<!-- header START -->
<div id="header">
	<div id="caption">
		<h1 id="title"><a href="./"><?php echo $blogname; ?></a></h1>
		<div id="tagline"><?php echo $bloginfo; ?></div>
	</div>

	<!-- navigation START -->
	<div id="navigation">
		<ul id="menus">
			<?php if(ISLOGIN): ?>
			<li class="current_page_item"><a href="./index.php">首页</a></li>
			<li class="page_item page-item-2"><a href="./admin/write_log.php">写日志</a></li>
			<li class="page_item page-item-2"><a href="./admin/">管理中心</a></li>
			<li class="page_item page-item-2"><a href="./admin/index.php?action=logout">退出</a></li>
			<?php else: ?>
			<li class="current_page_item"><a href="./index.php">首页</a></li>
			<li class="page_item page-item-2"><a href="./admin/index.php">登录</a></li>
			<?php endif; ?>
		</ul>

		<!-- searchbox START -->
		<div id="searchbox">
							<form name="keyform" method="get" action="index.php">
					<div class="content">
						<input class="textfield" name="keyword"  type="text" value="" style="width:130px;"/>
						<span class="switcher" >切换搜索引擎</span>
					</div>
				</form>
					</div>
		<!-- searchbox END -->

		<div class="fixed"></div>
	</div>
	<!-- navigation END -->

	<div class="fixed"></div>
</div>
<!-- header END -->
<!-- content START -->
<div id="content">

	<!-- main START -->
	<div id="main">
