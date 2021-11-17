<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Hi，<a class="small" href="./blogger.php"><?php echo $user_cache[UID]['name'] ?></a></h1>
		<?php doAction('adm_main_top'); ?>
    </div>
<?php if (ROLE == ROLE_ADMIN): ?>
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <h6 class="card-header">站点信息</h6>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">文章
                            <a href="./article.php"><span class="badge badge-primary badge-pill"><?php echo $sta_cache['lognum']; ?></span></a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">草稿
                            <a href="./article.php?draft=1"><span class="badge badge-primary badge-pill"><?php echo $sta_cache['draftnum']; ?></span></a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">评论
                            <a href="./comment.php"><span class="badge badge-primary badge-pill"><?php echo $sta_cache['comnum_all']; ?></span></a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">待审评论
                            <a href="./comment.php?hide=y"><span class="badge badge-warning badge-pill"><?php echo $sta_cache['hidecomnum']; ?></span></a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">用户数
                            <a href="./user.php"><span class="badge badge-warning badge-pill"><?php echo count($user_cache); ?></span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <h6 class="card-header">软件信息</h6>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            PHP
                            <span class="small"><?php echo $php_ver; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            MySQL
                            <span class="small"><?php echo $mysql_ver; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Web Server
                            <span class="small"><?php echo $serverapp; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            EMLOG
							<?php if (!Register::isRegLocal()) : ?>
                                <a href="register.php"><span class="badge badge-danger"><?php echo Option::EMLOG_VERSION; ?> 未注册, 点击去注册</span></a>
							<?php else: ?>
                                <span class="badge badge-success"><?php echo Option::EMLOG_VERSION; ?> 已注册</span>
							<?php endif; ?>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a id="ckup" href="javascript:checkupdate();" class="badge badge-success">检查更新</a>
                            <span id="upmsg"></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
		<?php if (!Register::isRegLocal()) : ?>
            <div class="col-lg-6 mb-4">
                <div class="card bg-danger text-white shadow">
                    <div class="card-body">
                        <h4>您安装的emlog pro尚未注册，注册后将获得：</h4>
                        <div>1、一键升级，获得来自官方的安全和功能更新。</div>
                        <div>2、解锁扩展商店，获得更多模板和插件。</div>
                        <div>3、解除使用限制和所有未注册提示。</div>
                        <div>4、"投我以桃，报之以李"，支持我们把emlog做的更好。</div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="register.php" class="btn btn-sm btn-success shadow-lg">现在去注册</a>
                    </div>
                </div>
            </div>
		<?php endif; ?>
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <h6 class="card-header">官方消息</h6>
                <div class="card-body" id="admindex_msg">
                    <ul class="list-group list-group-flush"></ul>
                </div>
            </div>
        </div>
    </div>
    <script>
        setTimeout(hideActived, 2600);
        $("#menu_home").addClass('active');
        $(document).ready(function () {
            $("#admindex_msg ul").html("").addClass("spinner-border text-primary");
            $.get("./index.php?action=get_news",
                function (data) {
                    $.each(data.items, function (i, item) {
                        var image = '';
                        if (item.image != '') {
                            image = "<a href=\"" + item.url + "\" target=\"_blank\" title=\"" + item.title + "\"><img src=\"" + item.image + "\"></a><br />";
                        }
                        $("#admindex_msg ul").append("<li class=\"msg_type_" + item.type + "\">" + image + "<span>" + item.date + "</span><a href=\"" + item.url + "\" target=\"_blank\">" + item.title + "</a></li>");
                    });
                    $("#admindex_msg ul").removeClass();
                });
        });

        function checkupdate() {
            $("#upmsg").html("").addClass("spinner-border text-primary");
            $.get("./upgrade.php?action=check_update",
                function (result) {
                    if (result.code == 1001) {
                        $("#upmsg").html("您的emlog pro尚未注册，<a href=\"register.php\">去注册</a>").removeClass();
                    } else if (result.code == 1002) {
                        $("#upmsg").html("已经是最新版本").removeClass();
                    } else if (result.code == 200) {
                        $("#upmsg").html("有可用的新版本 " + result.data.version + "，<a href=\"https://www.emlog.net/docs/#/changelog\" target=\"_blank\">查看更新内容</a>，<a id=\"doup\" href=\"javascript:doup('" + result.data.file + "','" + result.data.sql + "');\">现在更新</a>").removeClass();
                    } else {
                        $("#upmsg").html("检查失败，可能是网络问题").removeClass();
                    }
                });
        }

        function doup(source, upsql) {
            $("#upmsg").html("正在更新中，请耐心等待").addClass("ajaxload");
            $.get('./upgrade.php?action=update&source=' + source + "&upsql=" + upsql,
                function (data) {
                    $("#upmsg").removeClass();
                    if (data.match("succ")) {
                        $("#upmsg").html('恭喜您！更新成功了，请<a href="./">刷新页面</a>开始体验新版emlog');
                    } else if (data.match("error_down")) {
                        $("#upmsg").html('下载更新失败，可能是服务器网络问题');
                    } else if (data.match("error_zip")) {
                        $("#upmsg").html('解压更新失败，可能是你的服务器空间不支持zip模块');
                    } else if (data.match("error_dir")) {
                        $("#upmsg").html('更新失败，目录不可写');
                    } else {
                        $("#upmsg").html('更新失败');
                    }
                });
        }
    </script>
<?php endif; ?>