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
		$title = "你的站点收到新的待审核文章投稿";
		$content = "文章标题是：" . $post_title;
		$sendmail = new SendMail();
		$ret = $sendmail->send($email, $title, $content);
		if ($ret) {
			return true;
		}
		return false;
	}

	public static function sendNewCommentMail($comment, $gid) {
		if (!self::smtpServerReady()) {
			return false;
		}
		if (Option::get('mail_notice_comment') === 'n') {
			return false;
		}

		$sendmail = new SendMail();
		$title = "你的文章收到新的评论";
		$content = "评论内容：" . $comment;

		$r = self::getArticleInfo($gid);
		if ($r) {
			$content .= '<br><br> 来自文章：' . $r['log_title'];
			$email = self::getArticleAuthorEmail($r['author']);
			if (!$email) {
				return false;
			}
			$sendmail->send($email, $title, $content);
		}
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

	private static function getArticleInfo($gid) {
		$Log_Model = new Log_Model();
		$r = $Log_Model->getOneLogForHome($gid);
		if (isset($r['author'])) {
			return $r;
		}
		return false;
	}

	private static function getArticleAuthorEmail($uid) {
		$User_Model = new User_Model();
		$r = $User_Model->getOneUser($uid);
		if (isset($r['email'])) {
			return $r['email'];
		}
		return false;
	}

}
