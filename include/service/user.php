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
	}
}
