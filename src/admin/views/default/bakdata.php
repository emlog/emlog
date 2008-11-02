<?php if(!defined('ADMIN_ROOT')) {exit('error!');} ?>
<div class=containertitle><b>数据库备份</b></div>
<div class=line></div>
<script type='text/javascript'>
$(document).ready(function(){
	$("#adm_bakdata_list tbody tr:odd").addClass("tralt_b");
	$("#adm_bakdata_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")})
});
</script>
<form  method="post" action="backupdata.php?action=dell_all_bak">
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
      <td><a href="./bakup/<?php echo $bakname; ?>"><?php echo $bakname; ?></a></td>
      <td><?php echo $modtime; ?></td>
      <td><?php echo $size; ?></td>
      <td><a href="javascript: isdel('<?php echo $value; ?>', 5);">导入</a></td>
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
<form action="backupdata.php?action=bakstart" method="post">
<table width="95%" align="center" border="0">
    <tbody>
      <tr>
        <td valign="top" width="65">选择要备份的数据库表:<br /></td>
        <td width="608">
        <select multiple="multiple" size="11" name="table_box[]">
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