<?php
/*
Template Name:旧的模板待删除
Description:emlog官方维护的自带默认模板
Author:emlog
Author Url:http://www.emlog.net
*/
if (!defined('EMLOG_ROOT')) {
    exit('error!');
}
require_once View::getView('module');
?>
<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $site_title; ?></title>
    <meta name="keywords" content="<?php echo $site_key; ?>"/>
    <meta name="description" content="<?php echo $site_description; ?>"/>
    <meta name="generator" content="emlog"/>
    <link rel="alternate" type="application/rss+xml" title="RSS" href="<?php echo BLOG_URL; ?>rss.php"/>
    <link href="<?php echo TEMPLATE_URL; ?>css/main.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo TEMPLATE_URL; ?>css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo TEMPLATE_URL; ?>js/jquery.min.3.5.1.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
    <script src="<?php echo TEMPLATE_URL; ?>js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo TEMPLATE_URL; ?>js/common_tpl.js" type="text/javascript"></script>
    <?php doAction('index_head'); ?>
</head>
<body>
<!--导航-->
<?php blog_navi(); ?>

<header class="sb-page-header">
    <div class="container">
        <h1><?php echo $blogname; ?></h1>
        <p><?php echo $bloginfo; ?></p>
    </div>
</header>

<div class="container">
    <div class="row">