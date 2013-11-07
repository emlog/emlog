<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class="containertitle2">
<a class="navi3" href="./configure.php"><? echo $lang['base_settings']; ?></a>
<a class="navi4" href="./seo.php"><? echo $lang['seo_settings']; ?></a>
<a class="navi4" href="./style.php"><? echo $lang['backstage_style']; ?></a>
<a class="navi4" href="./blogger.php"><? echo $lang['personal_data']; ?></a>
<?php if(isset($_GET['activated'])):?><span class="actived"><? echo $lang['settings_saved_ok']; ?></span><?php endif;?>
</div>
<form action="configure.php?action=mod_config" method="post" name="input" id="input">
  <table cellspacing="8" cellpadding="4" width="95%" align="center" border="0">
      <tr>
        <td width="18%" align="right"><? echo $lang['blog_name'];?>:</td>
        <td width="82%"><input maxlength="200" style="width:390px;" class="input" value="<?php echo $blogname; ?>" name="blogname" /></td>
      </tr>
      <tr>
        <td align="right" valign="top"><? echo $lang['blog_description'];?>:</td>
        <td><textarea name="bloginfo" cols="" rows="3" style="width:386px;" class="textarea"><?php echo $bloginfo; ?></textarea></td>
      </tr>
      <tr>
        <td align="right"><? echo $lang['blog_url'];?>:</td>
        <td><input maxlength="200" style="width:390px;" class="input" value="<?php echo $blogurl; ?>" name="blogurl" /></td>
      </tr>
      <tr>
        <td align="right"><? echo $lang['show_perpage']; ?>:</td>
        <td><input maxlength="5" size="4" class="input" value="<?php echo $index_lognum; ?>" name="index_lognum" />篇文章</td>
      </tr>
	  <tr>
        <td valign="top" align="right"><? echo $lang['server_tz'];?>:<br /></td>
        <td>
		<select name="timezone" style="width:390px;" class="input">
<?php
		$tzlist = array('-12'=> $lang['tz-12:00'],
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
        (<? echo $lang['time_local']; ?>: <?php echo gmdate('Y-m-d H:i:s', time() + $timezone * 3600); ?>)
        </td>
      </tr>
      <tr>
        <td align="right" width="18%" valign="top"><? echo $lang['function_switch']; ?>:<br /></td>
        <td width="82%">
        <input type="checkbox" style="vertical-align:middle;" value="y" name="login_code" id="login_code" <?php echo $conf_login_code; ?> /><? echo $lang['login_captcha']; ?><br />
        <input type="checkbox" style="vertical-align:middle;" value="y" name="isthumbnail" id="isthumbnail" <?php echo $conf_isthumbnail; ?> /><? echo $lang['attachment_thumb']; ?><br />
        <input type="checkbox" style="vertical-align:middle;" value="y" name="isgzipenable" id="isgzipenable" <?php echo $conf_isgzipenable; ?> /><? echo $lang['gzip_compression']; ?><br />
        <input type="checkbox" style="vertical-align:middle;" value="y" name="isxmlrpcenable" id="isxmlrpcenable" <?php echo $conf_isxmlrpcenable; ?> /><? echo $lang['offline_writing']; ?><br />
      	<input type="checkbox" style="vertical-align:middle;" value="y" name="ismobile" id="ismobile" <?php echo $conf_ismobile; ?> /><? echo $lang['mobile_version']; ?>, <? echo $lang['link_url']; ?>: <span id="m"><a title="<? echo $lang['mobile_use']; ?>"><?php echo BLOG_URL.'m'; ?></a></span>
      	</td>
      <tr>
  </table>
  <div class="setting_line"></div>
  <table cellspacing="8" cellpadding="4" width="95%" align="center" border="0">
      <tr>
        <td align="right" width="18%" valign="top"><? echo $lang['twitter']; ?>:<br /></td>
        <td width="82%">
		<input type="checkbox" style="vertical-align:middle;" value="y" name="istwitter" id="istwitter" <?php echo $conf_istwitter; ?> /><? echo $lang['twitter_enable']; ?>,
		每页显示<input type="text" name="index_twnum" maxlength="3" value="<?php echo Option::get('index_twnum'); ?>" class="input" style="width:25px;" />条微语<br />
		<input type="checkbox" style="vertical-align:middle;" value="y" name="istreply" id="istreply" <?php echo $conf_istreply; ?> /><? echo $lang['twitter_reply_enable']; ?>,
		<input type="checkbox" style="vertical-align:middle;" value="y" name="reply_code" id="reply_code" <?php echo $conf_reply_code; ?> /><? echo $lang['reply_captcha_enable']; ?>,
		<input type="checkbox" style="vertical-align:middle;" value="y" name="ischkreply" id="ischkreply" <?php echo $conf_ischkreply; ?> /><? echo $lang['reply_premoderate']; ?><br />
		</td>
      </tr>
  </table>
  <div class="setting_line"></div>
  <table cellspacing="8" cellpadding="4" width="95%" align="center" border="0">
      <tr>
        <td align="right" width="18%">RSS:<br /></td>
        <td width="82%">
		输出<input maxlength="5" size="4" value="<?php echo $rss_output_num; ?>" class="input" name="rss_output_num" />篇文章，且输出
        <select name="rss_output_fulltext" class="input">
		<option value="n" <?php echo $ex2; ?>><? echo $lang['summary']; ?></option>
        </select>
		</td>
      </tr>
  </table>
  <div class="setting_line"></div>
  <table cellspacing="8" cellpadding="4" width="95%" align="center" border="0">
      <tr>
        <td align="right" width="18%" valign="top"><? echo $lang['comments']; ?>:<br /></td>
        <td width="82%">
        <input type="checkbox" style="vertical-align:middle;" value="y" name="iscomment" id="iscomment" <?php echo $conf_iscomment; ?> />开启评论，发表评论间隔<input maxlength="5" size="2" class="input" value="<?php echo $comment_interval; ?>" name=comment_interval />秒<br />
		<input type="checkbox" style="vertical-align:middle;" value="y" name="ischkcomment" id="ischkcomment" <?php echo $conf_ischkcomment; ?> /><? echo $lang['approved']; ?><br />
		<input type="checkbox" style="vertical-align:middle;" value="y" name="comment_code" id="comment_code" <?php echo $conf_comment_code; ?> /><? echo $lang['verification_code']; ?><br />
		<input type="checkbox" style="vertical-align:middle;" value="y" name="isgravatar" id="isgravatar" <?php echo $conf_isgravatar; ?> /><? echo $lang['author_avatar']; ?><br />
		<input type="checkbox" style="vertical-align:middle;" value="y" name="comment_needchinese" id="comment_needchinese" <?php echo $conf_comment_needchinese; ?> /><? echo $lang['comment_need_chinese']; ?><br />
		<input type="checkbox" style="vertical-align:middle;" value="y" name="comment_paging" id="comment_paging" <?php echo $conf_comment_paging; ?> /><? echo $lang['comment_pagination']; ?><br />
		每页显示<input maxlength="5" size="4" class="input" value="<?php echo $comment_pnum; ?>" name="comment_pnum" />条评论，
		<select name="comment_order" class="input"><option value="newer" <?php echo $ex3; ?>>较新的</option><option value="older" <?php echo $ex4; ?>>较旧的</option></select>排在前面<br />
		</td>
      </tr>
  </table>
  <div class="setting_line"></div>
  <table cellspacing="8" cellpadding="4" width="95%" align="center" border="0">
      <tr>
        <td align="right"><? echo $lang['registration_number']; ?>:</td>
        <td><input maxlength="200" style="width:390px;" class="input" value="<?php echo $icp; ?>" name="icp" /></td>
      </tr>
      <tr>
        <td align="right" width="18%" valign="top"><? echo $lang['footer_info'];?>:<br /></td>
        <td width="82%">
		<textarea name="footer_info" cols="" rows="6" class="textarea" style="width:386px;"><?php echo $footer_info; ?></textarea><br />
		<? echo $lang['footer_prompt']; ?>
		</td>
      </tr>
  </table>
  <div class="setting_line"></div>
  <table cellspacing="8" cellpadding="4" width="95%" align="center" border="0">
      <tr>
        <td align="center" colspan="2"><input type="submit" value="<? echo $lang['save_settings'];?>" class="button" /></td>
      </tr>
  </table>
</form>