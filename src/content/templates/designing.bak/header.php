<?php
/*
Template Name:奇遇
Description:啊，随便高一个模板出来
Version:1.2
Author:emlog
Author Url:http://www.emlog.net
Sidebar Amount:1
ForEmlog:5.0.1
*/
if(!defined('EMLOG_ROOT')) {exit('error!');}
require_once View::getView('module');
emLoadJQuery();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $site_title; ?></title>
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="description" content="<?php echo $site_description; ?>" />
<meta name="generator" content="emlog" />
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php echo BLOG_URL; ?>xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="<?php echo BLOG_URL; ?>wlwmanifest.xml" />
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php" />
<link href="<?php echo TEMPLATE_URL; ?>main.css" rel="stylesheet" type="text/css" />
<script src="<?php echo BLOG_URL; ?>include/lib/js/common_tpl.js" type="text/javascript"></script>
<?php doAction('index_head'); ?>
<script src="<?php echo TEMPLATE_URL; ?>js/jquery.transit.min.js" type="text/javascript"></script>
<script src="<?php echo TEMPLATE_URL; ?>js/s.js" type="text/javascript"></script>
</head>
<body>
<div id="container">
	<div id="header">
		<h1><a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a></h1>
		<h3><?php echo $bloginfo; ?></h3>
	</div>
	<div id="nav"><?php //blog_navi();?></div>