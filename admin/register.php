<?php
/**
 * 链接管理
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
	if ($emkey === '12345678') {
        Option::updateOption("emkey", $emkey);
        $CACHE->updateCache('options');
        emDirect("./index.php?active_reg=1");
    }
	emDirect("./index.php?error_b=1");
}
