<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class="containertitle2">
<a class="navi1" href="./configure.php"><? echo $lang['base_settings']; ?></a>
<a class="navi2" href="./permalink.php"><? echo $lang['permalink']; ?></a>
<a class="navi4" href="./blogger.php"><? echo $lang['personal_data']; ?></a>
<?php if(isset($_GET['activated'])):?><span class="actived"><? echo $lang['settings_saved_ok']; ?></span><?php endif;?>
<?php if(isset($_GET['error'])):?><span class="error"><? echo $lang['error_htaccess']; ?></span><?php endif;?>
</div>
<div style="margin-left:10px;">
<div class="des"><? echo $lang['permalink_info']; ?></div>
<form action="permalink.php?action=update" method="post">
  <table cellspacing="8" cellpadding="4" width="95%" border="0">
    <tbody>
      <tr>
        <td><input type="radio" name="permalink" value="0" <?php echo $ex0; ?>><? echo $lang['default_format']; ?>: <span class="permalink_url"><?php echo BLOG_URL; ?>?post=1</span></td>
      </tr>
	  <tr>
        <td><input type="radio" name="permalink" value="1" <?php echo $ex1; ?>><? echo $lang['file_format']; ?>： <span class="permalink_url"><?php echo BLOG_URL; ?>post-1.html</span></td>
      </tr>
	  <tr>
        <td><input type="radio" name="permalink" value="2" <?php echo $ex2; ?>><? echo $lang['directory_format']; ?>： <span class="permalink_url"><?php echo BLOG_URL; ?>post/1</span></td>
      </tr>
      <tr>
        <td rowspan="2"><input type="submit" value="<? echo $lang['save_settings']; ?>" class="button" /></td>
      </tr>
    </tbody>
  </table>
</form>
</div>