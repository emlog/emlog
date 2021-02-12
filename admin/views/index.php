<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">控制台首页</h1>
    </div>
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <h6 class="card-header">站点信息</h6>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">文章
                            <span class="badge badge-primary badge-pill"><?php echo $sta_cache['lognum']; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">评论
                            <span class="badge badge-primary badge-pill"><?php echo $sta_cache['comnum_all']; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center small">
                            服务器环境：PHP<?php echo $php_ver; ?>， MySQL<?php echo $mysql_ver; ?>，<?php echo $serverapp; ?>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <h6 class="card-header">官方消息</h6>
                <div class="card-body">
                    <div class="panel-body" id="admindex_msg">
                        <ul class="list-group list-group-flush"></ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#admindex_msg ul").html("<span class=\"ajax_remind_1\">正在读取...</span>");
        $.getJSON("<?php echo OFFICIAL_SERVICE_HOST; ?>services/messenger.php?v=<?php echo Option::EMLOG_VERSION; ?>&callback=?",
            function (data) {
                $("#admindex_msg ul").html("");
                $.each(data.items, function (i, item) {
                    var image = '';
                    if (item.image != '') {
                        image = "<a href=\"" + item.url + "\" target=\"_blank\" title=\"" + item.title + "\"><img src=\"" + item.image + "\"></a><br />";
                    }
                    $("#admindex_msg ul").append("<li class=\"msg_type_" + item.type + "\">" + image + "<span>" + item.date + "</span><a href=\"" + item.url + "\" target=\"_blank\">" + item.title + "</a></li>");
                });
            });
    });
</script>