<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class="containertitle2">
<a class="navi1" href="./configure.php"><? echo $lang['base_settings']; ?></a>
<a class="navi4" href="./style.php"><? echo $lang['backstage_style']; ?></a>
<a class="navi2" href="./permalink.php"><? echo $lang['permalink']; ?></a>
<a class="navi4" href="./blogger.php"><? echo $lang['personal_data']; ?></a>
<?php if(isset($_GET['activated'])):?><span class="actived"><? echo $lang['settings_saved_ok']; ?></span><?php endif;?>
<?php if(isset($_GET['error'])):?><span class="error"><? echo $lang['error_htaccess']; ?></span><?php endif;?>
</div>
<div style="margin-left:10px;">
<div class="des"><? echo $lang['permalink_info']; ?>
</div>
<form action="permalink.php?action=update" method="post">
<div style="margin:10px 10px;">
	<li><input type="radio" name="permalink" value="0" <?php echo $ex0; ?>><? echo $lang['default_format']; ?>: <span class="permalink_url"><?php echo BLOG_URL; ?>?post=1</span></li>
    <li><input type="radio" name="permalink" value="1" <?php echo $ex1; ?>><? echo $lang['file_format']; ?>: <span class="permalink_url"><?php echo BLOG_URL; ?>post-1.html</span></li>
    <li><input type="radio" name="permalink" value="2" <?php echo $ex2; ?>><? echo $lang['directory_format']; ?>: <span class="permalink_url"><?php echo BLOG_URL; ?>post/1</span></li>
	<li><input type="radio" name="permalink" value="3" <?php echo $ex3; ?>><? echo $lang['category_format']; ?>: <span class="permalink_url"><?php echo BLOG_URL; ?>category/1.html</span></li>
    <div style="border-top:1px solid #F7F7F7; width:521px; margin:10px 0px 10px 0px;"></div>
	<li><? echo $lang['link_alias_enable']; ?>: <input type="checkbox" style="vertical-align:middle;" value="y" name="isalias" id="isalias" <?php echo $isalias; ?> /></li>
	<li><? echo $lang['link_alias_html']; ?>: <input type="checkbox" style="vertical-align:middle;" value="y" name="isalias_html" id="isalias_html" <?php echo $isalias_html; ?> /></li>
	<li style="margin-top:10px;"><input type="submit" value="<? echo $lang['save_settings']; ?>" class="button" /></li>
</div>
</form>
</div>