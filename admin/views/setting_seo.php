<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['activated'])): ?>
    <div class="alert alert-success">设置保存成功</div><?php endif ?>
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">保存失败：根目录下的.htaccess不可写</div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">设置</h1>
</div>
<div class="panel-heading">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./setting.php">基础设置</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=user">用户设置</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=mail">邮件通知</a></li>
        <li class="nav-item"><a class="nav-link active" href="./setting.php?action=seo">SEO优化</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=api">API接口</a></li>
        <li class="nav-item"><a class="nav-link" href="./blogger.php">个人信息</a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="setting.php?action=seo_save" method="post">
            <h4>文章链接</h4>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="permalink" value="0" <?= $ex0 ?>>
                <label class="form-check-label">默认格式：<span class="permalink_url"><?= BLOG_URL ?>?post=1</span></label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="permalink" value="1" <?= $ex1 ?>>
                <label class="form-check-label">文件格式：<span class="permalink_url"><?= BLOG_URL ?>post-1.html</span></label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="permalink" value="2" <?= $ex2 ?>>
                <label class="form-check-label">目录格式：<span class="permalink_url"><?= BLOG_URL ?>post/1</span></label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="permalink" value="3" <?= $ex3 ?>>
                <label class="form-check-label">分类格式：<span class="permalink_url"><?= BLOG_URL ?>category/1.html</span></label>
            </div>

            <div class="form-check mt-3">
                <input class="form-check-input" type="checkbox" value="y" name="isalias" id="isalias" <?= $isalias ?> />
                <label>启用链接别名：<span class="permalink_url"><?= BLOG_URL ?>abc</span></label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="isalias_html" id="isalias_html" <?= $isalias_html ?> />
                <label>启用链接别名html后缀：<span class="permalink_url"><?= BLOG_URL ?>abc.html</span></label>
            </div>

            <div class="alert alert-warning">
                如果修改后文章无法访问，可能是服务器空间不支持URL重写，请修改回默认格式并关闭文章连接别名。<br>
            </div>

            <div class="alert alert-primary">
                Nginx服务器请配置如下伪静态规则：<br><br>
                location / {<br>
                &nbsp;&nbsp;&nbsp;&nbsp;index index.php index.html;<br>
                &nbsp;&nbsp;&nbsp;&nbsp;if (!-e $request_filename){<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;rewrite ^/(.*)$ /index.php last;<br>
                &nbsp;&nbsp;&nbsp;&nbsp;}<br>
                }<br>
            </div>

            <h4 class="mt-4">页头信息</h4>
            <div class="form-group">
                <label>站点浏览器标题(title)</label>
                <input class="form-control" value="<?= $site_title ?>" name="site_title">
            </div>
            <div class="form-group">
                <label><label>站点关键字(keywords)</label></label>
                <input class="form-control" value="<?= $site_key ?>" name="site_key">
            </div>
            <div class="form-group">
                <label><label>站点浏览器描述(description)</label></label>
                <textarea name="site_description" class="form-control"><?= $site_description ?></textarea>
            </div>
            <div class="form-group">
                <label>文章浏览器标题方案：</label>
                <select name="log_title_style" class="form-control">
                    <option value="0" <?= $opt0 ?>>文章标题</option>
                    <option value="1" <?= $opt1 ?>>文章标题 - 站点标题</option>
                    <option value="2" <?= $opt2 ?>>文章标题 - 站点浏览器标题</option>
                </select>
            </div>

            <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
            <input type="submit" value="保存设置" class="btn btn-sm btn-success"/>
        </form>
    </div>
</div>
<script>
    setTimeout(hideActived, 3600);
    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('show');
    $("#menu_setting").addClass('active');
</script>