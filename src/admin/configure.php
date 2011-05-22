<?php
/**
 * 基本设置
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

require_once 'globals.php';

if ($action == '') {
	$options_cache = $CACHE->readCache('options');
	extract($options_cache);

	$conf_login_code = $login_code == 'y' ? 'checked="checked"' : '';
	$conf_comment_code = $comment_code == 'y' ? 'checked="checked"' : '';
	$conf_ischkcomment = $ischkcomment == 'y' ? 'checked="checked"' : '';
	$conf_istrackback = $istrackback == 'y' ? 'checked="checked"' : '';
	$conf_isgzipenable = $isgzipenable == 'y' ? 'checked="checked"' : '';
	$conf_isxmlrpcenable = $isxmlrpcenable == 'y' ? 'checked="checked"' : '';
	$conf_isgravatar = $isgravatar == 'y' ? 'checked="checked"' : '';

	$ex1 = $ex2 = '';
	if ($rss_output_fulltext == 'y') {
		$ex1 = 'selected="selected"';
	} else {
	 	$ex2 = 'selected="selected"';
	}

	include View::getView('header');
	require_once(View::getView('configure'));
	include View::getView('footer');
	View::output();
}

//update config
if ($action == 'mod_config') {
	$getData = array(
	'site_key' => isset($_POST['site_key']) ? addslashes($_POST['site_key']) : '',
	'blogname' => isset($_POST['blogname']) ? addslashes($_POST['blogname'])  : '',
	'blogurl' => isset($_POST['blogurl']) ? addslashes($_POST['blogurl']) : '',
	'bloginfo' => isset($_POST['bloginfo']) ? addslashes($_POST['bloginfo']) : '',
	'icp' => isset($_POST['icp']) ? addslashes($_POST['icp']):'',
	'index_lognum' => isset($_POST['index_lognum']) ? intval($_POST['index_lognum']) : '',
	'timezone' => isset($_POST['timezone']) ? floatval($_POST['timezone']) : '',
	'login_code'   => isset($_POST['login_code']) ? addslashes($_POST['login_code']) : 'n',
	'comment_code' => isset($_POST['comment_code']) ? addslashes($_POST['comment_code']) : 'n',
	'ischkcomment' => isset($_POST['ischkcomment']) ? addslashes($_POST['ischkcomment']) : 'n',
	'isgzipenable' => isset($_POST['isgzipenable']) ? addslashes($_POST['isgzipenable']) : 'n',
	'isxmlrpcenable' => isset($_POST['isxmlrpcenable']) ? addslashes($_POST['isxmlrpcenable']) : 'n',
	'istrackback' => isset($_POST['istrackback']) ? addslashes($_POST['istrackback']) : 'n',
	'rss_output_num' => isset($_POST['rss_output_num']) ? intval($_POST['rss_output_num']) : 10,
	'rss_output_fulltext' => isset($_POST['rss_output_fulltext']) ? addslashes($_POST['rss_output_fulltext']) : 'y',
	'isgravatar' => isset($_POST['isgravatar']) ? addslashes($_POST['isgravatar']) : 'n',
	);

	if ($getData['login_code'] == 'y' && !function_exists("imagecreate") && !function_exists('imagepng')){
		formMsg("开启登录验证码失败!服务器不支持该功能","configure.php",0);
	}
	if ($getData['comment_code'] == 'y' && !function_exists("imagecreate") && !function_exists('imagepng')){
		formMsg("开启评论验证码失败!服务器不支持该功能","configure.php",0);
	}
	if($getData['blogurl'] && substr($getData['blogurl'], -1) != '/'){
		$getData['blogurl'] .= '/';
	}
	if($getData['blogurl'] && strncasecmp($getData['blogurl'],'http://',7)){
		$getData['blogurl'] = 'http://'.$getData['blogurl'];
	}

	foreach ($getData as $key => $val) {
		Option::updateOption($key, $val);
	}
	$CACHE->updateCache(array('tags', 'options', 'comment', 'record'));
	emDirect("./configure.php?activated=true");
}
