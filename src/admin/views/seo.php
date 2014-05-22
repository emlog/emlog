<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class="containertitle2">
<a class="navi1" href="./configure.php"><? echo $lang['base_settings']; ?></a>
<a class="navi2" href="./seo.php"><? echo $lang['seo_settings']; ?></a>
<a class="navi4" href="./style.php"><? echo $lang['backstage_style']; ?></a>
<a class="navi4" href="./blogger.php"><? echo $lang['personal_data']; ?></a>
<?php if(isset($_GET['activated'])):?><span class="actived"><? echo $lang['settings_saved_ok']; ?></span><?php endif;?>
<?php if(isset($_GET['error'])):?><span class="error"><? echo $lang['error_htaccess']; ?></span><?php endif;?>
</div>
<div style="margin-left:10px;">
<form action="seo.php?action=update" method="post">
<div style="font-size: 14px; margin: 10px 0px 10px 10px;"><b><? echo $lang['link_settings']; ?>:</b></div>
<div class="des" style="margin-left:10px;">
    <? echo $lang['permalink_info']; ?>
</div>
<div style="margin:10px 8px;">
	<li><input type="radio" name="permalink" value="0" <?php echo $ex0; ?>><? echo $lang['default_format']; ?>: <span class="permalink_url"><?php echo BLOG_URL; ?>?post=1</span></li>
    <li><input type="radio" name="permalink" value="1" <?php echo $ex1; ?>><? echo $lang['file_format']; ?>: <span class="permalink_url"><?php echo BLOG_URL; ?>post-1.html</span></li>
    <li><input type="radio" name="permalink" value="2" <?php echo $ex2; ?>><? echo $lang['directory_format']; ?>: <span class="permalink_url"><?php echo BLOG_URL; ?>post/1</span></li>
	<li><input type="radio" name="permalink" value="3" <?php echo $ex3; ?>><? echo $lang['category_format']; ?>: <span class="permalink_url"><?php echo BLOG_URL; ?>category/1.html</span></li>
    <div style="border-top:1px solid #F7F7F7; width:521px; margin:10px 0px 10px 0px;"></div>
	<li><? echo $lang['link_alias_enable']; ?>: <input type="checkbox" style="vertical-align:middle;" value="y" name="isalias" id="isalias" <?php echo $isalias; ?> /></li>
	<li><? echo $lang['link_alias_html']; ?>: <input type="checkbox" style="vertical-align:middle;" value="y" name="isalias_html" id="isalias_html" <?php echo $isalias_html; ?> /></li>
</div>
<div style="border-top:1px solid #F7F7F7; width:521px; margin:10px 0px 10px 0px;"></div>
<div style="font-size: 14px; margin: 20px 0px 10px 10px;"><b><? echo $lang['meta_settings']; ?>:</b></div>
<div class="item_edit" style="margin-left:10px;">
    <li><? echo $lang['site_title']; ?> (title)<br /><input maxlength="200" style="width:300px;" value="<?php echo $site_title; ?>" name="site_title" /></li>
    <li><? echo $lang['meta_keywords']; ?> (keywords)<br /><input maxlength="200" style="width:300px;" value="<?php echo $site_key; ?>" name="site_key" /></li>
    <li><? echo $lang['meta_description']; ?> (description)<br /><textarea name="site_description" cols="" rows="4" style="width:300px;"><?php echo $site_description; ?></textarea></li>
    <li><? echo $lang['meta_title_scheme']; ?>:
        <select name="log_title_style" class="input">
		<option value="0" <?php echo $opt0; ?>><? echo $lang['article_title']; ?></option>
		<option value="1" <?php echo $opt1; ?>><? echo $lang['article_title_site_title']; ?></option>
        <option value="2" <?php echo $opt2; ?>><? echo $lang['article_title_site_meta_title']; ?></option>
        </select>
    </li>
    <li style="margin-top:10px;"><input type="submit" value="<? echo $lang['save_settings']; ?>" class="button" /></li>
</div>
</form>
</div>