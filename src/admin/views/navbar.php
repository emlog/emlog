<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div class=containertitle><b>导航管理</b>
<?php if(isset($_GET['active_taxis'])):?><span class="actived">排序更新成功</span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="actived">删除导航成功</span><?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="actived">修改导航成功</span><?php endif;?>
<?php if(isset($_GET['active_add'])):?><span class="actived">添加导航成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">导航名称和地址不能为空</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">没有可排序的导航</span><?php endif;?>
</div>
<div class=line></div>
<form action="navbar.php?action=taxis" method="post">
  <table width="100%" id="adm_navi_list" class="item_list">
    <thead>
      <tr>
	  	<th width="50"><b>序号</b></th>
        <th width="230"><b>导航</b></th>
        <th width="80" class="tdcenter"><b>状态</b></th>
		<th width="80" class="tdcenter"><b>查看</b></th>
		<th width="400"><b>描述</b></th>
        <th width="100"></th>
      </tr>
    </thead>
    <tbody>
	<?php 
	if($navis):
	foreach($navis as $key=>$value):
	doAction('adm_navi_display');
	?>  
      <tr>
		<td><input class="num_input" name="navi[<?php echo $value['id']; ?>]" value="<?php echo $value['taxis']; ?>" maxlength="4" /></td>
		<td><a href="navbar.php?action=mod&amp;navid=<?php echo $value['id']; ?>" title="修改导航"><?php echo $value['naviname']; ?></a></td>
		<td class="tdcenter">
		<?php if ($value['hide'] == 'n'): ?>
		<a href="navbar.php?action=hide&amp;id=<?php echo $value['id']; ?>" title="点击隐藏导航">显示</a>
		<?php else: ?>
		<a href="navbar.php?action=show&amp;id=<?php echo $value['id']; ?>" title="点击显示导航" style="color:red;">隐藏</a>
		<?php endif;?>
		</td>
		<td class="tdcenter">
	  	<a href="<?php echo $value['siteurl']; ?>" target="_blank" title="查看导航">
	  	<img src="./views/images/vlog.gif" align="absbottom" border="0" /></a>
	  	</td>
        <td><?php echo $value['description']; ?></td>
        <td><a href="javascript: em_confirm(<?php echo $value['id']; ?>, 'navi');">删除</a></td>
      </tr>
	<?php endforeach;else:?>
	  <tr><td class="tdcenter" colspan="4">还没有添加导航</td></tr>
	<?php endif;?>
    </tbody>
  </table>
  <div class="list_footer"><input type="submit" value="改变排序" class="submit" /></div>
</form>
<form action="navbar.php?action=add" method="post" name="navi" id="navi">
<div style="margin:30px 0px 10px 0px;"><a href="javascript:displayToggle('navi_new', 2);">添加导航+</a></div>
<div id="navi_new">
	<li><input maxlength="4" style="width:30px;" name="taxis" /> 序号</li>
	<li><input maxlength="200" style="width:128px;" name="naviname" /> 导航名称</li>
	<li><input name="description" style="width:230px;" maxlength="200"> 描述(选填)</li>
	<li><input maxlength="200" style="width:328px;" name="url" /> 跳转地址，在新窗口打开<input type="checkbox" style="vertical-align:middle;" value="y" name="newtab" /></li>
	<li><input type="submit" name="" value="添加导航"  /></li>
</div>
</form>
<script>
$("#navi_new").css('display', $.cookie('em_navi_new') ? $.cookie('em_navi_new') : 'none');
$(document).ready(function(){
	$("#adm_navi_list tbody tr:odd").addClass("tralt_b");
	$("#adm_navi_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")})
});
setTimeout(hideActived,2600);
$("#menu_navbar").addClass('sidebarsubmenu1');
</script>