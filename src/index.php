<?php
/**
 * Front-end main page
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'init.php';

define('TEMPLATE_PATH', TPLS_PATH.Option::get('nonce_templet').'/');//Foreground template path
define('CURPAGE_HOME',  'home');
define('CURPAGE_LOG',   'echo_log');
define('CURPAGE_TW',    'twitter');

$emDispatcher = Dispatcher::getInstance();
$emDispatcher->dispatch();
View::output();
