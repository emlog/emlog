<?php
/*
Template Name:默认模板
Template Url:https://www.emlog.net/template/
Description:这是emlog pro的默认模板
Author:emlog官方
Author Url:https://www.emlog.net
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
    <title><?= $site_title ?></title>
    <meta name="keywords" content="<?= $site_key ?>"/>
    <meta name="description" content="<?= $site_description ?>"/>
    <base href="<?= BLOG_URL ?>"/>
    <link rel="shortcut icon" href="<?= BLOG_URL ?>favicon.ico"/>
    <link rel="bookmark" href="<?= BLOG_URL ?>favicon.ico" type="image/x-icon" 　/>
    <link rel="alternate" title="RSS" href="<?= BLOG_URL ?>rss.php" type="application/rss+xml"/>
    <link href="<?= TEMPLATE_URL ?>css/style.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= TEMPLATE_URL ?>css/markdown.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>" rel="stylesheet" type="text/css"/>
    <script src="<?= TEMPLATE_URL ?>js/jquery.min.3.5.1.js?v=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script>function sendinfo(url) {  // 日历生成和翻页
            $("#calendar").load(url)
        }</script>
	<?php doAction('index_head') ?>
</head>

<body>
<nav class="blog-header">
    <div class="blog-header-c container">
        <a class="blog-header-title" href="<?= BLOG_URL ?>"><?= $blogname ?></a>
        <div class="blog-header-subtitle"><?= $bloginfo ?></div>
        <div class="blog-header-toggle">
            <svg class="blogtoggle-icon">
                <rect x="1" y="1" fill="#5F5F5F" width="26" height="1.6"/>
                <rect x="1" y="8" fill="#5F5F5F" width="26" height="1.6"/>
                <rect x="1" y="15" fill="#5F5F5F" width="26" height="1.6"/>
            </svg>
        </div>

		<?php blog_navi() ?>
		<?php doAction('index_navi_ext') ?>

    </div>
</nav>
