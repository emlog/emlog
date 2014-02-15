<?php
/**
 * Twitters
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

$Twitter_Model = new Twitter_Model();

if ($action == '') {
	$Reply_Model = new Reply_Model();

	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

	$tws = $Twitter_Model->getTwitters($page,1);
	$twnum = $Twitter_Model->getTwitterNum(1);
	$pageurl =  pagination($twnum, Option::get('admin_perpage_num'), $page, 'twitter.php?page=');
	$avatar = empty($user_cache[UID]['avatar']) ? './views/images/avatar.jpg' : '../' . $user_cache[UID]['avatar'];

	include View::getView('header');
	require_once View::getView('twitter');
	include View::getView('footer');
	View::output();
}
// Post twit
if ($action == 'post') {
	$t = isset($_POST['t']) ? addslashes(trim($_POST['t'])) : '';
	$img = isset($_POST['img']) ? addslashes(trim($_POST['img'])) : '';

	if ($img && !$t) {
		$t = $lang['image_share'];
	}

	if (!$t) {
		emDirect("twitter.php?error_a=1");
	}

	$tdata = array('content' => $Twitter_Model->formatTwitter($t),
			'author' => UID,
			'date' => time(),
			'img' => str_replace('../', '', $img)
	);

	$twid = $Twitter_Model->addTwitter($tdata);
	$CACHE->updateCache(array('sta','newtw'));
	doAction('post_twitter', $t, $twid);
	emDirect("twitter.php?active_t=1");
}
// Delete twit
if ($action == 'del') {
	$id = isset($_GET['id']) ? intval($_GET['id']) : '';
	$Twitter_Model->delTwitter($id);
	$CACHE->updateCache(array('sta','newtw'));
	emDirect("twitter.php?active_del=1");
}
// Get reply
if ($action == 'getreply') {
	$tid = isset($_GET['tid']) ? intval($_GET['tid']) : null;

	$Reply_Model = new Reply_Model();
	$replys = $Reply_Model->getReplys($tid);

	$response = '';
	foreach ($replys as $val) {
		 if ($val['hide'] == 'n') {
			$style = "background-color:#FFF";
			$act = "<span><a href=\"javascript: hidereply({$val['id']},{$tid});\">{$lang['hide']}</a></span> ";
		 } else {
			$style = "background-color:#FEE0E4";
            $act = "<span><a href=\"javascript: pubreply({$val['id']},{$tid});\">{$lang['comments_approve']}</a></span> ";
		 }
		 $response .= "
		 <li id=\"reply_{$val['id']}\" style=\"{$style}\">
		 <span class=\"name\">{$val['name']}</span> {$val['content']}<span class=\"time\">{$val['date']}</span>{$act}
         <a href=\"javascript: delreply({$val['id']},{$tid});\">{$lang['remove']}</a> 
         <em><a href=\"javascript:reply({$tid}, '@{$val['name']}:');\">{$lang['reply']}</a></em>
		 </li>";
	}
	echo $response;
}
// Reply the twit.
if ($action == 'reply') {
	$r = isset($_POST['r']) ? addslashes(trim($_POST['r'])) : '';
	$tid = isset($_GET['tid']) ? intval($_GET['tid']) : null;

	if (!$r || mb_strlen($r) > 420) {
		exit('err1');
	}

	$date = time();
	$name =  $user_cache[UID]['name'];

	$rdata = array(
			'tid' => $tid,
			'content' => $r,
			'name' => $name,
			'date' => $date,
	);

	$Reply_Model = new Reply_Model();
	$rid = $Reply_Model->addReply($rdata);
	if ($rid === false) {
		exit('err2');
	}
	$Twitter_Model->updateReplyNum($tid, '+1');
	$CACHE->updateCache('sta');

	$date = smartDate($date);
	$r = htmlClean(stripslashes($r));
	$response = "
		 <li id=\"reply_{$rid}\" style=\"background-color:#FFEEAA\">
		 <span class=\"name\">{$name}</span> {$r}<span class=\"time\">{$date}</span>
         <span><a href=\"javascript: hidereply({$rid},{$tid});\">{$lang['comments_hide']}</a></span> 
         <a href=\"javascript: delreply({$rid},{$tid});\">{$lang['remove']}</a> 
         <em><a href=\"javascript:reply({$tid}, '@{$name}:');\">{$lang['reply']}</a></em>
		 </li>";
	echo $response;
}
// Delete reply
if ($action == 'delreply') {
	$rid = isset($_GET['rid']) ? intval($_GET['rid']) : null;
	$tid = isset($_GET['tid']) ? intval($_GET['tid']) : null;
	$Reply_Model = new Reply_Model();
	if ( $Reply_Model->delReply($rid) == 'n') {
		$Twitter_Model->updateReplyNum($tid, '-1');
	}
	echo $tid;
}
// Hide reply
if ($action == 'hidereply') {
	$rid = isset($_GET['rid']) ? intval($_GET['rid']) : null;
	$tid = isset($_GET['tid']) ? intval($_GET['tid']) : null;
	$Reply_Model = new Reply_Model();
	$Reply_Model->hideReply($rid);
	$Twitter_Model->updateReplyNum($tid, '-1');
}
// Publish reply
if ($action == 'pubreply') {
	$rid = isset($_GET['rid']) ? intval($_GET['rid']) : null;
	$tid = isset($_GET['tid']) ? intval($_GET['tid']) : null;
	$Reply_Model = new Reply_Model();
	$Reply_Model->pubReply($rid);
	$Twitter_Model->updateReplyNum($tid, '+1');
}
