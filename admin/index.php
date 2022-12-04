<?php
/**
 * control panel
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

if (empty($action)) {
	$avatar = empty($user_cache[UID]['avatar']) ? './views/images/avatar.svg' : '../' . $user_cache[UID]['avatar'];
	$name = $user_cache[UID]['name'];
	$role = $user_cache[UID]['role'];

	$serverapp = $_SERVER['SERVER_SOFTWARE'];
	$DB = Database::getInstance();
	$mysql_ver = $DB->getMysqlVersion();

	$max_execution_time = ini_get('max_execution_time') ?: '';
	$max_upload_size = ini_get('upload_max_filesize') ?: '';
	$php_ver = PHP_VERSION . ', ' . $max_execution_time . 's,' . $max_upload_size;
	$role_name = User::getRoleName($role, UID);
	if (function_exists("curl_init")) {
		$c = curl_version();
		$php_ver .= ",curl" . $c['version'];
	}
	if (class_exists('ZipArchive', FALSE)) {
		$php_ver .= ',zip';
	}

	include View::getAdmView('header');
	require_once(View::getAdmView('index'));
	include View::getAdmView('footer');
	View::output();
}