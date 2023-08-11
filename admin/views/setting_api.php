<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<?php if (isset($_GET['ok'])): ?>
    <div class="alert alert-success">保存成功</div><?php endif ?>
<?php if (isset($_GET['ok_reset'])): ?>
    <div class="alert alert-success">接口秘钥重置成功</div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">设置</h1>
</div>
<div class="panel-heading">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./setting.php">基础设置</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=user">用户设置</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=mail">邮件通知</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=seo">SEO设置</a></li>
        <li class="nav-item"><a class="nav-link active" href="./setting.php?action=api">API</a></li>
        <li class="nav-item"><a class="nav-link" href="./blogger.php">个人信息</a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="setting.php?action=api_save" method="post" name="input" id="input">
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="y" name="is_openapi" id="is_openapi" <?= $conf_is_openapi ?> />
                <label class="form-check-label">开启API</label>
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
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
                <input type="submit" value="保存设置" class="btn btn-sm btn-success"/>
            </div>
        </form>
        <div class="alert alert-warning">
            <b>API接口列表：</b><br><br>
            文章发布 (可用于对接内容发布软件，文章发布接口URL：<?= BLOG_URL ?>?rest-api=article_post)<br>
            分类列表<br>
            笔记发布<br>
            笔记列表<br>
            资源文件上传<br>
            ……<br><br>
            详见接口文档：<a href="https://www.emlog.net/docs/#/api" target="_blank">API接口文档→</a>
        </div>
    </div>
</div>
<script>
    $(function () {
        $("#menu_category_sys").addClass('active');
        $("#menu_sys").addClass('show');
        $("#menu_setting").addClass('active');
        setTimeout(hideActived, 3600);
    });
</script>
