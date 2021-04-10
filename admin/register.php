<?php
/**
 * register emlog
 * @package EMLOG (www.emlog.net)
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

if ($action === 'register') {
	$emkey = $_POST['emkey'] ?? '';

	if (empty($emkey)) {
		emDirect("./index.php?error_b=1");
	}

	$emcurl = new EmCurl();
	$emcurl->setPost(['emkey' => $emkey]);
	$emcurl->request(OFFICIAL_SERVICE_HOST . 'register/auth');

	$retStatus = $emcurl->getHttpStatus();
	if ($emcurl->getHttpStatus() !== 200) {
		emDirect("./index.php?error_b=1");
	}

	$respone = $emcurl->getRespone();
	$respone = json_decode($respone, 1);
	if (!$respone || $respone['msg'] != 'ok') {
		emDirect("./index.php?error_b=1");
	}

	Option::updateOption("emkey", $emkey);
	$CACHE->updateCache('options');
	emDirect("./index.php?active_reg=1");
}
