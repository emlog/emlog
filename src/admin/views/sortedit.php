<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<?php if(isset($_GET['error_a'])):?><span class="error"><? echo $lang['category_is_empty']; ?></span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="error"><? echo $lang['alias_bad_format']; ?></span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="error"><? echo $lang['alias_unique']; ?></span><?php endif;?>
<?php if(isset($_GET['error_e'])):?><span class="error"><? echo $lang['alias_no_system']; ?></span><?php endif;?>
<div class=containertitle><b><? echo $lang['category_edit']; ?></b></div>
<div class=line></div>
<form action="sort.php?action=update" method="post">
<div class="item_edit">
	<li><input style="width:200px;" value="<?php echo $sortname; ?>" name="sortname" id="sortname" class="input" /> <? echo $lang['name']; ?></li>
	<li><input style="width:200px;" value="<?php echo $alias; ?>" name="alias" id="alias" class="input" /><? echo $lang['alias']; ?> <span id="alias_msg_hook"></span></li>
	<?php if (empty($sorts[$sid]['children'])): ?>
	<li>
		<select name="pid" id="pid" class="input">
			<option value="0"<?php if($pid == 0):?> selected="selected"<?php endif; ?>><? echo $lang['none']; ?></option>
			<?php
				foreach($sorts as $key=>$value):
					if ($key == $sid || $value['pid'] != 0) continue;
			?>
			<option value="<?php echo $key; ?>"<?php if($pid == $key):?> selected="selected"<?php endif; ?>><?php echo $value['sortname']; ?></option>
			<?php endforeach; ?>
		</select>
        <span><? echo $lang['category_parent']; ?></span>
	</li>
	<?php endif; ?>
	<li><? echo $lang['category_description']; ?><br />
		<textarea name="description" type="text" style="width:230px;height:60px;overflow:auto;" class="textarea"><?php echo $description; ?></textarea></li>
	<li>
	<input type="hidden" value="<?php echo $sid; ?>" name="sid" />
	<input type="submit" value="<? echo $lang['save']; ?>" class="button" id="save"  />
	<input type="button" value="<? echo $lang['_cancel_']; ?>" class="button" onclick="javascript: window.history.back();" />
    </li>
</div>
</form>
<script>
$("#menu_sort").addClass('sidebarsubmenu1');
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
		$("#save").attr("disabled", "disabled");
		$("#alias_msg_hook").html('<span id="input_error">'+l_alias_invalid+'</span>');
	}else if (2 == issortalias(a)){
		$("#save").attr("disabled", "disabled");
		$("#alias_msg_hook").html('<span id="input_error">'+l_alias_numeric+'</span>');
	}else if (3 == issortalias(a)){
		$("#save").attr("disabled", "disabled");
		$("#alias_msg_hook").html('<span id="input_error">'+l_alias_not_system+'</span>');
	}else {
		$("#alias_msg_hook").html('');
		$("#msg").html('');
		$("#save").attr("disabled", false);
	}
}
</script>