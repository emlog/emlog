<?php
if (!defined('EMLOG_ROOT')) {
    exit('error!');
}
?>
<script>setTimeout(hideActived, 2600);</script>
<div class="containertitle"><b>管理首页</b></div>
<div class="row">
    <div class="col-lg-2 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list-alt fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $sta_cache['lognum']; ?></div>
                        <div>文章数量</div>
                    </div>
                </div>
            </div>
            <a href="admin_log.php">
                <div class="panel-footer">
                    <span class="pull-left">文章管理</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-2 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $sta_cache['comnum_all']; ?></div>
                        <div>评论数量</div>
                    </div>
                </div>
            </div>
            <a href="comment.php">
                <div class="panel-footer">
                    <span class="pull-left">评论管理</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-2 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comment fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $sta_cache['twnum']; ?></div>
                        <div>微语数量</div>
                    </div>
                </div>
            </div>
            <a href="twitter.php">
                <div class="panel-footer">
                    <span class="pull-left">管理微语</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-2 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-thumbs-up fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">13</div>
                        <div>点赞数量</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">查看所有点赞</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<div class="row">
<?php if (ROLE == ROLE_ADMIN): ?>
        <div class="col-lg-4">
            <!-- /.panel -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-laptop fa-fw"></i> 服务器信息
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" id="admindex_servinfo">
                    <ul class="timeline">
                        <li>数据库表前缀：<?php echo DB_PREFIX; ?></li>
                        <li>PHP版本：<?php echo $php_ver; ?></li>
                        <li>MySQL版本：<?php echo $mysql_ver; ?></li>
                        <li>服务器环境：<?php echo $serverapp; ?></li>
                        <li>GD图形处理库：<?php echo $gd_ver; ?></li>
                        <li>服务器空间允许上传最大文件：<?php echo $uploadfile_maxsize; ?></li>
                        <li><a href="index.php?action=phpinfo">更多信息&raquo;</a></li>
                    </ul>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <div class="col-lg-4">
            <!-- /.panel -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-volume-down fa-fw"></i> 官方消息
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" id="admindex_msg">
                    <ul class="timeline"></ul>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div id="admindex">
                <div id="about" class="alert alert-warning">
                  您正在使用emlog <?php echo Option::EMLOG_VERSION; ?>  <span><a id="ckup" href="javascript:void(0);">检查更新</a></span><br />
                  <span id="upmsg"></span>
                </div>
            </div>
        </div>
    </div>
            <script>
                $(document).ready(function() {
                    $("#admindex_msg ul").html("<span class=\"ajax_remind_1\">正在读取...</span>");
                    $.getJSON("<?php echo OFFICIAL_SERVICE_HOST; ?>services/messenger.php?v=<?php echo Option::EMLOG_VERSION; ?>&callback=?",
                            function(data) {
                                $("#admindex_msg ul").html("");
                                $.each(data.items, function(i, item) {
                                    var image = '';
                                    if (item.image != '') {
                                        image = "<a href=\"" + item.url + "\" target=\"_blank\" title=\"" + item.title + "\"><img src=\"" + item.image + "\"></a><br />";
                                    }
                                    $("#admindex_msg ul").append("<li class=\"msg_type_" + item.type + "\">" + image + "<span>" + item.date + "</span><a href=\"" + item.url + "\" target=\"_blank\">" + item.title + "</a></li>");
                                });
                            });
                });
                $("#about #ckup").click(function() {
                    $("#about #upmsg").html("正在检查，请稍后").addClass("ajaxload");
                    $.getJSON("<?php echo OFFICIAL_SERVICE_HOST; ?>services/check_update.php?ver=<?php echo Option::EMLOG_VERSION; ?>&callback=?",
                            function(data) {
                                if (data.result.match("no")) {
                                    $("#about #upmsg").html("目前还没有适合您当前版本的更新！").removeClass();
                                } else if (data.result.match("yes")) {
                                    $("#about #upmsg").html("有可用的emlog更新版本 " + data.ver + "，更新之前请您做好数据备份工作，<a id=\"doup\" href=\"javascript:doup('" + data.file + "','" + data.sql + "');\">现在更新</a>").removeClass();
                                } else {
                                    $("#about #upmsg").html("检查失败，可能是网络问题").removeClass();
                                }
                            });
                });
                function doup(source, upsql) {
                    $("#about #upmsg").html("系统正在更新中，请耐心等待").addClass("ajaxload");
                    $.get('./index.php?action=update&source=' + source + "&upsql=" + upsql,
                            function(data) {
                                $("#about #upmsg").removeClass();
                                if (data.match("succ")) {
                                    $("#about #upmsg").html('恭喜您！更新成功了，请<a href="./">刷新页面</a>开始体验新版emlog');
                                } else if (data.match("error_down")) {
                                    $("#about #upmsg").html('下载更新失败，可能是服务器网络问题');
                                } else if (data.match("error_zip")) {
                                    $("#about #upmsg").html('解压更新失败，可能是你的服务器空间不支持zip模块');
                                } else if (data.match("error_dir")) {
                                    $("#about #upmsg").html('更新失败，目录不可写');
                                } else {
                                    $("#about #upmsg").html('更新失败');
                                }
                            });
                }
            </script>
<?php else: ?>
<div class="row">
        <div class="col-lg-12">
            <div id="admindex_main">
                <div id="about"><a href="blogger.php"><?php echo $name; ?></a> （<b><?php echo $sta_cache[UID]['lognum']; ?></b>篇文章，<b><?php echo $sta_cache[UID]['commentnum']; ?></b>条评论）</div>
            </div>
            <div class="clear"></div>
        </div>
</div>
<?php endif; ?>
