<?php
/**
 * Service: User
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class User {

	const ROLE_ADMIN = 'admin';              //Admin
	const ROLE_WRITER = 'writer';            //Registered user
	const ROLE_VISITOR = 'visitor';          //Guest

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
/*vot*/				$role_name = $uid === 1 ? lang(ROLE_FOUNDER) : lang(ROLE_ADMIN);
				break;
			case self::ROLE_WRITER:
/*vot*/			$role_name = lang(ROLE_WRITER);
				break;
			case self::ROLE_VISITOR:
/*vot*/			$role_name = lang(ROLE_VISITOR);
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

/*vot*/		$title = lang('reset_password_code');
/*vot*/		$content = lang('email_verify_code') . $randCode;
		$sendmail = new SendMail();
		$ret = $sendmail->send($mail, $title, $content);
		if ($ret) {
			return true;
		} else {
			return false;
		}
	}

		// Check image verification code
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

	// Check email verification code
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

	// Check user permissions
	static function checkRolePermission() {
		$request_uri = strtolower(substr(basename($_SERVER['SCRIPT_NAME']), 0, -4));
		if (ROLE === self::ROLE_WRITER && !in_array($request_uri, ['article', 'twitter', 'media', 'blogger', 'comment', 'index', 'article_save'])) {
/*vot*/			emMsg(lang('group_no_permission'), './');
		}
	}

}
