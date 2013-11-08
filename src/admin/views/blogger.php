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
<?php if(isset($_GET['error_c'])):?><span class="error"><? echo $lang['password_short']; ?></span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="error"><? echo $lang['password_not_equal']; ?></span><?php endif;?>
<?php if(isset($_GET['error_e'])):?><span class="error"><? echo $lang['username_allready_exists']; ?></span><?php endif;?>
</div>
<div style="margin-left:30px;">
<form action="blogger.php?action=update" method="post" name="blooger" id="blooger" enctype="multipart/form-data">
<div class="item_edit">
	<li>
	<?php echo $icon; ?><input type="hidden" name="photo" value="<?php echo $photo; ?>"/><br />
	<? echo $lang['photo_info']; ?><br />
    <input name="photo" type="file" /> <? echo $lang['image_type_support']; ?>
	</li>
	<li><? echo $lang['nickname']; ?><br /><input maxlength="50" style="width:200px;" class="input" value="<?php echo $nickname; ?>" name="name" /> </li>
	<li><? echo $lang['email'];?><br /><input name="email" class="input" value="<?php echo $email; ?>" style="width:200px;" maxlength="200" /></li>
	<li><? echo $lang['description']; ?><br /><textarea name="description" class="textarea" style="width:300px; height:65px;" type="text" maxlength="500"><?php echo $description; ?></textarea></li>
	<li><input maxlength="200" style="width:200px;" class="input" value="<?php echo $username; ?>" name="username" /> <? echo $lang['login_name']; ?></li>
    <li><input type="password" maxlength="200" class="input" style="width:200px;" value="" name="newpass" /> <? echo $lang['password_new']; ?> <? echo $lang['password_not_less']; ?></li>
	<li><input type="password" maxlength="200" class="input" style="width:200px;" value="" name="repeatpass" /> <? echo $lang['password_repeat']; ?></li>
    <li><input type="submit" value="<? echo $lang['personal_data_save']; ?>" class="button" /></li>
</div>
</form>
<script>
$("#chpwd").css('display', $.cookie('em_chpwd') ? $.cookie('em_chpwd') : 'none');
setTimeout(hideActived,2600);
</script>