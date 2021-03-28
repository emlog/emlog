<?php
/*
Template Name:默认模板
Description:emlog官方维护的自带默认模板
Author:emlog
Author Url:http://www.emlog.net
*/
if (!defined('EMLOG_ROOT')) {
    exit('error!');
}
require_once View::getView('module');
?>
<!DOCTYPE html>
<html lang="zh">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $site_title; ?></title>
    <meta name="keywords" content="<?php echo $site_key; ?>"/>
    <meta name="description" content="<?php echo $site_description; ?>"/>
    <meta name="generator" content="emlog"/>
	
    <link href="<?php echo TEMPLATE_URL; ?>css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo TEMPLATE_URL; ?>css/main.css" rel="stylesheet" type="text/css"/>
	<link rel="alternate" title="RSS" href="<?php echo BLOG_URL; ?>rss.php" type="application/rss+xml" />
	<?php doAction('index_head'); ?>
</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light mb-5">
    <div class="container">
        <a class="navbar-brand" id='main_blogname' href="./" ><?php echo $blogname; ?></a>
		<span id = 'sub_blogname'><?php echo $bloginfo; ?></span>
		
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
		
        <?php blog_navi(); ?>
    </div>
</nav>

