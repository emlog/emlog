<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<?php if (isset($_GET['activated'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('settings_saved_ok')?></div><?php endif; ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?=lang('settings')?></h1>
</div>
<div class="panel-heading">
    <ul class="nav nav-pills">
<!--vot--><li class="nav-item"><a class="nav-link active" href="./configure.php"><?=lang('basic_settings')?></a></li>
<!--vot--><li class="nav-item"><a class="nav-link" href="./seo.php"><?=lang('seo_settings')?></a></li>
<!--vot--><li class="nav-item"><a class="nav-link" href="./blogger.php"><?=lang('personal_settings')?></a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="configure.php?action=mod_config" method="post" name="input" id="input">
            <div class="form-group">
<!--vot-->      <label><?=lang('site_title')?>:</label>
                <input class="form-control" value="<?php echo $blogname; ?>" name="blogname">
            </div>
            <div class="form-group">
<!--vot-->      <label><?=lang('site_subtitle')?>:</label>
                <textarea name="bloginfo" cols="" rows="3" class="form-control"><?php echo $bloginfo; ?></textarea>
            </div>
            <div class="form-group">
<!--vot-->      <label><?=lang('site_address')?>:</label>
                <input class="form-control" value="<?php echo $blogurl; ?>" name="blogurl">
            </div>
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="y" name="detect_url" id="detect_url" <?php echo $conf_detect_url; ?> />
<!--vot-->      <label class="form-check-label" for="exampleCheck1"><?=lang('detect_url')?></label>
            </div>

            <div class="form-group">
<!--vot-->      <label><?=lang('your_timezone')?></label>
                <select name="timezone" style="width:320px;" class="form-control">
                    <?php foreach ($tzlist as $key => $value):
                        $ex = $key == $timezone ? "selected=\"selected\"" : ''; ?>
                        <option value="<?php echo $key; ?>" <?php echo $ex; ?>><?php echo $value; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="y" name="login_code" id="login_code" <?php echo $conf_login_code; ?> >
<!--vot-->      <label class="form-check-label"><?=lang('login_verification_code')?></label>
            </div>

            <div class="form-group form-inline">
                <input class="form-check-input" type="checkbox" value="y" name="iscomment" id="iscomment" <?php echo $conf_iscomment; ?> />
<!--vot-->      <label><?=lang('enable_comments')?></label>,
<!--vot-->      <?=lang('comment_interval')?> <input class="form-control" value="<?php echo $comment_interval; ?>" name=comment_interval/> <?=lang('seconds')?>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="ischkcomment" id="ischkcomment" <?php echo $conf_ischkcomment; ?> />
<!--vot-->      <label><?=lang('comment_moderation')?></label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="comment_code" id="comment_code" <?php echo $conf_comment_code; ?> />
<!--vot-->      <label><?=lang('comment_verification_code')?></label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="isgravatar" id="isgravatar" <?php echo $conf_isgravatar; ?> />
<!--vot-->      <label><?=lang('comment_avatar')?></label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="comment_needchinese" id="comment_needchinese" <?php echo $conf_comment_needchinese; ?> />
<!--vot-->      <label><?=lang('comment_must_contain_chinese')?></label>
            </div>
            <div class="form-group form-inline">
                <input class="form-check-input" type="checkbox" value="y" name="comment_paging" id="comment_paging" <?php echo $conf_comment_paging; ?> />
<!--vot-->      <label><?=lang('comment_per_page')?>,</label>
<!--vot-->      <?=lang('per_page')?> <input maxlength="5" style="width:50px;" class="form-control" value="<?php echo $comment_pnum; ?>" name="comment_pnum"/><?=lang('_comments')?>,
                <select name="comment_order" class="form-control">
<!--vot-->          <option value="newer" <?php echo $ex3; ?>><?=lang('newer')?></option>
<!--vot-->          <option value="older" <?php echo $ex4; ?>><?=lang('older')?></option>
<!--vot-->      </select><?=lang('standing_in_front')?>
            </div>

            <div class="form-group form-inline">
<!--vot-->      <label><?=lang('posts_per_page')?></label>
                <input class="form-control mx-sm-3" value="<?php echo $index_lognum; ?>" name="index_lognum"/>
            </div>

            <div class="form-group form-inline">
<!--vot-->      RSS <?=lang('export')?> <input maxlength="5" style="width:50px;" value="<?php echo $rss_output_num; ?>" class="form-control" name="rss_output_num"/> <?=lang('rss_output_num')?>
                <select name="rss_output_fulltext" class="form-control">
<!--vot-->          <option value="y" <?php echo $ex1; ?>><?=lang('full_text')?></option>
<!--vot-->          <option value="n" <?php echo $ex2; ?>><?=lang('summary')?></option>
                </select>
            </div>

            <div class="form-group form-inline">
                <input class="form-check-input" type="checkbox" value="y" name="isexcerpt" id="isexcerpt" <?php echo $conf_isexcerpt; ?> />
<!--vot-->      <label class="form-check-label"><?=lang('auto_summary')?></label>
<!--vot-->      <input type="text" name="excerpt_subnum" value="<?php echo Option::get('excerpt_subnum'); ?>" class="form-control" style="width:60px;"/> <?=lang('characters_as_summary')?>
            </div>

            <div class="form-group form-inline">
<!--vot-->      <?=lang('php_upload_max_size')?> <input maxlength="10" style="width:80px;" class="form-control" value="<?php echo $att_maxsize; ?>" name="att_maxsize"/> KB
            </div>
            <div class="form-group form-inline">
<!--vot-->      <?=lang('allow_attach_type')?> <input maxlength="200" style="width:320px;" class="form-control" value="<?php echo $att_type; ?>" name="att_type"/>
            </div>
            <div class="form-group form-inline">
<!--vot-->      <input type="checkbox" value="y" name="isthumbnail" id="isthumbnail" <?php echo $conf_isthumbnail; ?> /> <?=lang('thumbnail_max_size')?>
                <input maxlength="5" style="width:60px;" class="form-control" value="<?php echo $att_imgmaxw; ?>" name="att_imgmaxw"/> x
<!--vot-->      <input maxlength="5" style="width:60px;" class="form-control" value="<?php echo $att_imgmaxh; ?>" name="att_imgmaxh"/> <?= lang('unit_pixels') ?>
            </div>
            <div class="form-group">
<!--vot-->      <label><?=lang('icp_reg_no')?></label>
                <input class="form-control" value="<?php echo $icp; ?>" name="icp"/>
            </div>
            <div class="form-group">
<!--vot-->      <label><?=lang('home_footer_info')?>:</label>
                <textarea name="footer_info" rows="6" class="form-control"><?php echo $footer_info; ?></textarea>
            </div>
            <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
<!--vot-->  <input type="submit" value="<?=lang('save_settings')?>" class="btn btn-success"/>
        </form>
    </div>
</div>
<script>
    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('show');
    $("#menu_setting").addClass('active');
    setTimeout(hideActived, 2600);
</script>
