<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<!doctype html>
<html lang="<?= _currentHtmlLang() ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=renderer content=webkit>
    <title><?= _lang('admin_center') ?> - <?= Option::get('blogname') ?></title>
    <link rel="shortcut icon" href="./views/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="./views/css/style.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>">
    <link rel="stylesheet" type="text/css" href="./editor.md/css/editormd.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>">
    <link rel="stylesheet" type="text/css" href="./views/css/bootstrap-sbadmin-4.5.3.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>">
    <link rel="stylesheet" type="text/css" href="./views/css/css-main.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>">
    <link rel="stylesheet" type="text/css" href="./views/css/icofont/icofont.min.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>">
    <link rel="stylesheet" type="text/css" href="./views/css/dropzone.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>">
    <link rel="stylesheet" type="text/css" href="./views/css/cropper.min.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>">
    <script src="./views/js/jquery.min.3.5.1.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="./views/js/bootstrap.bundle.min.4.6.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="./views/js/jquery-ui.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="./views/js/jquery.ui.touch-punch.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="./views/js/jquery.ui.timepicker-addon.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="./views/js/js.cookie-2.2.1.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="./views/js/cropper.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script>
        var _langJS = <?= json_encode(EmLang::getInstance()->getJsLang()); ?>;
    </script>
    <script src="./views/js/common.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="./views/components/layer/layer.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="./views/components/message.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <?php doAction('adm_head') ?>
</head>

<body id="page-top">
    <div id="editor-md-dialog"></div>
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion sd-hidden rounded-em-lg m-1" id="accordionSidebar">
            <li class="nav-item active emlog_title" id="menu_home">
                <a class="nav-link" href="./"><?= subString(Option::get('panel_menu_title'), 0, 11) ?: 'EMLOG PRO' ?></a>
            </li>
            <hr class="sidebar-divider my-0">
            <li class="nav-item" id="menu_panel">
                <a class="nav-link" href="./"><i class="icofont-dashboard icofont-1x"></i><span><?= _lang('dashboard') ?></span></a>
            </li>
            <hr class="sidebar-divider my-0">
            <li class="nav-item" id="menu_category_content">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu_content" aria-expanded="true" aria-controls="menu_content">
                    <i class="icofont-pencil-alt-5"></i><span><?= _lang('article') ?></span>
                </a>
                <div id="menu_content" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="z-index: 1055;">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" id="menu_write" href="article.php?action=write"><?= _lang('write_article') ?></a>
                        <a class="collapse-item" id="menu_log" href="article.php"><?= _lang('article') ?></a>
                        <a class="collapse-item" id="menu_draft" href="article.php?draft=1"><?= _lang('draft') ?></a>
                        <?php if (User::isAdmin()): ?>
                            <a class="collapse-item" id="menu_sort" href="sort.php"><?= _lang('category') ?></a>
                            <a class="collapse-item" id="menu_tag" href="tag.php"><?= _lang('tag') ?></a>
                        <?php endif ?>
                    </div>
                </div>
            </li>
            <li class="nav-item" id="menu_cm">
                <a class="nav-link" href="comment.php"><i class="icofont-comment"></i><span><?= _lang('comment') ?></span></a>
            </li>
            <li class="nav-item" id="menu_twitter">
                <a class="nav-link" href="twitter.php"><i class="icofont-penalty-card"></i><span><?= _lang('twitter') ?></span></a>
            </li>
            <li class="nav-item" id="menu_media">
                <a class="nav-link" href="media.php"><i class="icofont-image"></i><span><?= _lang('media') ?></span></a>
            </li>
            <?php if (User::isAdmin()): ?>
                <li class="nav-item" id="menu_user">
                    <a class="nav-link" href="user.php"><i class="icofont-user"></i><span><?= _lang('user') ?></span></a>
                </li>
                <li class="nav-item" id="menu_category_view">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu_view" aria-expanded="true" aria-controls="menu_view">
                        <i class="icofont-paint"></i><span><?= _lang('appearance') ?></span>
                    </a>
                    <div id="menu_view" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="z-index: 1055;">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <div class="d-flex align-items-center justify-content-between">
                                <a class="collapse-item flex-grow-1 mr-0" id="menu_tpl" href="template.php"><?= _lang('template') ?></a>
                                <a class="collapse-item text-secondary ml-0" id="menu_tpl_setting" href="template.php?setting=1" title="<?= _lang('template_setting') ?>"><i class="icofont-options"></i></a>
                            </div>
                            <a class="collapse-item" id="menu_navi" href="navbar.php"><?= _lang('navbar') ?></a>
                            <a class="collapse-item" id="menu_widget" href="widgets.php"><?= _lang('widget') ?></a>
                            <a class="collapse-item" id="menu_page" href="page.php"><?= _lang('page') ?></a>
                            <a class="collapse-item" id="menu_link" href="link.php"><?= _lang('link') ?></a>
                        </div>
                    </div>
                </li>
                <li class="nav-item" id="menu_category_ext">
                    <a class="nav-link" href="plugin.php"><i class="icofont-plugin"></i><span><?= _lang('plugin') ?></span></a>
                </li>
                <li class="nav-item" id="menu_category_sys">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu_sys" aria-expanded="true" aria-controls="menu_sys">
                        <i class="icofont-options"></i><span><?= _lang('system') ?></span>
                    </a>
                    <div id="menu_sys" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" id="menu_data" href="data.php"><?= _lang('data') ?></a>
                            <a class="collapse-item" id="menu_setting" href="setting.php"><?= _lang('setting') ?></a>
                        </div>
                    </div>
                </li>
                <li class="nav-item" id="menu_store">
                    <a class="nav-link" href="store.php"><i class="icofont-shopping-cart"></i><span><?= _lang('store') ?></span></a>
                </li>
                <hr class="sidebar-divider d-none d-md-block">
                <?php doAction('adm_menu') ?>
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>
                <?php if (!Register::isRegLocal()) : ?>
                    <div class="sidebar-card">
                        <p class="text-center mb-2"><strong>EMLOG</strong> - <?= ucfirst(Option::EMLOG_VERSION) ?></p>
                        <a class="btn btn-danger btn-sm" href="https://www.emlog.net/register" target="_blank"><?= _lang('upgrade_license') ?></a>
                    </div>
                <?php endif ?>
            <?php endif ?>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid" id="main-container">
                    <nav class="navbar navbar-expand navbar-light topbar mb-4 mt-1 static-top shadow d-flex justify-content-between rounded-em-lg">
                        <button id="sidebarToggleTop" class="btn d-md-none rounded-circle mr-3">
                            <i class="icofont-navigation-menu"></i>
                        </button>
                        <!-- shortcut bar -->
                        <div id="shortcut-bar-container" class="position-relative d-none d-md-inline-block">
                            <div id="shortcut-bar-toggle" class="d-inline-block px-2" style="cursor:pointer;">
                                <i class="icofont-simple-right text-gray-400"></i>
                            </div>
                            <div id="shortcut-bar-content" class="d-inline-block position-absolute overflow-hidden text-nowrap"
                                style="left:30px; top:0; width:0; transition:width 0.3s;">
                                <a href="#" class="my-1" data-toggle="modal" data-target="#shortcutModal"><i class="icofont-plus"></i></a>
                                <span class="text-gray-300 mr-2">|</span>
                                <a href="./article.php?action=write" class="mr-2"><?= _lang('write_article') ?></a>
                                <a href="article.php" class="mr-2"><?= _lang('article') ?></a>
                                <a href="article.php?draft=1" class="mr-2"><?= _lang('draft') ?></a>
                                <?php foreach ($shortcuts as $item): ?>
                                    <a href="<?= $item['url'] ?>" class="mr-2"><?= $item['name'] ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <!-- Topbar Navbar -->
                        <div>
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item dropdown no-arrow mx-1">
                                    <a class="nav-link" href=".." target="_blank" role="button">
                                        <?php
                                        $blog_name = Option::get('blogname');
                                        echo empty($blog_name) ? _lang('view_site') : subString($blog_name, 0, 12);
                                        ?>
                                    </a>
                                </li>
                                <li class="topbar-divider d-none d-sm-block"></li>
                                <li class="nav-item mx-1">
                                    <a class="nav-link" href="blogger.php" role="button">
                                        <img class="img-profile rounded-circle"
                                            src="<?= User::getAvatar($user_cache[UID]['avatar']) ?>">
                                    </a>
                                </li>
                                <li class="topbar-divider d-none d-sm-block"></li>
                                <li class="nav-item mx-1">
                                    <a class="nav-link" href="account.php?action=logout" title="<?= _lang('logout') ?>" role="button">
                                        <i class="icofont-logout icofont-1x"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>