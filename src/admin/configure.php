<?php
/**
 * 基本设置
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

if ($action == '') {
	$options_cache = $CACHE->readCache('options');
	extract($options_cache);

	$conf_login_code = $login_code == 'y' ? 'checked="checked"' : '';
	$conf_comment_code = $comment_code == 'y' ? 'checked="checked"' : '';
	$conf_comment_needchinese = $comment_needchinese == 'y' ? 'checked="checked"' : '';
	$conf_iscomment = $iscomment == 'y' ? 'checked="checked"' : '';
	$conf_ischkcomment = $ischkcomment == 'y' ? 'checked="checked"' : '';
	$conf_istrackback = $istrackback == 'y' ? 'checked="checked"' : '';
	$conf_isthumbnail = $isthumbnail == 'y' ? 'checked="checked"' : '';
	$conf_isgzipenable = $isgzipenable == 'y' ? 'checked="checked"' : '';
	$conf_isxmlrpcenable = $isxmlrpcenable == 'y' ? 'checked="checked"' : '';
	$conf_isgravatar = $isgravatar == 'y' ? 'checked="checked"' : '';
	$conf_comment_paging = $comment_paging == 'y' ? 'checked="checked"' : '';
	$conf_istwitter = $istwitter == 'y' ? 'checked="checked"' : '';
	$conf_reply_code = $reply_code == 'y' ? 'checked="checked"' : '';
	$conf_ischkreply = $ischkreply == 'y' ? 'checked="checked"' : '';

	$ex1 = $ex2 = $ex3 = $ex4 = '';
	if ($rss_output_fulltext == 'y') {
		$ex1 = 'selected="selected"';
	} else {
	 	$ex2 = 'selected="selected"';
	}
	if ($comment_order == 'newer') {
		$ex3 = 'selected="selected"';
	} else {
	 	$ex4 = 'selected="selected"';
	}

	include View::getView('header');
	require_once(View::getView('configure'));
	include View::getView('footer');
	View::output();
}

if ($action == 'mod_config') {
	$getData = array(
	'site_key' => isset($_POST['site_key']) ? addslashes($_POST['site_key']) : '',
	'blogname' => isset($_POST['blogname']) ? addslashes($_POST['blogname'])  : '',
	'blogurl' => isset($_POST['blogurl']) ? addslashes($_POST['blogurl']) : '',
	'bloginfo' => isset($_POST['bloginfo']) ? addslashes($_POST['bloginfo']) : '',
	'icp' => isset($_POST['icp']) ? addslashes($_POST['icp']):'',
	'footer_info' => isset($_POST['footer_info']) ? addslashes($_POST['footer_info']):'',
	'index_lognum' => isset($_POST['index_lognum']) ? intval($_POST['index_lognum']) : '',
	'timezone' => isset($_POST['timezone']) ? floatval($_POST['timezone']) : '',
	'login_code'   => isset($_POST['login_code']) ? addslashes($_POST['login_code']) : 'n',
	'comment_code' => isset($_POST['comment_code']) ? addslashes($_POST['comment_code']) : 'n',
	'comment_needchinese' => isset($_POST['comment_needchinese']) ? addslashes($_POST['comment_needchinese']) : 'n',
	'comment_interval' => isset($_POST['comment_interval']) ? intval($_POST['comment_interval']) : 15,
	'iscomment' => isset($_POST['iscomment']) ? addslashes($_POST['iscomment']) : 'n',
	'ischkcomment' => isset($_POST['ischkcomment']) ? addslashes($_POST['ischkcomment']) : 'n',
	'isgzipenable' => isset($_POST['isgzipenable']) ? addslashes($_POST['isgzipenable']) : 'n',
	'isxmlrpcenable' => isset($_POST['isxmlrpcenable']) ? addslashes($_POST['isxmlrpcenable']) : 'n',
	'istrackback' => isset($_POST['istrackback']) ? addslashes($_POST['istrackback']) : 'n',
	'isthumbnail' => isset($_POST['isthumbnail']) ? addslashes($_POST['isthumbnail']) : 'n',
	'rss_output_num' => isset($_POST['rss_output_num']) ? intval($_POST['rss_output_num']) : 10,
	'rss_output_fulltext' => isset($_POST['rss_output_fulltext']) ? addslashes($_POST['rss_output_fulltext']) : 'y',
	'isgravatar' => isset($_POST['isgravatar']) ? addslashes($_POST['isgravatar']) : 'n',
	'comment_paging' => isset($_POST['comment_paging']) ? addslashes($_POST['comment_paging']) : 'n',
	'comment_pnum' => isset($_POST['comment_pnum']) ? intval($_POST['comment_pnum']) : '',
	'comment_order' => isset($_POST['comment_order']) ? addslashes($_POST['comment_order']) : 'newer',
	'istwitter' => isset($_POST['istwitter']) ? addslashes($_POST['istwitter']) : 'n',
	'ischkreply' => isset($_POST['ischkreply']) ? addslashes($_POST['ischkreply']) : 'n',
	'reply_code' => isset($_POST['reply_code']) ? addslashes($_POST['reply_code']) : 'n',
	'index_twnum' => isset($_POST['index_twnum']) ? intval($_POST['index_twnum']) : 10,
	'site_title' => isset($_POST['site_title']) ? addslashes($_POST['site_title'])  : '',
	'site_description' => isset($_POST['site_description']) ? addslashes($_POST['site_description']) : '',
	'site_key' => isset($_POST['site_key']) ? addslashes($_POST['site_key']) : '',
	);

	if ($getData['login_code'] == 'y' && !function_exists("imagecreate") && !function_exists('imagepng')) {
		emMsg("开启登录验证码失败!服务器不支持该功能","configure.php");
	}
	if ($getData['comment_code'] == 'y' && !function_exists("imagecreate") && !function_exists('imagepng')) {
		emMsg("开启评论验证码失败!服务器不支持该功能","configure.php");
	}
	if ($getData['blogurl'] && substr($getData['blogurl'], -1) != '/') {
		$getData['blogurl'] .= '/';
	}
	if ($getData['blogurl'] && strncasecmp($getData['blogurl'],'http://',7)) {
		$getData['blogurl'] = 'http://'.$getData['blogurl'];
	}

	foreach ($getData as $key => $val) {
		Option::updateOption($key, $val);
	}
	$CACHE->updateCache(array('tags', 'options', 'comment', 'record'));
	emDirect("./configure.php?activated=true");
}
