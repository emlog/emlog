<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class="panel-heading">
<ul class="nav nav-tabs" role="tablist">
  <li role="presentation"><a href="./configure.php"><?=lang('basic_settings')?></a></li>
  <li role="presentation" class="active"><a href="./seo.php"><?=lang('seo_settings')?></a></li>
  <li role="presentation"><a href="./blogger.php"><?=lang('personal_settings')?></a></li>
</ul>
<?php if(isset($_GET['activated'])):?><span class="alert alert-success"><?=lang('settings_saved_ok')?></span><?php endif;?>
<?php if(isset($_GET['error'])):?><span class="alert alert-danger"><?=lang('htaccess_not_writable')?></span><?php endif;?>
</div>
<div class="panel-body" style="margin-left:30px;">
<form action="seo.php?action=update" method="post">
<h4><?=lang('post_url_settings')?></h4>
<div class="alert alert-info" style="width: 100%">
<!--vot--><?=lang('post_url_rewriting')?>
<!--vot--><br /><?=lang('post_url_custom')?>
</div>
<div class="form-group">
            <div class="radio">
                <label>
                    <input type="radio" name="permalink" value="0" <?php echo $ex0; ?>><?=lang('default_format')?>: <span class="permalink_url"><?php echo BLOG_URL; ?>?post=1</span>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="permalink" value="1" <?php echo $ex1; ?>><?=lang('file_format')?>: <span class="permalink_url"><?php echo BLOG_URL; ?>post-1.html</span>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="permalink" value="2" <?php echo $ex2; ?>><?=lang('directory_format')?>: <span class="permalink_url"><?php echo BLOG_URL; ?>post/1</span>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="permalink" value="3" <?php echo $ex3; ?>><?=lang('category_format')?>: <span class="permalink_url"><?php echo BLOG_URL; ?>category/1.html</span>
                </label>
            </div>
</div>
<div class="form-group">
                <div class="checkbox">
                <label>
                    <input type="checkbox" style="vertical-align:middle;" value="y" name="isalias" id="isalias" <?php echo $isalias; ?> /><?=lang('post_alias_enable')?>
                </label>
            </div>
                <div class="checkbox">
                <label>
                    <input type="checkbox" style="vertical-align:middle;" value="y" name="isalias_html" id="isalias_html" <?php echo $isalias_html; ?> /><?=lang('enable_html_suffix')?>
                </label>
            </div>
</div>

<h4><?=lang('meta_settings')?>
<div class="form-group">
    <li>
        <label><?=lang('meta_title')?>
        <input maxlength="200" style="width:300px;" class="form-control" value="<?php echo $site_title; ?>" name="site_title" />
    </li>
    <li>
        <label><?=lang('meta_keywords')?></label>
        <input maxlength="200" style="width:300px;" class="form-control" value="<?php echo $site_key; ?>" name="site_key" />
    </li>
    <li>
        <label><?=lang('meta_description')?></label>
        <textarea name="site_description" class="form-control" cols="" rows="4" style="width:300px;"><?php echo $site_description; ?></textarea>
    </li>
    <li>
        <label><?=lang('meta_title_scheme')?>:</label>
        <select name="log_title_style" class="form-control" style="width: 120px;">
        <option value="0" <?php echo $opt0; ?>><?=lang('post_title')?></option>
        <option value="1" <?php echo $opt1; ?>><?=lang('post_title_site_title')?></option>
        <option value="2" <?php echo $opt2; ?>><?=lang('post_title_site_meta_title')?></option>
        </select>
    </li>
    <li style="margin-top:10px;">
        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
<!--vot--><input type="submit" value="<?=lang('save_settings')?>" class="btn btn-primary" />
    </li>
</div>
</form>
</div>
<script>
    setTimeout(hideActived, 2600);
    $("#menu_setting").addClass('active').parent().parent().addClass('active');
</script>