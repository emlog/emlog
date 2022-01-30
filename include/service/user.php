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

}
