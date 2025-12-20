<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800"><?php _lang('setting'); ?></h1>
</div>
<div class="panel-heading">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./setting.php"><?php _lang('setting_basic'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=user"><?php _lang('setting_user'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=mail"><?php _lang('setting_mail'); ?></a></li>
        <li class="nav-item"><a class="nav-link active" href="./setting.php?action=seo"><?php _lang('setting_seo'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=api"><?php _lang('setting_api'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=ai"><?php _lang('setting_ai'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./blogger.php"><?php _lang('setting_profile'); ?></a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="setting.php?action=seo_save" method="post" name="seo_setting_form" id="seo_setting_form">
            <h4><?php _lang('article_link'); ?></h4>
            <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="permalink" id="permalink0" value="0" <?= $ex0 ?>>
                                    <label class="form-check-label" for="permalink0"><?php _lang('link_format_default'); ?></label>
                                </div>
                            </td>
                            <td><span class="permalink_url"><?= BLOG_URL ?>?post=1</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="permalink" id="permalink1" value="1" <?= $ex1 ?>>
                                    <label class="form-check-label" for="permalink1"><?php _lang('link_format_file'); ?></label>
                                </div>
                            </td>
                            <td><span class="permalink_url"><?= BLOG_URL ?>post-1.html</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="permalink" id="permalink2" value="2" <?= $ex2 ?>>
                                    <label class="form-check-label" for="permalink2"><?php _lang('link_format_dir'); ?></label>
                                </div>
                            </td>
                            <td><span class="permalink_url"><?= BLOG_URL ?>post/1</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="permalink" id="permalink3" value="3" <?= $ex3 ?>>
                                    <label class="form-check-label" for="permalink3"><?php _lang('link_format_category'); ?></label>
                                </div>
                            </td>
                            <td><span class="permalink_url"><?= BLOG_URL ?>category/1.html</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="isalias" id="isalias" <?= $isalias ?> />
                <label class="custom-control-label" for="isalias"><?php _lang('enable_link_alias'); ?>：<span class="permalink_url"><?= BLOG_URL ?>abc</span></label>
            </div>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="isalias_html" id="isalias_html" <?= $isalias_html ?> />
                <label class="custom-control-label" for="isalias_html"><?php _lang('enable_link_alias_html'); ?>：<span class="permalink_url"><?= BLOG_URL ?>abc.html</span></label>
            </div>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="is_sample_url" id="is_sample_url" <?= $is_sample_url ?> />
                <label class="custom-control-label" for="is_sample_url"><?php _lang('enable_simple_url'); ?></label>
            </div>
            <div class="alert alert-warning mt-3">
                <?php _lang('url_rewrite_warning'); ?><br>
            </div>
            <div class="alert alert-primary">
                <p>
                    <?php _lang('nginx_rewrite_rule'); ?>：<br><br>
                    location / {<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;index index.php index.html;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;if (!-e $request_filename){<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;rewrite ^/(.*)$ /index.php last;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;}<br>
                    }
                </p>
                <?php _lang('more_rewrite_rules'); ?>：<a href="https://www.emlog.net/docs/faq" target="_blank"><?php _lang('faq'); ?></a>
            </div>
            <h4 class="mt-4"><?php _lang('header_info'); ?></h4>
            <div class="form-group">
                <label><?php _lang('site_browser_title'); ?></label>
                <input class="form-control" value="<?= $site_title ?>" name="site_title">
            </div>
            <div class="form-group">
                <label><label><?php _lang('site_keywords'); ?></label></label>
                <input class="form-control" value="<?= $site_key ?>" name="site_key">
            </div>
            <div class="form-group">
                <label><label><?php _lang('site_description'); ?></label></label>
                <textarea name="site_description" class="form-control"><?= $site_description ?></textarea>
            </div>
            <div class="form-group">
                <label><?php _lang('article_title_style'); ?></label>
                <select name="log_title_style" class="form-control">
                    <option value="0" <?= $opt0 ?>><?php _lang('article_title'); ?></option>
                    <option value="1" <?= $opt1 ?>><?php _lang('article_site_title'); ?></option>
                    <option value="2" <?= $opt2 ?>><?php _lang('article_site_browser_title'); ?></option>
                </select>
            </div>
            <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
            <input type="submit" value="<?php _lang('save'); ?>" class="btn btn-sm btn-success" />
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