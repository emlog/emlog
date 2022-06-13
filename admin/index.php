<?php
/**
 * control pannel
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

	$serverapp = $_SERVER['SERVER_SOFTWARE'];
	$DB = Database::getInstance();
	$mysql_ver = $DB->getMysqlVersion();

	$max_execution_time = ini_get('max_execution_time') ?: '';
	$max_upload_size = ini_get('upload_max_filesize') ?: '';
/*vot*/	$php_ver = PHP_VERSION . ', ' . $max_execution_time . 's, ' . $max_upload_size;
	if (function_exists("curl_init")) {
		$c = curl_version();
/*vot*/		$php_ver .= ", curl" . $c['version'];
	}
	if (class_exists('ZipArchive', FALSE)) {
/*vot*/		$php_ver .= ', zip';
	}

	include View::getAdmView('header');
	require_once(View::getAdmView('index'));
	include View::getAdmView('footer');
	View::output();
}

if ($action === 'get_news') {
	$emcurl = new EmCurl();
	$emcurl->request('https://www.emlog.net/services/messenger_pro.php');
	header('Content-Type: application/json; charset=UTF-8');
	if ($emcurl->getHttpStatus() !== 200) {
		exit('{"result":"fail"}');
	}
	$response = $emcurl->getRespone();
	exit($response);
}