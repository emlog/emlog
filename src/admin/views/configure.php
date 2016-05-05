<?php if (!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="panel-heading">
    <ul class="nav nav-tabs" role="tablist">
<!--vot--><li role="presentation" class="active"><a href="./configure.php"><?=lang('basic_settings')?></a></li>
<!--vot--><li role="presentation"><a href="./seo.php"><?=lang('seo_settings')?></a></li>
<!--vot--><li role="presentation"><a href="./blogger.php"><?=lang('personal_settings')?></a></li>
<!--vot--><?php if(isset($_GET['activated'])):?><span class="alert alert-success"><?=lang('settings_saved_ok')?></span><?php endif; ?>
    </ul>
</div>
<div class="panel-body" style="margin-left:30px;">
    <form action="configure.php?action=mod_config" method="post" name="input" id="input">
        <div class="form-group">
<!--vot--><label><?=lang('site_title')?>:</label><input style="width:390px;" class="form-control" value="<?= $blogname; ?>" name="blogname" />
        </div>
        <div class="form-group">
<!--vot--><label><?=lang('site_subtitle')?>:</label><textarea name="bloginfo" cols="" rows="3" style="width:386px;" class="form-control"><?= $bloginfo; ?></textarea>
        </div>
        <div class="form-group">
<!--vot--><label><?=lang('site_address')?>:</label><input style="width:390px;" class="form-control" value="<?= $blogurl; ?>" name="blogurl" />
            <div class="checkbox">
                <label>
<!--vot-->          <input type="checkbox" value="y" name="detect_url" id="detect_url" <?= $conf_detect_url; ?> /> <?=lang('detect_url')?>
                </label>
            </div>
        </div>
        <div class="form-group form-inline">
<!--vot--><label><?=lang('per_page')?>:</label><input style="width:50px;" class="form-control" value="<?= $index_lognum; ?>" name="index_lognum" /><?=lang('_posts')?>
        </div>
        <div class="form-group form-inline">
<!--vot--><label><?=lang('your_timezone')?>:</label>
            <select name="timezone" style="width:320px;" class="form-control">
                <?php
                foreach ($tzlist as $key => $value):
                    $ex = $key == $timezone ? "selected=\"selected\"" : '';
                    ?>
                    <option value="<?= $key; ?>" <?= $ex; ?>><?= $value; ?></option>
                <?php endforeach; ?>
            </select>
<!--vot-->  (<?=lang('local_time')?>: <?= date('Y-m-d H:i:s'); ?>)
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label>
<!--vot-->          <input type="checkbox" value="y" name="login_code" id="login_code" <?= $conf_login_code; ?> /><?=lang('login_verification_code')?>
                </label>
            </div>
            <div class="checkbox form-inline">
<!--vot-->      <input type="checkbox" value="y" name="isexcerpt" id="isexcerpt" <?= $conf_isexcerpt; ?> /><?=lang('auto_summary')?>,
<!--vot-->      <?=lang('before_intercept')?><input type="text" name="excerpt_subnum" value="<?= Option::get('excerpt_subnum'); ?>" class="form-control" style="width:60px;" /><?=lang('characters_as_summary')?>
            </div>          
        </div>
        <div class="form-group form-inline">
<!--vot-->  <?=lang('export')?><input maxlength="5" style="width:50px;" value="<?= $rss_output_num; ?>" class="form-control" name="rss_output_num" /><?=lang('_posts_and_output')?>
            <select name="rss_output_fulltext" class="form-control">
<!--vot-->      <option value="y" <?= $ex1; ?>><?=lang('full_text')?></option>
<!--vot-->      <option value="n" <?= $ex2; ?>><?=lang('summary')?></option>
            </select>
        </div>
        <div class="form-group">
            <div class="checkbox form-inline">
<!--vot-->      <label><input type="checkbox" value="y" name="iscomment" id="iscomment" <?= $conf_iscomment; ?> /><?=lang('enable_comment_interval')?><input maxlength="5" style="width:50px;" class="form-control" value="<?= $comment_interval; ?>" name=comment_interval /><?=lang('_seconds')?>
            </div>
            <div class="checkbox">
                <label>
<!--vot-->          <input type="checkbox" value="y" name="ischkcomment" id="ischkcomment" <?= $conf_ischkcomment; ?> /><?=lang('comment_moderation')?>
                </label>
            </div>
            <div class="checkbox">
                <label>
<!--vot-->          <input type="checkbox" value="y" name="comment_code" id="comment_code" <?= $conf_comment_code; ?> /><?=lang('comment_verification_code')?>
                </label>
            </div>
            <div class="checkbox">
                <label>
<!--vot-->          <input type="checkbox" value="y" name="isgravatar" id="isgravatar" <?= $conf_isgravatar; ?> /><?=lang('comment_avatar')?>
                </label>
            </div>
            <div class="checkbox">
                <label>
<!--vot-->          <input type="checkbox" value="y" name="comment_needchinese" id="comment_needchinese" <?= $conf_comment_needchinese; ?> /><?=lang('comment_must_contain_chinese')?>
                </label>
            </div>
            <div class="checkbox form-inline">
<!--vot-->      <label><input type="checkbox" value="y" name="comment_paging" id="comment_paging" <?= $conf_comment_paging; ?> /><?=lang('comment_per_page')?>,</label>
<!--vot-->      <?=lang('per_page')?><input maxlength="5" style="width:50px;" class="form-control" value="<?= $comment_pnum; ?>" name="comment_pnum" /><?=lang('_comments')?>,
<!--vot-->      <select name="comment_order" class="form-control"><option value="newer" <?= $ex3; ?>><?=lang('newer')?></option><option value="older" <?= $ex4; ?>><?=lang('older')?></option></select><?=lang('standing_in_front')?>
            </div>
        </div>
        <div class="form-group form-inline">
<!--vot-->  <input maxlength="10" style="width:80px;" class="form-control" value="<?= $att_maxsize; ?>" name="att_maxsize" />KB (<?=lang('php_upload_max_size')?>
        </div>
        <div class="form-group form-inline">
<!--vot-->  <input maxlength="200" style="width:320px;" class="form-control" value="<?= $att_type; ?>" name="att_type" /> <?=lang('allow_attach_type')?> <?=lang('separate_by_comma')?>
        </div>
        <div class="form-group form-inline">
<!--vot-->  <input type="checkbox" value="y" name="isthumbnail" id="isthumbnail" <?= $conf_isthumbnail; ?> /><?=lang('thumbnail_max_size')?><input maxlength="5" style="width:60px;" class="form-control" value="<?= $att_imgmaxw; ?>" name="att_imgmaxw" /> x <input maxlength="5" style="width:60px;" class="form-control" value="<?= $att_imgmaxh; ?>" name="att_imgmaxh" /><?=lang('unit_pixels')?>
        </div>
        <div class="form-group">
<!--vot-->  <?=lang('icp_reg_no')?>:
            <input maxlength="200" style="width:390px;" class="form-control" value="<?= $icp; ?>" name="icp" />
        </div>
        <div class="form-group">
<!--vot-->  <label><?=lang('home_footer_info')?>:</label>
            <textarea name="footer_info" cols="" rows="6" class="form-control" style="width:386px;"><?= $footer_info; ?></textarea>
        </div>
        <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
<!--vot--><input type="submit" value="<?=lang('save_settings')?>" class="btn btn-primary" />
    </form>
</div>
<script>
    setTimeout(hideActived, 2600);
    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('in');
    $("#menu_setting").addClass('active');
</script>
