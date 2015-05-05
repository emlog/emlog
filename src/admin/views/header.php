<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<!DOCTYPE html>
<html dir="<?= EMLOG_LANGUAGE_DIR ?>" lang="<?=EMLOG_LANGUAGE?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
<!--vot--><title><?=lang('admin_center')?> - <?php echo Option::get('blogname'); ?></title>
    <link href="./views/css/cssreset-min.css" rel="stylesheet">
    <link href="./views/css/bootstrap.min.css" rel="stylesheet">
    <link href="./views/css/font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="./views/css/css-main.css?v=<?php echo Option::EMLOG_VERSION; ?>" type=text/css rel=stylesheet>
    <link href="./views/css/adminlte.min.css?v=<?php echo Option::EMLOG_VERSION; ?>" type=text/css rel=stylesheet>
    <link href="./views/css/skin-green.css?v=<?php echo Option::EMLOG_VERSION; ?>" type=text/css rel=stylesheet>
    <script src="../include/lib/js/jquery/jquery-1.11.0.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
    <script src="../include/lib/js/jquery/plugin-cookie.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
    <script src="./views/js/bootstrap.min.js"></script>
    <script src="./views/js/common.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
    <script src="./views/js/app.min.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
</head>
<body class="skin-green">
<div id="wrapper">
    <header class="main-header">
    <a href="./" class="logo"><b>EMLOG</b> v6.0</a>
    <nav class="navbar navbar-static-top" role="navigation">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <li><a href="../" target="_blank"><i class="fa fa-home fa-fw"></i><?=lang('to_site_new_window')?></a></li>
            <li><a href="./?action=logout"><i class="fa fa-power-off fa-fw"></i><?=lang('logout')?></a></li>
        </ul>
      </div>
    </nav>
    </header>

    <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <a href="./blogger.php">
              <img src="<?php echo empty($user_cache[UID]['avatar']) ? './views/images/avatar.jpg' : '../' . $user_cache[UID]['avatar'] ?>" class="img-rounded" alt="User Image">
          </a>
        </div>
        <div class="pull-left info">
            <p><a href="./blogger.php"><?php echo subString($user_cache[UID]['name'], 0, 12) ?></a></p>
            <i class="fa fa-circle text-success"></i> <?php echo ROLE == ROLE_ADMIN ? lang('admin') : lang('user'); ?>
        </div>
      </div>
      <ul class="sidebar-menu">
        <li id="menu_wt"><a href="write_log.php"><i class="fa fa-edit fa-fw"></i> <?=lang('post_write')?></a></li>
        <li id="menu_log"><a href="admin_log.php"><i class="fa fa-list-alt fa-fw"></i> <?=lang('post_manage')?></a></li>
        <?php if (ROLE == ROLE_ADMIN):?>
        <li id="menu_tag"><a href="tag.php"><i class="fa fa-tags fa-fw"></i> <?=lang('tags')?></a></li>
        <li id="menu_sort"><a href="sort.php"><i class="fa fa-flag fa-fw"></i> <?=lang('categories')?></a></li>
        <?php endif;?>
        <li id="menu_cm">
            <a href="comment.php">
                <i class="fa fa-comments fa-fw"></i> <?=lang('comments')?>
                <small class="label pull-right bg-red"><?php $hidecmnum = ROLE == ROLE_ADMIN ? $sta_cache['hidecomnum'] : $sta_cache[UID]['hidecommentnum'];$n = $hidecmnum > 999 ? '...' : $hidecmnum;echo $n;?></small>
            </a>
        </li>
        <?php if (ROLE == ROLE_ADMIN):?>
        <li id="menu_tw"><a href="twitter.php"><i class="fa fa-comment fa-fw"></i> <?=lang('twitters')?></a></li>
        <li id="menu_page"><a href="page.php"><i class="fa fa-file-o fa-fw"></i> <?=lang('pages')?></a></li>
        <li id="menu_link"><a href="link.php"><i class="fa fa-link fa-fw"></i> <?=lang('links')?></a></li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-eye fa-fw"></i> <?=lang('exterior')?><span class="fa arrow"></span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li id="menu_widget"><a href="widgets.php"><i class="fa fa-columns fa-fw"></i> <?=lang('sidebar')?></a></li>
                <li id="menu_navi"><a href="navbar.php"><i class="fa fa-bars fa-fw"></i> <?=lang('navigation')?></a></li>
                <li id="menu_tpl"><a href="template.php"><i class="fa fa-eye fa-fw"></i> <?=lang('templates')?></a></li>
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-cog fa-fw"></i> <?=lang('system')?><span class="fa arrow"></span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li id="menu_setting"><a href="./configure.php"><i class="fa fa-wrench fa-fw"></i><?=lang('settings')?></a></li>
                <li id="menu_user"><a href="user.php"><i class="fa fa-user fa-fw"></i> <?=lang('users')?></a></li>
                <li id="menu_data"><a href="data.php"><i class="fa fa-database fa-fw"></i> <?=lang('data')?></a></li>
                <li id="menu_plug"><a href="plugin.php"><i class="fa fa-plug fa-fw"></i> <?=lang('plugins')?></a></li>
                <li id="menu_store"><a href="store.php"><i class="fa fa-shopping-cart fa-fw"></i> <?=lang('applications')?></a></li>
            </ul>
        </li>
        <?php if (!empty($emHooks['adm_sidebar_ext'])): ?>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-puzzle-piece fa-fw"></i> <?=lang('extensions')?><span class="fa arrow"></span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
               <?php doAction('adm_sidebar_ext'); ?>
            </ul>
        </li>
        <?php endif;?>
        <?php endif;?>
      </ul>
    </section>
    </aside>
    <div class="content-wrapper">
