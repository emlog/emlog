<?php if (!defined('EMLOG_ROOT')) {exit('error!');}?>
<!DOCTYPE html>
<html>
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
        <script src="../include/lib/js/jquery/jquery-1.11.0.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
        <script src="../include/lib/js/jquery/plugin-cookie.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
        <script src="./views/js/bootstrap.min.js"></script>
        <script src="./views/js/common.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
    </head>
    <body>
        <div id="wrapper">
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
<!--vot-->          <a class="navbar-brand" href="../" target="_blank" title="<?=lang('to_site_new_window')?>">
                        <?php
                        $blog_name = Option::get('blogname');
/*vot*/                 echo empty($blog_name) ? lang('to_site') : subString($blog_name, 0, 24);
                        ?>
                    </a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
<!--vot-->          <li><a href="./"><i class="fa fa-home fa-fw"></i><?=lang('admincp')?></a></li>
                    <li><a href="./configure.php"><i class="fa fa-wrench fa-fw"></i> 设置</a></li>
<!--vot-->          <li><a href="./?action=logout"><i class="fa fa-power-off fa-fw"></i><?=lang('logout')?></a></li>
                </ul>

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li class="sidebar-avatar">
                                <div style="text-align: center;">
                                    <a href="./blogger.php">
                                        <img class="img-circle" src="<?php echo empty($user_cache[UID]['avatar']) ? './views/images/avatar.jpg' : '../' . $user_cache[UID]['avatar'] ?>" />
                                    </a>
                                </div>
                            </li>
<!--vot-->                  <li><a href="write_log.php" id="menu_wt"><i class="fa fa-edit fa-fw"></i> <?=lang('post_write')?></a></li>
<!--vot-->                  <li><a href="admin_log.php" id="menu_log"><i class="fa fa-list-alt fa-fw"></i> <?=lang('posts')?></a></li>
                            <?php if (ROLE == ROLE_ADMIN):?>
<!--vot-->                  <li><a href="tag.php" id="menu_tag"><i class="fa fa-tags fa-fw"></i> <?=lang('tags')?></a></li>
                            <li><a href="sort.php" id="menu_sort"><i class="fa fa-flag fa-fw"></i> <?=lang('categories')?></a></li>
                            <?php endif;?>
<!--vot-->                  <li><a href="comment.php" id="menu_cm"><i class="fa fa-comments fa-fw"></i> <?=lang('comments')?> (
                                    <?php
                                    $hidecmnum = ROLE == ROLE_ADMIN ? $sta_cache['hidecomnum'] : $sta_cache[UID]['hidecommentnum'];
                                    $n = $hidecmnum > 999 ? '...' : $hidecmnum;
                                    echo $n > 0 ? "({$n})" : '';
                                    ?>
                                    </a></li>
                            <?php if (ROLE == ROLE_ADMIN):?>
<!--vot-->                  <li><a href="page.php" id="menu_page"><i class="fa fa-file-o fa-fw"></i> <?=lang('pages')?></a></li>
<!--vot-->                  <li><a href="link.php" id="menu_link"><i class="fa fa-link fa-fw"></i> <?=lang('friend_links')?></a></li>
                            <li id="menu_category_view" class="">
<!--vot-->                      <a href="#"><i class="fa fa-eye fa-fw"></i> <?=lang('exterior')?><span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse" id="menu_view">
<!--vot-->                          <li><a href="widgets.php" id="menu_widget"><i class="fa fa-columns fa-fw"></i> <?=lang('sidebar')?></a></li>
<!--vot-->                          <li><a href="navbar.php" id="menu_navi"><i class="fa fa-bars fa-fw"></i> <?=lang('navigation')?></a></li>
<!--vot-->                          <li><a href="template.php" id="menu_tpl"><i class="fa fa-eye fa-fw"></i> <?=lang('templates')?></a></li>
                                </ul>
                            </li>
                            <li id="menu_category_sys" class="">
<!--vot-->                      <a href="#"><i class="fa fa-cog fa-fw"></i> <?=lang('system')?><span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse" id="menu_sys">
<!--vot-->                          <li><a href="./configure.php" id="menu_setting"><i class="fa fa-wrench fa-fw"></i> <?=lang('settings')?></a></li>
<!--vot-->                          <li><a href="user.php" id="menu_user"><i class="fa fa-user fa-fw"></i> <?=lang('users')?></a></li>
<!--vot-->                          <li><a href="data.php" id="menu_data"><i class="fa fa-database fa-fw"></i> <?=lang('data')?></a></li>
<!--vot-->                          <li><a href="plugin.php" id="menu_plug"><i class="fa fa-plug fa-fw"></i> <?=lang('plugins')?></a></li>
<!--vot-->                          <li><a href="store.php" id="menu_store"><i class="fa fa-shopping-cart fa-fw"></i> <?=lang('applications')?></a></li>
                                </ul>
                            </li>
                            <?php if (!empty($emHooks['adm_sidebar_ext'])): ?>
                            <li id="menu_category_ext" class="">
<!--vot-->                      <a href="#"><i class="fa fa-puzzle-piece fa-fw"></i> <?=lang('extensions')?><span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse" id="menu_ext">
                                    <li><?php doAction('adm_sidebar_ext'); ?></li>
                                </ul>
                            </li>
                            <?php endif;?>
                            <?php endif;?>
                        </ul>
                    </div>
                </div>
            </nav>
            <div id="page-wrapper">
