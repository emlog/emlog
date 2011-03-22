<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<script>setTimeout(hideActived,2600);</script>
<div class=containertitle><b>分类管理</b>
<?php if(isset($_GET['active_taxis'])):?><span class="actived">排序更新成功</span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="actived">删除分类成功</span><?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="actived">修改分类成功</span><?php endif;?>
<?php if(isset($_GET['active_add'])):?><span class="actived">添加分类成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">分类名称不能为空</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">没有可排序的分类</span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="error">别名格式错误</span><?php endif;?>
</div>
<div class=line></div>
<form  method="post" action="sort.php?action=taxis">
  <table width="100%" id="adm_sort_list" class="item_list">
    <thead>
      <tr>
        <th width="55"><b>序号</b></th>
        <th width="300"><b>名称</b></th>
		<th width="300"><b>别名</b></th>
        <th width="50" class="tdcenter"><b>日志</b></th>
        <th width="100"></th>
      </tr>
    </thead>
    <tbody>
<?php foreach($sorts as $key=>$value): ?>
      <tr>
        <td>
        <input type="hidden" value="<?php echo $value['sid'];?>" class="sort_id" />
        <input maxlength="4" class="num_input" name="sort[<?php echo $value['sid']; ?>]" value="<?php echo $value['taxis']; ?>" /></td>
		<td class="sortname"><?php echo $value['sortname']; ?></td>
		<td class="alias"><?php echo $value['alias']; ?></td>
		<td class="tdcenter"><a href="./admin_log.php?sid=<?php echo $value['sid']; ?>"><?php echo $value['lognum']; ?></a></td>
        <td><a href="javascript: em_confirm(<?php echo $value['sid']; ?>, 'sort');">删除</a></td>
      </tr>
<?php endforeach;?>   
</tbody>
</table>
<div class="list_footer"><input type="submit" value="改变排序" class="submit" /></div>
</form>
<form action="sort.php?action=add" method="post">
<div style="margin:30px 0px 10px 0px;"><a href="javascript:displayToggle('sort_new', 2);">添加新分类+</a></div>
<div id="sort_new">
	<li>序号</li>
	<li><input maxlength="4" style="width:30px;" name="taxis" /></li>
	<li>名称</li>
	<li><input maxlength="200" style="width:200px;" name="sortname" id="sortname" /></li>
	<li>别名 <span id="alias_msg_hook"></span></li>
	<li><input maxlength="200" style="width:200px;" name="alias" id="alias" /> (用于URL的友好显示，通常由英文字母构成)</li>
	<li><input type="submit" value="添加新分类" onclick="return checksortform();" class="submit"/></li>
</div>
</form>
<script>
$("#sort_new").css('display', $.cookie('em_sort_new') ? $.cookie('em_sort_new') : 'none');
$("#alias").keyup(function(){checkalias();});
function checksortform(){
	var a = $.trim($("#alias").val());
	var n = $.trim($("#sortname").val());
	if (n==""){
		alert("分类名称不能为空");
		$("#sortname").focus();
		return false;
	}else if(isalias(a)){
		return true;
	}else {
		alert("链接别名格式错误");
		$("#alias").focus();
		return false
	};
}
$(document).ready(function(){
	$("#adm_sort_list tbody tr:odd").addClass("tralt_b");
	$("#adm_sort_list tbody tr")
	.mouseover(function(){$(this).addClass("trover")})
	.mouseout(function(){$(this).removeClass("trover")});
	$(".sortname").click(function a(){
		if($(this).find(".sort_input").attr("type") == "text"){return false;}
		var name = $.trim($(this).html());
		var m = $.trim($(this).text());
		$(this).html("<input type=text value=\""+name+"\" class=sort_input>");
		$(this).find(".sort_input").focus();
		$(this).find(".sort_input").bind("blur", function(){
			var n = $.trim($(this).val());
			if(n != m && n != ""){
				window.location = "sort.php?action=update&sid="+$(this).parent().parent().find(".sort_id").val()+"&name="+encodeURIComponent(n);
			}else{
				$(this).parent().html(name);
			}
		});
	});
	$(".alias").click(function b(){
		if($(this).find(".alias_input").attr("type") == "text"){return false;}
		var name = $.trim($(this).html());
		var m = $.trim($(this).text());
		$(this).html("<input type=text value=\""+name+"\" class=alias_input>");
		$(this).find(".alias_input").focus();
		$(this).find(".alias_input").bind("blur", function(){
			var n = $.trim($(this).val());
			if(n != m){
				window.location = "sort.php?action=update&sid="+$(this).parent().parent().find(".sort_id").val()+"&alias="+encodeURIComponent(n);
			}else{
				$(this).parent().html(name);
			}
		});
	});
	$("#menu_sort").addClass('sidebarsubmenu1');
});
</script>