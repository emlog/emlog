<?php
/*
Template Name: Default template
Template Url: https://www.emlog.net/template/
Description: Emlog Pro Default template
Author:emlog
Author Url:http://www.emlog.net
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
    <meta name="generator" content="emlog"/>
    <link rel="alternate" title="RSS" href="<?php echo BLOG_URL; ?>rss.php" type="application/rss+xml"/>
    <link href="<?php echo TEMPLATE_URL; ?>css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo TEMPLATE_URL; ?>css/main.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo TEMPLATE_URL; ?>css/markdown.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo TEMPLATE_URL; ?>js/common_tpl.js" type="text/javascript"></script>
    <script src="<?php echo TEMPLATE_URL; ?>js/jquery.min.3.5.1.js?v=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>"></script>
    <script src="<?php echo TEMPLATE_URL; ?>js/bootstrap.min.js" type="text/javascript"></script>
	<?php doAction('index_head'); ?>
<!--vot--><script src="<?= BLOG_URL ?>lang/<?= EMLOG_LANGUAGE ?>/lang_js.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light mb-3">
    <div class="container">
        <a class="navbar-brand main_blogname" title="<?php echo $bloginfo; ?>" href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation" style="outline: none;">
            <span class="navbar-toggler-icon"></span>
        </button>
		<?php blog_navi(); ?>
		<?php doAction('index_navi_ext'); ?>
    </div>
</nav>

