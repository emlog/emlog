<?php

class User {

	const ROLE_FOUNDER = 'founder';          //Founder
	const ROLE_ADMIN = 'admin';              //Admin
	const ROLE_WRITER = 'writer';            //Writer
	const ROLE_VISITOR = 'visitor';          //Guest

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
/*vot*/			$role_name = lang(ROLE_FOUNDER);
				break;
			case self::ROLE_ADMIN:
/*vot*/			$role_name = lang(ROLE_ADMIN);
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
		$_SESSION['code'] = $randCode;
		$_SESSION['mail'] = $mail;

/*vot*/		$title = lang('reset_password_code');
/*vot*/		$content = lang('email_verify_code') . $randCode;
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
