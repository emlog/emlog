<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div class=containertitle><b>导航管理</b>
<?php if(isset($_GET['active_taxis'])):?><span class="actived">排序更新成功</span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="actived">删除导航成功</span><?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="actived">修改导航成功</span><?php endif;?>
<?php if(isset($_GET['active_add'])):?><span class="actived">添加导航成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">导航名称和地址不能为空</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">没有可排序的导航</span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="error">默认导航不能删除</span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="error">请选择要添加的分类</span><?php endif;?>
<?php if(isset($_GET['error_e'])):?><span class="error">请选择要添加的页面</span><?php endif;?>
<?php if(isset($_GET['error_f'])):?><span class="error">导航地址格式错误(需包含http等前缀)</span><?php endif;?>
</div>
<div class=line></div>
<form action="navbar.php?action=taxis" method="post">
  <table width="100%" id="adm_navi_list" class="item_list">
    <thead>
      <tr>
	  	<th width="50"><b>序号</b></th>
        <th width="230"><b>导航</b></th>
        <th width="60" class="tdcenter"><b>类型</b></th>
        <th width="60" class="tdcenter"><b>状态</b></th>
        <th width="50" class="tdcenter"><b>查看</b></th>
		<th width="360"><b>地址</b></th>
        <th width="100"></th>
      </tr>
    </thead>
    <tbody>
	<?php 
	if($navis):
	foreach($navis as $key=>$value):
	$value['type_name'] = '';
	switch ($value['type']) {
		case Navi_Model::navitype_home:
		case Navi_Model::navitype_t:
		case Navi_Model::navitype_admin:
			$value['type_name'] = '系统';
			break;
		case Navi_Model::navitype_sort:
			$value['type_name'] = '分类';
			break;
		case Navi_Model::navitype_page:
			$value['type_name'] = '页面';
			break;
		case Navi_Model::navitype_custom:
			$value['type_name'] = '自定';
			break;
	}
	doAction('adm_navi_display');
	?>  
      <tr>
		<td><input class="num_input" name="navi[<?php echo $value['id']; ?>]" value="<?php echo $value['taxis']; ?>" maxlength="4" /></td>
		<td><a href="navbar.php?action=mod&amp;navid=<?php echo $value['id']; ?>" title="编辑导航"><?php echo $value['naviname']; ?></a></td>
		<td class="tdcenter"><?php echo $value['type_name'];?></td>
		<td class="tdcenter">
		<?php if ($value['hide'] == 'n'): ?>
		<a href="navbar.php?action=hide&amp;id=<?php echo $value['id']; ?>" title="点击隐藏导航">显示</a>
		<?php else: ?>
		<a href="navbar.php?action=show&amp;id=<?php echo $value['id']; ?>" title="点击显示导航" style="color:red;">隐藏</a>
		<?php endif;?>
		</td>
		<td class="tdcenter">
	  	<a href="<?php echo $value['url']; ?>" target="_blank">
	  	<img src="./views/images/<?php echo $value['newtab'] == 'y' ? 'vlog.gif' : 'vlog2.gif';?>" align="absbottom" border="0" /></a>
	  	</td>
        <td><?php echo $value['url']; ?></td>
        <td>
        <a href="navbar.php?action=mod&amp;navid=<?php echo $value['id']; ?>">编辑</a>
        <?php if($value['isdefault'] == 'n'):?>
        <a href="javascript: em_confirm(<?php echo $value['id']; ?>, 'navi');" class="care">删除</a>
        <?php endif;?>
        </td>
      </tr>
	<?php endforeach;else:?>
	  <tr><td class="tdcenter" colspan="4">还没有添加导航</td></tr>
	<?php endif;?>
    </tbody>
  </table>
  <div class="list_footer"><input type="submit" value="改变排序" class="button" /></div>
</form>
<div id="navi_add">
<form action="navbar.php?action=add" method="post" name="navi" id="navi">
<div>
	<h1 onclick="displayToggle('navi_add_custom', 2);">添加自定义导航+</h1>
	<ul id="navi_add_custom">
	<li><input maxlength="4" style="width:30px;" name="taxis" /> 序号</li>
	<li><input maxlength="200" style="width:100px;" name="naviname" /> 导航名称</li>
	<li>
	<input maxlength="200" style="width:175px;" name="url" id="url" /> 地址(带http)</li>
    <li>在新窗口打开<input type="checkbox" style="vertical-align:middle;" value="y" name="newtab" /></li>
	<li><input type="submit" name="" value="添加"  /></li>
	</ul>
</div>
</form>
<form action="navbar.php?action=add_sort" method="post" name="navi" id="navi">
<div>
	<h1 onclick="displayToggle('navi_add_sort', 2);">添加分类到导航+</h1>
	<ul id="navi_add_sort">
	<?php 
	if($sorts):
    foreach($sorts as $key=>$value):
	if ($value['pid'] != 0) {
		continue;
	}
    ?>
	<li>
        <input type="checkbox" style="vertical-align:middle;" name="sort_ids[]" value="<?php echo $value['sid']; ?>" class="ids" />
		<?php echo $value['sortname']; ?>
	</li>
	<?php
		$children = $value['children'];
		foreach ($children as $key):
		$value = $sorts[$key];
	?>
    <li>
        &nbsp; &nbsp; &nbsp;  <input type="checkbox" style="vertical-align:middle;" name="sort_ids[]" value="<?php echo $value['sid']; ?>" class="ids" />
        <?php echo $value['sortname']; ?>
	</li>
	<?php 
        endforeach;
   endforeach;
   ?>
	<li><input type="submit" name="" value="添加"  /></li>
	<?php else:?>
	<li>还没有分类，<a href="sort.php">新建分类</a></li>
	<?php endif;?> 
	</ul>
</div>
</form>
<form action="navbar.php?action=add_page" method="post" name="navi" id="navi">
<div>
	<h1 onclick="displayToggle('navi_add_page', 2);">添加页面到导航+</h1>
	<ul id="navi_add_page">
	<?php 
	if($pages):
	foreach($pages as $key=>$value): 
	?>
	<li>
        <input type="checkbox" style="vertical-align:middle;" name="pages[<?php echo $value['gid']; ?>]" value="<?php echo $value['title']; ?>" class="ids" />
		<?php echo $value['title']; ?>
	</li>
	<?php endforeach;?>
	<li><input type="submit" name="" value="添加"  /></li>
	<?php else:?>
	<li>还没页面，<a href="page.php">新建页面</a></li>
	<?php endif;?> 
	</ul>
</div>
</form>
</div>
<script>
$("#navi_add_custom").css('display', $.cookie('em_navi_add_custom') ? $.cookie('em_navi_add_custom') : '');
$("#navi_add_sort").css('display', $.cookie('em_navi_add_sort') ? $.cookie('em_navi_add_sort') : '');
$("#navi_add_page").css('display', $.cookie('em_navi_add_page') ? $.cookie('em_navi_add_page') : '');
$(document).ready(function(){
	$("#adm_navi_list tbody tr:odd").addClass("tralt_b");
	$("#adm_navi_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")})
});
setTimeout(hideActived,2600);
$("#menu_navbar").addClass('sidebarsubmenu1');
</script>