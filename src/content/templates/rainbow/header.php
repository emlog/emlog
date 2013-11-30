<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
require_once View::getView('module');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="description" content="<?php echo $description; ?>" />
<meta name="generator" content="emlog" />
<title><?php echo $blogtitle; ?> Powered by emlog</title>
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php echo BLOG_URL; ?>xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="<?php echo BLOG_URL; ?>wlwmanifest.xml" />
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php" />
<link href="<?php echo TEMPLATE_URL; ?>style.css" rel="stylesheet" type="text/css" />
<script src="<?php echo BLOG_URL; ?>include/lib/js/jquery/jquery-1.2.6.js" type="text/javascript"></script>
<script src="<?php echo BLOG_URL; ?>include/lib/js/common_tpl.js" type="text/javascript"></script>
<?php doAction('index_head'); ?>
</head>
<body>
<div class="topmenu"></div>
<!-- Wrapper begin -->
<div class="wrapper">
	<div class="ctop"></div>
    <!-- Container begin -->
    <div class="container">
        <!-- Header begin -->
        <div id="header">
                <!-- Top begin -->
                <div class="top">
                    <!-- Logo begin -->
                    <div class="logo">
    					<div class="eye1">
	    					<img src="<?php echo TEMPLATE_URL; ?>images/pupil.png" style="top:12px;left:12px" id="movingEye1" />
    					</div>
    					<div class="eye2">
	    					<img src="<?php echo TEMPLATE_URL; ?>images/pupil.png" style="top:12px;left:12px" id="movingEye2" />
    					</div>
    				</div>
                    <!-- Logo end -->
                    <!-- Search begin -->
                    <div class="search">
						<form method="get" action="http://www.google.com/search" class="searchform" target="_blank">
							<input type="text" name="q" class="searchInput" />
							<input type="submit" name="btnG" class="searchBtn" value="搜索" />
							<input type="hidden" name="ie" value="UTF8" />
							<input type="hidden" name="oe" value="UTF8" />
							<input type="hidden" name="hl" value="zh-CN" />
							<input type="hidden" name="domains" value="www.qiyuuu.com" />
							<input type="hidden" name="sitesearch" value="www.qiyuuu.com" />
						</form>
                    </div>
                    <!-- Search end -->
                </div>
                <!-- Top end -->
                <!-- Main Navigation begin -->
                <ul class="navi">
                	<li<?php echo $curpage == CURPAGE_HOME ? ' class="current-menu-item"' : '';?>><a href="<?php echo BLOG_URL; ?>">首页</a></li>
					<?php if($istwitter == 'y'):?>
					<li<?php echo $curpage == CURPAGE_TW ? ' class="current-menu-item"' : '';?>><a href="<?php echo BLOG_URL; ?>t/">碎语</a></li>
					<?php endif;?>
					<?php 
					foreach ($navibar as $key => $val):
					if ($val['hide'] == 'y'){continue;}
					if (empty($val['url'])){$val['url'] = Url::log($key);}
					?>
					<li<?php echo isset($logid) && $key == $logid ? ' class="current-menu-item"' : '';?>><a href="<?php echo $val['url']; ?>" target="<?php echo $val['is_blank']; ?>"><?php echo $val['title']; ?></a></li>
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
                <!-- Main Navigation end -->
                <!-- Sub Navigation begin -->
                <div class="subnavi">
                    <!-- Breadcrumb begin -->
                    <div class="breadcrumb">
                    当前位置：<a href="<?php echo BLOG_URL; ?>">首页</a>
					<?php if($curpage == CURPAGE_LOG): ?>
						<?php blog_sort($sortid, $logid, 1); ?> > <a href="<?php echo Url::log($logid); ?>"><?php echo $log_title; ?></a>
					<?php elseif($curpage == CURPAGE_TW): ?>
 						> <a href="<?php echo BLOG_URL; ?>t/">碎语</a>
					<?php elseif($curpage == CURPAGE_HOME): ?>
						<?php if(isset($plugin) && $plugin): ?>
	 						> <a href="<?php echo BLOG_URL; ?>plugin/<?php echo $plugin; ?>"><?php echo $plugin; ?></a>
						<?php elseif(isset($sortid) && $sortid): ?>
 							> <a href="<?php echo Url::sort($sortid); ?>"><?php echo $sort_cache[$sortid]['sortname']; ?></a>
						<?php elseif(isset($tag) && $tag): ?>
 							> <a href="<?php echo Url::tag($tag); ?>"><?php echo $tag; ?></a>
						<?php elseif(isset($keyword) && $keyword): ?>
 							> <a href="<?php echo BLOG_URL; ?>?keyword=<?php echo urlencode($keyword); ?>"><?php echo $keyword; ?></a>
						<?php elseif(isset($author) && isset($user_cache[$author])): ?>
 							> <a href="<?php echo Url::author($author); ?>"><?php echo $user_cache[$author]['name']; ?></a>
						<?php elseif(isset($record) && preg_match("/^[\d]{6,8}$/", $record)): ?>
 							> <a href="<?php echo Url::record($record); ?>">归档<?php echo $record; ?></a>
						<?php endif; ?>
					<?php endif;?>
                    </div>
                    <!-- Breadcrumb end -->
                </div>
                <!-- Sub Navigation end -->
        </div>
        <!-- Header end -->
        <!-- Content begin -->
        <div id="content">