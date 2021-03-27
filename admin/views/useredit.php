<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<?php if (isset($_GET['error_login'])): ?>
    <div class="alert alert-danger">用户名不能为空</div><?php endif; ?>
<?php if (isset($_GET['error_exist'])): ?>
    <div class="alert alert-danger">该用户名已存在</div><?php endif; ?>
<?php if (isset($_GET['error_pwd_len'])): ?>
    <div class="alert alert-danger">密码长度不得小于6位</div><?php endif; ?>
<?php if (isset($_GET['error_pwd2'])): ?>
    <div class="alert alert-danger">两次输入密码不一致</div><?php endif; ?>
<h1 class="h3 mb-4 text-gray-800">修改作者资料</h1>
<form action="user.php?action=update" method="post">
    <div class="form-group">
        <label for="username">用户名</label>
        <input class="form-control" value="<?php echo $username; ?>" name="username" id="username">
    </div>
    <div class="form-group">
        <label for="nickname">昵称</label>
        <input class="form-control" value="<?php echo $nickname; ?>" name="nickname" id="nickname">
    </div>
    <div class="form-group">
        <label for="password">新密码(不修改请留空)</label>
        <input type="password" class="form-control" name="password" id="password">
    </div>
    <div class="form-group">
        <label for="password2">重复新密码</label>
        <input type="password" class="form-control" name="password2" id="password2">
    </div>
    <div class="form-group">
        <label for="email">电子邮件</label>
        <input class="form-control" value="<?php echo $email; ?>" name="email" id="email">
    </div>
    <div class="form-group">
        <select name="role" id="role" class="form-control">
<!--vot-->          <option value="writer" <?php echo $ex1; ?>><?=lang('user')?></option>
<!--vot-->          <option value="admin" <?php echo $ex2; ?>><?=lang('admin')?></option>
        </select>
    </div>
    <div class="form-group" id="ischeck">
        <select name="ischeck" class="form-control">
<!--vot-->          <option value="n" <?php echo $ex3; ?>><?=lang('posts_not_need_audit')?></option>
<!--vot-->          <option value="y" <?php echo $ex4; ?>><?=lang('posts_need_audit')?></option>
        </select>
    </div>
    <div class="form-group">
        <label for="description">个人描述</label>
        <textarea name="description" type="text" class="form-control"><?php echo $description; ?></textarea>
    </div>
    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
    <input type="hidden" value="<?php echo $uid; ?>" name="uid"/>
<!--vot-->      <input type="submit" value="<?=lang('save')?>" class="btn btn-success">
<!--vot-->      <input type="button" value="<?=lang('cancel')?>" class="btn btn-default" onclick="window.location='user.php';"></li>
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
