<?php
/**
 * Service: User
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class User {

	const ROLE_ADMIN = 'admin';              //管理员
	const ROLE_WRITER = 'writer';            //注册用户
	const ROLE_VISITOR = 'visitor';          //游客

	static function isAdmin($role = ROLE) {
		if ($role == self::ROLE_ADMIN) {
			return true;
		}
		return false;
	}

	static function isVistor($role = ROLE) {
		if ($role == self::ROLE_VISITOR) {
			return true;
		}
		return false;
	}

	static function getRoleName($role, $uid = 0) {
		$role_name = '';
		switch ($role) {
			case self::ROLE_ADMIN:
				$role_name = $uid === 1 ? '创始人' : '管理员';
				break;
			case self::ROLE_WRITER:
				$role_name = '注册用户';
				break;
			case self::ROLE_VISITOR:
				$role_name = '游客';
				break;
		}
		return $role_name;
	}

	static function sendResetMail($mail) {
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
		} else {
			return false;
		}
	}

	// 检查图片验证码
	static function checkLoginCode($login_code) {
		if (!isset($_SESSION)) {
			session_start();
		}
		$session_code = $_SESSION['code'] ?? '';
		if ((!$login_code || $login_code !== $session_code) && Option::get('login_code') === 'y') {
			unset($_SESSION['code']);
			return false;
		}
		return true;
	}

	// 检查邮箱验证码
	static function checkMailCode($mail_code) {
		if (!isset($_SESSION)) {
			session_start();
		}
		$session_code = $_SESSION['mail_code'] ?? '';
		if (!$mail_code || $mail_code !== $session_code) {
			unset($_SESSION['code']);
			return false;
		}
		return true;
	}

	// 检查用户权限
	static function checkRolePermission() {
		$request_uri = strtolower(substr(basename($_SERVER['SCRIPT_NAME']), 0, -4));
		if (ROLE === self::ROLE_WRITER && !in_array($request_uri, ['article', 'twitter', 'media', 'blogger', 'comment', 'index', 'article_save'])) {
			emMsg('你所在的用户组无法使用该功能，请联系管理员', './');
		}
	}

}
