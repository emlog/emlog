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
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=api">API接口</a></li>
        <li class="nav-item"><a class="nav-link" href="./blogger.php">个人信息</a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="setting.php?action=user_save" method="post" name="input" id="input">
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="y" name="is_signup" id="is_signup" <?= $conf_is_signup ?> />
                <label class="form-check-label">开启用户注册</label>
            </div>
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="y" name="login_code" id="login_code" <?= $conf_login_code ?> >
                <label class="form-check-label">开启登录注册图形验证码（提高安全性，建议开启）</label>
            </div>
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="y" name="email_code" id="email_code" <?= $conf_email_code ?> >
                <label class="form-check-label">开启注册邮件验证码</label>
            </div>
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="y" name="ischkarticle" id="ischkarticle" <?= $conf_ischkarticle ?> />
                <label class="form-check-label">注册用户发布文章需要审核</label>
            </div>
            <div class="form-group form-inline">
                <label>注册用户限制24小时发文数量（包括草稿）：</label>
                <input class="form-control mx-sm-3" style="width:60px;" value="<?= $conf_posts_per_day ?>" type="number" name="posts_per_day"/>
            </div>
            <div class="form-group">
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
                <input type="submit" value="保存设置" class="btn btn-sm btn-success"/>
            </div>
        </form>
        <div class="alert alert-warning">
            <b>用户组</b><br>
            注册用户：通过注册产生，可以发布文章、笔记、上传图片等<br>
            内容编辑：负责文章、资源、评论等内容的管理<br>
            管理员：拥有站点全部管理权限，可以管理用户、进行系统设置等<br>
        </div>
    </div>
</div>
<script>
    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('show');
    $("#menu_setting").addClass('active');
    setTimeout(hideActived, 2600);
</script>
