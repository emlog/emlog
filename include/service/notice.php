<?php
/**
 * Service: Notice
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Notice {

	public static function sendResetMail($mail) {
		if (!isset($_SESSION)) {
			session_start();
		}
		$randCode = getRandStr(8, false);
		$_SESSION['mail_code'] = $randCode;
		$_SESSION['mail'] = $mail;

		$title = "找回密码邮件验证码";
		$content = "邮件验证码：" . $randCode;
		$sendmail = new SendMail();
		$ret = $sendmail->send($mail, $title, $content);
		if ($ret) {
			return true;
		}
		return false;
	}

	public static function sendNewPostMail($post_title) {
		if (Option::get('mail_notice_post') === 'n') {
			return false;
		}
		$CACHE = Cache::getInstance();
		$user_cache = $CACHE->readCache('user');
		if (empty($user_cache[1]['mail'])) {
			return false;
		}
		$email = $user_cache[1]['mail'];
		$title = "你的站点收到新的待审核文章投稿";
		$content = "文章标题是：" . $post_title;
		$sendmail = new SendMail();
		$ret = $sendmail->send($email, $title, $content);
		if ($ret) {
			return true;
		}
		return false;
	}

	public static function sendNewCommentMail($comment) {
		if (Option::get('mail_notice_comment') === 'n') {
			return false;
		}
		$CACHE = Cache::getInstance();
		$user_cache = $CACHE->readCache('user');
		$email = $user_cache[1]['mail'];
		if (empty($user_cache[1]['mail'])) {
			return false;
		}
		$title = "你的站点收到新的评论";
		$content = "评论内容是：" . $comment;
		$sendmail = new SendMail();
		$ret = $sendmail->send($email, $title, $content);
		if ($ret) {
			return true;
		}
		return false;
	}

}
