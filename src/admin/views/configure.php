<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class="containertitle2">
<!--vot--><a class="navi3" href="./configure.php"><?=lang('basic_settings')?></a>
<!--vot--><a class="navi4" href="./seo.php"><?=lang('seo_settings')?></a>
<!--vot--><a class="navi4" href="./style.php"><?=lang('background_style')?></a>
<!--vot--><a class="navi4" href="./blogger.php"><?=lang('personal_settings')?></a>
<!--vot--><?php if(isset($_GET['activated'])):?><span class="actived"><?=lang('settings_saved_ok')?></span><?php endif;?>
</div>
<form action="configure.php?action=mod_config" method="post" name="input" id="input">
  <table cellspacing="8" cellpadding="4" width="95%" align="center" border="0">
      <tr>
<!--vot--><td width="18%" align="right"><?=lang('site_title')?>:</td>
        <td width="82%"><input maxlength="200" style="width:390px;" class="input" value="<?php echo $blogname; ?>" name="blogname" /></td>
      </tr>
      <tr>
<!--vot--><td align="right" valign="top"><?=lang('site_subtitle')?>:</td>
        <td><textarea name="bloginfo" cols="" rows="3" style="width:386px;" class="textarea"><?php echo $bloginfo; ?></textarea></td>
      </tr>
      <tr>
<!--vot--><td align="right"><?=lang('site_address')?>:</td>
        <td><input maxlength="200" style="width:390px;" class="input" value="<?php echo $blogurl; ?>" name="blogurl" /></td>
      </tr>
      <tr>
<!--vot-->	<td align="right"><?=lang('per_page')?>:</td>
<!--vot-->	<td><input maxlength="5" size="4" class="input" value="<?php echo $index_lognum; ?>" name="index_lognum" /><?=lang('_posts')?></td>
      </tr>
	  <tr>
<!--vot-->	<td valign="top" align="right"><?=lang('your_timezone')?>:<br /></td>
        <td>
		<select name="timezone" style="width:390px;" class="input">
<?php
/*vot*/		$tzlist = array(
/*vot*/				'-12'=>lang('tz-12'),
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
foreach($tzlist as $key=>$value):
$ex = $key==$timezone?"selected=\"selected\"":'';
?>
		<option value="<?php echo $key; ?>" <?php echo $ex; ?>><?php echo $value; ?></option>
<?php endforeach;?>
        </select>
<!--vot-->(<?=lang('local_time')?>: <?php echo gmdate('Y-m-d H:i:s', time() + $timezone * 3600); ?>)
        </td>
      </tr>
      <tr>
<!--vot-->	<td align="right" width="18%" valign="top"><?=lang('function_switch')?>:<br /></td>
        <td width="82%">
<!--vot-->	<input type="checkbox" style="vertical-align:middle;" value="y" name="login_code" id="login_code" <?php echo $conf_login_code; ?> /><?=lang('login_verification_code')?><br />
<!--vot-->	<input type="checkbox" style="vertical-align:middle;" value="y" name="isgzipenable" id="isgzipenable" <?php echo $conf_isgzipenable; ?> /><?=lang('gzip_compression')?><br />
<!--vot-->	<input type="checkbox" style="vertical-align:middle;" value="y" name="isxmlrpcenable" id="isxmlrpcenable" <?php echo $conf_isxmlrpcenable; ?> /><?=lang('offline_writing')?><br />
<!--vot-->	<input type="checkbox" style="vertical-align:middle;" value="y" name="ismobile" id="ismobile" <?php echo $conf_ismobile; ?> /><?=lang('mobile_access_address')?>: <span id="m"><a title="<?=lang('access_site_by_mobile')?>"><?php echo BLOG_URL.'m'; ?></a></span><br />
<!--vot-->	<input type="checkbox" style="vertical-align:middle;" value="y" name="isexcerpt" id="isexcerpt" <?php echo $conf_isexcerpt; ?> /><?=lang('auto_summary')?>
<!--vot-->	<input type="text" name="excerpt_subnum" maxlength="3" value="<?php echo Option::get('excerpt_subnum'); ?>" class="input" style="width:25px;" /><?=lang('characters_as_summary')?><br />
        </td>
      <tr>
  </table>
  <div class="setting_line"></div>
  <table cellspacing="8" cellpadding="4" width="95%" align="center" border="0">
      <tr>
<!--vot--><td align="right" width="18%" valign="top"><?=lang('twitters')?>:<br /></td>
        <td width="82%">
<!--vot-->	<input type="checkbox" style="vertical-align:middle;" value="y" name="istwitter" id="istwitter" <?php echo $conf_istwitter; ?> /><?=lang('twitters_enable')?>
<!--vot-->	<?=lang('per_page')?> <input type="text" name="index_twnum" maxlength="3" value="<?php echo Option::get('index_twnum'); ?>" class="input" style="width:25px;" /><?=lang('_twitters')?><br />
<!--vot-->	<input type="checkbox" style="vertical-align:middle;" value="y" name="istreply" id="istreply" <?php echo $conf_istreply; ?> /><?=lang('twitter_reply_enable')?>
<!--vot-->	<input type="checkbox" style="vertical-align:middle;" value="y" name="reply_code" id="reply_code" <?php echo $conf_reply_code; ?> /><?=lang('reply_verification_code')?>
<!--vot-->	<input type="checkbox" style="vertical-align:middle;" value="y" name="ischkreply" id="ischkreply" <?php echo $conf_ischkreply; ?> /><?=lang('reply_audit')?><br />
		</td>
      </tr>
  </table>
  <div class="setting_line"></div>
  <table cellspacing="8" cellpadding="4" width="95%" align="center" border="0">
      <tr>
<!--vot--><td align="right" width="18%"><?=lang('rss')?>:<br /></td>
        <td width="82%">
<!--vot-->	<?=lang('export')?><input maxlength="5" size="4" value="<?php echo $rss_output_num; ?>" class="input" name="rss_output_num" /><?=lang('_posts_and_output')?>
        <select name="rss_output_fulltext" class="input">
<!--vot-->	<option value="y" <?php echo $ex1; ?>><?=lang('full_text')?></option>
<!--vot-->	<option value="n" <?php echo $ex2; ?>><?=lang('summary')?></option>
        </select>
		</td>
      </tr>
  </table>
  <div class="setting_line"></div>
  <table cellspacing="8" cellpadding="4" width="95%" align="center" border="0">
      <tr>
<!--vot--><td align="right" width="18%" valign="top"><?=lang('comments')?>:<br /></td>
        <td width="82%">
<!--vot-->	<input type="checkbox" style="vertical-align:middle;" value="y" name="iscomment" id="iscomment" <?php echo $conf_iscomment; ?> /><?=lang('enable_comment_interval')?><input maxlength="5" size="2" class="input" value="<?php echo $comment_interval; ?>" name=comment_interval /><?=lang('_seconds')?><br />
<!--vot-->	<input type="checkbox" style="vertical-align:middle;" value="y" name="ischkcomment" id="ischkcomment" <?php echo $conf_ischkcomment; ?> /><?=lang('comment_moderation')?><br />
<!--vot-->	<input type="checkbox" style="vertical-align:middle;" value="y" name="comment_code" id="comment_code" <?php echo $conf_comment_code; ?> /><?=lang('comment_verification_code')?><br />
<!--vot-->	<input type="checkbox" style="vertical-align:middle;" value="y" name="isgravatar" id="isgravatar" <?php echo $conf_isgravatar; ?> /><?=lang('comment_avatar')?><br />
<!--vot-->	<input type="checkbox" style="vertical-align:middle;" value="y" name="comment_needchinese" id="comment_needchinese" <?php echo $conf_comment_needchinese; ?> /><?=lang('comment_must_contain_chinese')?><br />
<!--vot-->	<input type="checkbox" style="vertical-align:middle;" value="y" name="comment_paging" id="comment_paging" <?php echo $conf_comment_paging; ?> /><?=lang('comment_per_page')?>
<!--vot-->	<?=lang('per_page')?><input maxlength="5" size="4" class="input" value="<?php echo $comment_pnum; ?>" name="comment_pnum" /><?=lang('_comments_')?>
<!--vot-->	<select name="comment_order" class="input"><option value="newer" <?php echo $ex3; ?>><?=lang('newer')?></option><option value="older" <?php echo $ex4; ?>><?=lang('older')?></option></select><?=lang('standing_in_front')?><br />
		</td>
      </tr>
  </table>
<div class="setting_line"></div>
  <table cellspacing="8" cellpadding="4" width="95%" align="center" border="0">
      <tr>
        <td align="right" width="18%" valign="top"><? echo $lang['attachments']; ?>:<br /></td>
        <td width="82%">
		<? echo $lang['attachment_max_upload']; ?>: <input maxlength="10" size="8" class="input" value="<?php echo $att_maxsize; ?>" name="att_maxsize" />KB (<? echo $lang['attachment_php_info']; ?> <?php echo ini_get('upload_max_filesize'); ?> <? echo $lang['limit']; ?>)<br />
        <? echo $lang['attachment_types']; ?>: <input maxlength="200" style="width:320px;" class="input" value="<?php echo $att_type; ?>" name="att_type" />(<? echo $lang['separate_by_comma']; ?>)<br />
        <input type="checkbox" style="vertical-align:middle;" value="y" name="isthumbnail" id="isthumbnail" <?php echo $conf_isthumbnail; ?> /><? echo $lang['thumbnail_generate']; ?>, <? echo $lang['max_size']; ?>: <input maxlength="5" size="4" class="input" value="<?php echo $att_imgmaxw; ?>" name="att_imgmaxw" />x<input maxlength="5" size="4" class="input" value="<?php echo $att_imgmaxh; ?>" name="att_imgmaxh" /> <? echo $lang['unit_pixel']; ?><br />
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
        <td align="center" colspan="2">
            <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
        	<input type="submit" value="<? echo $lang['save_settings'];?>" class="button" />
        </td>
      </tr>
  </table>
</form>