<?php if(!defined('ADMIN_ROOT')) {exit('error!');} ?>
<script>setTimeout(hideActived,2600);</script>
<div class=containertitle><b>分类管理</b>
<?php if(isset($_GET['active_taxis'])):?><span class="actived">排序更新成功</span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="actived">删除分类成功</span><?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="actived">修改分类成功</span><?php endif;?>
<?php if(isset($_GET['active_add'])):?><span class="actived">添加分类成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">分类名称不能为空</span><?php endif;?>
</div>
<div class=line></div>
<form  method="post" action="sort.php?action=taxis">
  <table width="95%" id="adm_sort_list">
    <thead>
      <tr class="rowstop">
        <td width="50"><b>序号</b></td>
        <td width="500"><b>分类名称</b></td>
        <td width="300"></td>
      </tr>
    </thead>
    <tbody>
<?php foreach($sorts as $key=>$value): ?>
      <tr>
        <td>
        <input type="hidden" value="<?php echo $value['sid'];?>" class="sort_id" />
        <input size="3" name="sort[<?php echo $value['sid']; ?>]" value="<?php echo $value['taxis']; ?>" /></td>
		<td class="sortname"><?php echo $value['sortname']; ?></td>
        <td><a href="javascript: em_confirm(<?php echo $value['sid']; ?>, 'sort');">删除</a></td>
      </tr>
<?php endforeach;?>   
</tbody>
</table>
<div class="list_footer"><input type="submit" value="更新排序" class="submit" /></div>
</form>
<form action="sort.php?action=add" method="post">
<div style="margin:50px 0px 0px 3px">
<input maxlength="200" size="15" name="sortname" /> <input type="submit" value="添加新分类" class="submit"/>
</div>
</form>
<script type='text/javascript'>
$(document).ready(function(){
	$("#adm_sort_list tbody tr:odd").addClass("tralt_b");
	$("#adm_sort_list tbody tr")
	.mouseover(function(){$(this).addClass("trover")})
	.mouseout(function(){$(this).removeClass("trover")});
	$(".sortname").click(function aaa(){
		if($(this).find(".sort_input").attr("type") == "text"){return false;}
		var name = $.trim($(this).html());
		var m = $.trim($(this).text());
		$(this).html("<input type=text value="+name+" class=sort_input>");
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
});
</script>