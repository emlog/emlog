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

}
