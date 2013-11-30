<?php
/*
Template Name:未命名
Description:
Author:奇遇
Author Url:http://www.qiyuuu.com
Sidebar Amount:1
*/
if(!defined('EMLOG_ROOT')) {exit('error!');}
require_once View::getView('module');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $blogtitle; ?> - powered by emlog</title>
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="description" content="<?php echo $description; ?>" />
<meta name="generator" content="emlog" />
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php echo BLOG_URL; ?>xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="<?php echo BLOG_URL; ?>wlwmanifest.xml" />
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php" />
<link href="<?php echo TEMPLATE_URL; ?>main.css" rel="stylesheet" type="text/css" />
<script src="<?php echo BLOG_URL; ?>include/lib/js/common_tpl.js" type="text/javascript"></script>
<?php doAction('index_head'); ?>
</head>
<body>
<?php if(!$isIE):?><div id="rainbow">
</div><?php endif; ?>
<?php if(!$isIE || $isIE9): ?><div id="navi">
	<div class="outer-book-left">
		<div class="outer-book-right">
			<div class="inner-book-right">
				<div class="inner-book-left">
					<ul class="navi">
						<li class="navbg"></li>
						<li class="<?php echo $curpage == CURPAGE_HOME || (isset($logid) && !in_array($logid,array_keys($navibar))) ? 'current ' : '';?>navlist"><a href="<?php echo BLOG_URL; ?>">首页</a></li>
						<?php if($istwitter == 'y'):?>
						<li class="<?php echo $curpage == CURPAGE_TW ? 'current ' : '';?>navlist"><a href="<?php echo BLOG_URL; ?>t/"><?php echo Option::get('twnavi');?></a></li>
						<?php endif;?>
						<?php 
						foreach ($navibar as $key => $val):
						if ($val['hide'] == 'y'){continue;}
						if (empty($val['url'])){$val['url'] = Url::log($key);}
						?>
						<li class="<?php echo isset($logid) && $key == $logid ? 'current ' : '';?>navlist"><a href="<?php echo $val['url']; ?>" target="<?php echo $val['is_blank']; ?>"><?php echo $val['title']; ?></a></li>
						<?php endforeach;?>
						<?php doAction('navbar', '<li class="navlist">', '</li>'); ?>
						<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
						<li class="navlist"><a href="<?php echo BLOG_URL; ?>admin/write_log.php" class="non-ajax">写日志</a></li>
						<li class="navlist"><a href="<?php echo BLOG_URL; ?>admin/" class="non-ajax">管理中心</a></li>
						<li class="navlist"><a href="<?php echo BLOG_URL; ?>admin/?action=logout" class="non-ajax">退出</a></li>
						<?php else: ?>
						<li class="navlist"><a href="<?php echo BLOG_URL; ?>admin/" class="non-ajax">登录</a></li>
						<?php endif; ?>
   					</ul>
				</div>
			</div>
		</div>
	</div>
</div><?php endif; ?>
<div id="wrapper">
	<div id="header">
		<h1><a href="<?php echo BLOG_URL; ?>" title="<?php echo Option::get('blogname'); ?>"><?php echo Option::get('blogname'); ?></a></h1>
		<div class="blogdesc"><?php echo Option::get('bloginfo'); ?></div>
		<?php if($isIE && !$isIE9): ?><div id="navi-ie">
			<ul class="navi-ie">
				<li class="<?php echo $curpage == CURPAGE_HOME || (isset($logid) && !in_array($logid,array_keys($navibar))) ? 'current ' : '';?>navlist"><a href="<?php echo BLOG_URL; ?>">首页</a></li>
				<?php if($istwitter == 'y'):?>
				<li class="<?php echo $curpage == CURPAGE_TW ? 'current ' : '';?>navlist"><a href="<?php echo BLOG_URL; ?>t/"><?php echo Option::get('twnavi');?></a></li>
				<?php endif;?>
				<?php 
					foreach ($navibar as $key => $val):
					if ($val['hide'] == 'y'){continue;}
					if (empty($val['url'])){$val['url'] = Url::log($key);}
				?>
				<li class="<?php echo isset($logid) && $key == $logid ? 'current ' : '';?>navlist"><a href="<?php echo $val['url']; ?>" target="<?php echo $val['is_blank']; ?>"><?php echo $val['title']; ?></a></li>
				<?php endforeach;?>
				<?php doAction('navbar', '<li class="navlist">', '</li>'); ?>
				<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
				<li class="navlist"><a href="<?php echo BLOG_URL; ?>admin/write_log.php" class="non-ajax">写日志</a></li>
				<li class="navlist"><a href="<?php echo BLOG_URL; ?>admin/" class="non-ajax">管理中心</a></li>
				<li class="navlist"><a href="<?php echo BLOG_URL; ?>admin/?action=logout" class="non-ajax">退出</a></li>
				<?php else: ?>
				<li class="navlist"><a href="<?php echo BLOG_URL; ?>admin/" class="non-ajax">登录</a></li>
				<li class="navbg"></li>
				<?php endif; ?>
   			</ul>
		</div><?php endif;?>
	</div>
	<div id="bread">
		<a href="<?php echo BLOG_URL; ?>"><?php echo Option::get('blogname'); ?></a>
		<?php if($curpage == CURPAGE_TW): ?>
			<span>&raquo;</span> <a href="<?php echo BLOG_URL; ?>t/"><?php echo Option::get('twnavi');?></a>
		<?php elseif($curpage == CURPAGE_HOME): ?>
			<?php if(isset($sortName)) :?>
			<span>&raquo;</span> <a href="<?php echo Url::sort($sortid); ?>"><?php echo $sortName; ?></a>
			<?php elseif(isset($tag)): ?>
			<span>&raquo;</span> <a href="<?php echo Url::tag(urlencode($tag)); ?>"><?php echo $tag; ?></a>
			<?php elseif(isset($author_name)): ?>
			<span>&raquo;</span> <a href="<?php echo Url::author($author); ?>"><?php echo $author_name; ?></a>
			<?php elseif(isset($record)): ?>
			<span>&raquo;</span> <a href="<?php echo Url::record($record); ?>">归档<?php echo $record; ?></a>
			<?php elseif(isset($keyword)): ?>
			<span>&raquo;</span> <a href="<?php echo BLOG_URL.'?keyword='.urlencode($keyword); ?>"><?php echo $keyword; ?></a>
			<?php elseif(isset($plugin)): ?>
			<span>&raquo;</span> <a href="<?php echo BLOG_URL.'?plugin='.$plugin; ?>"><?php echo $plugin; ?></a>
			<?php endif;?>
		<?php elseif($curpage == CURPAGE_LOG): 
			global $CACHE; 
			$log_cache_sort = $CACHE->readCache('logsort');
			if(!empty($log_cache_sort[$logid])): ?>
			<span>&raquo;</span> <a href="<?php echo Url::sort($log_cache_sort[$logid]['id']); ?>"><?php echo $log_cache_sort[$logid]['name']; ?></a>
			<?php endif; ?>
			<span>&raquo;</span> <span><?php echo $log_title; ?></span>
		<?php endif; ?>
		<?php if(isset($page) && $page > 1): ?>
			<span>&raquo;</span> <span>第<?php echo $page; ?>页</span>
		<?php endif; ?>
		<?php if(isset($comment_page) && $comment_page > 1): ?>
			<span>&raquo;</span> <span>评论第<?php echo $comment_page; ?>页</span>
		<?php endif; ?>
	</div>
	<div id="container">