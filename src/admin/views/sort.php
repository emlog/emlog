<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<script>setTimeout(hideActived,2600);</script>
<div class=containertitle><b><? echo $lang['categories_management'];?></b>
<?php if(isset($_GET['active_taxis'])):?><span class="actived"><? echo $lang['categories_ordered_ok'];?></span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="actived"><? echo $lang['categories_deleted_ok'];?></span><?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="actived"><? echo $lang['categories_edited_ok'];?></span><?php endif;?>
<?php if(isset($_GET['active_add'])):?><span class="actived"><? echo $lang['category_added_ok'];?></span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error"><? echo $lang['category_is_empty'];?></span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error"><? echo $lang['category_order_nothing'];?></span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="error"><? echo $lang['alias_characters']; ?></span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="error"><? echo $lang['alias_unique']; ?></span><?php endif;?>
<?php if(isset($_GET['error_e'])):?><span class="error"><? echo $lang['alias_no_system']; ?></span><?php endif;?>
</div>
<div class=line></div>
<form  method="post" action="sort.php?action=taxis">
	<table width="100%" id="adm_sort_list" class="item_list">
		<thead>
			<tr>
			<th width="55"><b><? echo $lang['order'];?></b></th>
			<th width="160"><b><? echo $lang['name']; ?></b></th>
            <th width="180"><b><? echo $lang['link_description']; ?></b></th>
			<th width="130"><b><? echo $lang['alias']; ?></b></th>
            <th width="100"><b><? echo $lang['template']; ?></b></th>
			<th width="40" class="tdcenter"><b><? echo $lang['view']; ?></b></th>
			<th width="40" class="tdcenter"><b><? echo $lang['article']; ?></b></th>
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
			<a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>"><? echo $lang['edit']; ?></a>
			<a href="javascript: em_confirm(<?php echo $value['sid']; ?>, 'sort', '<?php echo LoginAuth::genToken(); ?>');" class="care"><? echo $lang['remove']; ?></a>
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
			<a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>"><? echo $lang['edit']; ?></a>
			<a href="javascript: em_confirm(<?php echo $value['sid']; ?>, 'sort', '<?php echo LoginAuth::genToken(); ?>');" class="care"><? echo $lang['remove']; ?></a>
		</td>
	</tr>
	<?php endforeach; ?>
<?php endforeach;else:?>
	  <tr><td class="tdcenter" colspan="8"><? echo $lang['category_no_yet']; ?></td></tr>
<?php endif;?>  
</tbody>
</table>
<div class="list_footer"><input type="submit" value="<? echo $lang['update_sort_order'];?>" class="button" /></div>
</form>
<form action="sort.php?action=add" method="post">
<div style="margin:30px 0px 10px 0px;"><a href="javascript:displayToggle('sort_new', 2);"><? echo $lang['category_add']; ?>+</a></div>
<div id="sort_new" class="item_edit">
    <li><input maxlength="4" style="width:30px;" name="taxis" class="input"  /> <? echo $lang['order']; ?></li>
	<li><input maxlength="200" style="width:243px;" class="input" name="sortname" id="sortname" /> <? echo $lang['name']; ?><span class="required">*</span></li>
	<li><input maxlength="200" style="width:243px;" class="input" name="alias" id="alias" /> <? echo $lang['alias']; ?> (<? echo $lang['alias_prompt']; ?>)</li>
	<li>
		<select name="pid" id="pid" class="input">
			<option value="0"><? echo $lang['none']; ?></option>
			<?php
				foreach($sorts as $key=>$value):
					if($value['pid'] != 0) {
						continue;
					}
			?>
			<option value="<?php echo $key; ?>"><?php echo $value['sortname']; ?></option>
			<?php endforeach; ?>
		</select>
        <? echo $lang['category_parent']; ?>
	</li>
    <li><input maxlength="200" style="width:168px;" class="input" name="template" id="template" value="log_list" /> <? echo $lang['template']; ?> <? echo $lang['template_log_list']; ?></li>
	<li><? echo $lang['category_description']; ?><br />
	<textarea name="description" type="text" style="width:240px;height:60px;overflow:auto;" class="textarea"></textarea></li>
    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
	<li><input type="submit" id="addsort" value="<? echo $lang['category_add']; ?>" class="button"/><span id="alias_msg_hook"></span></li>
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
		$("#alias_msg_hook").html('<span id="input_error">'+l_alias_invalid+'</span>');
	}else if (2 == issortalias(a)){
		$("#addsort").attr("disabled", "disabled");
		$("#alias_msg_hook").html('<span id="input_error">'+l_alias_numeric+'</span>');
	}else if (3 == issortalias(a)){
		$("#addsort").attr("disabled", "disabled");
		$("#alias_msg_hook").html('<span id="input_error">'+l_alias_not_system+'</span>');
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