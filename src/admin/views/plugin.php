<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b><? echo $lang['plugin_management'];?></b><div id="msg"></div>
<?php if(isset($_GET['activate_install'])):?><span class="actived"><? echo $lang['plugin_upload_ok']; ?></span><?php endif;?>
<?php if(isset($_GET['active'])):?><span class="actived"><? echo $lang['plugin_activated_ok'];?></span><?php endif;?>
<?php if(isset($_GET['activate_del'])):?><span class="actived"><? echo $lang['plugin_del_ok']; ?></span><?php endif;?>
<?php if(isset($_GET['active_error'])):?><span class="error"><? echo $lang['plugin_activate_failed']; ?></span><?php endif;?>
<?php if(isset($_GET['inactive'])):?><span class="actived"><? echo $lang['plugin_deactivated_ok'];?></span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error"><? echo $lang['plugin_del_failed']; ?></span><?php endif;?>
</div>
<div class=line></div>
  <table width="100%" id="adm_plugin_list" class="item_list">
  <thead>
      <tr>
        <th width="200"></th>
        <th width="40" class="tdcenter"><b><? echo $lang['status'];?></b></th>
		<th width="60" class="tdcenter"><b><? echo $lang['plugin_version'];?></b></th>
		<th width="450" class="tdcenter"><b><? echo $lang['description'];?></b></th>
		<th width="60" class="tdcenter"></th>
      </tr>
  </thead>
  <tbody>
	<?php 
	if($plugins):
	$i = 0;
	foreach($plugins as $key=>$val):
		$plug_state = 'inactive';
		$plug_action = 'active';
		$plug_state_des = $lang['plugin_inactive'];
		if (in_array($key, $active_plugins))
		{
			$plug_state = 'active';
			$plug_action = 'inactive';
			$plug_state_des = $lang['plugin_active'];
		}
		$i++;
        if (TRUE === $val['Setting']) {
            $val['Name'] = "<a href=\"./plugin.php?plugin={$val['Plugin']}\" title=\"点击设置插件\">{$val['Name']} <img src=\"./views/images/set.png\" border=\"0\" /></a>";
        }
	?>	
      <tr>
        <td class="tdcenter"><?php echo $val['Name']; ?></td>
		<td class="tdcenter" id="plugin_<?php echo $i;?>">
		<a href="./plugin.php?action=<?php echo $plug_action;?>&plugin=<?php echo $key;?>"><img src="./views/images/plugin_<?php echo $plug_state; ?>.gif" title="<?php echo $plug_state_des; ?>" align="absmiddle" border="0"></a>
		</td>
        <td class="tdcenter"><?php echo $val['Version']; ?></td>
        <td>
		<?php echo $val['Description']; ?>
		<?php if ($val['Url'] != ''):?><a href="<?php echo $val['Url'];?>" target="_blank"><? echo $lang['plugin_page'];?> &raquo;</a><?php endif;?>
		<div style="margin-top:5px;">
		<?php if ($val['ForEmlog'] != ''):?><? echo $lang['applicable_for_emlog']; ?><?php echo $val['ForEmlog'];?>&nbsp | &nbsp<?php endif;?>
		<?php if ($val['Author'] != ''):?>
		<? echo $lang['author'];?>: <?php if ($val['AuthorUrl'] != ''):?>
			<a href="<?php echo $val['AuthorUrl'];?>" target="_blank"><?php echo $val['Author'];?></a>
			<?php else:?>
			<?php echo $val['Author'];?>
			<?php endif;?>
		<?php endif;?>
		</div>
		</td>
		<td class="tdcenter">
	    <a href="javascript: em_confirm('<?php echo $key; ?>', 'plu');" class="care"><? echo $lang['remove']; ?></a>
        </td>
      </tr>
	<?php endforeach;else: ?>
	  <tr>
        <td class="tdcenter" colspan="5"><? echo $lang['no_plugin_yet']; ?></td>
      </tr>
	<?php endif;?>
	</tbody>
  </table>
<div class="add_plugin"><a href="./plugin.php?action=install"><? echo $lang['plugin_install']; ?></a></div>
<script>
$("#adm_plugin_list tbody tr:odd").addClass("tralt_b");
$("#adm_plugin_list tbody tr")
	.mouseover(function(){$(this).addClass("trover")})
	.mouseout(function(){$(this).removeClass("trover")})
setTimeout(hideActived,2600);
$("#menu_plug").addClass('sidebarsubmenu1');
</script>