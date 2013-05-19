<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="containertitle2">
<?php if (ROLE == 'admin'):?>
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
</div>
<div style="margin-left:30px;">
<form action="blogger.php?action=update" method="post" name="blooger" id="blooger" enctype="multipart/form-data">
<div class="item_edit">
	<li>
	<?php echo $icon; ?><input type="hidden" name="photo" value="<?php echo $photo; ?>"/><br />
	<? echo $lang['photo_info']; ?><br />
    <input name="photo" type="file" /> <? echo $lang['image_type_support']; ?>
	</li>
	<li><? echo $lang['nickname']; ?><br /><input maxlength="50" style="width:185px;" value="<?php echo $nickname; ?>" name="name" /></li>
	<li><? echo $lang['email'];?><br /><input name="email" value="<?php echo $email; ?>" style="width:185px;" maxlength="200" /></li>
	<li><? echo $lang['personal_description'];?><br /><textarea name="description" style="width:300px; height:65px;" type="text" maxlength="500"><?php echo $description; ?></textarea></li>
	<li><input type="submit" value="<? echo $lang['personal_data_save'];?>" class="button" /></li>
</div>
</form>
<div style="margin:30px 0px 10px;"><a href="javascript:displayToggle('chpwd', 2);" class="care"><? echo $lang['modify_login_password']; ?>+</a></div>
<form action="blogger.php?action=update_pwd" method="post" name="blooger" id="blooger">
<div id="chpwd" class="item_edit">
	<li><input type="password" maxlength="200" style="width:185px;" value="" name="oldpass" /> <? echo $lang['password_current'];?></li>
	<li><input type="password" maxlength="200" style="width:185px;" value="" name="newpass" /> <? echo $lang['password_new'];?></li>
	<li><input type="password" maxlength="200" style="width:185px;" value="" name="repeatpass" /> <? echo $lang['password_new_confirm'];?></li>
	<li><input maxlength="200" style="width:185px;" name="username" /> <? echo $lang['user_name'];?></li>
	<li><input type="submit" value="<? echo $lang['save changes'];?>" class="button" /></li>
</div>
</form>
</div>
<script>
$("#chpwd").css('display', $.cookie('em_chpwd') ? $.cookie('em_chpwd') : 'none');
setTimeout(hideActived,2600);
</script>