<?php
/**
 * Database operation routing (only compatible with old version, not recommended)
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class MySql {

	public static function getInstance() {
		if (class_exists('mysqli', FALSE)) {
			return MySqlii::getInstance();
		}

		emMsg('服务器空间PHP不支持MySql数据库');
	}

}
