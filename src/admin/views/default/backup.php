<?php if(!defined('ADMIN_ROOT')) {exit('error!');} ?>
<script>setTimeout(hideActived,2600);</script>
<div class=containertitle><b>数据库备份</b>
<?php if(isset($_GET['active_del'])):?><span class="actived">备份文件删除成功</span><?php endif;?>
<?php if(isset($_GET['active_backup'])):?><span class="actived">数据备份成功</span><?php endif;?>
<?php if(isset($_GET['active_import'])):?><span class="actived">备份导入成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">请选择要删除的备份文件</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">错误的备份文件名</span><?php endif;?>
</div>
<div class=line></div>
<script type='text/javascript'>
$(document).ready(function(){
	$("#adm_bakdata_list tbody tr:odd").addClass("tralt_b");
	$("#adm_bakdata_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")})
});
</script>
<form  method="post" action="backup.php?action=dell_all_bak">
<table width="95%" id="adm_bakdata_list">
  <thead>
    <tr class="rowstop">
      <td width="22"><input onclick="CheckAll(this.form)" type="checkbox" value="on" name="chkall" /></td>
      <td width="661"><b>备份文件</b></td>
      <td width="226"><b>备份时间</b></td>
      <td width="149"><b>文件大小</b></td>
      <td width="87"></td>
    </tr>
  </head>
  <tbody>
	<?php 
		foreach($bakfiles  as $value):
		$modtime = date('Y-m-d H:i:s',filemtime($value));
		$size =  changeFileSize(filesize($value));
		$bakname = substr(strrchr($value,'/'),1);
	?>
    <tr>
      <td><input type="checkbox" value="<?php echo $value; ?>" name="bak[<?php echo $value; ?>]" /></td>
      <td><a href="../content/backup/<?php echo $bakname; ?>"><?php echo $bakname; ?></a></td>
      <td><?php echo $modtime; ?></td>
      <td><?php echo $size; ?></td>
      <td><a href="javascript: em_confirm('<?php echo $value; ?>', 'backup');">导入</a></td>
    </tr>
	<?php endforeach; ?>
	</tbody>
	<tfoot>
	<tr>
	<td align="center" colspan="5">
	<input type="submit" value="删除所选备份" class="submit2" />
	</td>
	</tr>
	</tfoot>
</table>
</form>
<div class=line></div>
<form action="backup.php?action=bakstart" method="post">
<table width="95%" align="center" border="0">
    <tbody>
      <tr>
        <td valign="top" width="65">选择要备份的数据库表:<br /></td>
        <td width="608">
        <select multiple="multiple" size="12" name="table_box[]">
		<?php foreach($tables  as $value): ?>
		<option value="<?php echo DB_PREFIX; ?><?php echo $value; ?>" selected="selected"><?php echo DB_PREFIX; ?><?php echo $value; ?></option>
		<?php endforeach; ?>	  
      	</select>
      	</td>
      </tr>
      <tr>
        <td align="left" width="65">备份文件名:</td>
        <td valign="top">	  
		<input maxlength="200" size="35" value="<?php echo $defname; ?>" name="bakfname" /><b>.sql</b>
		<span class="care">文件名只能由英文字母、数字、下划线组成</span>
		</td>
      </tr>      
      <tr>
        <td align="left" width="65"></td>
        <td valign="top">	  
		<input type="submit" value="开始备份" class="submit2" />
        </td>
      </tr>
    </tbody>
</table>
</form>