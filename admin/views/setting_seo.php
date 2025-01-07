<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">设置</h1>
</div>
<div class="panel-heading">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./setting.php">基础设置</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=user">用户设置</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=mail">邮件通知</a></li>
        <li class="nav-item"><a class="nav-link active" href="./setting.php?action=seo">SEO设置</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=api">API</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=ai">🤖AI</a></li>
        <li class="nav-item"><a class="nav-link" href="./blogger.php">个人信息</a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="setting.php?action=seo_save" method="post" name="seo_setting_form" id="seo_setting_form">
            <h4>文章链接</h4>
            <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="permalink" id="permalink0" value="0" <?= $ex0 ?>>
                                    <label class="form-check-label" for="permalink0">默认格式</label>
                                </div>
                            </td>
                            <td><span class="permalink_url"><?= BLOG_URL ?>?post=1</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="permalink" id="permalink1" value="1" <?= $ex1 ?>>
                                    <label class="form-check-label" for="permalink1">文件格式</label>
                                </div>
                            </td>
                            <td><span class="permalink_url"><?= BLOG_URL ?>post-1.html</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="permalink" id="permalink2" value="2" <?= $ex2 ?>>
                                    <label class="form-check-label" for="permalink2">目录格式</label>
                                </div>
                            </td>
                            <td><span class="permalink_url"><?= BLOG_URL ?>post/1</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="permalink" id="permalink3" value="3" <?= $ex3 ?>>
                                    <label class="form-check-label" for="permalink3">分类格式</label>
                                </div>
                            </td>
                            <td><span class="permalink_url"><?= BLOG_URL ?>category/1.html</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="form-check mt-3">
                <input class="form-check-input" type="checkbox" value="y" name="isalias" id="isalias" <?= $isalias ?> />
                <label for="isalias">启用链接别名：<span class="permalink_url"><?= BLOG_URL ?>abc</span></label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="isalias_html" id="isalias_html" <?= $isalias_html ?> />
                <label for="isalias_html">启用链接别名html后缀：<span class="permalink_url"><?= BLOG_URL ?>abc.html</span></label>
            </div>

            <div class="alert alert-warning">
                如果修改后文章无法访问，可能是服务器空间不支持URL重写（伪静态），请修改回默认格式并关闭文章连接别名。<br>
            </div>

            <div class="alert alert-primary">
                <p>
                    Nginx服务器请配置如下伪静态规则：<br><br>
                    location / {<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;index index.php index.html;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;if (!-e $request_filename){<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;rewrite ^/(.*)$ /index.php last;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;}<br>
                    }
                </p>
            </div>

            <h4 class="mt-4">页头信息</h4>
            <div class="form-group">
                <label>站点浏览器标题(title)</label>
                <input class="form-control" value="<?= $site_title ?>" name="site_title">
            </div>
            <div class="form-group">
                <label><label>站点关键字(keywords)，多个用英文逗号分隔</label></label>
                <input class="form-control" value="<?= $site_key ?>" name="site_key">
            </div>
            <div class="form-group">
                <label><label>站点浏览器描述(description)</label></label>
                <textarea name="site_description" class="form-control"><?= $site_description ?></textarea>
            </div>
            <div class="form-group">
                <label>文章浏览器标题方案</label>
                <select name="log_title_style" class="form-control">
                    <option value="0" <?= $opt0 ?>>文章标题</option>
                    <option value="1" <?= $opt1 ?>>文章标题 - 站点标题</option>
                    <option value="2" <?= $opt2 ?>>文章标题 - 站点浏览器标题</option>
                </select>
            </div>

            <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
            <input type="submit" value="保存设置" class="btn btn-sm btn-success" />
        </form>
    </div>
</div>
<script>
    $(function() {
        setTimeout(hideActived, 3600);
        $("#menu_category_sys").addClass('active');
        $("#menu_sys").addClass('show');
        $("#menu_setting").addClass('active');

        // 提交表单
        $("#seo_setting_form").submit(function(event) {
            event.preventDefault();
            submitForm("#seo_setting_form");
        });
    });
</script>