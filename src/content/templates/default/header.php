<?php
/*
Template Name: Default template
Description: Default template, simple and elegant
Author:emlog
Author Url:http://www.emlog.net
*/
if(!defined('EMLOG_ROOT')) {exit('error!');}
require_once View::getView('module');
?>
<!DOCTYPE html>
<!--vot--><html dir="<?= EMLOG_LANGUAGE_DIR ?>" lang="<?=EMLOG_LANGUAGE?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $site_title; ?></title>
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="description" content="<?php echo $site_description; ?>" />
<meta name="generator" content="emlog" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php" />
<link href="<?php echo TEMPLATE_URL; ?>main.css" rel="stylesheet" type="text/css" />
<link href="<?php echo BLOG_URL; ?>admin/views/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo BLOG_URL; ?>admin/editor/plugins/code/prettify.css" rel="stylesheet" type="text/css" />
<script src="<?php echo BLOG_URL; ?>include/lib/js/jquery/jquery-1.11.0.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
<script src="<?php echo BLOG_URL; ?>admin/editor/plugins/code/prettify.js" type="text/javascript"></script>
<script src="<?php echo BLOG_URL; ?>include/lib/js/common_tpl.js" type="text/javascript"></script>
<script src="<?php echo BLOG_URL; ?>admin/views/js/bootstrap.min.js" type="text/javascript"></script>
<!--vot--><script src="<?= BLOG_URL ?>lang/<?= EMLOG_LANGUAGE ?>/lang_js.js"></script>
<?php doAction('index_head'); ?>
</head>
<body>
<!--Navigation-->
<?php blog_navi();?>
<?
//DEBUG
//<div id="debug">
//echo '<pre>';
//echo 'LANGLIST=';
//print_r($GLOBALS['LANGLIST']);
//echo '</pre>';
//</div>
?>
<header class="sb-page-header">
	<div class="container">
		<h1><?php echo $blogname; ?></h1>
		<p><?php echo $bloginfo; ?></p>
	</div>
</header>
    
<div class="container">
	<div class="row">