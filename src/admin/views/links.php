<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<!--vot--><div class=containertitle><b><?=lang('link_management')?></b>
<!--vot--><?php if(isset($_GET['active_taxis'])):?><span class="actived"><?=lang('order_update_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_del'])):?><span class="actived"><?=lang('deleted_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_edit'])):?><span class="actived"><?=lang('edit_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_add'])):?><span class="actived"><?=lang('add_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_a'])):?><span class="error"><?=lang('site_and_url_empty')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_b'])):?><span class="error"><?=lang('no_link_order')?></span><?php endif;?>
</div>
<div class=line></div>
<form action="link.php?action=link_taxis" method="post">
  <table width="100%" id="adm_link_list" class="item_list">
    <thead>
      <tr>
<!--vot--><th width="50"><b><?=lang('id')?></b></th>
<!--vot--><th width="230"><b><?=lang('link')?></b></th>
<!--vot--><th width="80" class="tdcenter"><b><?=lang('status')?></b></th>
<!--vot--><th width="80" class="tdcenter"><b><?=lang('views')?></b></th>
<!--vot--><th width="400"><b><?=lang('description')?></b></th>
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
<!--vot-->	<td><a href="link.php?action=mod_link&amp;linkid=<?php echo $value['id']; ?>" title="<?=lang('edit_link')?>"><?php echo $value['sitename']; ?></a></td>
		<td class="tdcenter">
		<?php if ($value['hide'] == 'n'): ?>
<!--vot-->	<a href="link.php?action=hide&amp;linkid=<?php echo $value['id']; ?>" title="<?=lang('link_hide')?>"><?=lang('visible')?></a>
		<?php else: ?>
<!--vot-->	<a href="link.php?action=show&amp;linkid=<?php echo $value['id']; ?>" title="<?=lang('link_show')?>" style="color:red;"><?=lang('hidden')?></a>
		<?php endif;?>
		</td>
		<td class="tdcenter">
<!--vot-->  	<a href="<?php echo $value['siteurl']; ?>" target="_blank" title="<?=lang('view_link')?>">
	  	<img src="./views/images/vlog.gif" align="absbottom" border="0" /></a>
	  	</td>
        <td><?php echo $value['description']; ?></td>
        <td>
<!--vot--> <a href="link.php?action=mod_link&amp;linkid=<?php echo $value['id']; ?>"><?=lang('edit')?></a>
<!--vot--> <a href="javascript: em_confirm(<?php echo $value['id']; ?>, 'link', '<?php echo LoginAuth::genToken(); ?>');" class="care"><?=lang('delete')?></a>
        </td>
      </tr>
	<?php endforeach;else:?>
<!--vot--><tr><td class="tdcenter" colspan="6"><?=lang('no_links')?></td></tr>
	<?php endif;?>
    </tbody>
  </table>
<!--vot--><div class="list_footer"><input type="submit" value="<?=lang('order_change')?>" class="button" /></div>
</form>
<form action="link.php?action=addlink" method="post" name="link" id="link">
<!--vot--><div style="margin:30px 0px 10px 0px;"><a href="javascript:displayToggle('link_new', 2);"><?=lang('link_add')?>+</a></div>
<div id="link_new" class="item_edit">
<!--vot--><li><input maxlength="4" style="width:30px;" class="input" name="taxis" /> <?=lang('id')?></li>
<!--vot--><li><input maxlength="200" style="width:232px;" class="input" name="sitename" /> <?=lang('name')?><span class="required">*</span></li>
<!--vot--><li><input maxlength="200" style="width:232px;" class="input" name="siteurl" /> <?=lang('address')?><span class="required">*</span></li>
<!--vot--><li><?=lang('description')?></li>
	<li><textarea name="description" type="text" class="textarea" style="width:230px;height:60px;overflow:auto;"></textarea></li>
<!--vot--><li><input type="submit" name="" value="<?=lang('link_add')?>" /></li>
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