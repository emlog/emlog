<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="containertitle2">
<?php if (ROLE == ROLE_ADMIN):?>
<a class="navi1" href="./configure.php"><? echo $lang['base_settings']; ?></a>
<a class="navi4" href="./seo.php"><? echo $lang['seo_settings']; ?></a>
<a class="navi4" href="./style.php"><? echo $lang['backstage_style']; ?></a>
<a class="navi2" href="./blogger.php"><? echo $lang['personal_data']; ?></a>
<?php else:?>
<a class="navi1" href="./blogger.php"><? echo $lang['personal_data']; ?></a>
<?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="actived"><? echo $lang['personal_data_saved_ok'];?></span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="actived"><? echo $lang['photo_deleted_ok'];?></span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error"><? echo $lang['nickname_is_long']; ?></span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error"><? echo $lang['email_format_invalid']; ?></span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="error">密码长度不得小于6位</span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="error">两次输入的密码不一致</span><?php endif;?>
<?php if(isset($_GET['error_e'])):?><span class="error">要修改的登录名已存在</span><?php endif;?>
</div>
<div style="margin-left:30px;">
<form action="blogger.php?action=update" method="post" name="blooger" id="blooger" enctype="multipart/form-data">
<div class="item_edit">
	<li>
	<?php echo $icon; ?><input type="hidden" name="photo" value="<?php echo $photo; ?>"/><br />
	<? echo $lang['photo_info']; ?><br />
    <input name="photo" type="file" /> <? echo $lang['image_type_support']; ?>
	</li>
	<li>昵称<br /><input maxlength="50" style="width:200px;" class="input" value="<?php echo $nickname; ?>" name="name" /> </li>
	<li>邮箱<br /><input name="email" class="input" value="<?php echo $email; ?>" style="width:200px;" maxlength="200" /></li>
	<li>个人描述<br /><textarea name="description" class="textarea" style="width:300px; height:65px;" type="text" maxlength="500"><?php echo $description; ?></textarea></li>
	<li><input maxlength="200" style="width:200px;" class="input" value="<?php echo $username; ?>" name="username" /> 登陆名</li>
    <li><input type="password" maxlength="200" class="input" style="width:200px;" value="" name="newpass" /> 新密码（不小于6位，不修改请留空）</li>
	<li><input type="password" maxlength="200" class="input" style="width:200px;" value="" name="repeatpass" /> 再输入一次新密码</li>
    <li><input type="submit" value="保存资料" class="button" /></li>
</div>
</form>
<script>
$("#chpwd").css('display', $.cookie('em_chpwd') ? $.cookie('em_chpwd') : 'none');
setTimeout(hideActived,2600);
</script>