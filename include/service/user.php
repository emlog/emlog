<?php

class User {

	const ROLE_FOUNDER = 'founder';          //创始人
	const ROLE_ADMIN = 'admin';              //管理员
	const ROLE_WRITER = 'writer';            //用户
	const ROLE_VISITOR = 'visitor';          //游客

	static function isAdmin($role = ROLE) {
		if ($role == self::ROLE_ADMIN || $role == self::ROLE_FOUNDER) {
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

	static function getRoleName($role) {
		$role_name = '';
		switch ($role) {
			case self::ROLE_FOUNDER:
				$role_name = '创始人';
				break;
			case self::ROLE_ADMIN:
				$role_name = '管理员';
				break;
			case self::ROLE_WRITER:
				$role_name = '用户';
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
		$_SESSION['code'] = $randCode;
		$_SESSION['mail'] = $mail;

		$title = "找回密码邮件验证码";
		$content = "邮件验证码是：" . $randCode;
		$sendmail_model = new SendMail();
		$ret = $sendmail_model->send($mail, $title, $content);
		if ($ret) {
			return true;
		} else {
			return false;
		}
	}

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


}
