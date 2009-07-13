<?php
/*
Template Name:900123
Description:这是以我的生日命名的模板 ……
Author:小子
Author Url:http://www.1zdiy.com
Sidebar Amount:1
*/
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
	<div id="header">
		<div class="head-wrap">
			<div id="toptool">
			<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
			<div class="login" style="float:left">
			<a href="./admin/">管理中心</a> 丨 <a href="./admin/?action=logout">退出</a>
			</div>
			<?php else: ?>
			<form action="admin/index.php?action=login" method="post">
			<div class="login" style="float:left">
			<label>用户名</label>
			<INPUT id="user" name="user" value="" />
			<label>密码</label>
			<INPUT id="pw" type="password" name="pw" value="" />
			<INPUT id="ispersis" style="border:0;" type="checkbox" name="ispersis" value="1" checked /><label>记住我</label>

			<INPUT class="submit" type="submit" value=" 登 录" />
			</div>
			</form>
			<?php endif; ?>
			<div class="tool" style="float:right;">
			<span style="CURSOR: hand;" onClick="window.external.addFavorite('<?php echo BLOG_URL; ?>','<?php echo $blogname; ?>')" >加入收藏</span>
			</div>
			</div>
			<div id="head" style="clear:both">
				<ul>
					<li id="title"><h1><a href="./"><?php echo $blogname; ?></a></h1></li>
					<li id="tagline"><?php echo $bloginfo; ?></li>
				</ul>
			</div>
		</div>
		<div class="nav-wrap">
			<div id="nav">
				<ul id="menus">
			<li class="<?php echo empty($_GET) ? current : common; ?>"><a href="./">首页</a></li>
			<?php foreach ($navibar as $key => $val):
			if ($val['hide'] == 'y'){continue;}
			if (empty($val['url'])){$val['url'] = './?post='.$key;}
			?>
			<li class="<?php echo isset($logid) && $logid == $key ? current : common; ?>"><a href="<?php echo $val['url']; ?>" target="<?php echo $val['is_blank']; ?>"><?php echo $val['title']; ?></a></li>
			<?php endforeach;?>
			<?php doAction('navbar', '<li class="common">', '</li>'); ?>
					<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
					<li class="admin"><a href="./admin/write_log.php">写日志</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<!--header end-->
	<div class="main-wrap">
		<div class="category">
			<ul id="cate">
			<li><img src="content/templates/900123/images/catec.gif" /></li>
			<?php foreach($sort_cache as $value): ?>
			<li>
				<a href="./?sort=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?></a>
			</li>
			<?php endforeach; ?>
			</ul>
		</div>
		<div id="main">
