<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="containertitle2">
<?php if (ROLE == 'admin'):?>
<a class="navi1" href="./configure.php"><? echo $lang['base_settings']; ?></a>
<a class="navi4" href="./style.php"><? echo $lang['backstage_style']; ?></a>
<a class="navi4" href="./permalink.php"><? echo $lang['permalink']; ?></a>
<a class="navi2" href="./blogger.php"><? echo $lang['personal_data']; ?></a>
<?php else:?>
<a class="navi1" href="./blogger.php"><? echo $lang['personal_data']; ?></a>
<?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="actived"><? echo $lang['personal_data_saved_ok'];?></span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="actived"><? echo $lang['photo_deleted_ok'];?></span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error"><? echo $lang['nickname_is_long']; ?></span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error"><? echo $lang['email_format_invalid']; ?></span><?php endif;?>
</div>
<div style="margin-left:20px;">
<form action="blogger.php?action=update" method="post" name="blooger" id="blooger" enctype="multipart/form-data" class="mb-8">
<div>
	<li><?php echo $icon; ?><input type="hidden" name="photo" value="<?php echo $photo; ?>"/></li>
	<li>头像 (120X120 的jpg或png图片)</li>
	<li><input name="photo" type="file" style="width:245px;" /></li>
	<li><input maxlength="50" style="width:210px;" value="<?php echo $nickname; ?>" name="name" /></li>
	<li><? echo $lang['email'];?></li>
	<li><input name="email" value="<?php echo $email; ?>" style="width:210px;" maxlength="200" /></li>
	<li><? echo $lang['personal_description'];?></li>
	<li><textarea name="description" style="width:300px; height:65px;" type="text" maxlength="500"><?php echo $description; ?></textarea></li>
	<li><input type="submit" value="<? echo $lang['personal_data_save'];?>" class="submit" /></li>
	<li style="margin-top:30px;"><a href="javascript:displayToggle('chpwd', 2);"><? echo $lang['modify_login_password']; ?>+</a></li>
</div>
</form>
<form action="blogger.php?action=update_pwd" method="post" name="blooger" id="blooger">
<div id="chpwd">
	<li><? echo $lang['password_current'];?></li>
	<li><input type="password" maxlength="200" style="width:200px;" value="" name="oldpass" /></li>
	<li><? echo $lang['password_new'];?></li>
	<li><input type="password" maxlength="200" style="width:200px;" value="" name="newpass" /></li>
	<li><? echo $lang['password_new_confirm'];?></li>
	<li><input type="password" maxlength="200" style="width:200px;" value="" name="repeatpass" /></li>
	<li><? echo $lang['user_name'];?></li>
	<li><input maxlength="200" style="width:200px;" name="username" /></li>
	<li></li>
	<li><input type="submit" value="<? echo $lang['save changes'];?>" class="submit" /></li>
</div>
</form>
</div>
<script>
$("#chpwd").css('display', $.cookie('em_chpwd') ? $.cookie('em_chpwd') : 'none');
setTimeout(hideActived,2600);
</script>