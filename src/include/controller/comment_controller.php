<?php
/**
 * Post a comment
 *
 * @copyright (c) Emlog All Rights Reserved
 */

class Comment_Controller {
	function addComment($params) {
		$name = isset($_POST['comname']) ? addslashes(trim($_POST['comname'])) : '';
		$content = isset($_POST['comment']) ? addslashes(trim($_POST['comment'])) : '';
		$mail = isset($_POST['commail']) ? addslashes(trim($_POST['commail'])) : '';
		$url = isset($_POST['comurl']) ? addslashes(trim($_POST['comurl'])) : '';
		$imgcode = isset($_POST['imgcode']) ? addslashes(trim(strtoupper($_POST['imgcode']))) : '';
		$blogId = isset($_POST['gid']) ? intval($_POST['gid']) : -1;
		$pid = isset($_POST['pid']) ? intval($_POST['pid']) : 0;

		if (ISLOGIN === true) {
			$CACHE = Cache::getInstance();
			$user_cache = $CACHE->readCache('user');
			$name = addslashes($user_cache[UID]['name_orig']);
			$mail = addslashes($user_cache[UID]['mail']);
			$url = addslashes(BLOG_URL);
		}

		if ($url && strncasecmp($url,'http',4)) {
			$url = 'http://'.$url;
		}

		doAction('comment_post');

		$Comment_Model = new Comment_Model();
		$Comment_Model->setCommentCookie($name,$mail,$url);
		if($Comment_Model->isLogCanComment($blogId) === false) {
/*vot*/			emMsg(lang('comment_error_comment_disabled'));
		} elseif ($Comment_Model->isCommentExist($blogId, $name, $content) === true) {
/*vot*/			emMsg(lang('comment_error_content_exists'));
		} elseif (ROLE == ROLE_VISITOR && $Comment_Model->isCommentTooFast() === true) {
/*vot*/			emMsg(lang('comment_error_flood_control'));
		} elseif (empty($name)) {
/*vot*/			emMsg(lang('comment_error_name_enter'));
		} elseif (mb_strlen($name) > 20) {
/*vot*/			emMsg(lang('comment_error_name_invalid'));
		} elseif ($mail != '' && !checkMail($mail)) {
/*vot*/			emMsg(lang('comment_error_email_invalid'));
		} elseif (ISLOGIN == false && $Comment_Model->isNameAndMailValid($name, $mail) === false) {
/*vot*/			emMsg(lang('comment_error_other_user'));
		} elseif (!empty($url) && preg_match("/^(http|https)\:\/\/[^<>'\"]*$/", $url) == false) {
/*vot*/			emMsg(lang('comment_error_url_invalid'),'javascript:history.back(-1);');
		} elseif (empty($content)) {
/*vot*/			emMsg(lang('comment_error_empty'));
		} elseif (mb_strlen($content) > 8000) {
/*vot*/			emMsg(lang('comment_error_content_invalid'));
		} elseif (ROLE == ROLE_VISITOR && Option::get('comment_needchinese') == 'y' && !preg_match('/[\x{4e00}-\x{9fa5}]/iu', $content)) {
/*vot*/			emMsg(lang('comment_error_national_chars'));
		} elseif (ISLOGIN == false && Option::get('comment_code') == 'y' && session_start() && $imgcode != $_SESSION['code']) {
/*vot*/			emMsg(lang('comment_error_captcha_invalid'));
		} else {
            $_SESSION['code'] = null;
			$Comment_Model->addComment($name, $content, $mail, $url, $imgcode, $blogId, $pid);
		}
	}
}
