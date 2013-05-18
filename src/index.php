<?php
/**
 * Front-end main page
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'my_func.php';
require_once 'init.php';

define('TEMPLATE_PATH', TPLS_PATH.Option::get('nonce_templet').'/');//Foreground template path

$emDispatcher = Dispatcher::getInstance();
$emDispatcher->dispatch();
View::output();
