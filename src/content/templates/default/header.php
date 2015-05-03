<?php
/*
Template Name:默认模板
Description:默认模板，简洁优雅
Version:1.2
Author:emlog
Author Url:http://www.emlog.net
*/
if(!defined('EMLOG_ROOT')) {exit('error!');}
require_once View::getView('module');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $site_title; ?></title>
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="description" content="<?php echo $site_description; ?>" />
<meta name="generator" content="emlog" />
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php" />
<link href="<?php echo TEMPLATE_URL; ?>main.css" rel="stylesheet" type="text/css" />
<link href="<?php echo BLOG_URL; ?>admin/views/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo BLOG_URL; ?>admin/editor/plugins/code/prettify.css" rel="stylesheet" type="text/css" />
<?php doAction('index_head'); ?>
</head>
<body>
<!--导航-->
<?php blog_navi();?>

<header class="sb-page-header">
	<div class="container">
		<h1><?php echo $blogname; ?></h1>
		<p><?php echo $bloginfo; ?></p>
	</div>
</header>
    
<div class="container">
	<div class="row">