<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div class=containertitle><b><? echo $lang['backup_database'];?></b>
<?php if(isset($_GET['active_del'])):?><span class="actived"><? echo $lang['backup_deleted_ok'];?></span><?php endif;?>
<?php if(isset($_GET['active_backup'])):?><span class="actived"><? echo $lang['backup_saved_ok'];?></span><?php endif;?>
<?php if(isset($_GET['active_import'])):?><span class="actived"><? echo $lang['backup_imported_ok'];?></span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error"><? echo $lang['backup_select_file'];?></span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error"><? echo $lang['backup_filename_invalid'];?></span><?php endif;?>
</div>
<div class=line></div>
<form  method="post" action="data.php?action=dell_all_bak" name="form_bak" id="form_bak">
<table width="100%" id="adm_bakdata_list" class="item_list">
  <thead>
    <tr>
      <th width="22"><input onclick="CheckAll(this.form)" type="checkbox" value="on" name="chkall" /></th>
      <th width="661"><b><? echo $lang['backup_file'];?></b></th>
      <th width="226"><b><? echo $lang['backup_time'];?></b></th>
      <th width="149"><b><? echo $lang['backup_size'];?></b></th>
      <th width="87"></th>
    </tr>
  </head>
  <tbody>
	<?php
		foreach($bakfiles  as $value):
		$modtime = smartDate(filemtime($value),'Y-m-d H:i:s');
		$size =  changeFileSize(filesize($value));
		$bakname = substr(strrchr($value,'/'),1);
	?>
    <tr>
      <td><input type="checkbox" value="<?php echo $value; ?>" name="bak[]" class="ids" /></td>
      <td><a href="../content/backup/<?php echo $bakname; ?>"><?php echo $bakname; ?></a></td>
      <td><?php echo $modtime; ?></td>
      <td><?php echo $size; ?></td>
      <td><a href="javascript: em_confirm('<?php echo $value; ?>', 'backup');"><? echo $lang['backup_import'];?></a></td>
    </tr>
	<?php endforeach; ?>
	</tbody>
</table>
<div class="list_footer"><? echo $lang['with_selected_do'];?>: <a href="javascript:bakact('del');"><? echo $lang['remove'];?></a></div>
</form>
<form action="data.php?action=bakstart" method="post">
<div style="margin:20px 0px 20px 0px;"><a href="javascript:displayToggle('backup', 0);"><? echo $lang['backup_info'];?> &raquo;</a></div>
<div id="backup">
	<p><? echo $lang['backup_choose_database'];?>:<br /><select multiple="multiple" size="11" name="table_box[]">
		<?php foreach($tables  as $value): ?>
		<option value="<?php echo DB_PREFIX; ?><?php echo $value; ?>" selected="selected"><?php echo DB_PREFIX; ?><?php echo $value; ?></option>
		<?php endforeach; ?>
      	</select></p>
	<p><? echo $lang['backup_filename'];?>: (<? echo $lang['backup_filename_info'];?>) <br /><input maxlength="200" size="35" value="<?php echo $defname; ?>" name="bakfname" /><b>.sql</b></p>
	<p><? echo $lang['backup_place'];?>?
	<? echo $lang['backup_local'];?><input type="radio" checked="checked" value="local" name="bakplace" id="bakup_place" />
	<? echo $lang['backup_server'];?><input type="radio" value="server" name="bakplace" id="bakup_place" /></p>
	<p><input type="submit" value="<? echo $lang['backup_start'];?>" class="submit" /></p>
</div>
</form>
<div class=containertitle><b><? echo $lang['cache'];?></b>
<?php if(isset($_GET['active_mc'])):?><span class="actived"><? echo $lang['cache_updated_ok'];?></span><?php endif;?>
</div>
<div class=line></div>
<div style="margin:0px 0px 20px 0px;">
	<p class="des"><? echo $lang['cache_info'];?></p>
	<p style="margin-left:10px;"><input type="button" onclick="window.location='data.php?action=mkcache';" value="<? echo $lang['cache_rebuild'];?>" class="submit" /></p>
</div>
<script type='text/javascript'>
setTimeout(hideActived,2600);
$(document).ready(function(){
	$("#adm_bakdata_list tbody tr:odd").addClass("tralt_b");
	$("#adm_bakdata_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")})
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