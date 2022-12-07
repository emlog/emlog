<?php
/**
 * Database operation routing
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Database {

	public static function getInstance() {
		if (class_exists('mysqli', FALSE)) {
			return MySqlii::getInstance();
		}

		if (class_exists('pdo', false)) {
			return Mysqlpdo::getInstance();
		}

		emMsg(lang('mysql_not_supported'));
	}

}
