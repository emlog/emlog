<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div class=containertitle><b><? echo $lang['backup_database'];?></b>
<?php if(isset($_GET['active_del'])):?><span class="actived"><? echo $lang['backup_deleted_ok'];?></span><?php endif;?>
<?php if(isset($_GET['active_backup'])):?><span class="actived"><? echo $lang['backup_saved_ok'];?></span><?php endif;?>
<?php if(isset($_GET['active_import'])):?><span class="actived"><? echo $lang['backup_imported_ok'];?></span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error"><? echo $lang['backup_select_file'];?></span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error"><? echo $lang['backup_filename_invalid'];?></span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="error"><? echo $lang['server_zip_nosupport']; ?></span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="error"><? echo $lang['backup_upload_error']; ?></span><?php endif;?>
<?php if(isset($_GET['error_e'])):?><span class="error"><? echo $lang['backup_filename_invalid']; ?></span><?php endif;?>
<?php if(isset($_GET['error_f'])):?><span class="error"><? echo $lang['zip_export_error']; ?></span><?php endif;?>
<?php if(isset($_GET['active_mc'])):?><span class="actived">缓存更新成功</span><?php endif;?>
</div>
<div class=line></div>
<form  method="post" action="data.php?action=dell_all_bak" name="form_bak" id="form_bak">
<table width="100%" id="adm_bakdata_list" class="item_list">
  <thead>
    <tr>
      <th width="683" colspan="2"><b><? echo $lang['backup_file']; ?></b></th>
      <th width="226"><b><? echo $lang['backup_time'];?></b></th>
      <th width="149"><b><? echo $lang['backup_size'];?></b></th>
      <th width="87"></th>
    </tr>
  </head>
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
      <td><a href="javascript: em_confirm('<?php echo $value; ?>', 'backup', '<?php echo LoginAuth::genToken(); ?>');"><? echo $lang['backup_import'];?></a></td>
    </tr>
	<?php endforeach;else:?>
	  <tr><td class="tdcenter" colspan="5"><? echo $lang['no_backups_yet']; ?></td></tr>
	<?php endif;?>
	</tbody>
</table>
<div class="list_footer">
<a href="javascript:void(0);" id="select_all"><? echo $lang['select all']; ?></a> <? echo $lang['with_selected_do']; ?>: <a href="javascript:bakact('del');" class="care"><? echo $lang['remove']; ?></a></div>
</form>
<div style="margin:50px 0px 20px 0px;">
    <a href="javascript:$('#import').hide();$('#cache').hide();displayToggle('backup', 0);" style="margin-right: 16px;"><? echo $lang['backup_info'];?>+</a> 
    <a href="javascript:$('#backup').hide();$('#cache').hide();displayToggle('import', 0);" style="margin-right: 16px;"><? echo $lang['backup_local_file']; ?>+</a> 
    <a href="javascript:$('#backup').hide();$('#import').hide();displayToggle('cache', 0);" style="margin-right: 16px;">更新缓存+</a>
</div>

<form action="data.php?action=bakstart" method="post">
<div id="backup">
	<p><? echo $lang['backup_choose_database'];?>:<br />
        <select multiple="multiple" size="12" name="table_box[]">
		<?php foreach($tables  as $value): ?>
		<option value="<?php echo DB_PREFIX; ?><?php echo $value; ?>" selected="selected"><?php echo DB_PREFIX; ?><?php echo $value; ?></option>
		<?php endforeach; ?>
      	</select>
	</p>
	<p><? echo $lang['backup_export_to']; ?>:
        <select name="bakplace" id="bakplace">
		<option value="local" selected="selected"><? echo $lang['backup_local']; ?></option>
		<option value="server"><? echo $lang['backup_server']; ?></option>
        </select>
    </p>
	<p id="local_bakzip"><? echo $lang['backup_compress']; ?>: <input type="checkbox" style="vertical-align:middle;" value="y" name="zipbak" id="zipbak"></p>
	<p id="server_bakfname" style="display:none;"><? echo $lang['backup_filename']; ?>: <input maxlength="200" size="35" value="<?php echo $defname; ?>" name="bakfname" /><b>.sql</b></p>
	<p><input type="submit" value="<? echo $lang['backup_start']; ?>" class="button" /></p>
</div>
</form>

<form action="data.php?action=import" enctype="multipart/form-data" method="post">
<div id="import">
    <p class="des">仅可导入相同版本emlog导出的数据库备份文件，且数据库表前缀需保持一致。<br />当前数据库表前缀：<?php echo DB_PREFIX; ?></p>
	<p>
        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
        <input type="file" name="sqlfile" /> <input type="submit" value="导入" class="submit" />
    </p>
</div>
</form>

<div id="cache">
	<p class="des">缓存可以加快站点的加载速度。通常系统会自动更新缓存，无需手动。有些特殊情况，比如缓存文件被修改、手动修改过数据库、页面出现异常等才需要手动更新。</p>
	<p><input type="button" onclick="window.location='data.php?action=Cache';" value="<? echo $lang['cache_rebuild'];?>" class="button" /></p>
</div>

<script>
setTimeout(hideActived,2600);
$(document).ready(function(){
	$("#select_all").toggle(function () {$(".ids").attr("checked", "checked");},function () {$(".ids").removeAttr("checked");});
	$("#adm_bakdata_list tbody tr:odd").addClass("tralt_b");
	$("#adm_bakdata_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")});
	$("#bakplace").change(function(){$("#server_bakfname").toggle();$("#local_bakzip").toggle();});
});
function bakact(act){
	if (getChecked('ids') == false) {
		alert('<? echo $lang['backup_select_file'];?>');
		return;
	}
	if(act == 'del' && !confirm('<? echo $lang['backup_delete_sure'];?>')){return;}
	$("#operate").val(act);
	$("#form_bak").submit();
}
$("#menu_data").addClass('sidebarsubmenu1');
</script>