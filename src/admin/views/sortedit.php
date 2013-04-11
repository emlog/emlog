<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<?php if(isset($_GET['error_a'])):?><span class="error">分类名称不能为空</span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="error">别名格式错误</span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="error">别名不能重复</span><?php endif;?>
<?php if(isset($_GET['error_e'])):?><span class="error">别名不得包含系统保留关键字</span><?php endif;?>
<div class=containertitle><b>编辑分类</b></div>
<div class=line></div>
<form action="sort.php?action=update" method="post">
<div class="item_edit">
	<li><input size="24" value="<?php echo $sortname; ?>" name="sortname" id="sortname" /> 名称</li>
	<li><input size="40" value="<?php echo $alias; ?>" name="alias" id="alias" /> 别名 <span id="alias_msg_hook"></span></li>
	<li>
	<input type="hidden" value="<?php echo $sid; ?>" name="sid" />
	<input type="submit" value="保 存" class="button" id="save"  />
	<input type="button" value="取 消" class="button" onclick="javascript: window.history.back();" />
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
		$("#alias_msg_hook").html('<span id="input_error">别名错误，应由字母、数字、下划线、短横线组成</span>');
	}else if (2 == issortalias(a)){
		$("#save").attr("disabled", "disabled");
		$("#alias_msg_hook").html('<span id="input_error">别名错误，不能为纯数字</span>');
	}else if (3 == issortalias(a)){
		$("#save").attr("disabled", "disabled");
		$("#alias_msg_hook").html('<span id="input_error">别名错误，与系统链接冲突</span>');
	}else {
		$("#alias_msg_hook").html('');
		$("#msg").html('');
		$("#save").attr("disabled", false);
	}
}
</script>