<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<section class="content-header">
    <h1><?=lang('author_info_manage')?></h1>
    <div class="containertitle">
    <?php if(isset($_GET['error_login'])):?><span class="alert alert-danger"><?=lang('user_name_empty')?></span><?php endif;?>
    <?php if(isset($_GET['error_exist'])):?><span class="alert alert-danger"><?=lang('user_name_exists')?></span><?php endif;?>
    <?php if(isset($_GET['error_pwd_len'])):?><span class="alert alert-danger"><?=lang('password_length_short')?></span><?php endif;?>
    <?php if(isset($_GET['error_pwd2'])):?><span class="alert alert-danger"><?=lang('passwords_not_equal')?></span><?php endif;?>
    </div>
</section>
<section class="content">
<form action="user.php?action=update" method="post">
<div class="form-group">
<!--vot--><li><input type="text" value="<?php echo $username; ?>" name="username" style="width:200px;" class="form-control" /> <?=lang('user_name')?></li>
<!--vot--><li><input type="text" value="<?php echo $nickname; ?>" name="nickname" style="width:200px;" class="form-control" /> <?=lang('nickname')?></li>
<!--vot--><li><input type="password" value="" name="password" style="width:200px;" class="form-control" /> <?=lang('password_new')?></li>
<!--vot--><li><input type="password" value="" name="password2" style="width:200px;" class="form-control" /> <?=lang('password_new_repeat')?></li>
<!--vot--><li><input type="text"  value="<?php echo $email; ?>" name="email" style="width:200px;" class="form-control" /> <?=lang('email')?></li>
    <li>
	<select name="role" id="role" class="form-control">
<!--vot-->    <option value="writer" <?php echo $ex1; ?>><?=lang('user')?></option>
<!--vot-->    <option value="admin" <?php echo $ex2; ?>><?=lang('admin')?></option>
	</select>
	</li>
    <li id="ischeck">
	<select name="ischeck" class="form-control">
<!--vot-->    <option value="n" <?php echo $ex3; ?>><?=lang('posts_not_need_audit')?></option>
<!--vot-->    <option value="y" <?php echo $ex4; ?>><?=lang('posts_need_audit')?></option>
	</select>
	</li>
<!--vot--><li><?=lang('personal_description')?><br />
	<textarea name="description" rows="5" style="width:260px;" class="form-control"><?php echo $description; ?></textarea></li>
	<li>
    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
	<input type="hidden" value="<?php echo $uid; ?>" name="uid" />
<!--vot--><input type="submit" value="<?=lang('save')?>" class="btn btn-primary" />
<!--vot--><input type="button" value="<?=lang('cancel')?>" class="btn btn-default" onclick="window.location='user.php';" /></li>
</div>
</form>
</section>
<script>
setTimeout(hideActived,2600);
if($("#role").val() == 'admin') $("#ischeck").hide();
$("#role").change(function(){$("#ischeck").toggle()})
$("#menu_user").addClass('active').parent().parent().addClass('active');
</script>
