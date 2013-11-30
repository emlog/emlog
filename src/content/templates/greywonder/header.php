<?php
/*
Template Name:Grey Wonder
Description:暗色系，各种特效。
Author:奇遇
Author Url:http://www.qiyuuu.com
Sidebar Amount:4
*/
if(!defined('EMLOG_ROOT')) {exit('error!');}
require_once View::getView('module');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $blogtitle; ?> Powered by emlog</title>
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="description" content="<?php echo $description; ?>" />
<meta name="generator" content="emlog" />
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php echo BLOG_URL; ?>xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="<?php echo BLOG_URL; ?>wlwmanifest.xml" />
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php" />
<link href="<?php echo TEMPLATE_URL; ?>main.css" rel="stylesheet" type="text/css" />
<?php if(isset($_COOKIE['logo-position'])): ?><style type="text/css">.logo{left:<?php echo $_COOKIE['logo-position']; ?>}</style><?php endif; ?>
<script src="<?php echo BLOG_URL; ?>include/lib/js/common_tpl.js" type="text/javascript"></script>
<?php doAction('index_head'); ?>
</head>
<body>
<div class="logo">
	<div id="message">
		页面载入中...
	</div>
	<div class="eye1">
	    <img src="<?php echo TEMPLATE_URL; ?>images/pupil.png" style="top:12px;left:12px" id="movingEye1" />
    </div>
    <div class="eye2">
		<img src="<?php echo TEMPLATE_URL; ?>images/pupil.png" style="top:12px;left:12px" id="movingEye2" />
    </div>
</div>
<div class="topnav">
	<div class="container">
		<ul class="navi">
			<li<?php echo $curpage == CURPAGE_HOME ? ' class="current"' : '';?>><a href="<?php echo BLOG_URL; ?>">首页</a></li>
			<?php if($istwitter == 'y'):?>
			<li<?php echo $curpage == CURPAGE_TW ? ' class="current"' : '';?>><a href="<?php echo BLOG_URL; ?>t/"><?php echo Option::get('twnavi');?></a></li>
			<?php endif;?>
			<?php 
				foreach ($navibar as $key => $val):
				if ($val['hide'] == 'y'){continue;}
				if (empty($val['url'])){$val['url'] = Url::log($key);}
			?>
			<li<?php echo isset($logid) && $key == $logid ? ' class="current"' : '';?>><a href="<?php echo $val['url']; ?>" target="<?php echo $val['is_blank']; ?>"><?php echo $val['title']; ?></a></li>
			<?php endforeach;?>
			<?php doAction('navbar', '<li>', '</li>'); ?>
		</ul>
		<div class="info">
			<?php echo $bloginfo; ?>
		</div>
	</div>
</div>