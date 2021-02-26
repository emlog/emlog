<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<!doctype html>
<!--vot--><html lang="<?=EMLOG_LANGUAGE?>" dir="<?= EMLOG_LANGUAGE_DIR ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--vot--><title><?=lang('admin_center')?> - <?php echo Option::get('blogname'); ?></title>
    <!-- CSS -->
    <link href="./views/css/sb-admin-2.css" rel="stylesheet">
    <link href="./views/css/css-main.css" type=text/css rel=stylesheet>
    <link href="./views/css/fontawesome-free/css/fontawesome.min.css" rel="stylesheet">
    <link href="./views/css/fontawesome-free/css/brands.min.css" rel="stylesheet">
    <link href="./views/css/fontawesome-free/css/solid.min.css" rel="stylesheet">
    <!-- JS -->
    <script src="./views/js/jquery.min.3.5.1.js"></script>
    <script src="./views/js/bootstrap.bundle.min.4.6.js"></script>
    <!--    <script src="./views/js/jquery.easing.min.js"></script>-->
    <script src="./views/js/common.js"></script>
<!--vot--><script>/*vot*/	var em_lang = '<?= EMLOG_LANGUAGE ?>';</script>
    <?php doAction('adm_head'); ?>
</head>
<!--vot--><body>
<div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="./">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">emlog <sup><?php echo Option::EMLOG_VERSION ?></sup></div>
        </a>

        <hr class="sidebar-divider my-0">

        <li class="nav-item" id="menu_home">
<!--vot-->  <a class="nav-link" href="./"><i class="fas fa-fw fa-tachometer-alt"></i><span><?= lang('post_write') ?></span></a>
        </li>

        <hr class="sidebar-divider my-0">

        <li class="nav-item" id="menu_log">
<!--vot-->  <a class="nav-link" href="admin_log.php"><i class="fas fa-table"></i><span><?= lang('posts') ?></span></a>
        </li>

        <li class="nav-item" id="menu_page">
<!--vot-->  <a class="nav-link" href="page.php"><i class="fas fa-file"></i><span><?= lang('pages') ?></span></a>
        </li>

        <li class="nav-item" id="menu_cm">
<!--vot-->  <a class="nav-link" href="comment.php"><i class="fas fa-comment"></i><span><?= lang('comments') ?></span></a>
        </li>

        <li class="nav-item" id="menu_tag">
<!--vot-->  <a class="nav-link" href="tag.php"><i class="fas fa-tags"></i><span><?= lang('tags') ?></span></a>
        </li>

        <li class="nav-item" id="menu_sort">
<!--vot-->  <a class="nav-link" href="sort.php"><i class="fas fa-table"></i><span><?= lang('category') ?></span></a>
        </li>

        <li class="nav-item" id="menu_link">
<!--vot-->  <a class="nav-link" href="./link.php"><i class="fas fa-link"></i><span><?= lang('friend_links') ?></span></a>
        </li>

        <hr class="sidebar-divider d-none d-md-block">

        <li class="nav-item" id="menu_category_view">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu_view" aria-expanded="true" aria-controls="menu_view">
                <i class="fas fa-palette"></i>
<!--vot-->      <span><?= lang('exterior') ?></span>
            </a>
            <div id="menu_view" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
<!--vot-->          <a class="collapse-item" id="menu_tpl" href="template.php"><?= lang('templates') ?></a>
<!--vot-->          <a class="collapse-item" id="menu_navi" href="navbar.php"><?= lang('navigation') ?></a>
<!--vot-->          <a class="collapse-item" id="menu_widget" href="widgets.php"><?= lang('sidebar') ?></a>
                </div>
            </div>
        </li>

        <li class="nav-item" id="menu_category_sys">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu_sys" aria-expanded="true" aria-controls="menu_sys">
                <i class="fas fa-fw fa-cog"></i>
                <span>系统</span>
            </a>
            <div id="menu_sys" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
<!--vot-->          <a class="collapse-item" href="configure.php"><?= lang('settings') ?></a>
<!--vot-->          <a class="collapse-item" href="user.php"><?= lang('users') ?></a>
<!--vot-->          <a class="collapse-item" href="data.php"><?= lang('data') ?></a>
<!--vot-->          <a class="collapse-item" href="plugin.php"><?= lang('plugins') ?></a>
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
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>
                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
<!--vot-->              <input type="text" class="form-control bg-light border-0 small" placeholder="<?=lang('search_for')?>" aria-label="<?=lang('search')?>" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow mx-1">
<!--vot-->          <a class="nav-link" href="../" target="_blank" title="<?= lang('to_site_new_window') ?>" role="button" >
                            <?php
                            $blog_name = Option::get('blogname');
<!--vot-->                  echo empty($blog_name) ? lang('to_site') : subString($blog_name, 0, 12);
                            ?>
                        </a>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<!--vot-->                  <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= lang('user_info') ?></span>
                            <img class="img-profile rounded-circle" src="<?php echo empty($user_cache[UID]['avatar']) ? './views/images/avatar.svg' : '../' . $user_cache[UID]['avatar'] ?>">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="blogger.php">
<!--vot-->                      <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i><?= lang('personal_settings') ?>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="?action=logout">
<!--vot-->                      <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i><?= lang('logout') ?>
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>