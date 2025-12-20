<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800"><?php _lang('setting'); ?></h1>
</div>
<div class="panel-heading">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./setting.php"><?php _lang('setting_basic'); ?></a></li>
        <li class="nav-item"><a class="nav-link active" href="./setting.php?action=user"><?php _lang('setting_user'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=mail"><?php _lang('setting_mail'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=seo"><?php _lang('setting_seo'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=api"><?php _lang('setting_api'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=ai"><?php _lang('setting_ai'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./blogger.php"><?php _lang('setting_profile'); ?></a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="setting.php?action=user_save" method="post" name="user_setting_form" id="user_setting_form">
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="is_signup" id="is_signup" <?= $conf_is_signup ?> />
                <label class="custom-control-label" for="is_signup"><?php _lang('enable_register'); ?></label>
            </div>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="login_code" id="login_code" <?= $conf_login_code ?>>
                <label class="custom-control-label" for="login_code"><?php _lang('login_captcha'); ?></label>
            </div>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="email_code" id="email_code" <?= $conf_email_code ?>>
                <label class="custom-control-label" for="email_code"><?php _lang('register_email_code'); ?></label>
            </div>
            <hr>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="ischkarticle" id="ischkarticle" <?= $conf_ischkarticle ?> />
                <label class="custom-control-label" for="ischkarticle"><?php _lang('register_article_audit'); ?></label>
            </div>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="article_uneditable" id="article_uneditable" <?= $conf_article_uneditable ?> />
                <label class="custom-control-label" for="article_uneditable"><?php _lang('article_uneditable'); ?></label>
            </div>
            <div class="form-group form-inline">
                <label for="posts_per_day"><?php _lang('register_post_limit'); ?></label>
                <input class="form-control mx-sm-3" style="width:60px;" value="<?= $posts_per_day ?>" type="number" min="0" name="posts_per_day" id="posts_per_day" />
            </div>
            <hr>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="forbid_user_upload" id="forbid_user_upload" <?= $conf_forbid_user_upload ?> />
                <label class="custom-control-label" for="forbid_user_upload"><?php _lang('forbid_register_upload'); ?></label>
            </div>
            <div class="form-group form-inline" id="form_att_maxsize">
                <?php _lang('register_upload_max'); ?>：<input type="number" min="0" style="width:200px;" class="form-control" value="<?= $att_maxsize ?>" name="att_maxsize" /> （<?php _lang('unit_kb'); ?>）
            </div>
            <div class="form-group form-inline" id="form_att_type">
                <?php _lang('register_upload_type'); ?>：<input maxlength="200" style="width:500px;" class="form-control" value="<?= $att_type ?>" name="att_type" />（<?php _lang('separate_by_comma'); ?>）
            </div>
            <hr>
            <div class="form-group form-inline">
                <label for="posts_name"><?php _lang('user_article_alias'); ?>：</label>
                <input class="form-control mx-sm-3" style="width:80px;" value="<?= $posts_name ?>" name="posts_name" id="posts_name" /> <?php _lang('alias_example'); ?>
            </div>
            <div class="form-group">
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                <input type="submit" value="<?php _lang('save'); ?>" class="btn btn-sm btn-success" />
            </div>
        </form>
        <div class="alert alert-warning">
            <b><?php _lang('user_group'); ?></b><br>
            <?php _lang('user_group_intro_1'); ?><br>
            <?php _lang('user_group_intro_2'); ?><br>
            <?php _lang('user_group_intro_3'); ?><br>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#menu_category_sys").addClass('active');
        $("#menu_sys").addClass('show');
        $("#menu_setting").addClass('active');
        setTimeout(hideActived, 3600);

        // 提交表单
        $("#user_setting_form").submit(function(event) {
            event.preventDefault();
            submitForm("#user_setting_form");
        });
    });
</script>