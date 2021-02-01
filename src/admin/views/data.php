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
<div class="container-fluid">
    <!-- Page Heading -->
<!--vot--><h1 class="h3 mb-4 text-gray-800"><?=lang('data_backup')?></h1>
    <form method="post" action="data.php?action=dell_all_bak" name="form_bak" id="form_bak">
        <table class="table table-striped table-bordered table-hover dataTable no-footer">
            <thead>
            <tr>
<!--vot-->      <th width="683" colspan="2"><b><?=lang('backup_file')?></b></th>
<!--vot-->      <th width="226"><b><?=lang('backup_time')?></b></th>
<!--vot-->      <th width="149"><b><?=lang('file_size')?></b></th>
                <th width="87"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($bakfiles):
                foreach ($bakfiles as $value):
                    $modtime = smartDate(filemtime($value), 'Y-m-d H:i:s');
                    $size = changeFileSize(filesize($value));
                    $bakname = substr(strrchr($value, '/'), 1);
                    ?>
                    <tr>
                        <td width="22"><input type="checkbox" value="<?php echo $value; ?>" name="bak[]" class="ids"/></td>
                        <td width="661"><a href="../content/backup/<?php echo $bakname; ?>"><?php echo $bakname; ?></a></td>
                        <td><?php echo $modtime; ?></td>
                        <td><?php echo $size; ?></td>
<!--vot-->              <td><a href="javascript: em_confirm('<?= $value ?>', 'backup', '<?= LoginAuth::genToken() ?>');"><?=lang('import')?></a></td>
                    </tr>
                <?php endforeach; else:?>
                <tr>
<!--vot-->          <td class="tdcenter" colspan="5"><?=lang('backup_no')?></td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
        <div class="list_footer">
<!--vot-->  <a href="javascript:void(0);" id="select_all"><?=lang('select_all')?></a> <?=lang('selected_items')?>: <a href="javascript:bakact('del');" class="care"><?=lang('delete')?></a></div>
    </form>

    <div style="margin:50px 0px 20px 0px;">
<!--vot--><a href="javascript:$('#import').hide();$('#cache').hide();displayToggle('backup', 0);" style="margin-right: 16px;"><?=lang('db_backup')?>+</a>
<!--vot--><a href="javascript:$('#backup').hide();$('#cache').hide();displayToggle('import', 0);" style="margin-right: 16px;"><?=lang('backup_import_local')?>+</a>
<!--vot--><a href="javascript:$('#backup').hide();$('#import').hide();displayToggle('cache', 0);" style="margin-right: 16px;"><?=lang('cache_update')?>+</a>
    </div>

    <form action="data.php?action=bakstart" method="post">
        <div id="backup">
<!--vot-->  <p><?=lang('backup_choose_table')?>:<br>
                <select multiple="multiple" size="12" name="table_box[]">
                    <?php foreach ($tables as $value): ?>
                        <option value="<?php echo DB_PREFIX; ?><?php echo $value; ?>" selected="selected"><?php echo DB_PREFIX; ?><?php echo $value; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
<!--vot-->  <p><?=lang('backup_export_to')?>:
                <select name="bakplace" id="bakplace">
<!--vot-->          <option value="local" selected="selected"><?=lang('backup_local')?></option>
<!--vot-->          <option value="server"><?=lang('backup_server')?></option>
                </select>
            </p>
<!--vot-->  <p id="local_bakzip"><?=lang('compress_zip')?>: <input type="checkbox" style="vertical-align:middle;" value="y" name="zipbak" id="zipbak"></p>
            <p>
                <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
<!--vot-->      <input type="submit" value="<?=lang('backup_start')?>" class="btn btn-primary">
            </p>
        </div>
    </form>

    <form action="data.php?action=import" enctype="multipart/form-data" method="post">
        <div id="import">
<!--vot-->  <p class="des"><?=lang('backup_version_tip')?><?= DB_PREFIX ?></p>
            <p>
                <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
<!--vot-->      <input type="file" name="sqlfile"> <input type="submit" value="<?=lang('import')?>" class="submit">
            </p>
        </div>
    </form>

    <div id="cache">
<!--vot--><p class="des"><?=lang('cache_update_info')?></p>
<!--vot--><p><input type="button" onclick="window.location='data.php?action=Cache';" value="<?=lang('cache_update')?>" class="btn btn-primary"></p>
    </div>
</div>
<!-- /.container-fluid -->
<script>
    setTimeout(hideActived, 2600);
    $(document).ready(function () {
        selectAllToggle();
        $("#bakplace").change(function () {
            $("#server_bakfname").toggle();
            $("#local_bakzip").toggle();
        });
    });

    function bakact(act) {
        if (getChecked('ids') == false) {
/*vot*/     alert('<?=lang('backup_file_select')?>');
            return;
        }
/*vot*/ if (act == 'del' && !confirm('<?=lang('backup_delete_sure')?>')) {
            return;
        }
        $("#operate").val(act);
        $("#form_bak").submit();
    }

    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('in');
    $("#menu_data").addClass('active');
</script>
