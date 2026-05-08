<?php

/**
 * register emlog
 * @package EMLOG
 * 
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
    $emkey = Input::postStrVar('emkey');

    if (empty($emkey)) {
        FlashMsg::redirectAdmin('auth', 'error_b');
    }

    $r = Register::doReg($emkey);

    if ($r === false) {
        FlashMsg::redirectAdmin('auth', 'error_b');
    }

    if (isset($r['type'])) {
        Option::updateOption("emkey_type", $r['type']);
    }

    Option::updateOption("emkey", $emkey);
    $CACHE->updateCache('options');
    emDirect("./auth.php");
}
