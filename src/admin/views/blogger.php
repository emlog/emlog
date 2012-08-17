<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="containertitle2">
<?php if (ROLE == 'admin'):?>
<a class="navi1" href="./configure.php">基本设置</a>
<a class="navi4" href="./style.php">后台风格</a>
<a class="navi4" href="./permalink.php">日志链接</a>
<a class="navi2" href="./blogger.php">个人资料</a>
<?php else:?>
<a class="navi1" href="./blogger.php">个人资料</a>
<?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="actived">个人资料修改成功</span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="actived">头像删除成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">昵称不能太长</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">电子邮件格式错误</span><?php endif;?>
</div>
<div style="margin-left:30px;">
<form action="blogger.php?action=update" method="post" name="blooger" id="blooger" enctype="multipart/form-data" class="mb-8">
<div id="blogger">
	<li>
	<?php echo $icon; ?><input type="hidden" name="photo" value="<?php echo $photo; ?>"/><br />
	头像<br />
    <input name="photo" type="file" /> (支持JPG、PNG格式图片)
	</li>
	<li>昵称<br /><input maxlength="50" style="width:185px;" value="<?php echo $nickname; ?>" name="name" /> </li>
	<li>电子邮件<br /><input name="email" value="<?php echo $email; ?>" style="width:185px;" maxlength="200" /></li>
	<li>个人描述<br /><textarea name="description" style="width:300px; height:65px;" type="text" maxlength="500"><?php echo $description; ?></textarea></li>
	<li><input type="submit" value="保存资料" class="button" /></li>
</div>
</form>
<div style="margin:30px 0px 10px;"><a href="javascript:displayToggle('chpwd', 2);">修改密码及登录名+</a></div>
<form action="blogger.php?action=update_pwd" method="post" name="blooger" id="blooger">
<div id="chpwd">
	<li><input type="password" maxlength="200" style="width:185px;" value="" name="oldpass" /> 当前密码</li>
	<li><input type="password" maxlength="200" style="width:185px;" value="" name="newpass" /> 新密码（不小于6位）</li>
	<li><input type="password" maxlength="200" style="width:185px;" value="" name="repeatpass" /> 重复新密码</li>
	<li><input maxlength="200" style="width:185px;" name="username" /> 登录名</li>
	<li><input type="submit" value="确认修改" class="button" /></li>
</div>
</form>
</div>
<script>
$("#chpwd").css('display', $.cookie('em_chpwd') ? $.cookie('em_chpwd') : 'none');
setTimeout(hideActived,2600);
</script>