<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['active_backup'])): ?>
    <div class="alert alert-success"><?php _lang('backup_success'); ?></div><?php endif ?>
<?php if (isset($_GET['active_import'])): ?>
    <div class="alert alert-success"><?php _lang('import_success'); ?></div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger"><?php _lang('select_backup_to_delete'); ?></div><?php endif ?>
<?php if (isset($_GET['error_b'])): ?>
    <div class="alert alert-danger"><?php _lang('backup_filename_error'); ?></div><?php endif ?>
<?php if (isset($_GET['error_c'])): ?>
    <div class="alert alert-danger"><?php _lang('zip_not_support_import'); ?></div><?php endif ?>
<?php if (isset($_GET['error_d'])): ?>
    <div class="alert alert-danger"><?php _lang('upload_backup_error'); ?></div><?php endif ?>
<?php if (isset($_GET['error_e'])): ?>
    <div class="alert alert-danger"><?php _lang('invalid_backup_file'); ?></div><?php endif ?>
<?php if (isset($_GET['error_f'])): ?>
    <div class="alert alert-danger"><?php _lang('zip_not_support_export'); ?></div><?php endif ?>
<?php if (isset($_GET['active_mc'])): ?>
    <div class="alert alert-success"><?php _lang('cache_update_success'); ?></div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800"><?php _lang('data'); ?></h1>
</div>
<div class="card-deck">
    <div class="card">
        <h5 class="card-header"><?php _lang('backup_db'); ?></h5>
        <div class="card-body">
            <div id="backup">
                <p><?php _lang('backup_db_desc'); ?></p>
            </div>
        </div>
        <div class="card-footer">
            <form action="data.php?action=backup" method="post" class="text-right">
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                <input type="submit" value="<?php _lang('start_backup'); ?>" class="btn btn-sm btn-success" />
            </form>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header"><?php _lang('import_backup'); ?></h5>
        <form action="data.php?action=import" enctype="multipart/form-data" method="post">
            <div class="card-body">
                <div id="import">
                    <p class="des"><?php _lang('import_backup_desc'); ?></p>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="sqlfile" id="sqlfile" required>
                    <label class="custom-file-label" for="sqlfile"><?php _lang('select_backup_file'); ?></label>
                </div>
                <small class="form-text text-muted mt-2">
                    <?php _lang('select_backup_file_desc'); ?><?= DB_PREFIX ?>
                </small>
            </div>
            <div class="card-footer text-right">
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                <input type="submit" value="<?php _lang('import_backup'); ?>" class="btn btn-sm btn-success" />
            </div>
        </form>
    </div>
    <div class="card">
        <h5 class="card-header"><?php _lang('update_cache'); ?></h5>
        <div class="card-body">
            <div id="cache">
                <p class="des"><?php _lang('cache_desc'); ?></p>
            </div>
        </div>
        <div class="card-footer text-right">
            <input type="button" onclick="window.location='data.php?action=Cache';" value="<?php _lang('update_cache'); ?>" class="btn btn-sm btn-success" />
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
            $(this).next('.custom-file-label').text(fileName || '<?php _lang('select_backup_file'); ?>');
        });
    });
</script>