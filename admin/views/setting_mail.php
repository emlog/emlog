<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['activated'])): ?>
    <div class="alert alert-success">设置保存成功</div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">设置</h1>
</div>
<div class="panel-heading">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./setting.php">基础设置</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=user">用户设置</a></li>
        <li class="nav-item"><a class="nav-link active" href="./setting.php?action=mail">邮件通知</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=seo">SEO优化</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=api">API接口</a></li>
        <li class="nav-item"><a class="nav-link" href="./blogger.php">个人信息</a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="setting.php?action=mail_save" method="post" name="input" id="mail_config">
            <h4>邮件服务</h4>
            <div class="form-group">
                <label>发送人邮箱</label>
                <input type="email" class="form-control" value="<?= $smtp_mail ?>" name="smtp_mail">
            </div>
            <div class="form-group">
                <label>SMTP密码</label>
                <input type="password" name="smtp_pw" cols="" rows="3" class="form-control" value="<?= $smtp_pw ?>" autocomplete="new-password">
            </div>
            <div class="form-group">
                <label>发送人名称（选填，建议填写站点名称）</label>
                <input type="from_name" class="form-control" value="<?= $smtp_from_name ?>" name="smtp_from_name">
            </div>
            <div class="form-group">
                <label>SMTP服务器</label>
                <input class="form-control" value="<?= $smtp_server ?>" name="smtp_server">
            </div>
            <div class="form-group">
                <label>端口 (465：ssl协议，如QQ邮箱，网易邮箱等，587：STARTTLS协议 如：Outlook邮箱)</label>
                <input class="form-control" value="<?= $smtp_port ?>" name="smtp_port">
            </div>
            <div class="form-group">
                <input type="button" value="发送测试" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#testMail"/>
            </div>
            <div class="alert alert-warning">
                <b>以QQ邮箱配置为例</b><br>
                发送人邮箱：你的QQ邮箱<br>
                SMTP密码：见QQ邮箱顶部设置-> 账户 -> 开启IMAP/SMTP服务 -> 生成授权码（即为SMTP密码）<br>
                发送人名称：你的姓名或者站点名称<br>
                SMTP服务器：smtp.qq.com<br>
                端口：465<br>
            </div>
            <!-- 设置接收邮箱的模态框 -->
            <div class="modal fade" id="testMail">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">发送测试</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input class="form-control" type="email" name="testTo" placeholder="输入接收邮箱">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div id="testMailMsg"></div>
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">关闭</button>
                            <button type="button" class="btn btn-success btn-sm" id="testSendBtn">发送</button>
                        </div>
                    </div>
                </div>
            </div>

            <h4>邮件通知</h4>
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="y" name="mail_notice_comment" id="mail_notice_comment" <?= $conf_mail_notice_comment ?> />
                <label class="form-check-label">新评论通知（仅发送到文章作者邮箱）</label>
            </div>
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="y" name="mail_notice_post" id="mail_notice_post" <?= $conf_mail_notice_post ?> >
                <label class="form-check-label">新文章投稿通知（仅发送到创始人邮箱）</label>
            </div>
            <div class="form-group">
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
                <input type="submit" value="保存设置" class="btn btn-sm btn-success"/>
            </div>
        </form>
    </div>
</div>
<script>
    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('show');
    $("#menu_setting").addClass('active');
    setTimeout(hideActived, 3600);

    $("#testSendBtn").click(function () {
        $("#testMailMsg").html("<small class='text-secondary'>发送中...<small>");

        $.post("setting.php?action=mail_test", $("#mail_config").serialize(), function (data) {
            if (data == '') {
                $("#testMailMsg").html("<small class='text-success'>发送成功</small>");
            } else {
                $("#testMailMsg").html(data);
            }

        });
    })
</script>
