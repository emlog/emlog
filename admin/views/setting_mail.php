<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['activated'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('settings_saved_ok')?></div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?=lang('settings')?></h1>
</div>
<div class="panel-heading">
    <ul class="nav nav-pills">
<!--vot--><li class="nav-item"><a class="nav-link" href="./setting.php"><?=lang('basic_settings')?></a></li>
<!--vot--><li class="nav-item"><a class="nav-link" href="./setting.php?action=user"><?=lang('user_settings')?></a></li>
<!--vot--><li class="nav-item"><a class="nav-link active" href="./setting.php?action=mail"><?=lang('email_notify')?></a></li>
<!--vot--><li class="nav-item"><a class="nav-link" href="./setting.php?action=seo"><?=lang('seo_settings')?></a></li>
<!--vot--><li class="nav-item"><a class="nav-link" href="./blogger.php"><?=lang('personal_settings')?></a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="setting.php?action=mail_save" method="post" name="input" id="mail_config">
<!--vot-->  <h4><?=lang('email_sending')?></h4>
            <div class="form-group">
<!--vot-->      <label><?=lang('sender_email')?></label>
                <input type="email" class="form-control" value="<?= $smtp_mail ?>" name="smtp_mail" required>
            </div>
            <div class="form-group">
<!--vot-->      <label><?=lang('smtp_password')?>:</label>
                <input type="password" name="smtp_pw" cols="" rows="3" class="form-control" value="<?= $smtp_pw ?>" required>
            </div>
            <div class="form-group">
<!--vot-->      <label><?=lang('smtp_server')?>:</label>
                <input class="form-control" value="<?= $smtp_server ?>" name="smtp_server" required>
            </div>
            <div class="form-group">
<!--vot-->      <label><?=lang('smtp_port')?>:</label>
                <input class="form-control" value="<?= $smtp_port ?>" name="smtp_port" required>
            </div>
            <div class="form-group">
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
<!--vot-->  <input type="submit" value="<?=lang('save_settings')?>" class="btn btn-sm btn-success"/>
                <input type="button" value="发送测试" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#testMail"/>
            </div>
            <div class="alert alert-warning">
                <b>以QQ邮箱配置为例</b><br>
                发送人邮箱：你的QQ邮箱<br>
                SMTP密码：见QQ邮箱顶部设置-> 账户 -> 开启IMAP/SMTP服务 -> 生成授权码（即为SMTP密码）<br>
                SMTP服务器：smtp.qq.com<br>
                端口：465 (只支持 SSL 端口)
                <br>
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
        </form>
    </div>
</div>
<script>
    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('show');
    $("#menu_setting").addClass('active');
    setTimeout(hideActived, 2600);

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
