<?php
/**
 * setting
 * @package EMLOG (www.emlog.net)
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

if (empty($action)) {
	$options_cache = $CACHE->readCache('options');
	extract($options_cache);

	$conf_login_code = $login_code == 'y' ? 'checked="checked"' : '';
	$conf_comment_code = $comment_code == 'y' ? 'checked="checked"' : '';
	$conf_comment_needchinese = $comment_needchinese == 'y' ? 'checked="checked"' : '';
	$conf_iscomment = $iscomment == 'y' ? 'checked="checked"' : '';
	$conf_ischkcomment = $ischkcomment == 'y' ? 'checked="checked"' : '';
	$conf_isthumbnail = $isthumbnail == 'y' ? 'checked="checked"' : '';
	$conf_isgravatar = $isgravatar == 'y' ? 'checked="checked"' : '';
	$conf_comment_paging = $comment_paging == 'y' ? 'checked="checked"' : '';
	$conf_istreply = $istreply == 'y' ? 'checked="checked"' : '';
	$conf_reply_code = $reply_code == 'y' ? 'checked="checked"' : '';
	$conf_ischkreply = $ischkreply == 'y' ? 'checked="checked"' : '';
	$conf_detect_url = $detect_url == 'y' ? 'checked="checked"' : '';

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

/*vot*/	include EMLOG_ROOT.'/lang/'.EMLOG_LANGUAGE.'/lang_tz.php'; // Load Time Zone List

	include View::getView('header');
	require_once(View::getView('configure'));
	include View::getView('footer');
	View::output();
}

if ($action == 'mod_config') {
	LoginAuth::checkToken();
	$getData = [
		'blogname'            => isset($_POST['blogname']) ? addslashes($_POST['blogname']) : '',
		'blogurl'             => isset($_POST['blogurl']) ? addslashes($_POST['blogurl']) : '',
		'bloginfo'            => isset($_POST['bloginfo']) ? addslashes($_POST['bloginfo']) : '',
		'icp'                 => isset($_POST['icp']) ? addslashes($_POST['icp']) : '',
		'footer_info'         => isset($_POST['footer_info']) ? addslashes($_POST['footer_info']) : '',
		'index_lognum'        => isset($_POST['index_lognum']) ? (int)$_POST['index_lognum'] : '',
/*vot*/		'timezone'            => isset($_POST['timezone']) ? addslashes($_POST['timezone']) : 'UTC',
		'login_code'          => isset($_POST['login_code']) ? addslashes($_POST['login_code']) : 'n',
		'comment_code'        => isset($_POST['comment_code']) ? addslashes($_POST['comment_code']) : 'n',
		'comment_needchinese' => isset($_POST['comment_needchinese']) ? addslashes($_POST['comment_needchinese']) : 'n',
		'comment_interval'    => isset($_POST['comment_interval']) ? (int)$_POST['comment_interval'] : 15,
		'iscomment'           => isset($_POST['iscomment']) ? addslashes($_POST['iscomment']) : 'n',
		'ischkcomment'        => isset($_POST['ischkcomment']) ? addslashes($_POST['ischkcomment']) : 'n',
		'isexcerpt'           => isset($_POST['isexcerpt']) ? addslashes($_POST['isexcerpt']) : 'n',
		'excerpt_subnum'      => isset($_POST['excerpt_subnum']) ? (int)$_POST['excerpt_subnum'] : '300',
		'isthumbnail'         => isset($_POST['isthumbnail']) ? addslashes($_POST['isthumbnail']) : 'n',
		'rss_output_num'      => isset($_POST['rss_output_num']) ? (int)$_POST['rss_output_num'] : 10,
		'rss_output_fulltext' => isset($_POST['rss_output_fulltext']) ? addslashes($_POST['rss_output_fulltext']) : 'y',
		'isgravatar'          => isset($_POST['isgravatar']) ? addslashes($_POST['isgravatar']) : 'n',
		'comment_paging'      => isset($_POST['comment_paging']) ? addslashes($_POST['comment_paging']) : 'n',
		'comment_pnum'        => isset($_POST['comment_pnum']) ? (int)$_POST['comment_pnum'] : '',
		'comment_order'       => isset($_POST['comment_order']) ? addslashes($_POST['comment_order']) : 'newer',
		'istreply'            => isset($_POST['istreply']) ? addslashes($_POST['istreply']) : 'n',
		'ischkreply'          => isset($_POST['ischkreply']) ? addslashes($_POST['ischkreply']) : 'n',
		'reply_code'          => isset($_POST['reply_code']) ? addslashes($_POST['reply_code']) : 'n',
		'index_twnum'         => isset($_POST['index_twnum']) ? (int)$_POST['index_twnum'] : 10,
		'att_maxsize'         => isset($_POST['att_maxsize']) ? (int)$_POST['att_maxsize'] : 20480,
		'att_type'            => isset($_POST['att_type']) ? str_replace('php', 'x', strtolower(addslashes($_POST['att_type']))) : '',
		'att_imgmaxw'         => isset($_POST['att_imgmaxw']) ? (int)$_POST['att_imgmaxw'] : 420,
		'att_imgmaxh'         => isset($_POST['att_imgmaxh']) ? (int)$_POST['att_imgmaxh'] : 460,
		'detect_url'          => isset($_POST['detect_url']) ? addslashes($_POST['detect_url']) : 'n',
	];

	if ($getData['login_code'] == 'y' && !function_exists("imagecreate") && !function_exists('imagepng')) {
/*vot*/ emMsg(lang('verification_code_not_supported'), "configure.php");
	}
	if ($getData['comment_code'] == 'y' && !function_exists("imagecreate") && !function_exists('imagepng')) {
/*vot*/ emMsg(lang('verification_code_comment_not_supported'), "configure.php");
	}
	if ($getData['blogurl'] && substr($getData['blogurl'], -1) != '/') {
		$getData['blogurl'] .= '/';
	}
	if ($getData['blogurl'] && strncasecmp($getData['blogurl'], 'http', 4)) {
		$getData['blogurl'] = 'http://' . $getData['blogurl'];
	}

	foreach ($getData as $key => $val) {
		Option::updateOption($key, $val);
	}
	$CACHE->updateCache(array('tags', 'options', 'comment', 'record'));
	emDirect("./configure.php?activated=1");
}
