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
        <form action="setting.php?action=mail_save" method="post" name="input" id="input">
<!--vot-->  <h4><?=lang('email_sending')?></h4>
            <div class="form-group">
<!--vot-->      <label><?=lang('email_send')?></label>
                <input class="form-control" value="<?= $smtp_mail ?>" name="smtp_mail">
            </div>
            <div class="form-group">
<!--vot-->      <label><?=lang('smtp_password')?>:</label>
                <input name="smtp_pw" cols="" rows="3" class="form-control" value="<?= $smtp_pw ?>">
            </div>
            <div class="form-group">
<!--vot-->      <label><?=lang('smtp_server')?>:</label>
                <input class="form-control" value="<?= $smtp_server ?>" name="smtp_server">
            </div>
            <div class="form-group">
<!--vot-->      <label><?=lang('port')?>：</label>
                <input class="form-control" value="<?= $smtp_port ?>" name="smtp_port">
            </div>
            <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
<!--vot-->  <input type="submit" value="<?=lang('save_settings')?>" class="btn btn-sm btn-success"/>
        </form>
    </div>
</div>
<script>
    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('show');
    $("#menu_setting").addClass('active');
    setTimeout(hideActived, 2600);
</script>
