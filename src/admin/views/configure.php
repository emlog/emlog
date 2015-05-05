<?php
if (!defined('EMLOG_ROOT')) {
    exit('error!');
}
?>
<div class="panel-heading">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="./configure.php"><?=lang('basic_settings')?></a></li>
        <li role="presentation"><a href="./seo.php"><?=lang('seo_settings')?></a></li>
        <li role="presentation"><a href="./blogger.php"><?=lang('personal_settings')?></a></li>
        <?php if (isset($_GET['activated'])): ?><span class="alert alert-success"><?=lang('settings_saved_ok')?></span><?php endif; ?>
    </ul>
</div>
<div class="panel-body" style="margin-left:30px;">
    <form action="configure.php?action=mod_config" method="post" name="input" id="input">
        <div class="form-group">
            <label><?=lang('site_title')?>:</label><input style="width:390px;" class="form-control" value="<?php echo $blogname; ?>" name="blogname" />
        </div>
        <div class="form-group">
            <label><?=lang('site_subtitle')?>:</label><textarea name="bloginfo" cols="" rows="3" style="width:386px;" class="form-control"><?php echo $bloginfo; ?></textarea>
        </div>
        <div class="form-group">
            <label><?=lang('site_address')?>:</label><input style="width:390px;" class="form-control" value="<?php echo $blogurl; ?>" name="blogurl" />
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="y" name="detect_url" id="detect_url" <?php echo $conf_detect_url; ?> /><?=lang('auto_site_url')?> <?=lang('auto_site_url_info')?>
                </label>
            </div>
        </div>
        <div class="form-group form-inline">
            <label><?=lang('per_page')?>:</label><input style="width:50px;" class="form-control" value="<?php echo $index_lognum; ?>" name="index_lognum" /><?=lang('_posts')?>
        </div>
        <div class="form-group form-inline">
            <label><?=lang('your_timezone')?>:</label>
            <select name="timezone" style="width:320px;" class="form-control">
                <?php
/*vot*/ $tzlist = array('-12'=>lang('tz-12'),
                '-11'=>lang('tz-11'),
                '-10'=>lang('tz-10'),
                '-9'=>lang('tz-9'),
                '-8'=>lang('tz-8'),
                '-7'=>lang('tz-7'),
                '-6'=>lang('tz-6'),
                '-5'=>lang('tz-5'),
                '-4'=>lang('tz-4'),
                '-3.5'=>lang('tz-3.5'),
                '-3'=>lang('tz-3'),
                '-2'=>lang('tz-2'),
                '-1'=>lang('tz-1'),
                '0'=>lang('tz0'),
                '1'=>lang('tz1'),
                '2'=>lang('tz2'),
                '3'=>lang('tz3'),
                '3.5'=>lang('tz3.5'),
                '4'=>lang('tz4'),
                '4.5'=>lang('tz4.5'),
                '5'=>lang('tz5'),
                '5.5'=>lang('tz5.5'),
                '6'=>lang('tz6'),
                '7'=>lang('tz7'),
                '8'=>lang('tz8'),
                '9'=>lang('tz9'),
                '9.5'=>lang('tz9.5'),
                '10'=>lang('tz10'),
                '11'=>lang('tz11'),
                '12'=>lang('tz12'),
                );
                foreach ($tzlist as $key => $value):
                    $ex = $key == $timezone ? "selected=\"selected\"" : '';
                    ?>
                    <option value="<?php echo $key; ?>" <?php echo $ex; ?>><?php echo $value; ?></option>
<?php endforeach; ?>
            </select>
<!--vot-->(<?=lang('local_time')?>: <?php echo gmdate('Y-m-d H:i:s', time() + $timezone * 3600); ?>)
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="y" name="login_code" id="login_code" <?php echo $conf_login_code; ?> /> <?=lang('login_verification_code')?>
                </label>
            </div>
            <div class="checkbox form-inline">
                <label><input type="checkbox" value="y" name="isexcerpt" id="isexcerpt" <?php echo $conf_isexcerpt; ?> /><?=lang('auto_summary')?></label>,
                <?=lang('auto_summary_get')?> <input type="text" name="excerpt_subnum" value="<?php echo Option::get('excerpt_subnum'); ?>" class="form-control" style="width:60px;" /><?=lang('characters_as_summary')?>
            </div>          
        </div>
        <div class="form-group">
            <div class="checkbox form-inline">
                <label><input type="checkbox" value="y" name="istwitter" id="istwitter" <?php echo $conf_istwitter; ?> /><?=lang('twitters_enable')?></label>,
                <?=lang('per_page')?> <input type="text" name="index_twnum" maxlength="3" value="<?php echo Option::get('index_twnum'); ?>" class="form-control" style="width:50px;" /><?lang('_twitters')?>
            </div>
            <div class="checkbox form-inline">
                <label><input type="checkbox" value="y" name="istreply" id="istreply" <?php echo $conf_istreply; ?> /><?=lang('twitter_reply_enable')?>, </label>
                <label><input type="checkbox" value="y" name="reply_code" id="reply_code" <?php echo $conf_reply_code; ?> /><?=lang('reply_verification_code')?>, </label>
                <label><input type="checkbox" value="y" name="ischkreply" id="ischkreply" <?php echo $conf_ischkreply; ?> /><?=lang('reply_audit')?></label>
            </div>
        </div>
        <div class="form-group form-inline">
            RSS <?=lang('export')?> <input maxlength="5" style="width:50px;" value="<?php echo $rss_output_num; ?>" class="form-control" name="rss_output_num" /> <?=lang('_posts_and_output')?>
            <select name="rss_output_fulltext" class="form-control">
<!--vot--><option value="y" <?php echo $ex1; ?>><?=lang('full_text')?></option>
<!--vot--><option value="n" <?php echo $ex2; ?>><?=lang('summary')?></option>
            </select>
        </div>
        <div class="form-group">
            <div class="checkbox form-inline">
                <label><input type="checkbox" value="y" name="iscomment" id="iscomment" <?php echo $conf_iscomment; ?> /><?=lang('enable_comments')?></label>, <?=lang('comment_interval')?> <input maxlength="5" style="width:50px;" class="form-control" value="<?php echo $comment_interval; ?>" name=comment_interval /><?=lang('_seconds')?>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="y" name="ischkcomment" id="ischkcomment" <?php echo $conf_ischkcomment; ?> /> <?=lang('comment_moderation')?>
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="y" name="comment_code" id="comment_code" <?php echo $conf_comment_code; ?> /> <?=lang('comment_verification_code')?>
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="y" name="isgravatar" id="isgravatar" <?php echo $conf_isgravatar; ?> /> <?=lang('comment_avatar')?>
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="y" name="comment_needchinese" id="comment_needchinese" <?php echo $conf_comment_needchinese; ?> /> <?=lang('comment_must_contain_chinese')?>
                </label>
            </div>
            <div class="checkbox form-inline">
                <label><input type="checkbox" value="y" name="comment_paging" id="comment_paging" <?php echo $conf_comment_paging; ?> /><?=lang('comment_per_page')?>,</label>
                <?=lang('per_page')?> <input maxlength="5" style="width:50px;" class="form-control" value="<?php echo $comment_pnum; ?>" name="comment_pnum" /><?=lang('comments_pending')?>,
                <select name="comment_order" class="form-control"><option value="newer" <?php echo $ex3; ?>><?=lang('newer')?></option><option value="older" <?php echo $ex4; ?>><?=lang('older')?></option></select> <?=lang('standing_in_front')?>
            </div>
        </div>
        <div class="form-group form-inline">
            <label><?=lang('upload_max_size')?></label> <input maxlength="10" style="width:80px;" class="form-control" value="<?php echo $att_maxsize; ?>" name="att_maxsize" />KB (<?=lang('php_upload_max_size')?> <?php echo ini_get('upload_max_filesize'); ?> <?=lang('_limit')?>)
        </div>
        <div class="form-group form-inline">
            <label><?=lang('allow_attach_type')?> </label> <input maxlength="200" style="width:320px;" class="form-control" value="<?php echo $att_type; ?>" name="att_type" /> <?=lang('separate_by_comma')?>
        </div>
        <div class="form-group form-inline">
            <input type="checkbox" value="y" name="isthumbnail" id="isthumbnail" <?php echo $conf_isthumbnail; ?> /> <?=lang('thumbnail_max_size')?> <input maxlength="5" style="width:60px;" class="form-control" value="<?php echo $att_imgmaxw; ?>" name="att_imgmaxw" /> x <input maxlength="5" style="width:60px;" class="form-control" value="<?php echo $att_imgmaxh; ?>" name="att_imgmaxh" /> <?=lang('unit_pixels')?>
        </div>
        <div class="form-group">
            <?=lang('icp_reg_no')?>:
            <input maxlength="200" style="width:390px;" class="form-control" value="<?php echo $icp; ?>" name="icp" />
        </div>
        <div class="form-group">
            <label><?=lang('home_footer_info')?> <?=lang('home_footer_info_html')?>:</label>
            <textarea name="footer_info" cols="" rows="6" class="form-control" style="width:386px;"><?php echo $footer_info; ?></textarea>
        </div>
        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
        <input type="submit" value="<?=lang('save_settings')?>" class="btn btn-primary" />
    </form>
</div>
<script>
    setTimeout(hideActived, 2600);
    $("#menu_setting").addClass('active').parent().parent().addClass('active');
</script>
