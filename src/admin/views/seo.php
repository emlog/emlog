<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class="containertitle2">
<!--vot--><a class="navi1" href="./configure.php"><?=lang('basic_settings')?></a>
<!--vot--><a class="navi2" href="./seo.php"><?=lang('seo_settings')?></a>
<!--vot--><a class="navi4" href="./style.php"><?=lang('background_style')?></a>
<!--vot--><a class="navi4" href="./blogger.php"><?=lang('personal_settings')?></a>
<!--vot--><?php if(isset($_GET['activated'])):?><span class="actived"><?=lang('settings_saved_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error'])):?><span class="error"><?=lang('htaccess_not_writable')?></span><?php endif;?>
</div>
<div style="margin-left:10px;">
<form action="seo.php?action=update" method="post">
<!--vot--><div style="font-size: 14px; margin: 10px 0px 10px 10px;"><b><?=lang('post_url_settings')?>:</b></div>
<div class="des" style="margin-left:10px;">
<!--vot--><?=lang('post_url_rewriting')?>
<!--vot--><br /><?=lang('post_url_custom')?>
</div>
<div style="margin:10px 8px;">
<!--vot--><li><input type="radio" name="permalink" value="0" <?php echo $ex0; ?>><?=lang('default_format')?>: <span class="permalink_url"><?php echo BLOG_URL; ?>?post=1</span></li>
<!--vot--><li><input type="radio" name="permalink" value="1" <?php echo $ex1; ?>><?=lang('file_format')?>: <span class="permalink_url"><?php echo BLOG_URL; ?>post-1.html</span></li>
<!--vot--><li><input type="radio" name="permalink" value="2" <?php echo $ex2; ?>><?=lang('directory_format')?>: <span class="permalink_url"><?php echo BLOG_URL; ?>post/1</span></li>
<!--vot--><li><input type="radio" name="permalink" value="3" <?php echo $ex3; ?>><?=lang('category_format')?>: <span class="permalink_url"><?php echo BLOG_URL; ?>category/1.html</span></li>
    <div style="border-top:1px solid #F7F7F7; width:521px; margin:10px 0px 10px 0px;"></div>
<!--vot--><li><?=lang('post_alias_enable')?>: <input type="checkbox" style="vertical-align:middle;" value="y" name="isalias" id="isalias" <?php echo $isalias; ?> /></li>
<!--vot--><li><?=lang('enable_html_suffix')?>: <input type="checkbox" style="vertical-align:middle;" value="y" name="isalias_html" id="isalias_html" <?php echo $isalias_html; ?> /></li>
</div>
<div style="border-top:1px solid #F7F7F7; width:521px; margin:10px 0px 10px 0px;"></div>
<!--vot--><div style="font-size: 14px; margin: 20px 0px 10px 10px;"><b><?=lang('meta_settings')?>:</b></div>
<div class="item_edit" style="margin-left:10px;">
<!--vot--><li><?=lang('meta_title')?><br /><input maxlength="200" style="width:300px;" class="input" value="<?php echo $site_title; ?>" name="site_title" /></li>
<!--vot--><li><?=lang('meta_keywords')?><br /><input maxlength="200" style="width:300px;" class="input" value="<?php echo $site_key; ?>" name="site_key" /></li>
<!--vot--><li><?=lang('meta_description')?><br /><textarea name="site_description" class="textarea" cols="" rows="4" style="width:300px;"><?php echo $site_description; ?></textarea></li>
<!--vot--><li><?=lang('meta_title_scheme')?>:
        <select name="log_title_style" class="input">
<!--vot-->	<option value="0" <?php echo $opt0; ?>><?=lang('post_title')?></option>
<!--vot-->	<option value="1" <?php echo $opt1; ?>><?=lang('post_title_site_title')?></option>
<!--vot-->	<option value="2" <?php echo $opt2; ?>><?=lang('post_title_site_meta_title')?></option>
        </select>
    </li>
    <li style="margin-top:10px;">
        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
<!--vot--><input type="submit" value="<?=lang('save_settings')?>" class="button" />
    </li>
</div>
</form>
</div>