<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['error_nickname'])): ?>
    <div class="alert alert-danger"><?= _lang('nickname_required') ?></div><?php endif ?>
<?php if (isset($_GET['error_email'])): ?>
    <div class="alert alert-danger"><?= _lang('email_username_empty') ?></div><?php endif ?>
<?php if (isset($_GET['error_exist'])): ?>
    <div class="alert alert-danger"><?= _lang('username_exists') ?></div><?php endif ?>
<?php if (isset($_GET['error_exist_email'])): ?>
    <div class="alert alert-danger"><?= _lang('error_exist_email') ?></div><?php endif ?>
<?php if (isset($_GET['error_pwd_len'])): ?>
    <div class="alert alert-danger"><?= _lang('password_min_length') ?></div><?php endif ?>
<?php if (isset($_GET['error_pwd2'])): ?>
    <div class="alert alert-danger"><?= _lang('password_inconsistent') ?></div><?php endif ?>
<h1 class="h4 mb-4 text-gray-800"><?= _lang('edit_user_info') ?></h1>
<div class="card shadow mb-4 mt-4">
    <div class="card-body">
        <form action="user.php?action=update" method="post">
            <div class="form-group">
                <p><img src="<?= User::getAvatar($avatar) ?>" height="65" width="65" class="rounded-circle" /> </p>
                <label for="avatar"><?= _lang('avatar') ?></label>
                <input class="form-control" value="<?= $avatar ?>" name="avatar" id="avatar" placeholder="<?= _lang('input_avatar_url') ?>">
            </div>
            <div class="form-group">
                <label for="nickname"><?= _lang('nickname') ?></label>
                <input class="form-control" value="<?= $nickname ?>" name="nickname" id="nickname" maxlength="20" required>
            </div>
            <div class="form-group">
                <label for="email"><?= _lang('email') ?></label>
                <input type="email" class="form-control" value="<?= $email ?>" name="email" id="email">
            </div>
            <div class="form-group">
                <label for="role"><?= _lang('user_group') ?></label>
                <select name="role" id="role" class="form-control">
                    <option value="writer" <?= $ex1 ?>><?= _lang('registered_user') ?></option>
                    <option value="editor" <?= $ex2 ?>><?= _lang('role_editor') ?></option>
                    <option value="admin" <?= $ex3 ?>><?= _lang('role_admin') ?></option>
                </select>
            </div>
            <div class="form-group">
                <label for="description"><?= _lang('personal_description') ?></label>
                <textarea name="description" id="description" type="text" class="form-control"><?= $description ?></textarea>
            </div>
            <div class="form-group">
                <label for="username"><?= _lang('username_login_tip') ?></label>
                <input class="form-control" value="<?= $username ?>" name="username" id="username">
            </div>
            <div class="form-group">
                <label for="password"><?= _lang('new_password_tip') ?></label>
                <input type="password" class="form-control" autocomplete="new-password" name="password" id="password">
            </div>
            <div class="form-group">
                <label for="password2"><?= _lang('repeat_new_password') ?></label>
                <input type="password" class="form-control" name="password2" id="password2">
            </div>
            <div class="form-group">
                <label for="credits"><?= _lang('credits') ?></label>
                <input class="form-control" value="<?= $credits ?>" name="credits" id="credits" type="number" min="0" step="1" max="999999999" required>
            </div>
            <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
            <input type="hidden" value="<?= $uid ?>" name="uid" />
            <input type="submit" value="<?= _lang('save') ?>" class="btn btn-sm btn-success" />
            <input type="button" value="<?= _lang('cancel') ?>" class="btn btn-sm btn-secondary" onclick="window.location='user.php';" />
        </form>
    </div>
</div>
<script>
    $(function() {
        setTimeout(hideActived, 3600);
        $("#menu_user").addClass('active');
    });
</script>