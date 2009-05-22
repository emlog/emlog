<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
require_once (getViews('module'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="keywords" content="<?php echo $site_key; ?>" />
	<meta name="generator" content="emlog" />
	<title><?php echo $blogtitle; ?></title>
	<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php">
	<link href="<?php echo CERTEMPLATE_URL; ?>/style.css" rel="stylesheet" type="text/css" />
	<!--[if IE]>
    	<link rel="stylesheet" type="text/css" href="<?php echo CERTEMPLATE_URL; ?>/ie.css" media="screen" />
    <![endif]-->
    <script src="<?php echo BLOG_URL; ?>lib/js/common_tpl.js" type="text/javascript"></script>
<?php doAction('index_head'); ?>
</head>
<body>
<div id="container">
	<div id="header">
		<h1><a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a><span><?php echo $bloginfo; ?></span></h1>
		<div id="search">
			<form method="get" id="searchform" action="<?php echo BLOG_URL; ?>">
				<input type="text" value="搜索..." name="keyword" id="s" onfocus="if(this.value=='搜索...')this.value=''" onblur="if(this.value=='')this.value='搜索...'" />
				<input type="submit" id="searchsubmit" value="" />
			</form>
		</div>
	</div>
	<div id="nav">
		<ul>
			<li class="current_page_item"><a href="<?php echo BLOG_URL; ?>">首页</a></li>
			<?php foreach ($navibar as $key => $val):
			if ($val['hide'] == 'y'){continue;}
			if (empty($val['url'])){$val['url'] = BLOG_URL.'?post='.$key;}
			?>
			<li><a href="<?php echo $val['url']; ?>" target="<?php echo $val['is_blank']; ?>"><?php echo $val['title']; ?></a></li>
			<?php endforeach;?>
			<?php doAction('navbar', '<li>', '</li>'); ?>
			<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
			<li><a href="<?php echo BLOG_URL; ?>admin/write_log.php">写日志</a></li>
			<li><a href="<?php echo BLOG_URL; ?>admin/">管理中心</a></li>
			<li><a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a></li>
			<?php else: ?>
			<li><a href="<?php echo BLOG_URL; ?>admin/">登录</a></li>
			<?php endif; ?>
		</ul>
		<a href="<?php echo BLOG_URL; ?>rss.php" id="feed"></a>
	</div>
<div id="wrapper">