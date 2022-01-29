<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['activated'])): ?>
    <div class="alert alert-success">设置保存成功</div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">设置</h1>
</div>
<div class="panel-heading">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./setting.php">基础设置</a></li>
        <li class="nav-item"><a class="nav-link active" href="./setting.php?action=user">用户设置</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=mail">邮件通知</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=seo">SEO优化</a></li>
        <li class="nav-item"><a class="nav-link" href="./blogger.php">个人信息</a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="setting.php?action=user_save" method="post" name="input" id="input">
            <h4>登录注册</h4>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="is_signup" id="is_signup" <?= $conf_is_signup ?> />
                <label>开启注册</label>
            </div>
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="y" name="login_code" id="login_code" <?= $conf_login_code ?> >
                <label class="form-check-label">登录注册验证码</label>
            </div>
            <h4>用户权限</h4>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="writer_permission" id="writer_permission" <?= $writer_permission ?> />
                <label>发布文章</label>
                <input class="form-check-input" type="checkbox" value="y" name="writer_permission" id="writer_permission" <?= $writer_permission ?> />
                <label>发布评论</label>
            </div>
            <h4>游客权限</h4>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="writer_permission" id="writer_permission" <?= $writer_permission ?> />
                <label>发布评论</label>
            </div>
            <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
            <input type="submit" value="保存设置" class="btn btn-sm btn-success"/>
        </form>
    </div>
</div>
<script>
    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('show');
    $("#menu_setting").addClass('active');
    setTimeout(hideActived, 2600);
</script>
