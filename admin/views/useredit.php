<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['error_login'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('user_name_empty')?></div><?php endif; ?>
<?php if (isset($_GET['error_exist'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('user_name_exists')?></div><?php endif; ?>
<?php if (isset($_GET['error_pwd_len'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('password_length_short')?></div><?php endif; ?>
<?php if (isset($_GET['error_pwd2'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('passwords_not_equal')?></div><?php endif; ?>
<!--vot--><h1 class="h3 mb-4 text-gray-800"><?=lang('user_manage')?></h1>
<form action="user.php?action=update" method="post">
    <div class="form-group">
<!--vot--><label for="username"><?=lang('user_name')?></label>
<!--vot--><input class="form-control" value="<?php echo $username; ?>" name="username" id="username" required>
    </div>
    <div class="form-group">
<!--vot--><label for="nickname"><?=lang('nickname')?></label>
        <input class="form-control" value="<?php echo $nickname; ?>" name="nickname" id="nickname">
    </div>
    <div class="form-group">
<!--vot--><label for="password"><?=lang('password_new')?></label>
        <input type="password" class="form-control" name="password" id="password">
    </div>
    <div class="form-group">
<!--vot--><label for="password2"><?=lang('password_new_repeat')?></label>
        <input type="password" class="form-control" name="password2" id="password2">
    </div>
    <div class="form-group">
<!--vot--><label for="email"><?=lang('email')?></label>
        <input class="form-control" value="<?php echo $email; ?>" name="email" id="email">
    </div>
    <div class="form-group">
        <select name="role" id="role" class="form-control">
<!--vot-->  <option value="writer" <?php echo $ex1; ?>><?=lang('user')?></option>
<!--vot-->  <option value="admin" <?php echo $ex2; ?>><?=lang('admin')?></option>
        </select>
    </div>
    <div class="form-group" id="ischeck">
        <select name="ischeck" class="form-control">
<!--vot-->  <option value="n" <?php echo $ex3; ?>><?=lang('posts_not_need_audit')?></option>
<!--vot-->  <option value="y" <?php echo $ex4; ?>><?=lang('posts_need_audit')?></option>
        </select>
    </div>
    <div class="form-group">
<!--vot--><label for="description"><?=lang('personal_description')?></label>>
        <textarea name="description" type="text" class="form-control"><?php echo $description; ?></textarea>
    </div>
    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
    <input type="hidden" value="<?php echo $uid; ?>" name="uid"/>
<!--vot--><input type="submit" value="<?=lang('save')?>" class="btn btn-sm btn-success"/>
<!--vot--><input type="button" value="<?=lang('cancel')?>" class="btn btn-sm btn-secondary" onclick="window.location='user.php';"/>
</form>

<script>
    setTimeout(hideActived, 2600);
    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('show');
    $("#menu_user").addClass('active');

    if ($("#role").val() == 'admin') $("#ischeck").hide();
    $("#role").change(function () {
        $("#ischeck").toggle()
    })
</script>
