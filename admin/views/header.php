<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name=renderer  content=webkit>
    <title>管理中心 - <?php echo Option::get('blogname'); ?></title>
    <link rel="stylesheet" href="./views/css/style.css" />
    <link rel="stylesheet" href="./editor.md/css/editormd.css" />
    <link href="./views/css/bootstrap-sbadmin-4.5.3.css" rel="stylesheet">
    <link href="./views/css/css-main.css" type=text/css rel=stylesheet>
    <link href="./views/css/icofont/icofont.min.css" type=text/css rel=stylesheet>
    <link href="./views/css/dropzone.css" type=text/css rel=stylesheet>
    <script src="./views/js/jquery.min.3.5.1.js"></script>
    <script src="./views/js/bootstrap.bundle.min.4.6.js"></script>
    <script src="./views/js/jquery-ui.min.js"></script>
    <script src="./views/js/js.cookie-2.2.1.min.js"></script>
    <script src="./views/js/common.js"></script>
	<?php doAction('adm_head'); ?>
</head>
<div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center" href="./">
            <div class="sidebar-brand-text mx-3">EMLOG Pro <?php if (ISREG === false) : ?>未注册<?php endif;?></div>
        </a>
        <hr class="sidebar-divider my-0">
        <li class="nav-item" id="menu_home">
            <a class="nav-link" href="./"><i class="icofont-dashboard icofont-1x"></i><span>管理后台</span></a>
        </li>
        <hr class="sidebar-divider my-0">
        <li class="nav-item" id="menu_category_content">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu_content" aria-expanded="true" aria-controls="menu_content">
                <i class="icofont-pencil-alt-5"></i><span>文章</span>
            </a>
            <div id="menu_content" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" id="menu_write" href="article.php?action=write">写文章</a>
                    <a class="collapse-item" id="menu_log" href="article.php">文章</a>
                    <a class="collapse-item" id="menu_sort" href="sort.php">分类</a>
                    <a class="collapse-item" id="menu_tag" href="tag.php">标签</a>
                </div>
            </div>
        </li>
        <li class="nav-item" id="menu_page">
            <a class="nav-link" href="page.php"><i class="icofont-page"></i><span>页面</span></a>
        </li>
        <li class="nav-item" id="menu_media">
            <a class="nav-link" href="media.php"><i class="icofont-image"></i><span>资源</span></a>
        </li>
        <li class="nav-item" id="menu_cm">
            <a class="nav-link" href="comment.php"><i class="icofont-comment"></i><span>评论</span></a>
        </li>
        <li class="nav-item" id="menu_link">
            <a class="nav-link" href="./link.php"><i class="icofont-link"></i><span>链接</span></a>
        </li>
        <li class="nav-item" id="menu_store">
            <a class="nav-link" href="store.php"><i class="icofont-shopping-cart"></i><span>商店</span></a>
        </li>
        <hr class="sidebar-divider d-none d-md-block">
        <li class="nav-item" id="menu_category_view">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu_view" aria-expanded="true" aria-controls="menu_view">
                <i class="icofont-paint"></i>
                <span>外观</span>
            </a>
            <div id="menu_view" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" id="menu_tpl" href="template.php">模板</a>
                    <a class="collapse-item" id="menu_navi" href="navbar.php">导航</a>
                    <a class="collapse-item" id="menu_widget" href="widgets.php">侧边栏</a>
                </div>
            </div>
        </li>
        <li class="nav-item" id="menu_category_sys">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu_sys" aria-expanded="true" aria-controls="menu_sys">
                <i class="icofont-options"></i>
                <span>系统</span>
            </a>
            <div id="menu_sys" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" id="menu_setting" href="configure.php">设置</a>
                    <a class="collapse-item" id="menu_user" href="user.php">用户</a>
                    <a class="collapse-item" id="menu_data" href="data.php">数据</a>
                    <a class="collapse-item" id="menu_plug" href="plugin.php">插件</a>
                </div>
            </div>
        </li>
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
                            <button class="btn btn-success" type="submit">
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
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $user_cache[UID]['name'] ?></span>
                            <img class="img-profile rounded-circle"
                                 src="<?php echo empty($user_cache[UID]['avatar']) ? './views/images/avatar.svg' : '../' . $user_cache[UID]['avatar'] ?>">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="blogger.php">
                                <i class="icofont-user icofont-1x"></i> 个人设置
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="?action=logout">
                                <i class="icofont-logout icofont-1x"></i> 退出
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="container-fluid">
