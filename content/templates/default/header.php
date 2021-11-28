<?php
/*
Template Name: Default template
Template Url: https://www.emlog.net/template/
Description: Emlog Pro Default template
Author: emlog official
Author Url:https://www.emlog.net
*/
if (!defined('EMLOG_ROOT')) {
	exit('error!');
}
require_once View::getView('module');
?>
<!doctype html>
<!--vot--><html lang="<?=EMLOG_LANGUAGE?>" dir="<?= EMLOG_LANGUAGE_DIR ?>">
<head>
<!--vot--><meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $site_title; ?></title>
    <meta name="keywords" content="<?php echo $site_key; ?>"/>
    <meta name="description" content="<?php echo $site_description; ?>"/>
    <meta name="generator" content="emlog"/>
    <link rel="shortcut icon" href="<?php echo BLOG_URL; ?>favicon.ico"/>
    <link rel="bookmark" href="<?php echo BLOG_URL; ?>favicon.ico" type="image/x-icon" />
    <link rel="alternate" title="RSS" href="<?php echo BLOG_URL; ?>rss.php" type="application/rss+xml"/>
    <link href="<?php echo TEMPLATE_URL; ?>css/style.css?t=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo TEMPLATE_URL; ?>css/markdown.css?t=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>" rel="stylesheet" type="text/css"/>
    <script src="<?php echo TEMPLATE_URL; ?>js/jquery.min.3.5.1.js?v=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>"></script>
<!--vot--><script>function sendinfo(url) {  // Calendar generation and page turning
            $("#calendar").load(url)
        }</script>
	<?php doAction('index_head'); ?>
<!--vot--><script src="<?= BLOG_URL ?>lang/<?= EMLOG_LANGUAGE ?>/lang_js.js?t=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>"></script>
</head>

<body>
<nav class="blog-header">
    <div class="blog-header-c container">
        <a class="blog-header-title" href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a>
        <div class="blog-header-subtitle"><?php echo $bloginfo; ?></div>
        <div class="blog-header-toggle">
            <svg  class="blogtoggle-icon" >
                <rect x="0.98" y="0.95" fill="#5F5F5F" width="26.05" height="1.66"/>
                <rect x="1.02" y="8.18" fill="#5F5F5F" width="26.05" height="1.66"/>
                <rect x="0.98" y="16.23" fill="#5F5F5F" width="26.05" height="1.66"/>
            </svg>
        </div>

		<?php blog_navi(); ?>
		<?php doAction('index_navi_ext'); ?>

    </div>
</nav>
