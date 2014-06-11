<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<script>setTimeout(hideActived,2600);</script>
<!--vot--><div class=containertitle><b><?=lang('category_manage')?></b>
<!--vot--><?php if(isset($_GET['active_taxis'])):?><span class="actived"><?=lang('category_update_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_del'])):?><span class="actived"><?=lang('category_deleted_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_edit'])):?><span class="actived"><?=lang('category_modify_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_add'])):?><span class="actived"><?=lang('category_add_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_a'])):?><span class="error"><?=lang('category_name_empty')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_b'])):?><span class="error"><?=lang('category_no_order')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_c'])):?><span class="error"><?=lang('alias_format_invalid')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_d'])):?><span class="error"><?=lang('alias_unique')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_e'])):?><span class="error"><?=lang('alias_no_keywords')?></span><?php endif;?>
</div>
<div class=line></div>
<form  method="post" action="sort.php?action=taxis">
	<table width="100%" id="adm_sort_list" class="item_list">
		<thead>
			<tr>
<!--vot-->		<th width="55"><b><?=lang('id')?></b></th>
<!--vot-->		<th width="160"><b><?=lang('name')?></b></th>
<!--vot-->		<th width="180"><b><?=lang('description')?></b></th>
<!--vot-->		<th width="130"><b><?=lang('alias')?></b></th>
<!--vot-->		<th width="100"><b><?=lang('template')?></b></th>
<!--vot-->		<th width="40" class="tdcenter"><b><?=lang('views')?></b></th>
<!--vot-->		<th width="40" class="tdcenter"><b><?=lang('posts')?></b></th>
			<th width="60"></th>
		</tr>
		</thead>
		<tbody>
<?php 
if($sorts):
foreach($sorts as $key=>$value):
	if ($value['pid'] != 0) {
		continue;
	}
?>
	<tr>
		<td>
			<input type="hidden" value="<?php echo $value['sid'];?>" class="sort_id" />
			<input maxlength="4" class="num_input" name="sort[<?php echo $value['sid']; ?>]" value="<?php echo $value['taxis']; ?>" />
		</td>
		<td class="sortname">
            <a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?></a>
        </td>
		<td><?php echo $value['description']; ?></td>
        <td class="alias"><?php echo $value['alias']; ?></td>
        <td class="alias"><?php echo $value['template']; ?></td>
		<td class="tdcenter">
			<a href="<?php echo Url::sort($value['sid']); ?>" target="_blank"><img src="./views/images/vlog.gif" align="absbottom" border="0" /></a>
		</td>
		<td class="tdcenter"><a href="./admin_log.php?sid=<?php echo $value['sid']; ?>"><?php echo $value['lognum']; ?></a></td>
		<td>
<!--vot-->		<a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>"><?=lang('edit')?></a>
<!--vot-->		<a href="javascript: em_confirm(<?php echo $value['sid']; ?>, 'sort', '<?php echo LoginAuth::genToken(); ?>');" class="care"><?=lang('delete')?></a>
		</td>
	</tr>
	<?php
		$children = $value['children'];
		foreach ($children as $key):
		$value = $sorts[$key];
	?>
	<tr>
		<td>
			<input type="hidden" value="<?php echo $value['sid'];?>" class="sort_id" />
			<input maxlength="4" class="num_input" name="sort[<?php echo $value['sid']; ?>]" value="<?php echo $value['taxis']; ?>" />
		</td>
		<td class="sortname">---- <a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?></a></td>
		<td><?php echo $value['description']; ?></td>
        <td class="alias"><?php echo $value['alias']; ?></td>
        <td class="alias"><?php echo $value['template']; ?></td>
		<td class="tdcenter">
			<a href="<?php echo Url::sort($value['sid']); ?>" target="_blank"><img src="./views/images/vlog.gif" align="absbottom" border="0" /></a>
		</td>
		<td class="tdcenter"><a href="./admin_log.php?sid=<?php echo $value['sid']; ?>"><?php echo $value['lognum']; ?></a></td>
		<td>
<!--vot-->		<a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>"><?=lang('edit')?></a>
<!--vot-->		<a href="javascript: em_confirm(<?php echo $value['sid']; ?>, 'sort', '<?php echo LoginAuth::genToken(); ?>');" class="care"><?=lang('delete')?></a>
		</td>
	</tr>
	<?php endforeach; ?>
<?php endforeach;else:?>
<!--vot-->  <tr><td class="tdcenter" colspan="8"><?=lang('categories_no')?></td></tr>
<?php endif;?>  
</tbody>
</table>
<!--vot--><div class="list_footer"><input type="submit" value="<?=lang('order_change')?>" class="button" /></div>
</form>
<form action="sort.php?action=add" method="post">
<!--vot--><div style="margin:30px 0px 10px 0px;"><a href="javascript:displayToggle('sort_new', 2);"><?=lang('category_add')?>+</a></div>
<div id="sort_new" class="item_edit">
<!--vot--> <li><input maxlength="4" style="width:30px;" name="taxis" class="input"  /> <?=lang('id')?></li>
<!--vot--> <li><input maxlength="200" style="width:243px;" class="input" name="sortname" id="sortname" /> <?=lang('name')?><span class="required">*</sapn></li>
<!--vot--> <li><input maxlength="200" style="width:243px;" class="input" name="alias" id="alias" /> <?=lang('alias_info')?></li>
	<li>
		<select name="pid" id="pid" class="input">
<!--vot-->		<option value="0"><?=lang('no')?></option>
			<?php
				foreach($sorts as $key=>$value):
					if($value['pid'] != 0) {
						continue;
					}
			?>
			<option value="<?php echo $key; ?>"><?php echo $value['sortname']; ?></option>
			<?php endforeach; ?>
		</select>
<!--vot-->      <?=lang('category_parent')?>
	</li>
<!--vot--> <li><input maxlength="200" style="width:168px;" class="input" name="template" id="template" value="log_list" /> <?=lang('template')?> <?=lang('template_info')?></li>
<!--vot--> <li><?=lang('category_description')?><br />
	<textarea name="description" type="text" style="width:240px;height:60px;overflow:auto;" class="textarea"></textarea></li>
    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
<!--vot--> <li><input type="submit" id="addsort" value="<?=lang('category_new_add')?>" class="button"/><span id="alias_msg_hook"></span></li>
</div>
</form>
<script>
$("#sort_new").css('display', $.cookie('em_sort_new') ? $.cookie('em_sort_new') : 'none');
$("#alias").keyup(function(){checksortalias();});
function issortalias(a){
	var reg1=/^[\w-]*$/;
	var reg2=/^[\d]+$/;
	if(!reg1.test(a)) {
		return 1;
	}else if(reg2.test(a)){
		return 2;
	}else if(a=='post' || a=='record' || a=='sort' || a=='tag' || a=='author' || a=='page'){
		return 3;
	} else {
		return 0;
	}
}
function checksortalias(){
	var a = $.trim($("#alias").val());
	if (1 == issortalias(a)){
		$("#addsort").attr("disabled", "disabled");
<!--vot-->	$("#alias_msg_hook").html('<span id="input_error"><?=lang('alias_invalid_characters')?></span>');
	}else if (2 == issortalias(a)){
		$("#addsort").attr("disabled", "disabled");
<!--vot-->	$("#alias_msg_hook").html('<span id="input_error"><?=lang('alias_only_digits')?></span>');
	}else if (3 == issortalias(a)){
		$("#addsort").attr("disabled", "disabled");
<!--vot-->	$("#alias_msg_hook").html('<span id="input_error"><?=lang('alias_system_link')?></span>');
	}else {
		$("#alias_msg_hook").html('');
		$("#msg").html('');
		$("#addsort").attr("disabled", false);
	}
}
$(document).ready(function(){
	$("#adm_sort_list tbody tr:odd").addClass("tralt_b");
	$("#adm_sort_list tbody tr")
	.mouseover(function(){$(this).addClass("trover")})
	.mouseout(function(){$(this).removeClass("trover")});
	$("#menu_sort").addClass('sidebarsubmenu1');
});
</script>