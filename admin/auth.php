<?php
/**
 * register emlog
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

if (empty($action)) {
    include View::getAdmView('header');
    require_once(View::getAdmView('auth'));
    include View::getAdmView('footer');
    View::output();
}

if ($action === 'auth') {
    $emkey = $_POST['emkey'] ? addslashes(trim($_POST['emkey'])) : '';

    if (empty($emkey)) {
        emDirect("./auth.php?error_b=1");
    }

    $r = Register::doReg($emkey);

    if ($r === false) {
        emDirect("./auth.php?error_b=1");
    }

    if (isset($r['type'])) {
        Option::updateOption("emkey_type", $r['type']);
    }

    Option::updateOption("emkey", $emkey);
    $CACHE->updateCache('options');
    emDirect("./auth.php?active_reg=1");
}
