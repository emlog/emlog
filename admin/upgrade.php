<?php
/**
 * Upgrade Center
 * @package EMLOG (www.emlog.net)
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

if ($action === 'check_update') {
	$emcurl = new EmCurl();
	$emcurl->request(OFFICIAL_SERVICE_HOST . 'services/check_update_pro.php?ver=' . Option::EMLOG_VERSION);
	$retStatus = $emcurl->getHttpStatus();
	if ($retStatus !== 200) {
		header('Content-Type: application/json; charset=UTF-8');
		exit('{"result":"fail"}');
	} else {
		$respone = $emcurl->getRespone();
		header('Content-Type: application/json; charset=UTF-8');
		exit($respone);
	}
}

if ($action === 'update' && ROLE === ROLE_ADMIN) {
	$source = isset($_GET['source']) ? trim($_GET['source']) : '';
	$upsql = isset($_GET['upsql']) ? trim($_GET['upsql']) : '';

	if (empty($source)) {
		exit('error');
	}

	$temp_file = emFecthFile(OFFICIAL_SERVICE_HOST . $source);
	if (!$temp_file) {
		exit('error_down');
	}

	$ret = emUnZip($temp_file, '../', 'update');
	@unlink($temp_file);

	switch ($ret) {
		case 1:
		case 2:
			exit('error_dir');
			break;
		case 3:
			exit('error_zip');
			break;
	}

	//update db
	if (!$upsql) {
		exit('succ');
	}
	$DB = Database::getInstance();
	$setchar = $DB->getMysqlVersion() > '4.1' ? "ALTER DATABASE `" . DB_NAME . "` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;" : '';
	$temp_file = emFecthFile(OFFICIAL_SERVICE_HOST . $upsql);
	if (!$temp_file) {
		exit('error_down');
	}
	$sql = file($temp_file);
	@unlink($temp_file);
	array_unshift($sql, $setchar);
	$query = '';
	foreach ($sql as $value) {
		if (!$value || $value[0] == '#') {
			continue;
		}
		$value = str_replace("{db_prefix}", DB_PREFIX, trim($value));
		if (preg_match("/\;$/i", $value)) {
			$query .= $value;
			$DB->query($query);
			$query = '';
		} else {
			$query .= $value;
		}
	}
	$CACHE->updateCache();
	exit('succ');
}