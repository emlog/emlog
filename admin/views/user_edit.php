<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<?php if (isset($_GET['error_nickname'])): ?>
    <div class="alert alert-danger">昵称不能都为空</div><?php endif ?>
<?php if (isset($_GET['error_email'])): ?>
    <div class="alert alert-danger">邮箱不能都为空</div><?php endif ?>
<?php if (isset($_GET['error_exist'])): ?>
    <div class="alert alert-danger">用户名已被占用</div><?php endif ?>
<?php if (isset($_GET['error_exist_email'])): ?>
    <div class="alert alert-danger">邮箱已被占用</div><?php endif ?>
<?php if (isset($_GET['error_pwd_len'])): ?>
    <div class="alert alert-danger">密码长度不得小于6位</div><?php endif ?>
<?php if (isset($_GET['error_pwd2'])): ?>
    <div class="alert alert-danger">两次输入密码不一致</div><?php endif ?>
<h1 class="h3 mb-4 text-gray-800">修改资料</h1>
<div class="card shadow mb-4 mt-4">
    <div class="card-body">
        <form action="user.php?action=update" method="post">
            <div class="form-group">
                <label for="nickname">昵称</label>
                <input class="form-control" value="<?= $nickname ?>" name="nickname" id="nickname" maxlength="20" required>
            </div>
            <div class="form-group">
                <label for="email">邮箱</label>
                <input type="email" class="form-control" value="<?= $email ?>" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="role">用户组</label>
                <select name="role" id="role" class="form-control">
                    <option value="writer" <?= $ex1 ?>>注册用户</option>
                    <option value="editor" <?= $ex2 ?>>内容编辑</option>
                    <option value="admin" <?= $ex3 ?>>管理员</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">个人描述</label>
                <textarea name="description" type="text" class="form-control"><?= $description ?></textarea>
            </div>
            <div class="form-group">
                <label for="username">用户名（为空则使用邮箱登录）</label>
                <input class="form-control" value="<?= $username ?>" name="username" id="username">
            </div>
            <div class="form-group">
                <label for="password">新密码(不修改请留空)</label>
                <input type="password" class="form-control" autocomplete="new-password" name="password" id="password">
            </div>
            <div class="form-group">
                <label for="password2">再次输入新密码</label>
                <input type="password" class="form-control" name="password2" id="password2">
            </div>
            <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
            <input type="hidden" value="<?= $uid ?>" name="uid"/>
            <input type="submit" value="保存" class="btn btn-sm btn-success"/>
            <input type="button" value="取消" class="btn btn-sm btn-secondary" onclick="window.location='user.php';"/>
        </form>
    </div>
</div>
<script>
    $(function () {
        setTimeout(hideActived, 3600);
        $("#menu_category_sys").addClass('active');
        $("#menu_sys").addClass('show');
        $("#menu_user").addClass('active');

        if ($("#role").val() == 'admin') $("#ischeck").hide();
        $("#role").change(function () {
            $("#ischeck").toggle()
        })
    });
</script>
