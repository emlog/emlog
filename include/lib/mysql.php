<?php
/**
 * Database operation routing (only compatible with old plug-ins, not recommended)
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class MySql {

	public static function getInstance() {
		if (class_exists('mysqli', FALSE)) {
			return MySqlii::getInstance();
		} else {
/*vot*/			emMsg('mysql_not_supported');
		}
	}

}
