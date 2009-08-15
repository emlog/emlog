<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b>作者管理</b>
<?php if(isset($_GET['active_del'])):?><span class="actived">删除作者成功</span><?php endif;?>
<?php if(isset($_GET['active_update'])):?><span class="actived">修改作者资料成功</span><?php endif;?>
<?php if(isset($_GET['active_add'])):?><span class="actived">添加作者成功</span><?php endif;?>
<?php if(isset($_GET['error_login'])):?><span class="error">用户名不能为空</span><?php endif;?>
<?php if(isset($_GET['error_exist'])):?><span class="error">该用户名已存在</span><?php endif;?>
<?php if(isset($_GET['error_pwd_len'])):?><span class="error">密码长度不得小于6位</span><?php endif;?>
<?php if(isset($_GET['error_pwd2'])):?><span class="error">两次输入密码不一致</span><?php endif;?>
</div>
<div class=line></div>
<form action="comment.php?action=admin_all_coms" method="post" name="form" id="form">
  <table width="100%" id="adm_comment_list" class="item_list">
  	<thead>
      <tr>
        <th width="90"><b>用户名</b></th>
        <th width="100"><b>昵称</b></th>
        <th width="260"><b>个人描述</b></th>
        <th width="80"><b>电子邮件</b></th>
		<th width="30" class="tdcenter"><b>日志</b></th>
		<th width="130"></th>
      </tr>
    </thead>
    <tbody>
	<?php
	foreach($users as $key => $val):
	?>
     <tr>
        <td><a href="user.php?action=edit&uid=<?php echo $val['uid']?>"><?php echo $val['login']; ?></a></td>
		<td><?php echo $val['name']; ?></td>
		<td><?php echo $val['description']; ?></td>
		<td><?php echo $val['email']; ?></td>
		<td class="tdcenter"><a href="./admin_log.php?uid=<?php echo $val['uid'];?>"><?php echo $user_cache[$val['uid']]['lognum']; ?></a></td>
		<td><a href="javascript: em_confirm(<?php echo $val['uid']; ?>, 'user');">删除</a></td>
     </tr>
	<?php endforeach; ?>
	</tbody>
  </table>
</form>
<form action="user.php?action=new" method="post">
<div style="margin:30px 0px 10px 0px;"><a href="javascript:displayToggle('user_new', 2);">添加作者(联合撰写人)&raquo;</a></div>
<div id="user_new">
	<li>用户名</li>
	<li><input name="login" type="text" id="login" value="" style="width:180px;" /></li>
	<li>密码</li>
	<li><input name="password" type="password" id="password" value="" style="width:180px;" /></li>
	<li>重复密码</li>
	<li><input name="password2" type="password" id="password2" value="" style="width:180px;" /></li>
	<li><br></li>
	<li><input type="submit" name="" value="添加作者"  /></li>
</div>
</div>
</form>
<script type='text/javascript'>
$("#user_new").css('display', $.cookie('em_user_new') ? $.cookie('em_user_new') : 'none');
$(document).ready(function(){
	$("#adm_comment_list tbody tr:odd").addClass("tralt_b");
	$("#adm_comment_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")})
});
setTimeout(hideActived,2600);
$("#menu_user").addClass('sidebarsubmenu1');
</script>