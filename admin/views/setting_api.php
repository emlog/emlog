<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['ok'])): ?>
    <div class="alert alert-success"><?= lang('saved_ok') ?></div><?php endif ?>
<?php if (isset($_GET['ok_reset'])): ?>
    <div class="alert alert-success"><?= lang('api_key_reset_ok') ?></div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= lang('settings') ?></h1>
</div>
<div class="panel-heading">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./setting.php"><?= lang('basic_settings') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=user"><?= lang('user_settings') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=mail"><?= lang('email_notify') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=seo"><?= lang('seo_settings') ?></a></li>
        <li class="nav-item"><a class="nav-link active" href="./setting.php?action=api"><?= lang('api_interface') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./blogger.php"><?= lang('personal_settings') ?></a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="setting.php?action=api_save" method="post" name="input" id="input">
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="y" name="is_openapi" id="is_openapi" <?= $conf_is_openapi ?> />
                <label class="form-check-label"><?= lang('api_enable') ?></label>
            </div>
            <p><?= lang('api_key') ?>:</p>
            <div class="input-group">
                <input type="text" class="form-control" disabled value="<?= $apikey ?>">
                <div class="input-group-append">
                    <button class="btn btn-outline-success" type="button" onclick="window.location.href='setting.php?action=api_reset&token=<?= LoginAuth::genToken() ?>'">
						<?= lang('api_key_reset') ?>
                    </button>
                </div>
            </div>
            <div class="form-group mt-3">
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
                <input type="submit" value="<?= lang('save_settings') ?>" class="btn btn-sm btn-success"/>
            </div>
        </form>
        <div class="alert alert-warning">
            <b><?= lang('api_list') ?>:</b><br>
			<?= lang('api_1') ?><br>
			<?= lang('api_2') ?><br>
			<?= lang('api_3') ?><br>
			<?= lang('api_4') ?><br>
			<?= lang('api_5') ?><br><br>
			<?= lang('api_more') ?>: <a href="https://www.emlog.net/docs/#/api" target="_blank" class="small"><?= lang('api_docs') ?></a>
        </div>
    </div>
</div>
<script>
    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('show');
    $("#menu_setting").addClass('active');
    setTimeout(hideActived, 2600);
</script>
