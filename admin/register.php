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
	$emkey = $_POST['emkey'] ? addslashes(trim($_POST['emkey'])) : '';

	if (empty($emkey)) {
		emDirect("./index.php?error_b=1");
	}

	if (Register::checkEmKey($emkey) === false) {
		emDirect("./index.php?error_b=1");
	}

	Option::updateOption("emkey", $emkey);
	$CACHE->updateCache('options');
	emDirect("./index.php?active_reg=1");
}
