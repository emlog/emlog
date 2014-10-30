<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>管理中心 - <?php echo Option::get('blogname'); ?></title>
<link href="./views/css/css-main.css?v=<?php echo Option::EMLOG_VERSION; ?>" type=text/css rel=stylesheet>
<link href="./views_new/css/bootstrap.min.css" rel="stylesheet">
<link href="./views_new/css/plugins/metisMenu/metisMenu.css" rel="stylesheet">
<link href="./views_new/css/sb-admin-2.css" rel="stylesheet">
<link href="./views_new/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="./blogger.php"><i class="fa fa-user fa-fw"></i>个人资料</a>
                        </li>
                        <li><a href="./configure.php"><i class="fa fa-gear fa-fw"></i>系统设置</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="./?action=logout"><i class="fa fa-sign-out fa-fw"></i>退出</a>
                        </li>
                    </ul>
                </li>
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
                        <li>
                            <a href="write_log.php"><i class="fa fa-edit fa-fw"></i> 写文章</a>
                        </li>
                        <li>
                            <a href="admin_log.php?pid=draft"><i class="fa fa-dashboard fa-fw"></i> 草稿 <?php 
                            if (ROLE == ROLE_ADMIN){
                                echo $sta_cache['draftnum'] == 0 ? '' : '('.$sta_cache['draftnum'].')'; 
                            }else{
                                echo $sta_cache[UID]['draftnum'] == 0 ? '' : '('.$sta_cache[UID]['draftnum'].')';
                            }
                            ?> 
                            </a>
                        </li>
                        <li>
                            <a href="admin_log.php"><i class="fa fa-dashboard fa-fw"></i> 文章</a>
                        </li>
                        <li>
                            <a href="tag.php"><i class="fa fa-dashboard fa-fw"></i> 标签</a>
                        </li>
                        <li>
                            <a href="sort.php"><i class="fa fa-dashboard fa-fw"></i> 分类</a>
                        </li>
                        <li>
                            <a href="comment.php"><i class="fa fa-dashboard fa-fw"></i> 评论</a>
                        </li>
                        <li>
                            <a href="twitter.php"><i class="fa fa-dashboard fa-fw"></i> 微语</a>
                        </li>
                        <li>
                            <a href="widgets.php"><i class="fa fa-dashboard fa-fw"></i> 侧边栏</a>
                        </li>
                        <li>
                            <a href="navbar.php"><i class="fa fa-dashboard fa-fw"></i> 导航</a>
                        </li>
                        <li>
                            <a href="page.php"><i class="fa fa-dashboard fa-fw"></i> 页面</a>
                        </li>
                        <li>
                            <a href="user.php"><i class="fa fa-dashboard fa-fw"></i> 用户</a>
                        </li>
                        <li>
                            <a href="data.php"><i class="fa fa-dashboard fa-fw"></i> 数据</a>
                        </li>
                        <li>
                            <a href="plugin.php"><i class="fa fa-dashboard fa-fw"></i> 插件</a>
                        </li>
                        <li>
                            <a href="template.php"><i class="fa"></i> 模板</a>
                        </li>
                                                <li class="">
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse" style="height: 0px;">
                                <li>
                                    <a href="blank.html">Blank Page</a>
                                </li>
                                <li>
                                    <a href="login.html">Login Page</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="store.php"><i class="fa fa-dashboard fa-fw"></i> 应用</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
<div id="page-wrapper">