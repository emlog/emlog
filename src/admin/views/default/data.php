<?php if(!defined('ADMIN_ROOT')) {exit('error!');} ?>
<div class=containertitle><b>数据备份</b>
<?php if(isset($_GET['active_del'])):?><span class="actived">备份文件删除成功</span><?php endif;?>
<?php if(isset($_GET['active_backup'])):?><span class="actived">数据备份成功</span><?php endif;?>
<?php if(isset($_GET['active_import'])):?><span class="actived">备份导入成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">请选择要删除的备份文件</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">错误的备份文件名</span><?php endif;?>
</div>
<div class=line></div>
<form  method="post" action="data.php?action=dell_all_bak">
<table width="100%" id="adm_bakdata_list">
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
    <br />
	<input type="submit" value="删除所选备份" class="submit" />
	</td>
	</tr>
	</tfoot>
</table>
</form>
<form action="data.php?action=bakstart" method="post">
<div style="margin:0px 0px 20px 3px;"><a href="javascript:displayToggle('backup', 0);">备份数据&raquo;</a></div>
<div id="backup" style="display:none;margin:0px 0px 20px 20px;">
	<li>选择要备份的数据库表：</li>
	<li><select multiple="multiple" size="12" name="table_box[]">
		<?php foreach($tables  as $value): ?>
		<option value="<?php echo DB_PREFIX; ?><?php echo $value; ?>" selected="selected"><?php echo DB_PREFIX; ?><?php echo $value; ?></option>
		<?php endforeach; ?>	  
      	</select></li>
	<li>备份文件名：<span class="care">(由英文字母、数字、下划线组成)</span></li>
	<li><input maxlength="200" size="35" value="<?php echo $defname; ?>" name="bakfname" /><b>.sql</b></li>
	<p><input type="submit" value="开始备份" class="submit" /></p>
</div>
</form>
<div class=containertitle><b>数据缓存</b>
<?php if(isset($_GET['active_mc'])):?><span class="actived">缓存更新成功</span><?php endif;?>
</div>
<div class=line></div>
<div style="margin:0px 0px 20px 20px;">
	<p class="notice">缓存技术可以大幅度加快你博客首页的加载速度。<br>通常系统会自动更新缓存，但也有些特殊情况需要你手动更新，比如缓存文件被无意修改、你手动修改过数据库等。</p>
	<p><input name="" type="button" onclick="window.location='data.php?action=mkcache';" value="重建缓存" class="submit" /></p>
</div>
<script type='text/javascript'>
setTimeout(hideActived,2600);
$(document).ready(function(){
	$("#adm_bakdata_list tbody tr:odd").addClass("tralt_b");
	$("#adm_bakdata_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")})
});
$("#menu_data").addClass('sidebarsubmenu1');
</script>