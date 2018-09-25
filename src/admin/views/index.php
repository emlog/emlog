<?php if (!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived, 2600);</script>
<div class="containertitle"><b>管理首页</b></div>
<?php doAction('adm_main_top'); ?>
<div class="row">
<?php if (ROLE == ROLE_ADMIN): ?>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-laptop fa-fw"></i> 站点信息
                </div>
                <div class="panel-body" id="admindex_servinfo">
                    <ul>
                        <li>有<b><?php echo $sta_cache['lognum'];?></b>篇文章，<b><?php echo $sta_cache['comnum_all'];?></b>条评论</li>
                        <li>数据库表前缀：<?php echo DB_PREFIX; ?></li>
                        <li>PHP版本：<?php echo $php_ver; ?></li>
                        <li>MySQL版本：<?php echo $mysql_ver; ?></li>
                        <li>服务器环境：<?php echo $serverapp; ?></li>
                        <li>服务器空间允许上传最大文件：<?php echo $uploadfile_maxsize; ?></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-volume-down fa-fw"></i> 官方消息
                </div>
                <div class="panel-body" id="admindex_msg">
                    <ul></ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div id="admindex">
                <div id="about" class="alert alert-warning">
                  欢迎使用 &copy; <a href="http://www.emlog.net" target="_blank">emlog</a> v<?php echo Option::EMLOG_VERSION; ?>
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
