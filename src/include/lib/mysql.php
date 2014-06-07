<?php

/**
 * 数据库操作路由
 *
 * @copyright (c) Emlog All Rights Reserved
 */
class MySql {
	public static function getInstance() {
		$mysql_instance = NULL;

		if (extension_loaded('mysqli')) {
			$errno = 0;
			$mysql_instance = MySqlii::getInstance($errno);
		}

		if (extension_loaded('mysql') && ($mysql_instance === NULL || $errno !== 0)) {
			$errno = 0;
			$mysql_instance = MySqlLegacy::getInstance($errno);
		}

		if ($mysql_instance === NULL) {
			emMsg('没有找到合适的数据库连接方法');
		}

		if ($errno !== 0) {
			switch ($errno) {
				case 1044:
				case 1045:
					emMsg("连接数据库失败，数据库用户名或密码错误");
					break;

				case 1049:
					emMsg("连接数据库失败，未找到您填写的数据库");
					break;

				case 2003:
					emMsg("连接数据库失败，数据库端口错误");
					break;

				case 2005:
					emMsg("连接数据库失败，数据库地址错误或者数据库服务器不可用");
					break;

				case 2006:
					emMsg("连接数据库失败，数据库服务器不可用");
					break;

				default :
					emMsg("连接数据库失败，请检查数据库信息。错误编号：" . $errno);
					break;
			}
		}

		return $mysql_instance;
	}

}
