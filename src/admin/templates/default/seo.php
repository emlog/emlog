<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class="panel-heading">
<ul class="nav nav-tabs" role="tablist">
<!--vot--><li class="nav-item"><a class="nav-link" href="./configure.php"><?=lang('basic_settings')?></a></li>
<!--vot--><li class="nav-item"><a class="nav-link active" href="./seo.php"><?=lang('seo_settings')?></a></li>
<!--vot--><li class="nav-item"><a class="nav-link" href="./blogger.php"><?=lang('personal_settings')?></a></li>
<!--vot--><?php if(isset($_GET['activated'])):?><span class="alert alert-success"><?=lang('settings_saved_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error'])):?><span class="alert alert-danger"><?=lang('htaccess_not_writable')?></span><?php endif;?>
</ul>
</div>
<div class="panel-body" style="margin-left:30px;">
<form action="seo.php?action=update" method="post">
<!--vot--><h4><?=lang('post_url_settings')?></h4>
<div class="alert alert-info" style="width: 100%">
<!--vot--><?=lang('post_url_rewriting')?>
<!--vot--><br><?=lang('post_url_custom')?>
</div>
<div class="form-group">
            <div class="radio">
                <label>
<!--vot-->          <input type="radio" name="permalink" value="0" <?= $ex0 ?>><?=lang('default_format')?>: <span class="permalink_url"><?= BLOG_URL ?>?post=1</span>
                </label>
            </div>
            <div class="radio">
                <label>
<!--vot-->          <input type="radio" name="permalink" value="1" <?= $ex1 ?>><?=lang('file_format')?>: <span class="permalink_url"><?= BLOG_URL ?>post-1.html</span>
                </label>
            </div>
            <div class="radio">
                <label>
<!--vot-->          <input type="radio" name="permalink" value="2" <?= $ex2 ?>><?=lang('directory_format')?>: <span class="permalink_url"><?= BLOG_URL ?>post/1</span>
                </label>
            </div>
            <div class="radio">
                <label>
<!--vot-->          <input type="radio" name="permalink" value="3" <?= $ex3 ?>><?=lang('category_format')?>: <span class="permalink_url"><?= BLOG_URL ?>category/1.html</span>
                </label>
            </div>
</div>
<div class="form-group">
                <div class="checkbox">
                <label>
<!--vot-->          <input type="checkbox" style="vertical-align:middle;" value="y" name="isalias" id="isalias" <?= $isalias ?>> <?=lang('post_alias_enable')?>
                </label>
            </div>
                <div class="checkbox">
                <label>
<!--vot-->          <input type="checkbox" style="vertical-align:middle;" value="y" name="isalias_html" id="isalias_html" <?= $isalias_html ?>> <?=lang('enable_html_suffix')?>
                </label>
            </div>
</div>

<!--vot--><h4><?=lang('meta_settings')?>:</h4>
<div class="form-group">
    <li>
<!--vot--><label><?=lang('meta_title')?></label>
        <input maxlength="200" style="width:300px;" class="form-control" value="<?php echo $site_title; ?>" name="site_title" />
    </li>
    <li>
<!--vot--><label><?=lang('meta_keywords')?></label>
        <input maxlength="200" style="width:300px;" class="form-control" value="<?php echo $site_key; ?>" name="site_key" />
    </li>
    <li>
<!--vot--><label><?=lang('meta_description')?></label>
        <textarea name="site_description" class="form-control" cols="" rows="4" style="width:300px;"><?php echo $site_description; ?></textarea>
    </li>
    <li>
<!--vot--><label><?=lang('meta_title_scheme')?>:</label>
        <select name="log_title_style" class="form-control" style="width: 120px;">
<!--vot-->    <option value="0" <?= $opt0 ?>><?=lang('post_title')?></option>
<!--vot-->    <option value="1" <?= $opt1 ?>><?=lang('post_title_site_title')?></option>
<!--vot-->    <option value="2" <?= $opt2 ?>><?=lang('post_title_site_meta_title')?></option>
        </select>
    </li>
    <li style="margin-top:10px;">
        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
<!--vot--><input type="submit" value="<?=lang('save_settings')?>" class="btn btn-primary">
    </li>
</div>
</form>
</div>
<script>
    setTimeout(hideActived, 2600);
    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('in');
    $("#menu_setting").addClass('active');
</script>