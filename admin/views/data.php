<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?= FlashMsg::renderDataAlerts(); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800"><?= _lang('data'); ?></h1>
</div>
<div class="card-deck">
    <div class="card">
        <h5 class="card-header"><?= _lang('backup_db'); ?></h5>
        <div class="card-body">
            <div id="backup">
                <p><?= _lang('backup_db_desc'); ?></p>
            </div>
        </div>
        <div class="card-footer">
            <form action="data.php?action=backup" method="post" class="text-right">
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                <input type="submit" value="<?= _lang('start_backup'); ?>" class="btn btn-sm btn-success" />
            </form>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header"><?= _lang('import_backup'); ?></h5>
        <form action="data.php?action=import" enctype="multipart/form-data" method="post" style="display: flex; flex-direction: column; flex-grow: 1;">
            <div class="card-body">
                <div id="import">
                    <p class="des"><?= _lang('import_backup_desc'); ?></p>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="sqlfile" id="sqlfile" required>
                    <label class="custom-file-label" for="sqlfile"><?= _lang('select_backup_file'); ?></label>
                </div>
                <small class="form-text text-muted mt-2">
                    <?= _lang('select_backup_file_desc'); ?><?= DB_PREFIX ?>
                </small>
            </div>
            <div class="card-footer text-right">
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                <input type="submit" value="<?= _lang('import_backup'); ?>" class="btn btn-sm btn-success" />
            </div>
        </form>
    </div>
    <div class="card">
        <h5 class="card-header"><?= _lang('data_repair'); ?></h5>
        <div class="card-body">
            <p class="des text-muted"><?= _lang('data_repair_desc'); ?></p>
            <div>
                <?= _lang('data_repair_features'); ?>
            </div>
        </div>
        <div class="card-footer text-right">
            <a href="store.php?keyword=工具箱" class="btn btn-sm btn-success"><?= _lang('get_toolbox_plugin'); ?></a>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header"><?= _lang('update_cache'); ?></h5>
        <div class="card-body">
            <div id="cache">
                <p class="des"><?= _lang('cache_desc'); ?></p>
            </div>
        </div>
        <div class="card-footer text-right">
            <input type="button" onclick="window.location='data.php?action=Cache';" value="<?= _lang('update_cache'); ?>" class="btn btn-sm btn-success" />
        </div>
    </div>
</div>

<script>
    $(function() {
        $("#menu_category_sys").addClass('active');
        $("#menu_sys").addClass('show');
        $("#menu_data").addClass('active');
        setTimeout(hideActived, 3600);

        // 监听备份文件上传
        $('#sqlfile').on('change', function() {
            var fileName = $(this).get(0).files[0] ? $(this).get(0).files[0].name : '';
            $(this).next('.custom-file-label').text(fileName || '<?= _lang('select_backup_file'); ?>');
        });
    });
</script>