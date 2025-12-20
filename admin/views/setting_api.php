<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['ok_reset'])): ?>
    <div class="alert alert-success"><?php _lang('api_key_reset_success'); ?></div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800"><?php _lang('setting'); ?></h1>
</div>
<div class="panel-heading">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./setting.php"><?php _lang('setting_basic'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=user"><?php _lang('setting_user'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=mail"><?php _lang('setting_mail'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=seo"><?php _lang('setting_seo'); ?></a></li>
        <li class="nav-item"><a class="nav-link active" href="./setting.php?action=api"><?php _lang('setting_api'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=ai"><?php _lang('setting_ai'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./blogger.php"><?php _lang('setting_profile'); ?></a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="setting.php?action=api_save" method="post" name="setting_api_form" id="setting_api_form">
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="is_openapi" id="is_openapi" <?= $conf_is_openapi ?> />
                <label class="custom-control-label" for="is_openapi"><?php _lang('enable_api'); ?></label>
            </div>
            <div class="input-group mt-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><?php _lang('api_key'); ?></span>
                </div>
                <input type="text" class="form-control" disabled value="<?= $apikey ?>">
                <div class="input-group-append">
                    <button class="btn btn-outline-success" type="button" onclick="window.location.href='setting.php?action=api_reset&token=<?= LoginAuth::genToken() ?>'">
                        <?php _lang('reset_api_key'); ?>
                    </button>
                </div>
            </div>
            <div class="form-group mt-3">
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
            </div>
        </form>
        <div class="alert alert-warning">
            <b><?php _lang('api_list'); ?>：</b><br><br>
            <?php _lang('api_article_post'); ?><?= BLOG_URL ?>?rest-api=article_post)<br>
            <?php _lang('api_category_list'); ?><br>
            <?php _lang('api_twitter_post'); ?><br>
            <?php _lang('api_twitter_list'); ?><br>
            <?php _lang('api_media_upload'); ?><br>
            ……<br><br>
            <?php _lang('api_doc_link'); ?>：<a href="https://www.emlog.net/docs/api" target="_blank"><?php _lang('api_doc'); ?>→</a>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#menu_category_sys").addClass('active');
        $("#menu_sys").addClass('show');
        $("#menu_setting").addClass('active');
        setTimeout(hideActived, 3600);
    });
    $('#setting_api_form').change(function() {
        submitForm('#setting_api_form');
    });
</script>