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

if (empty($action)) {
	include View::getView('header');
	require_once(View::getView('register'));
	include View::getView('footer');
	View::output();
}

if ($action === 'register') {
	$emkey = $_POST['emkey'] ? addslashes(trim($_POST['emkey'])) : '';

	if (empty($emkey)) {
		emDirect("./register.php?error_b=1");
	}

	if (Register::checkEmKey($emkey) === false) {
		emDirect("./register.php?error_b=1");
	}

	Option::updateOption("emkey", $emkey);
	$CACHE->updateCache('options');
	emDirect("./register.php?active_reg=1");
}
