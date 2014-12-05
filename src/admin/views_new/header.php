<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>管理中心 - <?php echo Option::get('blogname'); ?></title>
		<link href="./views_new/css/cssreset-min.css" rel="stylesheet">
		<link href="./views_new/css/bootstrap.min.css" rel="stylesheet">
		<link href="./views_new/css/font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="./views_new/css/css-main.css?v=<?php echo Option::EMLOG_VERSION; ?>" type=text/css rel=stylesheet>
        <script src="../include/lib/js/jquery/jquery-1.11.0.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
        <script src="../include/lib/js/jquery/plugin-cookie.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
        <script src="./views_new/js/bootstrap.min.js"></script>
		<script src="./views_new/js/common.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
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
                    <a class="navbar-brand" href="../" target="_blank" title="在新窗口浏站点">
                        <?php
                        $blog_name = Option::get('blogname');
                        echo empty($blog_name) ? '查看我的站点' : subString($blog_name, 0, 24);
                        ?>
                    </a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true">
                        <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="./comment.php?hide=y">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> 待审核评论
                                    <span class="pull-right text-muted small">
                                    <?php
                                    $hidecmnum = ROLE == ROLE_ADMIN ? $sta_cache['hidecomnum'] : $sta_cache[UID]['hidecommentnum'];
                                    $n = $hidecmnum > 999 ? '...' : $hidecmnum;
                                    echo $n;
                                    ?>
                                    </span>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                    </li>
                    <li><a href="./"><i class="fa fa-home fa-fw"></i>管理首页</a></li>
                    <li><a href="./configure.php" id="top_menu_setting"><i class="fa fa-wrench fa-fw"></i>设置</a></li>
                    <li><a href="./?action=logout"><i class="fa fa-power-off fa-fw"></i>退出</a></li>
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
                            <li><a href="write_log.php" id="menu_wt"><i class="fa fa-edit fa-fw"></i> 写文章</a></li>
                            <li><a href="admin_log.php?pid=draft" id="menu_draft"><i class="fa fa-files-o fa-fw"></i> 草稿 <?php
                                    if (ROLE == ROLE_ADMIN) {
                                        echo $sta_cache['draftnum'] == 0 ? '' : '(' . $sta_cache['draftnum'] . ')';
                                    } else {
                                        echo $sta_cache[UID]['draftnum'] == 0 ? '' : '(' . $sta_cache[UID]['draftnum'] . ')';
                                    }
                                    ?> 
                            </a></li>
                            <li><a href="admin_log.php" id="menu_log"><i class="fa fa-list-alt fa-fw"></i> 文章</a>
                            </li>
                            <?php if (ROLE == ROLE_ADMIN):?>
                            <li><a href="tag.php" id="menu_tag"><i class="fa fa-tags fa-fw"></i> 标签</a></li>
                            <li><a href="sort.php" id="menu_sort"><i class="fa fa-flag fa-fw"></i> 分类</a></li>
                            <?php endif;?>
                            <li><a href="comment.php" id="menu_cm"><i class="fa fa-comments fa-fw"></i> 评论</a></li>
                            <?php if (ROLE == ROLE_ADMIN):?>
                            <li><a href="twitter.php" id="menu_tw"><i class="fa fa-comment fa-fw"></i> 微语</a></li>
                            <li><a href="page.php" id="menu_page"><i class="fa fa-file-o fa-fw"></i> 页面</a></li>
							<li id="menu_category_view" class="">
                                <a href="#"><i class="fa fa-windows fa-fw"></i> 外观<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse" id="menu_view">
									<li><a href="widgets.php" id="menu_widget"><i class="fa fa-columns fa-fw"></i> 侧边栏</a></li>
									<li><a href="navbar.php" id="menu_navi"><i class="fa fa-bars fa-fw"></i> 导航</a></li>
                                    <li><a href="template.php" id="menu_tpl"><i class="fa fa-eye fa-fw"></i> 模板</a></li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
							<li id="menu_category_sys" class="">
                                <a href="#"><i class="fa fa-cog fa-fw"></i> 系统<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse" id="menu_sys">
                                    <li><a href="./configure.php" id="menu_setting"><i class="fa fa-wrench fa-fw"></i>设置</a></li>
									<li><a href="user.php" id="menu_user"><i class="fa fa-user fa-fw"></i> 用户</a></li>
									<li><a href="data.php" id="menu_data"><i class="fa fa-database fa-fw"></i> 数据</a></li>
									<li><a href="plugin.php" id="menu_plug"><i class="fa fa-plug fa-fw"></i> 插件</a></li>
                                    <li><a href="store.php" id="menu_store"><i class="fa fa-shopping-cart fa-fw"></i> 应用</a></li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <?php if (!empty($emHooks['adm_sidebar_ext'])): ?>
                            <li id="menu_category_ext" class="">
                                <a href="#"><i class="fa fa-puzzle-piece fa-fw"></i> 扩展功能<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse" id="menu_ext">
                                    <li><?php doAction('adm_sidebar_ext'); ?></li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <?php endif;?>
                            <?php endif;?>
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>
            <div id="page-wrapper">
