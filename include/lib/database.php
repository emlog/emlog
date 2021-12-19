<?php
/**
 * Route database operations
 *
 * @package EMLOG (www.emlog.net)
 */

class Database {

	public static function getInstance() {
		if (class_exists('mysqli', FALSE)) {
			return MySqlii::getInstance();
		} elseif (class_exists('pdo', false)) {
			return Mysqlpdo::getInstance();
		} else {
/*vot*/			emMsg(lang('mysql_not_supported'));
		}
	}

}
