<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<div class=containertitle><b>插件管理</b><div id="msg"></div>
</div>
<div class=line></div>
<form action="trackback.php?action=dell_all_tb" method="post">
  <table width="100%" id="adm_plugin_list">
  <thead>
      <tr class="rowstop">
        <td width="60"></td>
        <td width="26" align="center"><b>状态</b></td>
		<td width="30" align="center"><b>版本</b></td>
		<td width="500"><b>描述</b></td>
      </tr>
  </thead>
  <tbody>
	<?php 
	$i = 0;
	foreach($plugins as $key=>$val):
		$plug_state = 'inactive';
		$plug_action = 'active';
		$plug_state_des = '未激活';
		if (in_array($key, $active_plugins))
		{
			$plug_state = 'active';
			$plug_action = 'inactive';
			$plug_state_des = '已激活';
		}
		$i++;
	?>	
      <tr>
        <td align="center"><b><?php echo $val['Name']; ?></b></td>
		<td align="center" id="plugin_<?php echo $i;?>">
		<img src="./views/<?php echo ADMIN_TPL; ?>/images/plugin_<?php echo $plug_state; ?>.gif" onclick="do_plugin('<?php echo $key;?>', '<?php echo $plug_action; ?>', 'plugin_<?php echo $i;?>');" title="<?php echo $plug_state_des; ?>" align="absmiddle">
		</td>
        <td align="center"><?php echo $val['Version']; ?></td>
        <td>
		<?php echo $val['Description']; ?>
		<?php if ($val['Url'] != ''):?><a href="<?php echo $val['Url'];?>" target="_blank">插件主页&raquo;</a><?php endif;?>
		<br />
		<?php if ($val['Author'] != ''):?>
		作者：<a href="mailto:<?php echo $val['Email'];?>" title="给作者发邮件"><?php echo $val['Author'];?></a>
		<?php endif;?>
		</td>
      </tr>
	<?php endforeach; ?>
	</tbody>
  </table>
</form>
<script type='text/javascript'>
$("#adm_plugin_list tbody tr:odd").addClass("tralt_b");
$("#adm_plugin_list tbody tr")
	.mouseover(function(){$(this).addClass("trover")})
	.mouseout(function(){$(this).removeClass("trover")})
setTimeout(hideActived,2600);
function do_plugin (plugin, action, id){
	var url = 'plugin.php?action='+action;
	var querystr = "plugin="+plugin+"&id="+id;
	$("#msg").html("<span class=\"msg_autosave_do\">正在更改插件状态...</span>");
	$.post(url, querystr, function(data){
		$("#"+id).html(data);
		$("#msg").html("");
	});
}
$("#menu_plug").addClass('sidebarsubmenu1');
</script>