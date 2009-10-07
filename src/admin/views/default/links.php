<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div class=containertitle><b>链接管理</b>
<?php if(isset($_GET['active_taxis'])):?><span class="actived">排序更新成功</span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="actived">删除链接成功</span><?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="actived">修改链接成功</span><?php endif;?>
<?php if(isset($_GET['active_add'])):?><span class="actived">添加链接成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">站点名称和地址不能为空</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">没有可排序的链接</span><?php endif;?>
</div>
<div class=line></div>
<form action="link.php?action=link_taxis" method="post">
  <table width="100%" id="adm_link_list" class="item_list">
    <thead>
      <tr>
	  	<th width="50"><b>序号</b></th>
        <th width="230"><b>链接</b></th>
		<th width="30" class="tdcenter"><b>查看</b></th>
		<th width="550"><b>描述</b></th>
        <th width="100"></th>
      </tr>
    </thead>
    <tbody>
	<?php foreach($links as $key=>$value):?>  
      <tr>
		<td><input class="num_input" name="link[<?php echo $value['id']; ?>]" value="<?php echo $value['taxis']; ?>" maxlength="4" /></td>
		<td><a href="link.php?action=mod_link&amp;linkid=<?php echo $value['id']; ?>"><?php echo $value['sitename']; ?></a></td>
		<td class="tdcenter">
	  	<a href="<?php echo $value['siteurl']; ?>" target="_blank" title="查看链接">
	  	<img src="./views/<?php echo ADMIN_TPL; ?>/images/vlog.gif" align="absbottom" border="0" /></a>
	  	</td>
        <td><?php echo $value['description']; ?></td>
        <td><a href="javascript: em_confirm(<?php echo $value['id']; ?>, 'link');">删除</a></td>
      </tr>
	<?php endforeach; ?>
    </tbody>
  </table>
  <div class="list_footer"><input type="submit" value="改变排序" class="submit" /></div>
</form>
<form action="link.php?action=addlink" method="post" name="link" id="link">
<div style="margin:30px 0px 10px 0px;"><a href="javascript:displayToggle('link_new', 2);">添加链接&raquo;</a></div>
<div id="link_new">
	<li>名称</li>
	<li><input maxlength="200" size="35" name="sitename" /></li>
	<li>地址</li>
	<li><input maxlength="200" size="35" name="siteurl" /></li>
	<li>描述</li>
	<li><textarea name="description" rows="5" cols="40" type="text"></textarea></li>
	<li><input type="submit" name="" value="添加链接"  /></li>
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