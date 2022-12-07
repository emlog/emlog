<?php
/**
 * Service: Notice
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Notice {

	public static function sendResetMail($mail) {
		if (!self::smtpServerReady()) {
			return false;
		}
		if (!isset($_SESSION)) {
			session_start();
		}
		$randCode = getRandStr(8, false);
		$_SESSION['mail_code'] = $randCode;
		$_SESSION['mail'] = $mail;

		$title = lang('reset_password_code');
		$content = lang('email_verify_code') . $randCode;
		$sendmail = new SendMail();
		$ret = $sendmail->send($mail, $title, $content);
		if ($ret) {
			return true;
		}
		return false;
	}

	public static function sendNewPostMail($post_title) {
		if (!self::smtpServerReady()) {
			return false;
		}
		if (Option::get('mail_notice_post') === 'n') {
			return false;
		}
		$email = self::getFounderEmail();
		if (!$email) {
			return false;
		}
		$title = lang('new_article_review');
		$content = lang('new_article_title') . $post_title;
		$sendmail = new SendMail();
		$ret = $sendmail->send($email, $title, $content);
		if ($ret) {
			return true;
		}
		return false;
	}

	public static function sendNewCommentMail($comment) {
		if (!self::smtpServerReady()) {
			return false;
		}
		if (Option::get('mail_notice_comment') === 'n') {
			return false;
		}
		$email = self::getFounderEmail();
		if (!$email) {
			return false;
		}
		$title = lang('new_comment_review');
		$content = lang('new_comment_is') . $comment;
		$sendmail = new SendMail();
		$ret = $sendmail->send($email, $title, $content);
		if ($ret) {
			return true;
		}
		return false;
	}

	private static function smtpServerReady() {
		if (empty(Option::get('smtp_pw')) || empty(Option::get('smtp_mail'))) {
			return false;
		}
		return true;
	}

	private static function getFounderEmail() {
		$CACHE = Cache::getInstance();
		$user_cache = $CACHE->readCache('user');
		if (empty($user_cache[1]['mail'])) {
			return false;
		}
		return $user_cache[1]['mail'];
	}

}
