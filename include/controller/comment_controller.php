<?php
/**
 * 发表评论
 *
 * @package EMLOG (www.emlog.net)
 */

class Comment_Controller {
	function addComment($params) {
		$name = isset($_POST['comname']) ? addslashes(trim($_POST['comname'])) : '';
		$content = isset($_POST['comment']) ? addslashes(trim($_POST['comment'])) : '';
		$mail = isset($_POST['commail']) ? addslashes(trim($_POST['commail'])) : '';
		$url = isset($_POST['comurl']) ? addslashes(trim($_POST['comurl'])) : '';
		$imgcode = isset($_POST['imgcode']) ? addslashes(strtoupper(trim($_POST['imgcode']))) : '';
		$blogId = isset($_POST['gid']) ? (int)$_POST['gid'] : -1;
		$pid = isset($_POST['pid']) ? (int)$_POST['pid'] : 0;
		$uid = 0;

		if (ISLOGIN === true) {
			$CACHE = Cache::getInstance();
			$user_cache = $CACHE->readCache('user');
			$name = addslashes($user_cache[UID]['name_orig']);
			$mail = addslashes($user_cache[UID]['mail']);
			$url = addslashes(BLOG_URL);
			$uid = UID;
		}

		if ($url && strncasecmp($url, 'http', 4)) {
			$url = 'http://' . $url;
		}

		doAction('comment_post');

		$Comment_Model = new Comment_Model();
		$Comment_Model->setCommentCookie($name, $mail, $url);
		if ($Comment_Model->isLogCanComment($blogId) === false) {
			emMsg('评论失败：该文章已关闭评论');
		} elseif ($Comment_Model->isCommentExist($blogId, $name, $content) === true) {
			emMsg('评论失败：已存在相同内容评论');
		} elseif (User::isVistor() && $Comment_Model->isCommentTooFast() === true) {
			emMsg('评论失败：您写评论的速度太快了，请稍后再试');
		} elseif (empty($name)) {
			emMsg('评论失败：请填写姓名');
		} elseif (strlen($name) > 20) {
			emMsg('评论失败：姓名不符合规范');
		} elseif ($mail != '' && !checkMail($mail)) {
			emMsg('评论失败：邮件地址不符合规范');
		} elseif (ISLOGIN == false && $Comment_Model->isNameAndMailValid($name, $mail) === false) {
			emMsg('评论失败：禁止使用管理员昵称或邮箱评论');
		} elseif (!empty($url) && preg_match("/^(http|https)\:\/\/[^<>'\"]*$/", $url) == false) {
			emMsg('评论失败：主页地址不符合规范', 'javascript:history.back(-1);');
		} elseif (empty($content)) {
			emMsg('评论失败：请填写评论内容');
		} elseif (strlen($content) > 60000) {
			emMsg('评论失败：内容不符合规范');
		} elseif (User::isVistor() && Option::get('comment_needchinese') == 'y' && !preg_match('/[\x{4e00}-\x{9fa5}]/iu', $content)) {
			emMsg('评论失败：评论内容需包含中文');
		} elseif (ISLOGIN == false && Option::get('comment_code') == 'y' && session_start() && (empty($imgcode) || $imgcode !== $_SESSION['code'])) {
			emMsg('评论失败：验证码错误');
		}

		$_SESSION['code'] = null;
		$Comment_Model->addComment($uid, $name, $content, $mail, $url, $blogId, $pid);
	}
}
