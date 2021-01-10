<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>管理中心 - <?php echo Option::get('blogname'); ?></title>
    <link href="./views/<?php echo ADMIN_TEMPLATE; ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="./views/<?php echo ADMIN_TEMPLATE; ?>/css/fonts.css" rel="stylesheet">
    <link href="./views/<?php echo ADMIN_TEMPLATE; ?>/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Bootstrap core JavaScript-->
    <script src="./views/<?php echo ADMIN_TEMPLATE; ?>/vendor/jquery/jquery.min.js"></script>
    <script src="./views/<?php echo ADMIN_TEMPLATE; ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./views/<?php echo ADMIN_TEMPLATE; ?>/js/common.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
    <?php doAction('adm_head'); ?>
</head>

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="./">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">emlog <sup>pro</sup></div>
        </a>

        <hr class="sidebar-divider my-0">

        <li class="nav-item active">
            <a class="nav-link" href="./write_log.php">
                <i class="far fa-edit"></i>
                <span>写文章</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="./admin_log.php">
                <i class="fas fa-fw fa-table"></i>
                <span>文章</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="./page.php">
                <i class="fas fa-fw fa-table"></i>
                <span>页面</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="comment.php">
                <i class="fas fa-fw fa-table"></i>
                <span>评论</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="tag.php">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>标签</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="./sort.php">
                <i class="fas fa-fw fa-table"></i>
                <span>分类</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="./link.php">
                <i class="fas fa-fw fa-table"></i>
                <span>链接</span></a>
        </li>

        <hr class="sidebar-divider d-none d-md-block">

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-wrench"></i>
                <span>外观</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="./template.php">模板</a>
                    <a class="collapse-item" href="./navbar.php">导航</a>
                    <a class="collapse-item" href="./widgets.php">侧边栏</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-cog"></i>
                <span>系统</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="./configure.php">设置</a>
                    <a class="collapse-item" href="./user.php">用户</a>
                    <a class="collapse-item" href="./data.php">数据</a>
                    <a class="collapse-item" href="./plugin.php">插件</a>
                </div>
            </div>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">


                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link" href="../" target="_blank" title="在新窗口浏站点" role="button" >
                        <?php
                        $blog_name = Option::get('blogname');
                        echo empty($blog_name) ? '查看我的站点' : subString($blog_name, 0, 12);
                        ?>
                    </a>
                </li>

                <div class="topbar-divider d-none d-sm-block"></div>
                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">大伟</span>
                        <img class="img-profile rounded-circle" src="<?php echo empty($user_cache[UID]['avatar']) ? './views/default/images/avatar.svg' : '../' . $user_cache[UID]['avatar'] ?>">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="./configure.php">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>个人设置
                        </a>
                        <a class="dropdown-item" href="./configure.php">
                            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>系统设置
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="./?action=logout" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>退出
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- End of Topbar -->