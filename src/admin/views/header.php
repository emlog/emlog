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
    <link href="./views/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="./views/css/fonts.css" rel="stylesheet">
    <link href="./views/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Bootstrap core JavaScript-->
    <script src="./views/vendor/jquery/jquery.min.js"></script>
    <script src="./views/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./views/js/common.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
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
                <i class="fas fa-fw fa-tachometer-alt"></i>
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