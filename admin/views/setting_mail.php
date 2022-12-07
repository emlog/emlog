<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['activated'])): ?>
          <div class="alert alert-success"><?=lang('settings_saved_ok')?></div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800"><?=lang('settings')?></h1>
</div>
<div class="panel-heading">
    <ul class="nav nav-pills">
          <li class="nav-item"><a class="nav-link" href="./setting.php"><?=lang('basic_settings')?></a></li>
          <li class="nav-item"><a class="nav-link" href="./setting.php?action=user"><?=lang('user_settings')?></a></li>
          <li class="nav-item"><a class="nav-link active" href="./setting.php?action=mail"><?=lang('email_notify')?></a></li>
          <li class="nav-item"><a class="nav-link" href="./setting.php?action=seo"><?=lang('seo_settings')?></a></li>
          <li class="nav-item"><a class="nav-link" href="./setting.php?action=api"><?=lang('api_interface')?></a></li>
          <li class="nav-item"><a class="nav-link" href="./blogger.php"><?=lang('personal_settings')?></a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="setting.php?action=mail_save" method="post" name="input" id="mail_config">
            <h4><?=lang('email_service')?></h4>
            <div class="form-group">
                <label><?=lang('sender_email')?></label>
                <input type="email" class="form-control" value="<?= $smtp_mail ?>" name="smtp_mail" required>
            </div>
            <div class="form-group">
                <label><?=lang('smtp_password')?>:</label>
                <input type="password" name="smtp_pw" cols="" rows="3" class="form-control" value="<?= $smtp_pw ?>" required>
            </div>
            <div class="form-group">
                <label><?=lang('smtp_server')?>:</label>
                <input class="form-control" value="<?= $smtp_server ?>" name="smtp_server" required>
            </div>
            <div class="form-group">
                <label><?=lang('smtp_port')?> <?=lang('smtp_port_info')?></label>
                <input class="form-control" value="<?= $smtp_port ?>" name="smtp_port" required>
            </div>
            <div class="form-group">
                <input type="button" value="<?=lang('send_test')?>" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#testMail"/>
            </div>
            <div class="alert alert-warning">
                <?=lang('send_test_prompt')?>
            </div>
            <!-- Set the modal box for receiving mailboxes -->
            <div class="modal fade" id="testMail">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><?=lang('send_test')?></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input class="form-control" type="email" name="testTo" placeholder="<?=lang('recepient_email_enter')?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div id="testMailMsg"></div>
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><?=lang('close')?></button>
                            <button type="button" class="btn btn-success btn-sm" id="testSendBtn"><?=lang('send')?></button>
                        </div>
                    </div>
                </div>
            </div>

            <h4><?=lang('email_notify')?></h4>
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="y" name="mail_notice_comment" id="mail_notice_comment" <?= $conf_mail_notice_comment ?> />
                <label class="form-check-label"><?=lang('comment_new_notify')?></label>
            </div>
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="y" name="mail_notice_post" id="mail_notice_post" <?= $conf_mail_notice_post ?> >
                <label class="form-check-label"><?=lang('article_new_notify')?></label>
            </div>
            <div class="form-group">
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
                <input type="submit" value="<?=lang('save_settings')?>" class="btn btn-sm btn-success"/>
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
$("#testMailMsg").html("<small class='text-secondary'><?=lang('sending')?>...<small>");

        $.post("setting.php?action=mail_test", $("#mail_config").serialize(), function (data) {
            if (data == '') {
        $("#testMailMsg").html("<small class='text-success'><?=lang('send_ok')?></small>");
            } else {
                $("#testMailMsg").html(data);
            }

        });
    })
</script>
