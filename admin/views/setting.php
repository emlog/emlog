<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800"><?php _lang('setting'); ?></h1>
</div>
<div class="panel-heading">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active" href="./setting.php"><?php _lang('setting_basic'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=user"><?php _lang('setting_user'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=mail"><?php _lang('setting_mail'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=seo"><?php _lang('setting_seo'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=api"><?php _lang('setting_api'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=ai"><?php _lang('setting_ai'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./blogger.php"><?php _lang('setting_profile'); ?></a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="setting.php?action=save" method="post" name="setting_form" id="setting_form">
            <h4><?php _lang('site_info'); ?></h4>
            <div class="form-group">
                <label><?php _lang('site_title'); ?></label>
                <input class="form-control" value="<?= $blogname ?>" name="blogname">
            </div>
            <div class="form-group">
                <label><?php _lang('site_subtitle'); ?></label>
                <textarea name="bloginfo" cols="" rows="3" class="form-control"><?= $bloginfo ?></textarea>
            </div>
            <div class="form-group">
                <label><?php _lang('site_url'); ?></label>
                <input class="form-control" value="<?= $blogurl ?>" name="blogurl" type="url" required>
            </div>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="detect_url" id="detect_url" <?= $conf_detect_url ?> />
                <label class="custom-control-label" for="detect_url"><?php _lang('detect_site_url_desc'); ?></label>
            </div>
            <div class="form-group mt-3">
                <label><?php _lang('timezone'); ?></label>
                <select name="timezone" style="width:320px;" class="form-control">
                    <?php foreach ($tzlist as $key => $value):
                        $ex = $key == $timezone ? "selected=\"selected\"" : '' ?>
                        <option value="<?= $key ?>" <?= $ex ?>><?= $value ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group">
                <label><?php _lang('icp_number'); ?></label>
                <input class="form-control" value="<?= $icp ?>" name="icp" />
            </div>
            <div class="form-group">
                <label><?php _lang('footer_info'); ?></label>
                <textarea name="footer_info" rows="6" class="form-control"><?= $footer_info ?></textarea>
            </div>
            <hr>
            <h4><?php _lang('comment_setting'); ?></h4>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="iscomment" id="iscomment" <?= $conf_iscomment ?> />
                <label class="custom-control-label" for="iscomment"><?php _lang('enable_comment'); ?></label>
            </div>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="ischkcomment" id="ischkcomment" <?= $conf_ischkcomment ?> />
                <label class="custom-control-label" for="ischkcomment"><?php _lang('comment_audit'); ?></label>
            </div>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="comment_code" id="comment_code" <?= $conf_comment_code ?> />
                <label class="custom-control-label" for="comment_code"><?php _lang('comment_captcha'); ?></label>
            </div>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="login_comment" id="login_comment" <?= $conf_login_comment ?> />
                <label class="custom-control-label" for="login_comment"><?php _lang('comment_need_login'); ?></label>
            </div>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="comment_paging" id="comment_paging" <?= $conf_comment_paging ?> />
                <label class="custom-control-label" for="comment_paging"><?php _lang('comment_paging'); ?></label>
            </div>
            <div class="form-group form-inline">
                <?php _lang('comment_per_page'); ?>：<input maxlength="5" style="width:80px;" class="form-control" value="<?= $comment_pnum ?>" name="comment_pnum" type="number" min="0" />
            </div>
            <div class="form-group form-inline">
                <?php _lang('comment_order'); ?>：<select name="comment_order" class="form-control" style="width: 120px;">
                    <option value="newer" <?= $ex3 ?>><?php _lang('newer_first'); ?></option>
                    <option value="older" <?= $ex4 ?>><?php _lang('older_first'); ?></option>
                </select>
            </div>
            <div class="form-group form-inline">
                <?php _lang('comment_interval'); ?>： <input class="form-control mx-sm-3" value="<?= $comment_interval ?>" name="comment_interval" style="width:80px;" type="number" min="0" />
            </div>
            <hr>
            <h4><?php _lang('article_setting'); ?></h4>
            <div class="form-group form-inline">
                <label><?php _lang('article_per_page'); ?></label>
                <input class="form-control mx-sm-3" style="width:80px;" value="<?= $index_lognum ?>" name="index_lognum" type="number" min="1" />
            </div>
            <div class="form-group form-inline">
                <?php _lang('rss_output'); ?> <input maxlength="5" style="width:80px;" value="<?= $rss_output_num ?>" type="number" min="0" class="form-control" name="rss_output_num" />（0为关闭），且输出
                <select name="rss_output_fulltext" class="form-control">
                    <option value="y" <?= $ex1 ?>><?php _lang('rss_output_fulltext'); ?></option>
                    <option value="n" <?= $ex2 ?>><?php _lang('rss_output_abstract'); ?></option>
                </select>
            </div>
            <div class="alert alert-primary">
                <?php _lang('rss_feed_url'); ?>：<?= $blogurl . 'rss.php' ?>
            </div>
            <div class="custom-control custom-switch">
                <input class="custom-control-input" type="checkbox" value="y" name="isfullsearch" id="isfullsearch" <?= $conf_isfullsearch ?> />
                <label class="custom-control-label" for="isfullsearch"><?php _lang('full_text_search'); ?></label>
            </div>
            <hr>
            <h4><?php _lang('upload_setting'); ?></h4>
            <div class="form-group form-inline">
                <div class="custom-control custom-switch">
                    <input type="checkbox" value="y" name="isthumbnail" id="isthumbnail" class="custom-control-input" <?= $conf_isthumbnail ?> />
                    <label class="custom-control-label" for="isthumbnail"><?php _lang('upload_thumb'); ?></label>
                </div>
                ，<?php _lang('max_size'); ?>：
                <input maxlength="5" style="width:80px;" class="form-control" value="<?= $att_imgmaxw ?>" name="att_imgmaxw" /> x
                <input maxlength="5" style="width:80px;" class="form-control" value="<?= $att_imgmaxh ?>" name="att_imgmaxh" />（<?php _lang('unit_pixels'); ?>）
            </div>
            <hr>
            <h4><?php _lang('panel_setting'); ?></h4>
            <div class="form-group form-inline">
                <label><?php _lang('sidebar_menu_title'); ?></label>
                <input class="form-control ml-2" value="<?= $panel_menu_title ?>" name="panel_menu_title">
            </div>
            <hr>
            <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
            <input type="submit" value="<?php _lang('save'); ?>" class="btn btn-sm btn-success" />
        </form>
    </div>
</div>
<script>
    $(function() {
        $("#menu_category_sys").addClass('active');
        $("#menu_sys").addClass('show');
        $("#menu_setting").addClass('active');
        setTimeout(hideActived, 3600);

        // 提交表单
        $("#setting_form").submit(function(event) {
            event.preventDefault();
            submitForm("#setting_form");
        });

        // 设置界面: 自动检测站点地址 如果设置“自动检测地址”，则设置 input 为只读，以表示该项是无效的
        if ($("#detect_url").prop("checked")) {
            $("[name=blogurl]").attr("readonly", "readonly")
        }
        $("#detect_url").click(function() {
            if ($(this).prop("checked")) {
                $("[name=blogurl]").attr("readonly", "readonly")
            } else {
                $("[name=blogurl]").removeAttr("readonly")
            }
        })
    });
</script>