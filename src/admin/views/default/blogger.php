<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class=containertitle><b>个人资料</b>
<?php if(isset($_GET['active_edit'])):?><span class="actived">个人资料修改成功</span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="actived">头像删除成功</span><?php endif;?>
</div>
<div class=line></div>
<form action="blogger.php?action=update" method="post" name="blooger" id="blooger" enctype="multipart/form-data" class="mb-8">
<div>
	<li>昵称</li>
	<li><input maxlength="50" style="width:245px;" value="<?php echo $nickname; ?>" name="name" /></li>
	<li>电子邮件</li>
	<li><input name="email" value="<?php echo $email; ?>" style="width:245px;" maxlength="200" /></li>
	<?php if (ROLE == 'admin'):?>
	<li><?php echo $icon; ?><input type="hidden" name="photo" value="<?php echo $photo; ?>"/></li>
	<li>头像 (推荐上传大小为185 X 230，格式为jpg或png的图片)</li>
	<li><input name="photo" type="file" style="width:245px;" /></li>
	<?php endif;?>
	<li>个人描述</li>
	<li><textarea name="description" rows="5" cols="" style="width:300px;" type="text" maxlength="500"><?php echo $description; ?></textarea></li>
	<li><input type="submit" value="保存资料" class="submit" /></li>
</div>
</form>
<div class="containertitle"><b>修改密码/登录名</b></div>
<div class=line></div>
<form action="blogger.php?action=update_pwd" method="post" name="blooger" id="blooger">
<div>
	<li>当前密码</li>
	<li><input type="password" maxlength="200" style="width:200px;" value="" name="oldpass" /></li>
	<li>新密码</li>
	<li><input type="password" maxlength="200" style="width:200px;" value="" name="newpass" /></li>
	<li>重复新密码</li>
	<li><input type="password" maxlength="200" style="width:200px;" value="" name="repeatpass" /></li>
	<li>用户名</li>
	<li><input maxlength="200" style="width:200px;" name="username" /></li>
	<li></li>
	<li><input type="submit" value="确认修改" class="submit" /></li>
</div>
</form>