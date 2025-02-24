<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">设置</h1>
</div>
<div class="panel-heading">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./setting.php">基础设置</a></li>
        <li class="nav-item"><a class="nav-link active" href="./setting.php?action=user">用户设置</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=mail">邮件通知</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=seo">SEO设置</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=api">API</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=ai">✨AI</a></li>
        <li class="nav-item"><a class="nav-link" href="./blogger.php">个人信息</a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="setting.php?action=user_save" method="post" name="user_setting_form" id="user_setting_form">
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="is_signup" id="is_signup" <?= $conf_is_signup ?> />
                <label class="custom-control-label" for="is_signup">开启用户注册</label>
            </div>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="login_code" id="login_code" <?= $conf_login_code ?>>
                <label class="custom-control-label" for="login_code">登录注册图形验证码</label>
            </div>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="email_code" id="email_code" <?= $conf_email_code ?>>
                <label class="custom-control-label" for="email_code">用户注册邮件验证码（开启需配置邮件通知服务）</label>
            </div>
            <hr>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="ischkarticle" id="ischkarticle" <?= $conf_ischkarticle ?> />
                <label class="custom-control-label" for="ischkarticle">注册用户发布文章需要审核</label>
            </div>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="article_uneditable" id="article_uneditable" <?= $conf_article_uneditable ?> />
                <label class="custom-control-label" for="article_uneditable">审核通过的文章用户不可编辑、删除</label>
            </div>
            <div class="form-group form-inline">
                <label for="posts_per_day">注册用户限制24小时发文数量（包括草稿）：</label>
                <input class="form-control mx-sm-3" style="width:60px;" value="<?= $posts_per_day ?>" type="number" min="0" name="posts_per_day" id="posts_per_day" />
            </div>
            <hr>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="forbid_user_upload" id="forbid_user_upload" <?= $conf_forbid_user_upload ?> />
                <label class="custom-control-label" for="forbid_user_upload">禁止注册用户上传图文资源</label>
            </div>
            <div class="form-group form-inline" id="form_att_maxsize">
                注册用户上传最大限制：<input type="number" min="0" style="width:200px;" class="form-control" value="<?= $att_maxsize ?>" name="att_maxsize" /> （单位：KB）
            </div>
            <div class="form-group form-inline" id="form_att_type">
                允许注册用户上传的文件类型：<input maxlength="200" style="width:500px;" class="form-control" value="<?= $att_type ?>" name="att_type" />（多个用英文逗号分隔）
            </div>
            <hr>
            <div class="form-group form-inline">
                <label for="posts_name">用户中心文章别名：</label>
                <input class="form-control mx-sm-3" style="width:80px;" value="<?= $posts_name ?>" name="posts_name" id="posts_name" /> 如：帖子、投稿、资源等
            </div>
            <div class="form-group">
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                <input type="submit" value="保存设置" class="btn btn-sm btn-success" />
            </div>
        </form>
        <div class="alert alert-warning">
            <b>用户组</b><br>
            注册用户：可以发文投稿、管理自己的文章、图文资源<br>
            内容编辑：负责全站文章、资源、评论等内容的管理<br>
            管理员：拥有站点全部管理权限，可以管理用户、进行系统设置等<br>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#menu_category_sys").addClass('active');
        $("#menu_sys").addClass('show');
        $("#menu_setting").addClass('active');
        setTimeout(hideActived, 3600);

        // 提交表单
        $("#user_setting_form").submit(function(event) {
            event.preventDefault();
            submitForm("#user_setting_form");
        });
    });
</script>