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
		<th width="30" class="tdcenter"><b><? echo $lang['views'];?></b></th>
		<th width="550"><b><? echo $lang['link_description'];?></b></th>
        <th width="100"></th>
      </tr>
    </thead>
    <tbody>
	<?php foreach($links as $key=>$value):?>  
      <tr>
		<td><input class="num_input" name="link[<?php echo $value['id']; ?>]" value="<?php echo $value['taxis']; ?>" maxlength="4" /></td>
		<td><a href="link.php?action=mod_link&amp;linkid=<?php echo $value['id']; ?>"><?php echo $value['sitename']; ?></a></td>
		<td class="tdcenter">
	  	<a href="<?php echo $value['siteurl']; ?>" target="_blank" title="<? echo $lang['link_follow'];?>">
	  	<img src="./views/<?php echo ADMIN_TPL; ?>/images/vlog.gif" align="absbottom" border="0" /></a>
	  	</td>
        <td><?php echo $value['description']; ?></td>
        <td><a href="javascript: em_confirm(<?php echo $value['id']; ?>, 'link');"><? echo $lang['remove'];?></a></td>
      </tr>
	<?php endforeach; ?>
    </tbody>
  </table>
  <div class="list_footer"><input type="submit" value="<? echo $lang['update_sort_order'];?>" class="submit" /></div>
</form>
<form action="link.php?action=addlink" method="post" name="link" id="link">
<div style="margin:30px 0px 10px 0px;"><a href="javascript:displayToggle('link_new', 2);"><? echo $lang['link_add'];?> &raquo;</a></div>
<div id="link_new">
	<li><? echo $lang['link_name'];?></li>
	<li><input maxlength="200" size="35" name="sitename" /></li>
	<li><? echo $lang['link_url'];?></li>
	<li><input maxlength="200" size="35" name="siteurl" /></li>
	<li><? echo $lang['link_description'];?></li>
	<li><textarea name="description" rows="5" cols="40" type="text"></textarea></li>
	<li><input type="submit" name="" value="<? echo $lang['link_add'];?>"  /></li>
</div>
</form>
<script type='text/javascript'>
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