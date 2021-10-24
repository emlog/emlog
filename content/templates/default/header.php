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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $site_title; ?></title>
    <meta name="keywords" content="<?php echo $site_key; ?>"/>
    <meta name="description" content="<?php echo $site_description; ?>"/>
    <link rel="shortcut icon" href="/favicon.ico"/>
    <link rel="bookmark" href="/favicon.ico" type="image/x-icon" 　/>
    <link rel="alternate" title="RSS" href="<?php echo BLOG_URL; ?>rss.php" type="application/rss+xml"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_URL; ?>css/bootstrap.min.css?t=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_URL; ?>css/main.css?t=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_URL; ?>css/markdown.css?t=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>">
    <script src="<?php echo TEMPLATE_URL; ?>js/common_tpl.js?t=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>"></script>
    <script src="<?php echo TEMPLATE_URL; ?>js/jquery.min.3.5.1.js?v=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>"></script>
    <script src="<?php echo TEMPLATE_URL; ?>js/bootstrap.bundle.min.js?t=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>"></script>
	<?php doAction('index_head'); ?>
<!--vot--><script src="<?= BLOG_URL ?>lang/<?= EMLOG_LANGUAGE ?>/lang_js.js?t=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light mb-3">
    <div class="container mt-2 mb-2">
        <div class="navbar-brand">
            <a class="main_blogname" href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a>
            <div class="main_bloginfo text-muted mt-2"><?php echo $bloginfo; ?></div>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation" style="outline: none;">
            <span class="navbar-toggler-icon"></span>
        </button>
		<?php blog_navi(); ?>
		<?php doAction('index_navi_ext'); ?>
    </div>
</nav>

