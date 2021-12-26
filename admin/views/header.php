<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=renderer content=webkit>
    <title>管理中心 - <?= Option::get('blogname') ?></title>
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
    <script src="./views/js/js.cookie-2.2.1.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="./views/js/cropper.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="./views/js/common.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
	<?php doAction('adm_head') ?>
</head>
<body>
<div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion sd-hidden" id="accordionSidebar">
        <li class="nav-item active emlog_title" id="menu_home">
            <a class="nav-link" href="./">EMLOG PRO <?php if (!Register::isRegLocal()) : ?>未注册<?php endif ?></a>
        </li>
        <hr class="sidebar-divider my-0">
		<?php if (ROLE == ROLE_ADMIN): ?>
            <li class="nav-item" id="menu_home">
                <a class="nav-link" href="./"><i class="icofont-dashboard icofont-1x"></i><span>管理后台</span></a>
            </li>
		<?php endif ?>
        <hr class="sidebar-divider my-0">
        <li class="nav-item" id="menu_category_content">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu_content" aria-expanded="true" aria-controls="menu_content">
                <i class="icofont-pencil-alt-5"></i><span>文章</span>
            </a>
            <div id="menu_content" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" id="menu_write" href="article.php?action=write">写文章</a>
                    <a class="collapse-item" id="menu_log" href="article.php">文章</a>
                    <a class="collapse-item" id="menu_draft" href="article.php?draft=1">草稿</a>
					<?php if (ROLE == ROLE_ADMIN): ?>
                        <a class="collapse-item" id="menu_sort" href="sort.php">分类</a>
                        <a class="collapse-item" id="menu_tag" href="tag.php">标签</a>
					<?php endif ?>
                </div>
            </div>
        </li>
        <li class="nav-item" id="menu_cm">
            <a class="nav-link" href="comment.php"><i class="icofont-comment"></i><span>评论</span></a>
        </li>
        <li class="nav-item" id="menu_twitter">
            <a class="nav-link" href="twitter.php"><i class="icofont-penalty-card"></i><span>笔记</span></a>
        </li>
        <li class="nav-item" id="menu_media">
            <a class="nav-link" href="media.php"><i class="icofont-image"></i><span>资源</span></a>
        </li>
		<?php if (ROLE == ROLE_ADMIN): ?>
            <li class="nav-item" id="menu_page">
                <a class="nav-link" href="page.php"><i class="icofont-page"></i><span>页面</span></a>
            </li>
            <li class="nav-item" id="menu_category_view">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu_view" aria-expanded="true" aria-controls="menu_view">
                    <i class="icofont-paint"></i><span>外观</span>
                </a>
                <div id="menu_view" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" id="menu_tpl" href="template.php">模板</a>
                        <a class="collapse-item" id="menu_navi" href="navbar.php">导航</a>
                        <a class="collapse-item" id="menu_widget" href="widgets.php">边栏</a>
                        <a class="collapse-item" id="menu_link" href="link.php">链接</a>
                    </div>
                </div>
            </li>
            <li class="nav-item" id="menu_category_ext">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu_ext" aria-expanded="true" aria-controls="menu_ext">
                    <i class="icofont-plugin"></i><span>扩展</span>
                </a>
                <div id="menu_ext" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" id="menu_plug" href="plugin.php">插件</a>
						<?php doAction('adm_menu_ext') ?>
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <li class="nav-item" id="menu_store">
                <a class="nav-link" href="store.php"><i class="icofont-shopping-cart"></i><span>商店</span></a>
            </li>
            <li class="nav-item" id="menu_category_sys">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu_sys" aria-expanded="true" aria-controls="menu_sys">
                    <i class="icofont-options"></i><span>系统</span>
                </a>
                <div id="menu_sys" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" id="menu_user" href="user.php">用户</a>
                        <a class="collapse-item" id="menu_data" href="data.php">数据</a>
                        <a class="collapse-item" id="menu_setting" href="configure.php">设置</a>
                    </div>
                </div>
            </li>
		<?php endif ?>
        <hr class="sidebar-divider d-none d-md-block">
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <button id="sidebarToggleTop" class="btn d-md-none rounded-circle mr-3">
                    <i class="icofont-navigation-menu"></i>
                </button>
                <form action="article.php" method="get" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control bg-light border-0 small" placeholder="查找文章..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-success" type="submit">
                                <i class="icofont-search-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link" href=".." target="_blank" role="button">
							<?php
							$blog_name = Option::get('blogname');
							echo empty($blog_name) ? '查看我的站点' : subString($blog_name, 0, 12);
							?>
                        </a>
                    </li>
                    <div class="topbar-divider d-none d-sm-block"></div>
                    <li class="nav-item mx-1">
                        <a class="nav-link" href="blogger.php" role="button">
                            <img class="img-profile rounded-circle"
                                 src="<?= empty($user_cache[UID]['avatar']) ? './views/images/avatar.svg' : '../' . $user_cache[UID]['avatar'] ?>">
                        </a>
                    </li>
                    <div class="topbar-divider d-none d-sm-block"></div>
                    <li class="nav-item mx-1">
                        <a class="nav-link" href="?action=logout" title="退出" role="button">
                            <i class="icofont-logout icofont-1x"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="container-fluid">
