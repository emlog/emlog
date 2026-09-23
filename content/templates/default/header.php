<?php
/*
Template Name: 默认模板
Version: 1.2.7
Template Url: https://www.emlog.net/template
Description: 系统默认模板
Author: emlog
Author Url: https://www.emlog.net/profiles/cf75dc06
*/

defined('EMLOG_ROOT') || exit('access denied!');
require_once View::getView('module');
$v = '1.2.7';
if (!function_exists('_g')) {
    emMsg(_langTpl('template_plugin_tip'));
}

?>
<!doctype html>
<html lang="<?= _currentHtmlLang() ?>" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $site_title ?></title>
    <meta name="keywords" content="<?= $site_key ?>" />
    <meta name="description" content="<?= $site_description ?>" />
    <?php
    $favicon = Option::get('favicon') ? Option::get('favicon') : (function_exists('_g') ? _g('favicon') : '');
    if (!empty($favicon)): ?>
        <link href="<?= $favicon ?>" rel="icon">
    <?php endif; ?>
    <link rel="alternate" title="RSS" href="<?= BLOG_URL ?>rss.php" type="application/rss+xml" />
    <link href="<?= TEMPLATE_URL ?>css/style.css?v=<?= $v ?>&t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>" rel="stylesheet" />
    <link href="<?= TEMPLATE_URL ?>css/icon/iconfont.css?v=<?= $v ?>&t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>" rel="stylesheet" />
    <link href="<?= TEMPLATE_URL ?>css/markdown.css?v=<?= $v ?>&t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>" rel="stylesheet" />
    <script src="<?= TEMPLATE_URL ?>js/jquery.min.3.5.1.js?v=<?= $v ?>&t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="<?= TEMPLATE_URL ?>js/common_tpl.js?v=<?= $v ?>&t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="<?= TEMPLATE_URL ?>js/zoom.js?v=<?= $v ?>&t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <?php doAction('index_head') ?>
    <script>
        // 日历生成和翻页
        function sendinfo(url) {
            $("#calendar").load(url)
        }

        // 切换夜间模式主题
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            document.documentElement.setAttribute('data-theme', savedTheme);
        }
    </script>
    <script>
        window.emAuthConfig = {
            accountBase: "<?= BLOG_URL ?>admin/account.php",
            adminPathCode: "<?= defined('ADMIN_PATH_CODE') ? rawurlencode((string)constant('ADMIN_PATH_CODE')) : '' ?>",
            loginCode: <?= Option::get('login_code') === 'y' ? 'true' : 'false' ?>,
            emailCode: <?= Option::get('email_code') === 'y' ? 'true' : 'false' ?>,
            canSignup: <?= Option::get('is_signup') === 'y' ? 'true' : 'false' ?>
        };
    </script>
</head>

<body>
    <nav class="blog-header">
        <div class="blog-header-c container">
            <?php if (_em('logotype') == 1): ?>
                <a class="blog-header-title" href="<?= BLOG_URL ?>"><?= $blogname ?></a>
                <div class="blog-header-subtitle subtitle-overflow" title="<?= $bloginfo ?>"><?= $bloginfo ?></div>
            <?php elseif (_em('logotype') == 2): ?>
                <a class="blog-header-brand" href="<?= BLOG_URL ?>" title="<?= $blogname ?><?= !empty($bloginfo) ? ' - ' . $bloginfo : '' ?>">
                    <img class="blog-header-logo" src="<?= _em('logoimg') ?>" alt="<?= $blogname ?>">
                    <div class="blog-header-brand-text">
                        <span class="blog-header-brand-name"><?= $blogname ?></span>
                        <?php if (!empty($bloginfo)): ?>
                            <span class="blog-header-brand-desc" title="<?= $bloginfo ?>"><?= $bloginfo ?></span>
                        <?php endif; ?>
                    </div>
                </a>
            <?php else: ?>
                <a class="blog-header-imglink" href="<?= BLOG_URL ?>" title="<?= $bloginfo ?>"><img class="blog-header-img" src="<?= _em('logoimg') ?>" alt="<?= $blogname ?>" /></a>
            <?php endif; ?>
            <div class="blog-header-toggle">
                <svg class="blogtoggle-icon">
                    <rect x="1" y="1" fill="#5F5F5F" width="26" height="1.6" />
                    <rect x="1" y="8" fill="#5F5F5F" width="26" height="1.6" />
                    <rect x="1" y="15" fill="#5F5F5F" width="26" height="1.6" />
                </svg>
            </div>
            <?php blog_navi() ?>
            <?php doAction('index_navi_ext') ?>
        </div>
    </nav>