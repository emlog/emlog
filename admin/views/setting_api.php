<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['ok_reset'])): ?>
    <div class="alert alert-success">接口秘钥重置成功</div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">设置</h1>
</div>
<div class="panel-heading">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./setting.php">基础设置</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=user">用户设置</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=mail">邮件通知</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=seo">SEO设置</a></li>
        <li class="nav-item"><a class="nav-link active" href="./setting.php?action=api">API</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=ai">🤖AI</a></li>
        <li class="nav-item"><a class="nav-link" href="./blogger.php">个人信息</a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="setting.php?action=api_save" method="post" name="setting_api_form" id="setting_api_form">
            <p>开启API：</p>
            <div class="form-group form-check">
                <input class="mui-switch mui-switch-animbg" type="checkbox" value="y" name="is_openapi" id="is_openapi" <?= $conf_is_openapi ?> />
            </div>
            <p>API秘钥：</p>
            <div class="input-group">
                <input type="text" class="form-control" disabled value="<?= $apikey ?>">
                <div class="input-group-append">
                    <button class="btn btn-outline-success" type="button" onclick="window.location.href='setting.php?action=api_reset&token=<?= LoginAuth::genToken() ?>'">
                        重置API秘钥
                    </button>
                </div>
            </div>
            <div class="form-group mt-3">
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
            </div>
        </form>
        <div class="alert alert-warning">
            <b>API接口列表：</b><br><br>
            1. 文章发布 (可用于对接内容发布软件，文章发布接口URL：<?= BLOG_URL ?>?rest-api=article_post)<br>
            2. 分类列表<br>
            3. 微语发布<br>
            4. 微语列表<br>
            5. 资源文件上传<br>
            ……<br><br>
            详见接口文档：<a href="https://www.emlog.net/docs/api" target="_blank">API接口文档→</a>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#menu_category_sys").addClass('active');
        $("#menu_sys").addClass('show');
        $("#menu_setting").addClass('active');
        setTimeout(hideActived, 3600);
    });
    $('#setting_api_form').change(function() {
        submitForm('#setting_api_form');
    });
</script>