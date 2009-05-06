<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<div class=containertitle><b>修改链接</b></div>
<div class=line></div>
<form action="user.php?action=update" method="post">
<div>
	<li>用户名</li>
	<li><input size="40" value="<?php echo $username; ?>" name="username" /></li>
	<li>昵称</li>
	<li><input size="40" value="<?php echo $nickname; ?>" name="nickname" /></li>
	<li>电子邮件</li>
	<li><input size="40" value="<?php echo $email; ?>" name="email" /></li>
	<li>个人描述</li>
	<li><textarea name="description" rows="3" cols="45"><?php echo $description; ?></textarea></li>
	<li>
	<input type="hidden" value="<?php echo $uid; ?>" name="uid" />
	<input type="submit" value="确 定" class="submit" />
	<input type="button" value="取 消" class="submit" onclick="javascript: window.history.back();""/></li>
</div>
</form>
<script>
$("#menu_user").addClass('sidebarsubmenu1');
</script>