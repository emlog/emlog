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
	<li><input type="text" value="<?php echo $username; ?>" name="username" style="width:200px;" class="input" /> 用户名</li>
	<li><input type="text" value="<?php echo $nickname; ?>" name="nickname" style="width:200px;" class="input" /> 昵称</li>
	<li><input type="password" value="" name="password" style="width:200px;" class="input" /> 新密码(不修改请留空)</li>
	<li><input type="password" value="" name="password2" style="width:200px;" class="input" /> 重复新密码</li>
	<li><input type="text"  value="<?php echo $email; ?>" name="email" style="width:200px;" class="input" /> 电子邮件</li>
    <li>
	<select name="role" id="role" class="input">
		<option value="writer" <?php echo $ex1; ?>><? echo $lang['author']; ?></option>
		<option value="admin" <?php echo $ex2; ?>><? echo $lang['administrator']; ?></option>
	</select>
	</li>
    <li id="ischeck">
	<select name="ischeck" class="input">
        <option value="n" <?php echo $ex3; ?>>文章不需要审核</option>
		<option value="y" <?php echo $ex4; ?>>文章需要审核</option>
	</select>
	</li>
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