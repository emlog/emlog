<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<div class=containertitle><b>作者管理</b>
<?php if(isset($_GET['active_del'])):?><span class="actived">删除作者成功</span><?php endif;?>
<?php if(isset($_GET['active_add'])):?><span class="actived">添加作者成功</span><?php endif;?>
<?php if(isset($_GET['error_login'])):?><span class="error">用户名不能为空</span><?php endif;?>
<?php if(isset($_GET['error_pwd_len'])):?><span class="error">密码长度不得小于6位</span><?php endif;?>
<?php if(isset($_GET['error_pwd2'])):?><span class="error">两次输入密码不一致</span><?php endif;?>
</div>
<div class=line></div>
<form action="comment.php?action=admin_all_coms" method="post" name="form" id="form">
  <table width="95%" id="adm_comment_list">
  	<thead>
      <tr class="rowstop">
        <td width="60"><b>用户名</b></td>
        <td width="130"><b>昵称</b></td>
		<td width="60" align="center"><b>日志数</b></td>
        <td width="260"><b>电子邮件</b></td>
      </tr>
    </thead>
    <tbody>
	<?php
	foreach($users as $key => $val):
	?>
     <tr>
        <td><a href="user.php?action=mod&id=<?php echo $value['uid']?>"><?php echo $val['login']; ?></a></td>
		<td><?php echo $val['name']; ?></td>
		<td align="center"></td>
        <td><?php echo $val['email']; ?></td>
     </tr>
	<?php endforeach; ?>
	</tbody>
  </table>
</form>
<form action="user.php?action=new" method="post">
<div style="margin:30px 0px 0px 3px;"><a href="javascript:$('#user_new').toggle();void(0);">添加作者&raquo;</a></div>
<div id="user_new" style="display:none;">
<table width="500" id="adm_comment_list" cellpadding="2">
	<tr>
		<td align="right">用户名</td>
		<td ><input name="login" type="text" id="login" value="" style="width:150px;" /> (登录时所用的名称)</td>
	</tr>
	<tr>
		<td align="right">昵称</td>
		<td ><input name="name" type="text" id="name" value="" style="width:150px;" /></td>
	</tr>
	<tr>
		<td align="right">密码</td>
		<td ><input name="password" type="password" id="password" value="" style="width:150px;" /></td>
	</tr>
	<tr>
		<td align="right"></td>
		<td ><input name="password2" type="password" id="password2" value="" style="width:150px;" /> (重复输入密码)</td>
	</tr>
	<tr>
		<td align="right">电子邮件</td>
		<td ><input name="email" type="text" id="email" value="" style="width:240px;" /></td>
	</tr>
	<tr>
		<td valign="top" align="right">描述</td>
		<td ><textarea name="description" rows="3" cols="" style="width:260px;" type="text" maxlength="500"></textarea></td>
	</tr>
	<tr>
		<td align="right">角色</td>
		<td >		
		<select name="role" id="role">
		<option selected='selected' value='writer'>作者(联合撰稿人)</option>
		</select>
		</td>
	</tr>
    <tr>
    <td></td>
    <td align="center"">
    <input type="submit" value="添加作者" class="submit" />
    </td>
	</tr>
</table>
</div>
</form>
<script type='text/javascript'>
$(document).ready(function(){
	$("#adm_comment_list tbody tr:odd").addClass("tralt_b");
	$("#adm_comment_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")})
});
setTimeout(hideActived,2600);
</script>