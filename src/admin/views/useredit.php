<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<!--vot--><div class=containertitle><b><?=lang('author_info_manage')?></b>
<!--vot--><?php if(isset($_GET['error_login'])):?><span class="error"><?=lang('user_name_empty')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_exist'])):?><span class="error"><?=lang('user_name_exists')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_pwd_len'])):?><span class="error"><?=lang('password_length_short')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_pwd2'])):?><span class="error"><?=lang('passwords_not_equal')?></span><?php endif;?>
</div>
<div class=line></div>
<form action="user.php?action=update" method="post">
<div class="item_edit">
<!--vot--><li><input type="text" value="<?php echo $username; ?>" name="username" style="width:200px;" class="input" /> <?=lang('user_name')?></li>
<!--vot--><li><input type="text" value="<?php echo $nickname; ?>" name="nickname" style="width:200px;" class="input" /> <?=lang('nickname')?></li>
<!--vot--><li><input type="password" value="" name="password" style="width:200px;" class="input" /> <?=lang('password_new')?></li>
<!--vot--><li><input type="password" value="" name="password2" style="width:200px;" class="input" /> <?=lang('password_new_repeat')?></li>
<!--vot--><li><input type="text"  value="<?php echo $email; ?>" name="email" style="width:200px;" class="input" /> <?=lang('email')?></li>
    <li>
	<select name="role" id="role" class="input">
<!--vot-->	<option value="writer" <?php echo $ex1; ?>><?=lang('user')?></option>
<!--vot-->	<option value="admin" <?php echo $ex2; ?>><?=lang('admin')?></option>
	</select>
	</li>
    <li id="ischeck">
	<select name="ischeck" class="input">
<!--vot-->	<option value="n" <?php echo $ex3; ?>><?=lang('posts_not_need_audit')?></option>
<!--vot-->	<option value="y" <?php echo $ex4; ?>><?=lang('posts_need_audit')?></option>
	</select>
	</li>
<!--vot--><li><?=lang('personal_description')?><br />
	<textarea name="description" rows="5" style="width:260px;" class="textarea"><?php echo $description; ?></textarea></li>
	<li>
    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
	<input type="hidden" value="<?php echo $uid; ?>" name="uid" />
<!--vot--><input type="submit" value="<?=lang('save')?>" class="button" />
<!--vot--><input type="button" value="<?=lang('cancel')?>" class="button" onclick="window.location='user.php';" /></li>
</div>
</form>
<script>
setTimeout(hideActived,2600);
$("#menu_user").addClass('sidebarsubmenu1');
if($("#role").val() == 'admin') $("#ischeck").hide();
$("#role").change(function(){$("#ischeck").toggle()})
</script>