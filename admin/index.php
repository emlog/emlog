<?php
/**
 * 管理中心
 * @package EMLOG (www.emlog.net)
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
	$php_ver = PHP_VERSION;

	include View::getView('header');
	require_once(View::getView('index'));
	include View::getView('footer');
	View::output();
}

if ($action === 'get_news') {
	$emcurl = new EmCurl();
	$emcurl->request(OFFICIAL_SERVICE_HOST . 'services/messenger_pro.php?ver=' . Option::EMLOG_VERSION);
	$retStatus = $emcurl->getHttpStatus();
	if ($emcurl->getHttpStatus() !== 200) {
		header('Content-Type: application/json; charset=UTF-8');
		exit('{"result":"fail"}');
	} else {
		$respone = $emcurl->getRespone();
		header('Content-Type: application/json; charset=UTF-8');
		exit($respone);
	}
}