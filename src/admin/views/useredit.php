<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b><? echo $lang['personal_data_edit'];?></b>
<?php if(isset($_GET['error_login'])):?><span class="error"><? echo $lang['user_name_empty'];?></span><?php endif;?>
<?php if(isset($_GET['error_exist'])):?><span class="error"><? echo $lang['user_allready_exists'];?></span><?php endif;?>
<?php if(isset($_GET['error_pwd_len'])):?><span class="error"><? echo $lang['password_short'];?></span><?php endif;?>
<?php if(isset($_GET['error_pwd2'])):?><span class="error"><? echo $lang['password_not_equal'];?></span><?php endif;?>
</div>
<div class=line></div>
<form action="user.php?action=update" method="post">
<div class="item_edit">
	<li><input type="text" value="<?php echo $username; ?>" name="username" style="width:200px;" class="input" /><? echo $lang['user_name']; ?></li>
	<li><input type="text" value="<?php echo $nickname; ?>" name="nickname" style="width:200px;" class="input" /><? echo $lang['nickname']; ?></li>
	<li><input type="password" value="" name="password" style="width:200px;" class="input" /><? echo $lang['password_new']; ?> (<? echo $lang['password_leave_empty']; ?>)</li>
	<li><input type="password" value="" name="password2" style="width:200px;" class="input" /><? echo $lang['password_new_confirm']; ?></li>
	<li><input type="text"  value="<?php echo $email; ?>" name="email" style="width:200px;" class="input" /><? echo $lang['email']; ?></li>
    <li>
	<select name="role" id="role" class="input">
		<option value="writer" <?php echo $ex1; ?>><? echo $lang['author']; ?></option>
		<option value="admin" <?php echo $ex2; ?>><? echo $lang['administrator']; ?></option>
	</select>
	</li>
    <li id="ischeck">
	<select name="ischeck" class="input">
        <option value="n" <?php echo $ex3; ?>><? echo $lang['article_no_review']; ?></option>
		<option value="y" <?php echo $ex4; ?>><? echo $lang['article_to_review']; ?></option>
	</select>
	</li>
	<li><? echo $lang['personal_description']; ?><br />
	<textarea name="description" rows="5" style="width:260px;" class="textarea"><?php echo $description; ?></textarea></li>
	<li>
	<input type="hidden" value="<?php echo $uid; ?>" name="uid" />
	<input type="submit" value=" <? echo $lang['save'] ;?>" class="button" />
	<input type="button" value=" <? echo $lang['cancel'] ;?> " class="button" onclick="window.location='user.php';" /></li>
</div>
</form>
<script>
setTimeout(hideActived,2600);
$("#menu_user").addClass('sidebarsubmenu1');
if($("#role").val() == 'admin') $("#ischeck").hide();
$("#role").change(function(){$("#ischeck").toggle()})
</script>