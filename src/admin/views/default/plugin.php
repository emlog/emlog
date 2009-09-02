<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b><? echo $lang['plugin_management'];?></b><div id="msg"></div>
<?php if(isset($_GET['active'])):?><span class="actived"><? echo $lang['plugin_activated_ok'];?></span><?php endif;?>
<?php if(isset($_GET['inactive'])):?><span class="actived"><? echo $lang['plugin_deactivated_ok'];?></span><?php endif;?>
</div>
<div class=line></div>
<form action="trackback.php?action=dell_all_tb" method="post">
  <table width="100%" id="adm_plugin_list" class="item_list">
  <thead>
      <tr>
        <th width="100" class="tdcenter"><? echo $lang['plugin_name'];?></th>
        <th width="36" class="tdcenter"><b><? echo $lang['plugin_status'];?></b></th>
		<th width="30" class="tdcenter"><b><? echo $lang['plugin_version'];?></b></th>
		<th width="500" class="tdcenter"><b><? echo $lang['description'];?></b></th>
      </tr>
  </thead>
  <tbody>
	<?php 
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
	?>	
      <tr>
        <td class="tdcenter"><?php echo $val['Name']; ?></td>
		<td class="tdcenter" id="plugin_<?php echo $i;?>">
		<a href="./plugin.php?action=<?php echo $plug_action;?>&plugin=<?php echo $key;?>"><img src="./views/<?php echo ADMIN_TPL; ?>/images/plugin_<?php echo $plug_state; ?>.gif" title="<?php echo $plug_state_des; ?>" align="absmiddle" border="0"></a>
		</td>
        <td class="tdcenter"><?php echo $val['Version']; ?></td>
        <td>
		<?php echo $val['Description']; ?>
		<?php if ($val['Url'] != ''):?><a href="<?php echo $val['Url'];?>" target="_blank"><? echo $lang['plugin_page'];?> &raquo;</a><?php endif;?>
		<br />
		<?php if ($val['Author'] != ''):?>
		<? echo $lang['author'];?>:
			<?php if ($val['Email'] != ''):?>
			<a href="mailto:<?php echo $val['Email'];?>"><?php echo $val['Author'];?></a>
			<?php else:?>
			<?php echo $val['Author'];?>
			<?php endif;?>
		<?php endif;?>
		<?php if ($val['AuthorUrl'] != ''):?>, <a href="<?php echo $val['AuthorUrl'];?>" target="_blank"><? echo $lang['author_homepage'];?> &raquo;</a><?php endif;?>
		</td>
      </tr>
	<?php endforeach; ?>
	</tbody>
  </table>
</form>
<div style="margin:30px 0px 10px 3px;"><a href="http://www.emlog.net/extend/plugins" target="_blank"><? echo $lang['plugin_repository'];?> &raquo;</a></div>
<script type='text/javascript'>
$("#adm_plugin_list tbody tr:odd").addClass("tralt_b");
$("#adm_plugin_list tbody tr")
	.mouseover(function(){$(this).addClass("trover")})
	.mouseout(function(){$(this).removeClass("trover")})
setTimeout(hideActived,2600);
$("#menu_plug").addClass('sidebarsubmenu1');
</script>