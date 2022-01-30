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
<!--vot--><li class="nav-item"><a class="nav-link active" href="./setting.php?action=user"><?=lang('user_settings')?></a></li>
<!--vot--><li class="nav-item"><a class="nav-link" href="./setting.php?action=mail"><?=lang('email_notify')?></a></li>
<!--vot--><li class="nav-item"><a class="nav-link" href="./setting.php?action=seo"><?=lang('seo_settings')?></a></li>
<!--vot--><li class="nav-item"><a class="nav-link" href="./blogger.php"><?=lang('personal_settings')?></a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="setting.php?action=user_save" method="post" name="input" id="input">
<!--vot-->  <h4><?=lang('registration')?></h4>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="is_signup" id="is_signup" <?= $conf_is_signup ?> />
<!--vot-->      <label><?=lang('registration_open')?></label>
            </div>
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="y" name="login_code" id="login_code" <?= $conf_login_code ?> >
<!--vot-->      <label class="form-check-label"><?=lang('registration_captcha')?></label>
            </div>
<!--vot-->  <h4><?=lang('user_rights')?></h4>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="writer_permission" id="writer_permission" <?= $writer_permission ?> />
<!--vot-->      <label><?=lang('post_publish')?></label>
                <input class="form-check-input" type="checkbox" value="y" name="writer_permission" id="writer_permission" <?= $writer_permission ?> />
<!--vot-->      <label><?=lang('comment_write')?></label>
            </div>
<!--vot-->  <h4><?=lang('guest_rights')?></h4>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="writer_permission" id="writer_permission" <?= $writer_permission ?> />
<!--vot-->      <label><?=lang('comment_write')?></label>
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
