<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>
setTimeout(hideActived,2600);
</script>
<div class=containertitle><b><? echo $lang['settings'];?></b><?php if(isset($_GET['activated'])):?><span class="actived"><? echo $lang['settings_saved_ok'];?></span><?php endif;?></div>
<div class=line></div>
<form action="configure.php?action=mod_config" method="post" name="input" id="input">
  <table cellspacing="8" cellpadding="4" width="95%" align="center" border="0">
    <tbody>
      <tr nowrap="nowrap">
        <td width="18%" align="right"><? echo $lang['blog_name'];?>:</td>
        <td width="82%"><input maxlength="200" size="35" value="<?php echo $blogname; ?>" name="blogname" /></td>
      </tr>
      <tr nowrap="nowrap">
        <td align="right" valign="top"><? echo $lang['blog_description'];?>:</td>
        <td><textarea name="bloginfo" cols="" rows="4" style="width:300px;"><?php echo $bloginfo; ?></textarea></td>
      </tr>
      <tr nowrap="nowrap">
        <td align="right"><? echo $lang['blog_url'];?>:</td>
        <td class="care"><input maxlength="200" size="35" value="<?php echo $blogurl; ?>" name="blogurl" /></td>
      </tr>
      <tr nowrap="nowrap">
        <td align="right"><? echo $lang['blog_keywords'];?>:</td>
        <td><input maxlength="200" size="35" value="<?php echo $site_key; ?>" name="site_key" />
        <? echo $lang['separate_keywords'];?></td>
      </tr>
      <tr nowrap="nowrap">
        <td align="right"><? echo $lang['registration_number'];?>:</td>
        <td><input maxlength="200" size="35" value="<?php echo $icp; ?>" name="icp" /></td>
      </tr>
      <tr nowrap="nowrap">
        <td align="right"><? echo $lang['posts_per_page'];?>:</td>
        <td><input maxlength="5" size="10" value="<?php echo $index_lognum; ?>" name="index_lognum" /></td>
      </tr>
	  <tr>
        <td valign="top" align="right"><? echo $lang['server_tz'];?>:<br /></td>
        <td>
		<select name="timezone">
<?php
		$tzlist = array(
			'-12'=> $lang['tz-12:00'],
			'-11'=> $lang['tz-11:00'],
			'-10'=> $lang['tz-10:00'],
			'-9'=>  $lang['tz-09:00'],
			'-8'=>  $lang['tz-08:00'],
			'-7'=>  $lang['tz-07:00'],
			'-6'=>  $lang['tz-06:00'],
			'-5'=>  $lang['tz-05:00'],
			'-4'=>  $lang['tz-04:00'],
			'-3.5'=>$lang['tz-03:30'],
			'-3'=>  $lang['tz-03:00'],
			'-2'=>  $lang['tz-02:00'],
			'-1'=>  $lang['tz-01:00'],
			'0'=>   $lang['tz 00:00'],
			'1'=>   $lang['tz+01:00'],
			'2'=>   $lang['tz+02:00'],
			'3'=>   $lang['tz+03:00'],
			'3.5'=> $lang['tz+03:30'],
			'4'=>   $lang['tz+04:00'],
			'4.5'=> $lang['tz+04:30'],
			'5'=>   $lang['tz+05:00'],
			'5.5'=> $lang['tz+05:30'],
			'6'=>   $lang['tz+06:00'],
			'7'=>   $lang['tz+07:00'],
			'8'=>   $lang['tz+08:00'],
			'9'=>   $lang['tz+09:00'],
			'9.5'=> $lang['tz+09:30'],
			'10'=>  $lang['tz+10:00'],
			'11'=>  $lang['tz+11:00'],
			'12'=>  $lang['tz+12:00']
		);
foreach($tzlist as $key=>$value):
$ex = $key==$timezone?"selected=\"selected\"":'';
?>
		<option value="<?php echo $key; ?>" <?php echo $ex; ?>><?php echo $value; ?></option>
<?php endforeach;?>	
        </select>        
        </td>
      </tr>
      <tr>
        <td align="right"><? echo $lang['comments_require_approving'];?>:<br /></td>
        <td>
		<select name="ischkcomment">
          <option value="y" <?php echo $ex5; ?>><? echo $lang['yes'];?></option>
          <option value="n" <?php echo $ex6; ?>><? echo $lang['no'];?></option>
        </select>
		<? echo $lang['comments_require_approving_info'];?> </td>
      </tr>
	  <tr>
        <td align="right"><? echo $lang['trackback_settings_enable'];?>:<br /></td>
        <td>
		<select name="istrackback">
          <option value="y" <?php echo $ex7; ?>><? echo $lang['yes'];?></option>
          <option value="n" <?php echo $ex8; ?>><? echo $lang['no'];?></option>
        </select>
		</td>
      </tr>
      <tr>
        <td align="right"><? echo $lang['require_login_verification'];?>:<br /></td>
        <td class="care">
        <select name="login_code">
          <option value="y" <?php echo $ex1; ?>><? echo $lang['yes'];?></option>
          <option value="n" <?php echo $ex2; ?>><? echo $lang['no'];?></option>
        </select>
        </td>
      </tr>
      <tr>
        <td align="right"><? echo $lang['comments_require_verification_code'];?>:<br /></td>
        <td>
        <select name="comment_code">
          <option value="y" <?php echo $ex3; ?>><? echo $lang['yes'];?></option>
          <option value="n" <?php echo $ex4; ?>><? echo $lang['no'];?></option>
        </select>
        </td>
      </tr>
	  <tr>
        <td align="right"><? echo $lang['url_rewrite_enable'];?>:<br /></td>
        <td class="care">
		<select name="isurlrewrite">
          <option value="y" <?php echo $ex9; ?>><? echo $lang['yes'];?></option>
          <option value="n" <?php echo $ex10; ?>><? echo $lang['no'];?></option>
        </select> <? echo $lang['url_rewrite_info'];?></td>
      </tr>
      <tr>
        <td align="right"><? echo $lang['gzip_enable'];?>:<br /></td>
        <td class="care">
		<select name="isgzipenable">
          <option value="y" <?php echo $ex11; ?>><? echo $lang['yes'];?></option>
          <option value="n" <?php echo $ex12; ?>><? echo $lang['no'];?></option>
        </select>
		</td>
      </tr>
      <tr>
        <td align="center" colspan="2"><input type="submit" value="<? echo $lang['save_settings'];?>" class="button" /></td>
      </tr>
    </tbody>
  </table>
</form>