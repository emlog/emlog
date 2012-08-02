<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div class=containertitle><b><? echo $lang['links'];?></b>
<?php if(isset($_GET['active_taxis'])):?><span class="actived"><? echo $lang['links_ordered_ok'];?></span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="actived"><? echo $lang['links_deleted_ok'];?></span><?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="actived"><? echo $lang['links_edited_ok'];?></span><?php endif;?>
<?php if(isset($_GET['active_add'])):?><span class="actived"><? echo $lang['links_added_ok'];?></span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error"><? echo $lang['link_is_empty'];?></span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error"><? echo $lang['link_sort_nothing'];?></span><?php endif;?>
</div>
<div class=line></div>
<form action="link.php?action=link_taxis" method="post">
  <table width="100%" id="adm_link_list" class="item_list">
    <thead>
      <tr>
	  	<th width="50"><b><? echo $lang['order'];?></b></th>
        <th width="230"><b><? echo $lang['link'];?></b></th>
        <th width="80" class="tdcenter"><b><? echo $lang['status']; ?></b></th>
		<th width="80" class="tdcenter"><b><? echo $lang['view']; ?></b></th>
		<th width="400"><b><? echo $lang['link_description']; ?></b></th>
        <th width="100"></th>
      </tr>
    </thead>
    <tbody>
	<?php 
	if($links):
	foreach($links as $key=>$value):
	doAction('adm_link_display');
	?>  
      <tr>
		<td><input class="num_input" name="link[<?php echo $value['id']; ?>]" value="<?php echo $value['taxis']; ?>" maxlength="4" /></td>
		<td><a href="link.php?action=mod_link&amp;linkid=<?php echo $value['id']; ?>" title="<? echo $lang['link_edit']; ?>"><?php echo $value['sitename']; ?></a></td>
		<td class="tdcenter">
		<?php if ($value['hide'] == 'n'): ?>
		<a href="link.php?action=hide&amp;linkid=<?php echo $value['id']; ?>" title="<? echo $lang['click_to_hide_link']; ?>"><? echo $lang['visible']; ?></a>
		<?php else: ?>
		<a href="link.php?action=show&amp;linkid=<?php echo $value['id']; ?>" title="<? echo $lang['click_to_show_link']; ?>" style="color:red;"><? echo $lang['hidden']; ?></a>
		<?php endif;?>
		</td>
		<td class="tdcenter">
	  	<a href="<?php echo $value['siteurl']; ?>" target="_blank" title="<? echo $lang['link_follow']; ?>">
	  	<img src="./views/images/vlog.gif" align="absbottom" border="0" /></a>
	  	</td>
        <td><?php echo $value['description']; ?></td>
        <td><a href="javascript: em_confirm(<?php echo $value['id']; ?>, 'link');"><? echo $lang['remove'];?></a></td>
      </tr>
	<?php endforeach;else:?>
	  <tr><td class="tdcenter" colspan="6"><? echo $lang['no_links_yet']; ?></td></tr>
	<?php endif;?>
    </tbody>
  </table>
  <div class="list_footer"><input type="submit" value="<? echo $lang['update_sort_order'];?>" class="submit" /></div>
</form>
<form action="link.php?action=addlink" method="post" name="link" id="link">
<div style="margin:30px 0px 10px 0px;"><a href="javascript:displayToggle('link_new', 2);"><? echo $lang['link_add'];?>+</a></div>
<div id="link_new">
	<li><? echo $lang['order']; ?></li>
	<li><input maxlength="4" style="width:30px;" name="taxis" /></li>
	<li><? echo $lang['link_name'];?></li>
	<li><input maxlength="200" style="width:228px;" name="sitename" /></li>
	<li><? echo $lang['link_url'];?></li>
	<li><input maxlength="200" style="width:228px;" name="siteurl" /></li>
	<li><? echo $lang['link_description'];?></li>
	<li><textarea name="description" type="text" style="width:230px;height:60px;overflow:auto;"></textarea></li>
	<li><input type="submit" name="" value="<? echo $lang['link_add'];?>"  /></li>
</div>
</form>
<script>
$("#link_new").css('display', $.cookie('em_link_new') ? $.cookie('em_link_new') : 'none');
$(document).ready(function(){
	$("#adm_link_list tbody tr:odd").addClass("tralt_b");
	$("#adm_link_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")})
});
setTimeout(hideActived,2600);
$("#menu_link").addClass('sidebarsubmenu1');
</script>