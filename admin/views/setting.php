<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['activated'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('settings_saved_ok')?></div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?=lang('settings')?></h1>
</div>
<div class="panel-heading">
    <ul class="nav nav-pills">
<!--vot--><li class="nav-item"><a class="nav-link active" href="./setting.php"><?=lang('basic_settings')?></a></li>
<!--vot--><li class="nav-item"><a class="nav-link" href="./setting.php?action=user"><?=lang('user_settings')?></a></li>
<!--vot--><li class="nav-item"><a class="nav-link" href="./setting.php?action=mail"><?=lang('email_notify')?></a></li>
<!--vot--><li class="nav-item"><a class="nav-link" href="./setting.php?action=seo"><?=lang('seo_settings')?></a></li>
<!--vot--><li class="nav-item"><a class="nav-link" href="./blogger.php"><?=lang('personal_settings')?></a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="setting.php?action=save" method="post" name="input" id="input">
<!--vot-->  <h4><?=lang('site_info')?></h4>
            <div class="form-group">
<!--vot-->      <label><?=lang('site_title')?>:</label>
                <input class="form-control" value="<?= $blogname ?>" name="blogname">
            </div>
            <div class="form-group">
<!--vot-->      <label><?=lang('site_subtitle')?>:</label>
                <textarea name="bloginfo" cols="" rows="3" class="form-control"><?= $bloginfo ?></textarea>
            </div>
            <div class="form-group">
<!--vot-->      <label><?=lang('site_address')?>:</label>
                <input class="form-control" value="<?= $blogurl ?>" name="blogurl">
            </div>
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="y" name="detect_url" id="detect_url" <?= $conf_detect_url ?> />
<!--vot-->      <label class="form-check-label" for="exampleCheck1"><?=lang('detect_url')?></label>
            </div>

            <div class="form-group">
<!--vot-->      <label><?=lang('your_timezone')?></label>
                <select name="timezone" style="width:320px;" class="form-control">
					<?php foreach ($tzlist as $key => $value):
						$ex = $key == $timezone ? "selected=\"selected\"" : '' ?>
                        <option value="<?= $key ?>" <?= $ex ?>><?= $value ?></option>
					<?php endforeach ?>
                </select>
            </div>

            <div class="form-group">
<!--vot-->      <label><?=lang('icp_reg_no')?></label>
<!--vot-->      <input class="form-control" value="<?= $icp ?>" name="icp"/>
            </div>
            <div class="form-group">
<!--vot-->      <label><?=lang('home_footer_info')?> <?=lang('home_footer_info_html')?></label>
                <textarea name="footer_info" rows="6" class="form-control"><?= $footer_info ?></textarea>
            </div>

            <hr>

<!--vot-->  <h4><?=lang('comment_settings')?></h4>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="iscomment" id="iscomment" <?= $conf_iscomment ?> />
<!--vot-->      <label><?=lang('enable_comments')?></label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="ischkcomment" id="ischkcomment" <?= $conf_ischkcomment ?> />
<!--vot-->      <label><?=lang('comment_moderation')?></label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="comment_code" id="comment_code" <?= $conf_comment_code ?> />
<!--vot-->      <label><?=lang('comment_verification_code')?></label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="isgravatar" id="isgravatar" <?= $conf_isgravatar ?> />
<!--vot-->      <label><?=lang('comment_avatar')?></label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="comment_needchinese" id="comment_needchinese" <?= $conf_comment_needchinese ?> />
<!--vot-->      <label><?=lang('comment_must_contain_chinese')?></label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="comment_paging" id="comment_paging" <?= $conf_comment_paging ?> />
<!--vot-->      <label><?=lang('comment_per_page')?></label>
            </div>
            <div class="form-group form-inline">
<!--vot-->      <?=lang('comments_per_page')?>: <input maxlength="5" style="width:50px;" class="form-control" value="<?= $comment_pnum ?>" name="comment_pnum"/>
            </div>
            <div class="form-group form-inline">
<!--vot-->      <?=lang('comment_sort')?>: <select name="comment_order" class="form-control" style="width: 120px;">
<!--vot-->          <option value="newer" <?= $ex3 ?>><?=lang('new_first')?></option>
<!--vot-->          <option value="older" <?= $ex4 ?>><?=lang('old_first')?></option>
                </select>
            </div>
            <div class="form-group form-inline">
<!--vot-->      <?=lang('comment_interval')?> (<?=lang('seconds')?>): <input class="form-control mx-sm-3" value="<?= $comment_interval ?>" name="comment_interval" style="width: 100px;"/>
            </div>

            <hr>

<!--vot-->  <h4><?=lang('article_settigs')?></h4>
            <div class="form-group form-inline">
<!--vot-->      <label><?=lang('posts_per_page')?></label>
                <input class="form-control mx-sm-3" value="<?= $index_lognum ?>" name="index_lognum"/>
            </div>

            <div class="form-group form-inline">
<!--vot-->      RSS <?=lang('export')?> <input maxlength="5" style="width:50px;" value="<?= $rss_output_num ?>" class="form-control" name="rss_output_num"/> <?=lang('rss_output_num')?>
                <select name="rss_output_fulltext" class="form-control">
<!--vot-->          <option value="y" <?= $ex1 ?>><?=lang('full_text')?></option>
<!--vot-->          <option value="n" <?= $ex2 ?>><?=lang('summary')?></option>
                </select>
            </div>

            <hr>

<!--vot-->  <h4><?=lang('upload_settings')?></h4>
            <div class="form-group form-inline">
<!--vot-->      <?=lang('php_upload_max_size')?> <input maxlength="20" style="width:120px;" class="form-control" value="<?= $att_maxsize ?>" name="att_maxsize"/> KB (1M=1024KB)
            </div>
            <div class="form-group form-inline">
<!--vot-->      <?=lang('allow_attach_type')?> <input maxlength="200" style="width:500px;" class="form-control" value="<?= $att_type ?>" name="att_type"/> <?=lang('separate_by_comma')?>
            </div>
            <div class="form-group form-inline">
<!--vot-->      <input type="checkbox" value="y" name="isthumbnail" id="isthumbnail" <?= $conf_isthumbnail ?> /> <?=lang('thumbnail_max_size')?>
                <input maxlength="5" style="width:60px;" class="form-control" value="<?= $att_imgmaxw ?>" name="att_imgmaxw"/> x
<!--vot-->      <input maxlength="5" style="width:60px;" class="form-control" value="<?= $att_imgmaxh ?>" name="att_imgmaxh"/> <?=lang('unit_pixels')?>
            </div>
            <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
<!--vot-->  <input type="submit" value="<?=lang('save_settings')?>" class="btn btn-sm btn-success"/>
        </form>
    </div>
</div>
<script>
    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('show');
    $("#menu_setting").addClass('active');
    setTimeout(hideActived, 2600);
</script>
