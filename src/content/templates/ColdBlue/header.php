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
<link rel="stylesheet" href="<?php echo CERTEMPLATE_URL; ?>/css/reset.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo CERTEMPLATE_URL; ?>/css/style.css" type="text/css" media="screen" />
<script src="<?php echo BLOG_URL; ?>lib/js/common_tpl.js" type="text/javascript"></script>
<?php doAction('index_head'); ?>
</head>
<body>
	<div id="header"><div class="inner clear">
		<h1><a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a></h1>
		<ul id="navigation">
			<li><?php echo $bloginfo; ?></li>
		</ul>
	</div></div>
	
	<div id="search"><div class="inner clear">
	<ul id="nav-link">
	<li><a href="<?php echo BLOG_URL; ?>">首页</a></li>
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
		<form name="keyform" method="get" id="searchform" action="<?php echo BLOG_URL; ?>"><div>
	<input name="keyword"  type="text" value="" id="s" />
	<input type="submit" id="searchsubmit" value="Search" onclick="return keyw()" />
</div></form>
	</div></div>
	<div id="wrapper" class="clear">
	<div id="content">