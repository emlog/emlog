<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<script type='text/javascript'>
$(document).ready(function(){
	$("#adm_plugin_list tbody tr:odd").addClass("tralt_b");
	$("#adm_plugin_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")})
});
setTimeout(hideActived,2600);
</script>
<div class=containertitle><b>插件管理</b>
<?php if(isset($_GET['active_del'])):?><span class="actived">删除引用成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">请选择要执行操作的引用</span><?php endif;?>
</div>
<div class=line></div>
<form action="trackback.php?action=dell_all_tb" method="post">
  <table width="95%" id="adm_plugin_list">
  <thead>
      <tr class="rowstop">
        <td width="20"><input onclick="CheckAll(this.form)" type="checkbox" value="on" name="chkall" /></td>
        <td width="50"><b>插件</b></td>
        <td width="20"><b>版本</b></td>
		<td width="300"><b>描述</b></td>
        <td width="80"></td>
      </tr>
  </thead>
  <tbody>
	<?php foreach($plugins as $key=>$val):?>	
      <tr>
        <td><input type="checkbox" name="tb[<?php echo $key; ?>]" value="1" ></td>
        <td><b><?php echo $val['Title']; ?></b></td>
        <td><?php echo $val['Version']; ?></td>
        <td><?php echo $val['Description']; ?></td>
        <td> <a href="">删除</a> </td>
      </tr>
	<?php endforeach; ?>
	</tbody>
  </table>
</form>