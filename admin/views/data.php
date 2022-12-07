<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_del'])): ?>
    <div class="alert alert-success"><?= lang('backup_delete_ok') ?></div><?php endif ?>
<?php if (isset($_GET['active_backup'])): ?>
    <div class="alert alert-success"><?= lang('backup_create_ok') ?></div><?php endif ?>
<?php if (isset($_GET['active_import'])): ?>
    <div class="alert alert-success"><?= lang('backup_import_ok') ?></div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger"><?= lang('backup_file_select') ?></div><?php endif ?>
<?php if (isset($_GET['error_b'])): ?>
    <div class="alert alert-danger"><?= lang('backup_file_invalid') ?></div><?php endif ?>
<?php if (isset($_GET['error_c'])): ?>
    <div class="alert alert-danger"><?= lang('backup_import_zip_unsupported') ?></div><?php endif ?>
<?php if (isset($_GET['error_d'])): ?>
    <div class="alert alert-danger"><?= lang('backup_upload_failed') ?></div><?php endif ?>
<?php if (isset($_GET['error_e'])): ?>
    <div class="alert alert-danger"><?= lang('backup_file_wrong') ?></div><?php endif ?>
<?php if (isset($_GET['error_f'])): ?>
    <div class="alert alert-danger"><?= lang('backup_export_zip_unsupported') ?></div><?php endif ?>
<?php if (isset($_GET['active_mc'])): ?>
    <div class="alert alert-success"><?= lang('cache_update_ok') ?></div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= lang('data_backup') ?></h1>
</div>
<div class="card-deck">
    <div class="card">
        <h5 class="card-header"><?= lang('db_backup') ?></h5>
        <div class="card-body">
            <form action="data.php?action=backup" method="post">
                <div id="backup">
                    <p><?= lang('backup_prompt') ?></p>
                    <p id="local_bakzip"><?= lang('compress_zip') ?>: <input type="checkbox" style="vertical-align:middle;" value="y" name="zipbak" id="zipbak"></p>
                    <p>
                        <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
                        <input type="submit" value="<?= lang('backup_start') ?>" class="btn btn-sm btn-success"/>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header"><?= lang('backup_import_local') ?></h5>
        <div class="card-body">
            <form action="data.php?action=import" enctype="multipart/form-data" method="post">
                <div id="import">
                    <p class="des"><?= lang('backup_version_tip') ?> <?= DB_PREFIX ?></p>
                    <p>
                        <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
                        <input type="file" name="sqlfile" required/>
                        <input type="submit" value="<?= lang('import') ?>" class="btn btn-sm btn-success"/>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header"><?= lang('cache_update') ?></h5>
        <div class="card-body">
            <div id="cache">
                <p class="des"><?= lang('cache_update_info') ?></p>
                <p><input type="button" onclick="window.location='data.php?action=Cache';" value="<?= lang('cache_update') ?>" class="btn btn-sm btn-success"></p>
            </div>
        </div>
    </div>
</div>
<script>
    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('show');
    $("#menu_data").addClass('active');
    setTimeout(hideActived, 2600);
</script>
