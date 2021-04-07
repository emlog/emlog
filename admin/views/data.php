<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_del'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('backup_delete_ok')?></div><?php endif; ?>
<?php if (isset($_GET['active_backup'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('backup_create_ok')?></div><?php endif; ?>
<?php if (isset($_GET['active_import'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('backup_import_ok')?></div><?php endif; ?>
<?php if (isset($_GET['error_a'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('backup_file_select')?></div><?php endif; ?>
<?php if (isset($_GET['error_b'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('backup_file_invalid')?></div><?php endif; ?>
<?php if (isset($_GET['error_c'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('backup_import_zip_unsupported')?></div><?php endif; ?>
<?php if (isset($_GET['error_d'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('backup_upload_failed')?></div><?php endif; ?>
<?php if (isset($_GET['error_e'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('backup_file_wrong')?></div><?php endif; ?>
<?php if (isset($_GET['error_f'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('backup_export_zip_unsupported')?></div><?php endif; ?>
<?php if (isset($_GET['active_mc'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('cache_update_ok')?></div><?php endif; ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?=lang('data_backup')?></h1>
</div>
<div class="card-deck">
    <div class="card">
        <div class="card-body">
<!--vot-->  <h5 class="card-title"><?=lang('data_backup')?></h5>
            <form action="data.php?action=bakstart" method="post">
                <div id="backup">
<!--vot-->          <p><?=lang('backup_prompt')?></p>
<!--vot-->          <p id="local_bakzip"><?=lang('compress_zip')?>: <input type="checkbox" style="vertical-align:middle;" value="y" name="zipbak" id="zipbak"></p>
                    <p>
                        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
<!--vot-->              <input type="submit" value="<?=lang('backup_start')?>" class="btn btn-success"/>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
<!--vot-->  <h5 class="card-title"><?=lang('backup_import_local')?></h5>
            <form action="data.php?action=import" enctype="multipart/form-data" method="post">
                <div id="import">
<!--vot-->          <p class="des"><?=lang('backup_version_tip')?> <?php echo DB_PREFIX; ?></p>
                    <p>
                        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
<!--vot-->              <input type="file" name="sqlfile"/> <input type="submit" value="<?=lang('import')?>" class="submit"/>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
<!--vot-->  <h5 class="card-title"><?=lang('cache_update')?></h5>
            <div id="cache">
<!--vot-->      <p class="des"><?=lang('cache_update_info')?></p>
<!--vot-->      <p><input type="button" onclick="window.location='data.php?action=Cache';" value="<?=lang('cache_update')?>" class="btn btn-success"></p>
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
