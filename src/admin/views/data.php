<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<section class="content-header">
    <h1>数据库备份</h1>
    <div class="containertitle">
    <?php if(isset($_GET['active_del'])):?><span class="alert alert-success">备份文件删除成功</span><?php endif;?>
    <?php if(isset($_GET['active_backup'])):?><span class="alert alert-success">数据备份成功</span><?php endif;?>
    <?php if(isset($_GET['active_import'])):?><span class="alert alert-success">备份导入成功</span><?php endif;?>
    <?php if(isset($_GET['error_a'])):?><span class="alert alert-danger">请选择要删除的备份文件</span><?php endif;?>
    <?php if(isset($_GET['error_b'])):?><span class="alert alert-danger">备份文件名错误(应由英文字母、数字、下划线组成)</span><?php endif;?>
    <?php if(isset($_GET['error_c'])):?><span class="alert alert-danger">服务器空间不支持zip，无法导入zip备份</span><?php endif;?>
    <?php if(isset($_GET['error_d'])):?><span class="alert alert-danger">上传备份失败</span><?php endif;?>
    <?php if(isset($_GET['error_e'])):?><span class="alert alert-danger">错误的备份文件</span><?php endif;?>
    <?php if(isset($_GET['error_f'])):?><span class="alert alert-danger">服务器空间不支持zip，无法导出zip备份</span><?php endif;?>
    <?php if(isset($_GET['active_mc'])):?><span class="alert alert-success">缓存更新成功</span><?php endif;?>
    </div>
</section>
<section class="content">
<form  method="post" action="data.php?action=dell_all_bak" name="form_bak" id="form_bak">
<table class="table table-striped table-bordered table-hover dataTable no-footer">
  <thead>
    <tr>
<!--vot--><th width="683" colspan="2"><b><?=lang('backup_file')?></b></th>
<!--vot--><th width="226"><b><?=lang('backup_time')?></b></th>
<!--vot--><th width="149"><b><?=lang('file_size')?></b></th>
      <th width="87"></th>
    </tr>
  </thead>
  <tbody>
    <?php
        if($bakfiles):
        foreach($bakfiles  as $value):
        $modtime = smartDate(filemtime($value),'Y-m-d H:i:s');
        $size =  changeFileSize(filesize($value));
        $bakname = substr(strrchr($value,'/'),1);
    ?>
    <tr>
      <td width="22"><input type="checkbox" value="<?php echo $value; ?>" name="bak[]" class="ids" /></td>
      <td width="661"><a href="../content/backup/<?php echo $bakname; ?>"><?php echo $bakname; ?></a></td>
      <td><?php echo $modtime; ?></td>
      <td><?php echo $size; ?></td>
<!--vot--><td><a href="javascript: em_confirm('<?php echo $value; ?>', 'backup', '<?php echo LoginAuth::genToken(); ?>');"><?=lang('import')?></a></td>
    </tr>
    <?php endforeach;else:?>
<!--vot--><tr><td class="tdcenter" colspan="5"><?=lang('backup_no')?></td></tr>
    <?php endif;?>
    </tbody>
</table>
<div class="list_footer">
<!--vot--><a href="javascript:void(0);" id="select_all"><?=lang('select_all')?></a> <?=lang('selected_items')?>: <a href="javascript:bakact('del');" class="care"><?=lang('delete')?></a></div>
</form>

<div style="margin:50px 0px 20px 0px;">
<!--vot--><a href="javascript:$('#import').hide();$('#cache').hide();displayToggle('backup', 0);" style="margin-right: 16px;"><?=lang('db_backup')?>+</a> 
<!--vot--><a href="javascript:$('#backup').hide();$('#cache').hide();displayToggle('import', 0);" style="margin-right: 16px;"><?=lang('backup_import_local')?>+</a> 
<!--vot--><a href="javascript:$('#backup').hide();$('#import').hide();displayToggle('cache', 0);" style="margin-right: 16px;"><?=lang('cache_update')?>+</a>
</div>

<form action="data.php?action=bakstart" method="post">
<div id="backup">
<!--vot--><p><?=lang('backup_choose_table')?>:<br />
        <select multiple="multiple" size="12" name="table_box[]">
        <?php foreach($tables  as $value): ?>
        <option value="<?php echo DB_PREFIX; ?><?php echo $value; ?>" selected="selected"><?php echo DB_PREFIX; ?><?php echo $value; ?></option>
        <?php endforeach; ?>
        </select>
    </p>
<!--vot--><p><?=lang('backup_export_to')?>:
        <select name="bakplace" id="bakplace">
<!--vot-->    <option value="local" selected="selected"><?=lang('backup_local')?></option>
<!--vot-->    <option value="server"><?=lang('backup_server')?></option>
        </select>
    </p>
<!--vot--><p id="local_bakzip"><?=lang('compress_zip')?>: <input type="checkbox" style="vertical-align:middle;" value="y" name="zipbak" id="zipbak"></p>
    <p>
        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
        <input type="submit" value="开始备份" class="btn btn-primary" />
    </p>
</div>
</form>

<form action="data.php?action=import" enctype="multipart/form-data" method="post">
<div id="import">
<!--vot--><p class="des"><?=lang('backup_version_tip')?><?php echo DB_PREFIX; ?></p>
    <p>
        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
<!--vot--><input type="file" name="sqlfile" /> <input type="submit" value="<?=lang('import')?>" class="button" />
    </p>
</div>
</form>

<div id="cache">
<!--vot--><p class="des"><?=lang('cache_update_info')?></p>
<!--vot--><p><input type="button" onclick="window.location='data.php?action=Cache';" value="<?=lang('cache_update')?>" class="btn btn-primary" /></p>
</div>
</section>
<script>
setTimeout(hideActived,2600);
$(document).ready(function(){
    selectAllToggle();
    $("#adm_bakdata_list tbody tr:odd").addClass("tralt_b");
    $("#adm_bakdata_list tbody tr")
        .mouseover(function(){$(this).addClass("trover")})
        .mouseout(function(){$(this).removeClass("trover")});
    $("#bakplace").change(function(){$("#server_bakfname").toggle();$("#local_bakzip").toggle();});
});
function bakact(act){
    if (getChecked('ids') == false) {
/*vot*/ alert('<?=lang('backup_file_select')?>');
        return;
    }
/*vot*/ if(act == 'del' && !confirm('<?=lang('backup_delete_sure')?>')){return;}
    $("#operate").val(act);
    $("#form_bak").submit();
}
$("#menu_data").addClass('active').parent().parent().addClass('active');
</script>
