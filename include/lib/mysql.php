<?php
/**
 * 数据库操作路由 (仅仅兼容旧的插件，不推荐使用)
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
