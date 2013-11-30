<?php
/*
Template Name:未命名-ajax
Description:全站ajax
Author:奇遇
Author Url:http://www.qiyuuu.com
Sidebar Amount:1
ForEmlog:4.1.0
*/
if(!defined('EMLOG_ROOT')) {exit('error!');}
require_once View::getView('module');
if($_):
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $site_title; ?></title>
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="description" content="<?php echo str_replace("\r\n", ' ', $site_description); ?>" />
<meta name="generator" content="emlog" />
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php echo BLOG_URL; ?>xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="<?php echo BLOG_URL; ?>wlwmanifest.xml" />
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php" />
<link href="<?php echo TEMPLATE_URL; ?>css.php" rel="stylesheet" type="text/css" />
<?php doAction('index_head'); ?>
</head>
<body>
<div id="loading">
	<img src="<?php echo TEMPLATE_URL;?>images/ali/19.gif" alt="加载中……" width="50" height="50" />加载中……
</div>
<?php if(!$isIE):?><div id="rainbow">
</div><?php endif; ?>
<?php if(!$isIE || $isIE9): ?><div id="navi">
	<div class="outer-book-left">
		<div class="outer-book-right">
			<div class="inner-book-right">
				<div class="inner-book-left">
					<ul class="navi">
						<?php blog_navi();?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div><?php endif; ?>
<div id="wrapper">
	<div id="header">
		<h1><a href="<?php echo BLOG_URL; ?>" title="<?php echo Option::get('blogname'); ?>"><?php echo Option::get('blogname'); ?></a></h1>
		<div class="blogdesc"><pre><?php echo Option::get('bloginfo'); ?></pre></div>
		<?php if($isIE && !$isIE9): ?><div id="navi-ie">
			<ul class="navi-ie">
				<?php blog_navi();?>
			</ul>
		</div><?php endif;?>
	</div>
	<div id="bread">
		<?php include View::getView('bread'); ?>
	</div>
	<div id="container">
<?php else:$ajax['title']=$site_title;include View::getView('bread');$ajax['bread']=ob_get_clean();ob_start();endif; ?>